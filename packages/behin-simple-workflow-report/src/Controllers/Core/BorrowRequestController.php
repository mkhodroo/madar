<?php

namespace Behin\SimpleWorkflowReport\Controllers\Core;

use App\Http\Controllers\Controller;
use BehinUserRoles\Models\User;
use Behin\SimpleWorkflow\Jobs\SendPushNotification;
use Behin\SimpleWorkflow\Models\Entities\Borrow_requests;
use Behin\SimpleWorkflowReport\Exports\BorrowRequestsExport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BorrowRequestController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $myRequests = Borrow_requests::where('requester_id', $userId)
            ->orderByDesc('created_at')
            ->get();

        $pendingDeliveries = Borrow_requests::whereStatus('requested')
            ->orderByDesc('created_at')
            ->get();

        $deliveredRequests = Borrow_requests::whereStatus('delivered')->whereNotNull('delivered_at')
            ->whereNull('actual_return_date')
            ->orderByDesc('delivered_at')
            ->get();

        $waitingReturnConfirmation = Borrow_requests::whereStatus('pending_return_confirmation')
            ->orderByDesc('actual_return_date')
            ->get()
            ->filter(fn($request) => $request->status === 'pending_return_confirmation');

        $notAvailableRequests = Borrow_requests::whereStatus('not_available')
            ->orderByDesc('not_available_at_alt')
            ->orderByDesc('updated_at')
            ->get();

        $statuses = config('simpleWorkflowReport.borrow_requests.statuses', []);

        return view('SimpleWorkflowReportView::Core.BorrowRequest.index', compact(
            'myRequests',
            'pendingDeliveries',
            'deliveredRequests',
            'waitingReturnConfirmation',
            'notAvailableRequests',
            'statuses'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'item_name' => 'required|string',
            'quantity' => 'required|numeric|min:1',
            'item_id' => 'nullable|string',
            'case_id' => 'nullable|integer',
            'case_number' => 'nullable|string',
        ]);
        SendPushNotification::dispatch(
            82,
            'درخواست جدید تحویل کالای امانی',
            'درخواست جدید تحویل کالای امانی بهتون ارجاع داده شد',
            route('simpleWorkflowReport.borrow-requests.index')
        );

        $data['requester_id'] = Auth::id();
        $data['created_by'] = Auth::id();
        $data['status'] = config('simpleWorkflowReport.borrow_requests.statuses.requested.key');

        Borrow_requests::create($data);

        return redirect()->back()->with('success', 'درخواست شما ثبت شد.');
    }

    public function deliver(Request $request, Borrow_requests $borrowRequest): RedirectResponse
    {
        $validated = $request->validate([
            'delivered_at' => 'required|string',
            'expected_return_date' => 'nullable|string',
        ]);

        if (!is_null($borrowRequest->actual_return_date)) {
            return redirect()->back()->with('warning', 'برای درخواست تحویل‌گرفته‌شده امکان ویرایش اطلاعات تحویل وجود ندارد.');
        }

        $deliveredAtAlt = convertPersianDateTimeToTimestamp($request->delivered_at);
        $expectedReturnJalali = null;
        if (!empty($validated['expected_return_date'])) {
            $expected = convertPersianDateTimeToTimestamp($validated['expected_return_date']);
        }

        $borrowRequest->update([
            'delivery_id' => Auth::id(),
            'delivered_at_alt' => $deliveredAtAlt,
            'delivered_at' => $validated['delivered_at'],
            'expected_return_date_alt' => $expected,
            'expected_return_date' => $validated['expected_return_date'] ?? null,
            'status' => config('simpleWorkflowReport.borrow_requests.statuses.delivered.key'),
            'updated_by' => Auth::id(),
        ]);

        $message = is_null($borrowRequest->getOriginal('delivered_at'))
            ? 'درخواست تحویل شد و تاریخ‌ها ثبت گردید.'
            : 'اطلاعات تحویل به‌روزرسانی شد.';

        return redirect()->back()->with('success', $message);
    }

    public function markReturned(Borrow_requests $borrowRequest): RedirectResponse
    {
        if ($borrowRequest->status !== 'delivered') {
            return redirect()->back()->with('warning', 'این درخواست در وضعیت تحویل به درخواست‌کننده نیست.');
        }

        if ($borrowRequest->requester_id != Auth::id()) {
            return redirect()->back()->with('warning', 'تنها درخواست‌کننده می‌تواند تحویل کالا را ثبت کند.');
        }

        $now = Jalalian::now();

        $borrowRequest->update([
            'actual_return_date' => $now->format('Y-m-d'),
            'actual_return_date_alt' => $now->toCarbon()->timestamp,
            'updated_by' => Auth::id(),
            'status' => config('simpleWorkflowReport.borrow_requests.statuses.pending_return_confirmation.key')
        ]);

        return redirect()->back()->with('success', 'بازگشت کالا ثبت شد و در انتظار تایید انبار است.');
    }

    /**
     * انبار اعلام می‌کند کالای درخواست‌شده موجود نیست.
     * این وضعیت به‌جای ثبت تحویل و بازگشت صوری، در سوابق درخواست ذخیره می‌شود.
     */
    public function markNotAvailable(Request $request, Borrow_requests $borrowRequest): RedirectResponse
    {
        if (!access('انبار گردانی کالاهای امانی')) {
            return redirect()->back()->with('warning', 'شما دسترسی ثبت «موجود نیست» برای کالاهای امانی را ندارید.');
        }

        $validated = $request->validate([
            'note' => 'nullable|string|max:500',
        ]);

        $requestedStatus = config('simpleWorkflowReport.borrow_requests.statuses.requested.key');

        if ($borrowRequest->status !== $requestedStatus) {
            return redirect()->back()->with('warning', 'تنها درخواست‌های در انتظار تحویل را می‌توان به‌عنوان «موجود نیست» ثبت کرد.');
        }

        if (!is_null($borrowRequest->delivered_at_alt) || !is_null($borrowRequest->actual_return_date)) {
            return redirect()->back()->with('warning', 'برای این درخواست قبلا تحویل ثبت شده است و امکان ثبت «موجود نیست» وجود ندارد.');
        }

        $now = Jalalian::now();

        $borrowRequest->forceFill([
            'status' => config('simpleWorkflowReport.borrow_requests.statuses.not_available.key'),
            'not_available_at' => $now->format('Y-m-d H:i'),
            'not_available_at_alt' => $now->toCarbon()->timestamp,
            'not_available_by' => Auth::id(),
            'not_available_note' => $validated['note'] ?? null,
            'delivery_id' => Auth::id(),
            'updated_by' => Auth::id(),
        ])->save();

        if ($borrowRequest->requester_id) {
            SendPushNotification::dispatch(
                $borrowRequest->requester_id,
                'کالای امانی موجود نیست',
                'کالای «' . $borrowRequest->item_name . '» در انبار موجود نیست.',
                route('simpleWorkflowReport.borrow-requests.index')
            );
        }

        return redirect()->back()->with('success', 'موجود نبودن کالا ثبت شد و در سوابق درخواست ذخیره گردید.');
    }

    public function confirmReturn(Borrow_requests $borrowRequest): RedirectResponse
    {
        if ($borrowRequest->status !== 'pending_return_confirmation') {
            return redirect()->back()->with('warning', 'درخواست در انتظار تایید بازگشت نیست.');
        }

        $now = Jalalian::now();

        $borrowRequest->setReturnConfirmation([
            'by' => Auth::id(),
            'at' => $now->format('Y-m-d'),
            'at_alt' => $now->toCarbon()->timestamp,
        ]);

        $borrowRequest->status = config('simpleWorkflowReport.borrow_requests.statuses.returned.key');
        $borrowRequest->updated_by = Auth::id();
        $borrowRequest->save();

        return redirect()->back()->with('success', 'بازگشت کالا تایید شد.');
    }

    private function normalizeDate(string $value): string
    {
        return str_replace('/', '-', convertPersianToEnglish(trim($value)));
    }

    public function report()
    {
        $data = $this->prepareReportData(request());

        return view('SimpleWorkflowReportView::Core.BorrowRequest.report', [
            'allRequests' => $data['allRequests'],
            'users' => $data['users'],
            'statuses' => $data['statuses'],
        ]);
    }

    public function export(Request $request): BinaryFileResponse
    {
        $data = $this->prepareReportData($request, false);

        $fileName = sprintf('borrow-requests-report-%s.xlsx', now()->format('Y-m-d'));

        return Excel::download(
            new BorrowRequestsExport($data['allRequests'], $data['statuses']),
            $fileName
        );
    }

    /**
     * @return array{allRequests: mixed, users: mixed, statuses: array}
     */
    private function prepareReportData(Request $request, bool $paginate = true): array
    {
        $fromDate = $request->input('from_date') ?? null;
        $toDate = $request->input('to_date') ?? null;
        $dateColumn = $request->input('date_column') ?? 'delivered_at_alt';
        $perPage = $request->input('per_page') ?? 25;
        $item_name = $request->input('item_name') ?? null;
        $requesterId = $request->input('requester_id') ?? null;
        $status = $request->input('status') ?? null;
        $users = User::all();
        $statuses = config('simpleWorkflowReport.borrow_requests.statuses', []);


        $allRequests = Borrow_requests::query();
        if ($fromDate) {
            $fromDate .= ' 00:00';
            $fromDateAlt = convertPersianDateTimeToTimestamp($fromDate);
            $allRequests->where($dateColumn, '>=', $fromDateAlt);
        }
        if ($toDate) {
            $toDate .= ' 23:59';
            $toDateAlt = convertPersianDateTimeToTimestamp($toDate);
            $allRequests->where($dateColumn, '<=', $toDateAlt);
        }
        if ($requesterId) {
            $allRequests->where('requester_id', $requesterId);
        }
        if ($item_name) {
            $allRequests->where('item_name', 'like', '%' . $item_name . '%');
        }
        if ($status) {
            $allRequests->where('status', $status);
        }
        $allRequests = $allRequests->orderByDesc($dateColumn);

        if ($paginate) {
            $allRequests = $allRequests->paginate($perPage)->withQueryString();
        } else {
            $allRequests = $allRequests->get();
        }

        return compact('allRequests', 'users', 'statuses');
    }
}
