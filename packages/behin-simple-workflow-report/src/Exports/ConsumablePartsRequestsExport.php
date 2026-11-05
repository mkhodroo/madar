<?php

namespace Behin\SimpleWorkflowReport\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ConsumablePartsRequestsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    public function __construct(
        private readonly Collection $requests,
        private readonly bool $withPrices = false
    ) {
    }

    public function collection(): Collection
    {
        return $this->requests;
    }

    public function headings(): array
    {
        $headings = [
            'تاریخ درخواست',
            'شماره پرونده',
            'نام مشتری',
            'درخواست کننده',
            'قطعه',
            'تعداد مورد نیاز',
            'تعداد تحویل شده',
            'تعداد بازگشت شده به انبار',
            'منبع تامین',
            'شماره فاکتور',
            'تاریخ فاکتور',
            'تاریخ سفارش',
            'تاریخ دریافت',
            'مبلغ',
            'قیمت واحد',
            'واحد پول',
            'تعداد خریداری شده',
            'وضعیت',
        ];

        if (!$this->withPrices) {
            $headings = array_slice($headings, 0, 13);
        }

        return $headings;
    }

    public function map($request): array
    {
        if (is_array($request)) {
            $request = (object) $request;
        }

        $requesterName = '';
        if (!empty($request->created_by)) {
            $info = getUserInfo($request->created_by);
            $requesterName = $info->name ?? $info->full_name ?? '';
        }

        $row = [
            $this->formatCarbon($request->created_at ?? null),
            $request->case_number ?? '',
            $request->case()?->customerName() ?? ($request->customer_name ?? ''),
            $request->created_by ? getUserInfo($request->created_by)?->name : '',
            $request->product_name ?? '',
            $request->requested_quantity ?? '',
            $request->delivered_quantity ?? '',
            $request->returned_quantity ?? '',
            $request->supply_source ?? '',
            $request->invoice_number ?? '',
            $request->invoice_date ?? '',
            $request->additional_info?->order_date ?? '',
            $request->additional_info?->receipt_date ?? '',
            $request->amount ?? '',
        ];

        if ($this->withPrices) {
            $additional = is_array($request->additional_info ?? null)
                ? (object) $request->additional_info
                : ($request->additional_info ?? null);

            $currencyLabel = '';
            if ($additional && method_exists($additional, 'currencyLabel')) {
                $currencyLabel = $additional->currencyLabel();
            } elseif ($additional && !empty($additional->currency)) {
                $currencyLabel = $additional->currency;
            }

            $row = array_merge($row, [
                $additional->unit_price ?? '',
                $currencyLabel,
                $request->purchased_quantity ?? '',
                $request->consumable_part_status ?? '',
            ]);
        } else {
            $row[] = '';
            $row[] = '';
            $row[] = '';
            $row[] = $request->consumable_part_status ?? '';
        }

        return $row;
    }

    private function formatCarbon(mixed $value): string
    {
        if (empty($value)) {
            return '';
        }

        try {
            return toJalali($value)->format('Y-m-d H:i');
        } catch (\Throwable) {
            return '';
        }
    }
}
