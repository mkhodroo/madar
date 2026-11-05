<?php

namespace Behin\SimpleWorkflowReport\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ConsumablePartsBuyingOutExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    public function __construct(
        private readonly Collection $requests
    ) {
    }

    public function collection(): Collection
    {
        return $this->requests;
    }

    public function headings(): array
    {
        return [
            'تاریخ درخواست',
            'شماره پرونده',
            'نام مشتری',
            'قطعه',
            'تعداد مورد نیاز برای خرید',
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

        return [
            $this->formatCarbon($request->created_at ?? null),
            $request->case_number ?? '',
            $request->case()?->customerName() ?? ($request->customer_name ?? ''),
            $request->product_name ?? '',
            $request->required_quantity_to_purchase ?? '',
            $request->supply_source ?? '',
            $request->invoice_number ?? '',
            $request->invoice_date ?? '',
            $request->additional_info?->order_date ?? '',
            $request->additional_info?->receipt_date ?? '',
            $request->amount ?? '',
            $request->additional_info?->unit_price ?? '',
            $this->formatCurrency($request->additional_info?->currency ?? ''),
            $request->purchased_quantity ?? '',
            $request->consumable_part_status ?? '',
        ];
    }

    private function formatCurrency(string $key): string
    {
        $currencies = config('simpleWorkflowReport.consumable_parts.currencies', []);
        foreach ($currencies as $currency) {
            if ($currency['key'] === $key) {
                return $currency['label'];
            }
        }

        return $key;
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
