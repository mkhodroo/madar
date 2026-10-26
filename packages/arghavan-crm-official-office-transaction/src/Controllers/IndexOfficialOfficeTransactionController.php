<?php

namespace Arghavan\OfficialOfficeTransaction\Controllers;

use App\Http\Controllers\Controller;
use Arghavan\OfficialOfficeTransaction\Exports\OfficialOfficeTransactionExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;

class IndexOfficialOfficeTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = GetOfficialOfficeTransactionController::baseQuery();
        $debtsPettyCashCounterParty = GetOfficialOfficeTransactionController::baseQuery()->where('financial_type', 'بدهکار')->sum('amount');
        $creditsPettyCashCounterParty = GetOfficialOfficeTransactionController::baseQuery()->where('financial_type', 'بستانکار')->sum('amount');
        $monthOptions = [];
        $currentMonth = Jalalian::now();
        for ($i = 0; $i < 12; $i++) {
            $month = clone $currentMonth;
            if ($i > 0) {
                $month = $month->subMonths($i);
            }

            $monthOptions[] = [
                'value' => $month->format('Y-m'),
                'label' => $month->format('%B %Y'),
                'from' => $month->getFirstDayOfMonth()->format('Y-m-d'),
                'to' => $month->getEndDayOfMonth()->format('Y-m-d'),
            ];
        }

        $selectedMonthInput = $request->input('month', $monthOptions[0]['value']);
        $selectedMonth = convertPersianToEnglish($selectedMonthInput);
        if (!preg_match('/^\d{4}-\d{2}$/', $selectedMonth)) {
            $selectedMonth = $monthOptions[0]['value'];
        } else {
            [, $selectedMonthNumber] = array_map('intval', explode('-', $selectedMonth));
            if ($selectedMonthNumber < 1 || $selectedMonthNumber > 12) {
                $selectedMonth = $monthOptions[0]['value'];
            }
        }

        $selectedMonthJalali = Jalalian::fromFormat('Y-m-d', $selectedMonth . '-01');
        $defaultFrom = $selectedMonthJalali->getFirstDayOfMonth()->format('Y-m-d');
        $defaultTo = $selectedMonthJalali->getEndDayOfMonth()->format('Y-m-d');

        $fromValue = $request->filled('from') ? convertPersianToEnglish($request->input('from')) : $defaultFrom;
        $toValue = $request->filled('to') ? convertPersianToEnglish($request->input('to')) : $defaultTo;

        if ($fromValue) {
            $from = convertPersianToEnglish($fromValue);
            $from = Jalalian::fromFormat('Y-m-d', $from)
                ->toCarbon()
                ->startOfDay()
                ->timestamp;
            $fromMilisecends = $from . '000';
            $query->where('transaction_or_cheque_due_date_alt', '>=', $fromMilisecends);
        }
        if ($toValue) {
            $to = convertPersianToEnglish($toValue);
            $to = Jalalian::fromFormat('Y-m-d', $to)
                ->toCarbon()
                ->endOfDay()
                ->timestamp;
            $toMiliSeconds = $to . '000';
            $query->where('transaction_or_cheque_due_date_alt', '<=', $toMiliSeconds);
        }
        $officialOfficeTransactions = $query->orderByDesc('transaction_or_cheque_due_date')->get();
        return view('OfficialOfficeTransaction::index', compact(
            'officialOfficeTransactions',
            'monthOptions',
            'selectedMonth',
            'fromValue',
            'toValue',
            'debtsPettyCashCounterParty',
            'creditsPettyCashCounterParty'
        ));
    }


    

    public function export(Request $request)
    {
        $query = GetOfficialOfficeTransactionController::baseQuery();
        $debtsPettyCashCounterParty = GetOfficialOfficeTransactionController::baseQuery()->where('financial_type', 'بدهکار')->sum('amount');
        $creditsPettyCashCounterParty = GetOfficialOfficeTransactionController::baseQuery()->where('financial_type', 'بستانکار')->sum('amount');
        $monthOptions = [];
        $currentMonth = Jalalian::now();
        for ($i = 0; $i < 12; $i++) {
            $month = clone $currentMonth;
            if ($i > 0) {
                $month = $month->subMonths($i);
            }

            $monthOptions[] = [
                'value' => $month->format('Y-m'),
                'label' => $month->format('%B %Y'),
                'from' => $month->getFirstDayOfMonth()->format('Y-m-d'),
                'to' => $month->getEndDayOfMonth()->format('Y-m-d'),
            ];
        }

        $selectedMonthInput = $request->input('month', $monthOptions[0]['value']);
        $selectedMonth = convertPersianToEnglish($selectedMonthInput);
        if (!preg_match('/^\d{4}-\d{2}$/', $selectedMonth)) {
            $selectedMonth = $monthOptions[0]['value'];
        } else {
            [, $selectedMonthNumber] = array_map('intval', explode('-', $selectedMonth));
            if ($selectedMonthNumber < 1 || $selectedMonthNumber > 12) {
                $selectedMonth = $monthOptions[0]['value'];
            }
        }

        $selectedMonthJalali = Jalalian::fromFormat('Y-m-d', $selectedMonth . '-01');
        $defaultFrom = $selectedMonthJalali->getFirstDayOfMonth()->format('Y-m-d');
        $defaultTo = $selectedMonthJalali->getEndDayOfMonth()->format('Y-m-d');

        $fromValue = $request->filled('from') ? convertPersianToEnglish($request->input('from')) : $defaultFrom;
        $toValue = $request->filled('to') ? convertPersianToEnglish($request->input('to')) : $defaultTo;

        if ($fromValue) {
            $from = convertPersianToEnglish($fromValue);
            $from = Jalalian::fromFormat('Y-m-d', $from)
                ->toCarbon()
                ->startOfDay()
                ->timestamp;
            $fromMilisecends = $from . '000';
            $query->where('transaction_or_cheque_due_date_alt', '>=', $fromMilisecends);
        }
        if ($toValue) {
            $to = convertPersianToEnglish($toValue);
            $to = Jalalian::fromFormat('Y-m-d', $to)
                ->toCarbon()
                ->endOfDay()
                ->timestamp;
            $toMiliSeconds = $to . '000';
            $query->where('transaction_or_cheque_due_date_alt', '<=', $toMiliSeconds);
        }
        $officialOfficeTransactions = $query->orderByDesc('transaction_or_cheque_due_date')->get();
        $fileName = 'گزارش تراکنش های دفتر معین از ' . $fromValue . ' تا ' . $toValue . '.xlsx';
        return Excel::download(new OfficialOfficeTransactionExport($officialOfficeTransactions), $fileName);
    }
}

