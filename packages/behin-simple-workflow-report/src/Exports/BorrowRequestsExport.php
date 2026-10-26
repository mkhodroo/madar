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
            $request->actual_return_date ?? '',
        ];
    }

    private function formatTimestamp(mixed $value, bool $isCarbon = false): string
    {
        if (empty($value)) {
            return '';
        }

        try {
            if ($isCarbon) {
                return toJalali($value)->format('Y-m-d');
            }

            return toJalali((int) $value)->format('Y-m-d');
        } catch (\Throwable) {
            return '';
        }
    }
}
