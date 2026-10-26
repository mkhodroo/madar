<?php

namespace Behin\SimpleWorkflowReport\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ConsumablePartsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
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
            'قطعه',
            'شناسه کالا',
            'درخواست کننده',
            'تعداد درخواست شده',
            'تعداد تحویل شده',
            'تعداد بازگشت داده شده',
            'وضعیت',
            'تاریخ درخواست',
        ];

        if ($this->withPrices) {
            $headings = array_merge($headings, [
                'قیمت',
                'قیمت واحد',
                'واحد پول',
                'منبع تامین',
                'تاریخ فاکتور',
                'شماره فاکتور',
                'تاریخ سفارش',
                'تاریخ دریافت',
            ]);
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
            $request->product_name ?? '',
            $request->item_id ?? ($request->product_id ?? ''),
            $requesterName,
            $request->requested_quantity ?? '',
            $request->delivered_quantity ?? '',
            $request->returned_quantity ?? '',
            $request->consumable_part_status ?? '',
            $this->formatCarbon($request->created_at ?? null),
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
                $request->amount ?? '',
                $additional->unit_price ?? '',
                $currencyLabel,
                $request->supply_source ?? '',
                $request->invoice_date ?? '',
                $request->invoice_number ?? '',
                $additional->order_date ?? '',
                $additional->receipt_date ?? '',
            ]);
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
