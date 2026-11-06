@extends('behin-layouts.app')


@section('title')
    خلاصه گزارش فرایند {{ $process->name }}
@endsection

@php
    $financialTransactions = $financialTransactions ?? collect();
    $caseNumber = $caseNumber ?? null;
    $financialSummary = $financialSummary ?? null;

    // دسترسی قابل تخصیص به نقش‌های مختلف (در صورت نبود، به صورت غیرفعال در لیست دسترسی‌ها ساخته می‌شود)
    $canViewCaseFinancial = access('گزارش مالی پرونده از دفتر معین');

    $debitTransactions = $financialTransactions->where('financial_type', 'بدهکار');
    $creditTransactions = $financialTransactions->where('financial_type', 'بستانکار');

    // محاسبه مانده تجمعی به ترتیب تاریخ
    $runningBalance = 0;
    $cumulativeTransactions = $financialTransactions
        ->sortBy(function ($transaction) {
            return $transaction->transaction_or_cheque_due_date_alt ?: $transaction->transaction_or_cheque_due_date;
        })
        ->values()
        ->map(function ($transaction) use (&$runningBalance) {
            $amount = (float) str_replace(',', '', (string) $transaction->amount);
            $runningBalance += $transaction->financial_type === 'بستانکار' ? $amount : -$amount;
            $transaction->running_balance = $runningBalance;
            return $transaction;
        });
@endphp

