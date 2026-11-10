<?php

namespace Behin\SimpleWorkflowReport\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BorrowRequestsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    public function __construct(
        private readonly Collection $requests,
        private readonly array $statuses
    ) {
    }

    public function collection(): Collection
    {
        return $this->requests;
    }

    public function headings(): array
    {
        return [
            'کالا',
            'شناسه کالا',
            'تعداد',
            'درخواست کننده',
            'وضعیت',
            'تاریخ درخواست',
            'تاریخ تحویل',
            'تاریخ بازگشت مورد انتظار',
            'تاریخ بازگشت',
            'توضیحات موجود نبودن',
        ];
    }

    public function map($request): array
    {
        if (is_array($request)) {
            $request = (object) $request;
        }

        $requesterName = '-';
        if (!empty($request->requester_id)) {
            $info = getUserInfo($request->requester_id);
            $requesterName = $info->name ?? $info->full_name ?? '-';
        }

        $statusKey = $request->status ?? '';
        $statusLabel = $this->statuses[$statusKey]['label'] ?? $statusKey;

        return [
            $request->item_name ?? '',
            $request->item_id ?? '',
            $request->quantity ?? '',
            $requesterName,
            $statusLabel,
            $this->formatTimestamp($request->created_at ?? null, true),
            $this->formatTimestamp($request->delivered_at_alt ?? null),
            $this->formatTimestamp($request->expected_return_date_alt ?? null),
            $this->formatTimestamp($request->actual_return_date_alt ?? $request->actual_return_date ?? null),
            $this->notAvailableDescription($request),
        ];
    }

    private function notAvailableDescription(mixed $request): string
    {
        if (($request->status ?? null) !== 'not_available') {
            return '';
        }

        $parts = [];

        if (!empty($request->not_available_at)) {
            $parts[] = 'تاریخ اعلام: ' . $request->not_available_at;
        }

        if (!empty($request->not_available_by)) {
            $info = getUserInfo($request->not_available_by);
            $parts[] = 'ثبت توسط: ' . ($info->name ?? $info->full_name ?? $request->not_available_by);
        }

        if (!empty($request->not_available_note)) {
            $parts[] = 'توضیح: ' . $request->not_available_note;
        }

        return implode(' | ', $parts);
    }

    private function formatTimestamp(mixed $value, bool $isCarbon = false): string
    {
        if (empty($value)) {
            return '';
        }

        try {
            if ($isCarbon) {
                return toJalali($value)->format('Y-m-d H:i:s');
            }

            return toJalali(is_numeric($value) ? (int) $value : $value)->format('Y-m-d H:i:s');
        } catch (\Throwable) {
            return '';
        }
    }
}
