<?php

namespace Behin\SimpleWorkflowReport\Controllers\Core;

use App\Http\Controllers\Controller;
use Behin\SimpleWorkflow\Controllers\Core\CaseController;
use Behin\SimpleWorkflow\Controllers\Core\FormController;
use Behin\SimpleWorkflow\Controllers\Core\InboxController;
use Behin\SimpleWorkflow\Controllers\Core\ProcessController;
use Behin\SimpleWorkflow\Controllers\Core\TaskController;
use Behin\SimpleWorkflow\Models\Core\Process;
use Behin\SimpleWorkflow\Models\Core\TaskActor;
use Behin\SimpleWorkflow\Models\Entities\Financial_transactions;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SummaryReportController extends Controller
{
    public function index(): View
    {
        $processes = getProcesses();
        $users = User::all();
        return view('SimpleWorkflowReportView::Core.Summary.index', compact('processes','users'));
    }

    public function show($process_id)
    {
        $process = ProcessController::getById($process_id);

        // شماره پرونده‌ای که کاربر برای مشاهده گزارش مالی آن انتخاب کرده است
        $caseNumber = request()->query('case_number');
        if (!is_string($caseNumber) || $caseNumber === '') {
            $caseNumber = null;
        }

        $financialTransactions = collect();
        $financialSummary = null;

        if ($caseNumber !== null) {
            // مرتب‌سازی بر اساس تاریخ (اولویت با تاریخ میلادی/alt و در صورت نبود با تاریخ شمسی)
            $financialTransactions = Financial_transactions::where('case_number', $caseNumber)
                ->orderByRaw('COALESCE(transaction_or_cheque_due_date_alt, transaction_or_cheque_due_date) asc')
                ->orderBy('id')
                ->get();

            $totalDebit = (float) $financialTransactions
                ->where('financial_type', 'بدهکار')
                ->sum(fn($transaction) => (float) str_replace(',', '', (string) $transaction->amount));

            $totalCredit = (float) $financialTransactions
                ->where('financial_type', 'بستانکار')
                ->sum(fn($transaction) => (float) str_replace(',', '', (string) $transaction->amount));

            $financialSummary = [
                'total_debit' => $totalDebit,
                'total_credit' => $totalCredit,
                'balance' => $totalCredit - $totalDebit,
            ];
        }

        $view = 'SimpleWorkflowReportView::Core.Summary.process.' . $process_id;
        if(view()->exists($view)){
            return view($view, compact('process', 'caseNumber', 'financialTransactions', 'financialSummary'));
        }
        return view('SimpleWorkflowReportView::Core.Summary.show', compact('process', 'caseNumber', 'financialTransactions', 'financialSummary'));
    }

    public function edit($caseId) {
        $case = CaseController::getById($caseId);
        $process = $case->process;
        $summaryForm = RoleReportFormController::getSummaryReportFormByRoleId(Auth::user()->role_id, $process->id);
        if($summaryForm == null){
            return redirect()->back()->with('error', trans('Form not found'));  
        }
        $formId = $summaryForm->summary_form_id;

        $form = FormController::getById($formId);

        return view('SimpleWorkflowReportView::Core.Summary.edit', compact('case','form','process'));
    }
}