@section('content')
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">لیست پرونده های فرآیند {{ $process->name }}</div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="draft-list">
                                <thead>
                                    <tr>
                                        {{-- <th>ردیف</th> --}}
                                        <th class="d-none">شناسه</th>
                                        <th>شماره پرونده</th>
                                        <th>کارشناس</th>
                                        <th>نام</th>
                                        <th>دستگاه</th>
                                        <th>ایجاد کننده</th>
                                        <th>سریال مپا</th>
                                        <th>آخرین وضعیت</th>
                                        <th>ایجاد شده در</th>
                                        <th>اقدام</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($process->cases as $case)
                                        @php
                                            $name = $case->variables()->where('key', 'customer_fullname')->first()?->value;
                                            $name .= ' ';
                                            $name .= $case
                                                ->variables()
                                                ->where('key', 'customer_workshop_or_ceo_name')
                                                ->first()?->value;
                                            $device_name = $case->variables()->where('key', 'device_name')->first()?->value;

                                            $mapa_expert = $case->variables()->where('key', 'mapa_expert')->first()
                                                ?->value;
                                            $mapa_expert = getUserInfo($mapa_expert)?->name ?? '';
                                            $mapa_serial =
                                                $case->variables()->where('key', 'mapa_serial')->first()?->value ?? '';
                                        @endphp
                                        <tr ondblclick="window.location.href='{{ route('simpleWorkflowReport.summary-report.edit', ['summary_report' => $case->id]) }}'">
                                            {{-- <td>{{ $loop->iteration }}</td> --}}
                                            <td class="d-none">{{ $case->id }}</td>
                                            <td>{{ $case->number }}
                                                <a href="{{ route('simpleWorkflowReport.summary-report.edit', [ 'summary_report' => $case->id ]) }}"><i class="fa fa-external-link"></i></a>
                                                {!! $case->history !!}
                                            </td>
                                            <td>{{ $mapa_expert }}</td>

                                            <td>{{ $name }}</td>
                                            <td>{{ $device_name }}</td>
                                            <td>{{ $case->creator()?->name }}</td>
                                            <td>{{ $mapa_serial }}</td>
                                            @php
                                                $w = '';
                                                // $w = json_encode($case->whereIs());
                                                foreach ($case->whereIs() as $inbox) {
                                                    $w .= $inbox->task->styled_name ?? '';
                                                    $w .= '(' . getUserInfo($inbox->actor)?->name . ')';
                                                    $w .= '<br>';
                                                }
                                            @endphp
                                            <td>{!! $w !!}</td>
                                            <td dir="ltr">{{ toJalali($case->created_at)->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-1">
                                                    <a href="{{ route('simpleWorkflowReport.summary-report.edit', [ 'summary_report' => $case->id ]) }}"><button class="btn btn-primary btn-sm">{{ trans('fields.Show More') }}</button></a>
                                                    @if ($canViewCaseFinancial && filled($case->number))
                                                        <a href="{{ route('simpleWorkflowReport.summary-report.show', ['summary_report' => $process->id, 'case_number' => $case->number]) }}#case-financial-report"
                                                            class="btn btn-info btn-sm">گزارش مالی</a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($canViewCaseFinancial && filled($caseNumber))
            <div class="row justify-content-center mt-3">
                <div class="col-md-12" id="case-financial-report">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            گزارش مالی دفتر معین برای پرونده شماره {{ $caseNumber }}
                        </div>
                        <div class="card-body">
                            @if ($financialTransactions->isEmpty())
                                <div class="alert alert-warning">برای این شماره پرونده تراکنش مالی ثبت نشده است.</div>
                            @endif

                            {{-- جدول بدهکاری‌ها --}}
                            <div class="card mb-4">
                                <div class="card-header bg-danger text-white">جدول بدهکاری‌ها</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="case-debit-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>تاریخ</th>
                                                    <th>طرف حساب</th>
                                                    <th>مبلغ</th>
                                                    <th>نحوه پرداخت</th>
                                                    <th>شماره چک/فاکتور</th>
                                                    <th>توضیحات</th>
                                                    <th>بابت پرونده</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($debitTransactions as $transaction)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td dir="ltr"
                                                            data-order="{{ $transaction->transaction_or_cheque_due_date_alt ?: $transaction->transaction_or_cheque_due_date }}">
                                                            {{ $transaction->transaction_or_cheque_due_date }}</td>
                                                        <td>{{ $transaction->counterparty()?->name ?? '' }}</td>
                                                        <td dir="ltr">
                                                            {{ number_format((float) str_replace(',', '', (string) $transaction->amount)) }}
                                                        </td>
                                                        <td>{{ $transaction->financial_method }}</td>
                                                        <td>{{ $transaction->invoice_or_cheque_number }}</td>
                                                        <td>{{ $transaction->description }}</td>
                                                        <td>{{ $transaction->case_number }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="3" class="text-right">جمع بدهکاری این پرونده:</th>
                                                    <th dir="ltr">{{ number_format($financialSummary['total_debit'] ?? 0) }}</th>
                                                    <th colspan="4"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    @include('SimpleWorkflowReportView::Core.Summary.partial.case-financial-summary', [
                                        'financialSummary' => $financialSummary,
                                    ])
                                </div>
                            </div>

                            {{-- جدول بستانکاری‌ها --}}
                            <div class="card mb-4">
                                <div class="card-header bg-success text-white">جدول بستانکاری‌ها</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="case-credit-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>تاریخ</th>
                                                    <th>طرف حساب</th>
                                                    <th>مبلغ</th>
                                                    <th>نحوه پرداخت</th>
                                                    <th>شماره چک/فاکتور</th>
                                                    <th>توضیحات</th>
                                                    <th>بابت پرونده</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($creditTransactions as $transaction)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td dir="ltr"
                                                            data-order="{{ $transaction->transaction_or_cheque_due_date_alt ?: $transaction->transaction_or_cheque_due_date }}">
                                                            {{ $transaction->transaction_or_cheque_due_date }}</td>
                                                        <td>{{ $transaction->counterparty()?->name ?? '' }}</td>
                                                        <td dir="ltr">
                                                            {{ number_format((float) str_replace(',', '', (string) $transaction->amount)) }}
                                                        </td>
                                                        <td>{{ $transaction->financial_method }}</td>
                                                        <td>{{ $transaction->invoice_or_cheque_number }}</td>
                                                        <td>{{ $transaction->description }}</td>
                                                        <td>{{ $transaction->case_number }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="3" class="text-right">جمع بستانکاری این پرونده:</th>
                                                    <th dir="ltr">{{ number_format($financialSummary['total_credit'] ?? 0) }}</th>
                                                    <th colspan="4"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    @include('SimpleWorkflowReportView::Core.Summary.partial.case-financial-summary', [
                                        'financialSummary' => $financialSummary,
                                    ])
                                </div>
                            </div>

                            {{-- جدول تجمعی بدهکاری و بستانکاری --}}
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">جدول تجمعی (بدهکاری و بستانکاری)</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="case-cumulative-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>تاریخ</th>
                                                    <th>نوع</th>
                                                    <th>طرف حساب</th>
                                                    <th>بدهکار</th>
                                                    <th>بستانکار</th>
                                                    <th>مانده تجمعی</th>
                                                    <th>توضیحات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cumulativeTransactions as $transaction)
                                                    @php
                                                        $transactionAmount = (float) str_replace(',', '', (string) $transaction->amount);
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td dir="ltr"
                                                            data-order="{{ $transaction->transaction_or_cheque_due_date_alt ?: $transaction->transaction_or_cheque_due_date }}">
                                                            {{ $transaction->transaction_or_cheque_due_date }}</td>
                                                        <td>{{ $transaction->financial_type }}</td>
                                                        <td>{{ $transaction->counterparty()?->name ?? '' }}</td>
                                                        <td dir="ltr">
                                                            {{ $transaction->financial_type === 'بدهکار' ? number_format($transactionAmount) : '' }}
                                                        </td>
                                                        <td dir="ltr">
                                                            {{ $transaction->financial_type === 'بستانکار' ? number_format($transactionAmount) : '' }}
                                                        </td>
                                                        <td dir="ltr">{{ number_format($transaction->running_balance) }}</td>
                                                        <td>{{ $transaction->description }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="4" class="text-right">جمع:</th>
                                                    <th dir="ltr">{{ number_format($financialSummary['total_debit'] ?? 0) }}</th>
                                                    <th dir="ltr">{{ number_format($financialSummary['total_credit'] ?? 0) }}</th>
                                                    <th dir="ltr">{{ number_format($financialSummary['balance'] ?? 0) }}</th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    @include('SimpleWorkflowReportView::Core.Summary.partial.case-financial-summary', [
                                        'financialSummary' => $financialSummary,
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script>
        initial_view();
        $('#draft-list').DataTable({
            "stateSave": true,
            "order": [
                [1, "desc"]
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Persian.json"
            }
        });

        // جدول بدهکاری‌های پرونده - مرتب‌سازی بر اساس تاریخ (جدیدترین ابتدا)
        if ($('#case-debit-table').length) {
            $('#case-debit-table').DataTable({
                "order": [
                    [1, "desc"]
                ],
                "pageLength": 25,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Persian.json"
                }
            });
        }

        // جدول بستانکاری‌های پرونده - مرتب‌سازی بر اساس تاریخ (جدیدترین ابتدا)
        if ($('#case-credit-table').length) {
            $('#case-credit-table').DataTable({
                "order": [
                    [1, "desc"]
                ],
                "pageLength": 25,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Persian.json"
                }
            });
        }

        // جدول تجمعی پرونده - مرتب‌سازی بر اساس تاریخ (قدیمی‌ترین ابتدا تا مانده تجمعی درست باشد)
        if ($('#case-cumulative-table').length) {
            $('#case-cumulative-table').DataTable({
                "order": [
                    [1, "asc"]
                ],
                "pageLength": 25,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Persian.json"
                }
            });
        }
    </script>
@endsection
