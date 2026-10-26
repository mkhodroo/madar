@extends('behin-layouts.app')

@section('title', 'گزارش تراکنش های دفتر معین')
@php
    use Morilog\Jalali\Jalalian;
@endphp

@section('content')
    <div class="card">
        <div class="card-body">
            <form class="row" method="GET">
                <div class="col-md-3">
                    <select name="month" id="month-filter" class="form-select form-control">
                        @foreach ($monthOptions as $option)
                            <option value="{{ $option['value'] }}" data-from="{{ $option['from'] }}"
                                data-to="{{ $option['to'] }}" {{ $selectedMonth === $option['value'] ? 'selected' : '' }}>
                                {{ $option['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="from" class="form-control persian-date" value="{{ $fromValue }}"
                        placeholder="از تاریخ">
                </div>
                <div class="col-md-3">
                    <input type="text" name="to" class="form-control persian-date" value="{{ $toValue }}"
                        placeholder="تا تاریخ">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-warning" type="submit">فیلتر</button>
                    <a href="{{ route('official-office-transactions.export', ['from' => $fromValue, 'to' => $toValue, 'month' => $selectedMonth]) }}"
                        class="btn btn-success">خروجی اکسل</a>
                </div>
            </form>
        </div>
    </div>
    <div class="card mb-3">

        <div class="card-body table-responsive">
            <table class="table table-bordered" id="petty-cash-table">
                <thead>
                    <tr>
                        <th>طرف حساب</th>
                        <th>بستانکار</th>
                        <th>بدهکار</th>
                        <th>تاریخ پرداخت</th>
                        <th>مقصد حساب</th>
                        <th>پرونده</th>
                        <th>توضیحات</th>
                        <th>رسید</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($officialOfficeTransactions as $item)
                        <tr data-financial-type="{{ $item->financial_type }}"
                            @if ($item->financial_type == 'بدهکار') style="background: #f56c6c"
                            @elseif ($item->financial_type == 'بستانکار') 
                                class="bg-success" @endif>
                            <td>[[ $item->counterparty()?->name ?? '' ]]</td>
                            <td>[[ $item->financial_type == 'بستانکار' ? number_format($item->amount) : '' ]]</td>
                            <td>[[ $item->financial_type == 'بدهکار' ? number_format($item->amount) : '' ]]</td>
                            <td>{{ $item->transaction_or_cheque_due_date }}</td>
                            <td>{{ $item->destinationAccount() }}</td>
                            <td>{{ $item->case_number }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{!! $item->fileLink() !!}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>جمع:</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            مانده حساب: [[ number_format($debtsPettyCashCounterParty - $creditsPettyCashCounterParty) ]]
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#petty-cash-table').DataTable({
            language: {
                url: '{{ url('behin/lang/datatable.json') }}'
            },
            order: [
                [3, "desc"]
            ],
            pageLength: 25,
            footerCallback: function(row, data, start, end, display) {

                var api = this.api();

                function parseNumber(value) {
                    return parseInt(
                        (value || '0').toString().replace(/,/g, '')
                    ) || 0;
                }

                let creditTotal = 0; // بستانکار کل
                let debitTotal = 0; // بدهکار کل

                let creditPageTotal = 0; // بستانکار صفحه
                let debitPageTotal = 0; // بدهکار صفحه

                // جمع کل
                api.rows({
                    search: 'applied'
                }).every(function() {

                    let row = this.data();

                    creditTotal += parseNumber(row[1]);
                    debitTotal += parseNumber(row[2]);

                });

                // جمع صفحه جاری
                api.rows({
                    search: 'applied',
                    page: 'current'
                }).every(function() {

                    let row = this.data();

                    creditPageTotal += parseNumber(row[1]);
                    debitPageTotal += parseNumber(row[2]);

                });

                // نمایش در فوتر
                $(api.column(1).footer()).html(
                    'جمع بستانکار صفحه: ' + creditPageTotal.toLocaleString() +
                    '<br>جمع بستانکار کل: ' + creditTotal.toLocaleString()
                );

                $(api.column(2).footer()).html(
                    'جمع بدهکار صفحه: ' + debitPageTotal.toLocaleString() +
                    '<br>جمع بدهکار کل: ' + debitTotal.toLocaleString()
                );

                // اگر مانده هم بخواهید
                $(api.column(3).footer()).html(
                    'مانده صفحه: ' + (debitPageTotal - creditPageTotal).toLocaleString() +
                    '<br>مانده کل: ' + (debitTotal - creditTotal).toLocaleString()
                );
            }
        });

        $(function() {
            var monthFilter = document.getElementById('month-filter');
            var fromInput = document.querySelector('input[name="from"]');
            var toInput = document.querySelector('input[name="to"]');

            function applySelectedMonth() {
                if (!monthFilter) {
                    return;
                }
                var selectedOption = monthFilter.options[monthFilter.selectedIndex];
                if (!selectedOption) {
                    return;
                }
                if (fromInput && selectedOption.dataset.from) {
                    fromInput.value = selectedOption.dataset.from;
                }
                if (toInput && selectedOption.dataset.to) {
                    toInput.value = selectedOption.dataset.to;
                }
            }

            if (monthFilter) {
                monthFilter.addEventListener('change', applySelectedMonth);
            }
        });
    </script>
@endsection
