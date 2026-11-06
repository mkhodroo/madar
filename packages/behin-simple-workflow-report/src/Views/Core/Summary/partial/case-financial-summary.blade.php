@php
    $summary = $financialSummary ?? [
        'total_debit' => 0,
        'total_credit' => 0,
        'balance' => 0,
    ];
    $balance = (float) ($summary['balance'] ?? 0);
@endphp

<div class="card-footer bg-light">
    <div class="row text-center">
        <div class="col-md-4 mb-2 mb-md-0">
            <strong>مجموع بدهکاری:</strong>
            <span class="text-danger" dir="ltr">{{ number_format($summary['total_debit'] ?? 0) }}</span>
        </div>
        <div class="col-md-4 mb-2 mb-md-0">
            <strong>مجموع بستانکاری:</strong>
            <span class="text-success" dir="ltr">{{ number_format($summary['total_credit'] ?? 0) }}</span>
        </div>
        <div class="col-md-4">
            <strong>وضعیت لحظه‌ای مشتری برای این پرونده:</strong>
            @if ($balance < 0)
                <span class="badge badge-danger">بدهکار</span>
                <span dir="ltr">{{ number_format(abs($balance)) }}</span>
            @elseif ($balance > 0)
                <span class="badge badge-success">بستانکار</span>
                <span dir="ltr">{{ number_format($balance) }}</span>
            @else
                <span class="badge badge-secondary">تسویه</span>
            @endif
        </div>
    </div>
</div>