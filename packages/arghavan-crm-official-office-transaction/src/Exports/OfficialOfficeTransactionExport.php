<?php

namespace Arghavan\OfficialOfficeTransaction\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class OfficialOfficeTransactionExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
{
    use Exportable;

    public function __construct(private readonly Collection $rows)
    {
    }

    public function collection(): Collection
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'طرف حساب',
            'بستانکار',
            'بدهکار',
            'تاریخ پرداخت',
            'مقصد حساب',
            'پرونده',
            'توضیحات',
            'رسید',
        ];
    }

    public function map($row): array
    {
        if (is_array($row)) {
            $row = (object) $row;
        }

        $title = $row->counterparty()?->name ?? '';

        $financialType = $row->financial_type ?? '';

        $amount = $row->amount ?? 0;

        $amountFormatted = number_format($amount);

        $debit = $financialType === 'بدهکار' ? $amountFormatted : '';
        $credit = $financialType === 'بستانکار' ? $amountFormatted : '';

        $date = $row->transaction_or_cheque_due_date ?? '';

        $destinationAccount = method_exists($row, 'destinationAccount')
            ? $row->destinationAccount()
            : trim(($row->destination_account_name ?? '') . ' - ' . ($row->destination_account_number ?? ''), ' -');

        $caseNumber = $row->case_number ?? '';

        $description = $row->description ?? '';

        $fileUrl = method_exists($row, 'fileUrl')
            ? $row->fileUrl()
            : (!empty($row->file) ? url($row->file) : null);

        return [
            $title,
            $credit,
            $debit,
            $date,
            $destinationAccount,
            $caseNumber,
            $description,
            $fileUrl ?? '',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->setRightToLeft(true);

                $totalCredit = 0;
                $totalDebit = 0;
                foreach ($this->rows as $row) {
                    if (is_array($row)) {
                        $row = (object) $row;
                    }
                    $amount = (int) str_replace(',', '', (string) ($row->amount ?? 0));
                    if (($row->financial_type ?? '') === 'بستانکار') {
                        $totalCredit += $amount;
                    } elseif (($row->financial_type ?? '') === 'بدهکار') {
                        $totalDebit += $amount;
                    }
                }

                $totalsRow = $this->rows->count() + 2;
                $sheet->setCellValue('A' . $totalsRow, 'جمع:');
                $sheet->setCellValue('B' . $totalsRow, number_format($totalCredit));
                $sheet->setCellValue('C' . $totalsRow, number_format($totalDebit));
                $sheet->setCellValue(
                    'D' . $totalsRow,
                    'مانده: ' . number_format($totalDebit - $totalCredit)
                );
                $sheet->getStyle('A' . $totalsRow . ':H' . $totalsRow)->getFont()->setBold(true);
            },
        ];
    }
}

