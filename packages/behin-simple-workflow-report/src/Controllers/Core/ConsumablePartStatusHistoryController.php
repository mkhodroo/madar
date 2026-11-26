<?php

namespace Behin\SimpleWorkflowReport\Controllers\Core;

use App\Http\Controllers\Controller;
use BehinUserRoles\Models\User;
use Behin\SimpleWorkflow\Controllers\Core\ScriptController;
use Behin\SimpleWorkflow\Controllers\Core\ViewModelController;
use Behin\SimpleWorkflow\Jobs\SendPushNotification;
use Behin\SimpleWorkflow\Models\Entities\Borrow_requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;
use Behin\SimpleWorkflow\Models\Entities\Consumable_parts;
use Behin\SimpleWorkflowReport\Exports\ConsumablePartsExport;
use Behin\SimpleWorkflowReport\Exports\ConsumablePartsRequestsExport;
use Behin\SimpleWorkflowReport\Exports\ConsumablePartsBuyingInExport;
use Behin\SimpleWorkflowReport\Exports\ConsumablePartsBuyingOutExport;
use Behin\Sms\Controllers\ArsanSmsController;
use Brick\Math\BigInteger;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Behin\SimpleWorkflow\Models\Entities\Consumable_parts_status_history;
use Throwable;

class ConsumablePartStatusHistoryController extends Controller
{
    public static function store(Request $request, Consumable_parts $consumablePart)
    {
        if($consumablePart->consumable_part_status == $request->consumable_part_status) {
            return false;
        }
        Consumable_parts_status_history::create([
            'consumable_part_id' => $consumablePart->id,
            'status_before_change' => $consumablePart->consumable_part_status,
            'status_after_change' => $request->consumable_part_status ?? '',
            'description' => $request->description ?? '',
            'user_id' => Auth::user()->id,
            'created_at' => now(),
        ]);
        return true;
    }

    public function getHistoryOfConsumablePartId($consumablePartId)
    {
        $history = Consumable_parts_status_history::where('consumable_part_id', $consumablePartId)->get();
        return $history;
    }

    public function show($consumablePartId)
    {
        $history = $this->getHistoryOfConsumablePartId($consumablePartId);
        return view('SimpleWorkflowReportView::Core.ConsumablePart.history', compact('history'));
    }
}
