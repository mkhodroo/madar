

@extends('behin-layouts.app')

@section('title', 'لیست خرید خارجی')

@section('content')
    @if (access('مدیریت لیست خرید خارجی'))
        <div class="card">
            <div class="card-header card-header-buy-out">
                <h3 class="card-title">لیست خرید خارجی</h3>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('simpleWorkflowReport.consumable-parts.export-buying-out') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-file-excel"></i> خروجی Excel خرید خارجی
                </a>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered table-buy-out">
                    <thead>
                        <tr>
                            <th>تاریخ درخواست</th>
                            <th>شماره پرونده</th>
                            <th>نام مشتری</th>
                            <th>قطعه</th>
                            <th>تعداد مورد نیاز برای خرید</th>
                            <th>وضعیت</th>
                            <th>منبع تامین</th>
                            <th>شماره فاکتور</th>
                            <th class="col-invoice-date">تاریخ فاکتور</th>
                            <th class="col-invoice-date">تاریخ سفارش</th>
                            <th class="col-invoice-date">تاریخ دریافت</th>
                            <th style="width: 250px !important">مبلغ</th>
                            <th>قیمت واحد</th>
                            <th>واحد پول</th>
                            <th>تعداد خریداری شده</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consumableParts->whereIn('consumable_part_status', ['در انتظار خرید خارجی', 'در حال استعلام قیمت خارجی', 'سفارش خرید خارجی گذاشته شد', 'در انتظار دریافت هزینه از مشتری']) as $consumablePart)
                            <form
                                action="{{ route('simpleWorkflowReport.consumable-parts.store-external-buying-info', $consumablePart->id) }}"
                                method="post">
                                @csrf
                                @method('PUT')
                                <tr>
                                    <td dir="ltr">{{ toJalali($consumablePart->created_at) }}</td>
                                    <td>{{ $consumablePart->case_number }}</td>
                                    <td>{{ $consumablePart->case()?->customerName() ?? '' }}[[ $consumablePart->customer_name ]]</td>
                                    <td>{{ $consumablePart->product_name }}</td>
                                    <td>{{ $consumablePart->required_quantity_to_purchase }}</td>
                                    {{-- <td>
                                        <input type="number" name="required_quantity_to_purchase" id=""
                                            value="{{ $consumablePart->required_quantity_to_purchase }}"
                                            class="form-control">
                                    </td> --}}
                                    <td style="width: 300px">
                                        <select name="consumable_part_status" id="" class="form-control"
                                            style="width: 350px">
                                            @foreach (collect($statuses)->whereIn('key', ['pending_buy_in', 'pending_buy_out', 'requested', 'inquiring_price', 'purchase_order_placed', 'waiting_to_receive_payment_from_the_customer']) as $status)
                                                <option value="{{ $status['label'] }}"
                                                    {{ $status['label'] == $consumablePart->consumable_part_status ? 'selected' : '' }}>
                                                    {{ $status['label'] }}{{ !empty($status['assignee']) ? ' (' . $status['assignee'] . ')' : '' }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="supply_source" id="supply_source"
                                            value="{{ $consumablePart->supply_source }}" class="form-control"
                                            style="width: 150px">
                                    </td>
                                    <td>
                                        <input type="text" name="invoice_number" id="invoice_number"
                                            value="{{ $consumablePart->invoice_number }}" class="form-control"
                                            style="width: 150px">
                                    </td>
                                    <td class="col-invoice-date">
                                        @include('SimpleWorkflowView::Core.Form.field-generator', [
                                            'fieldName' => 'invoice_date',
                                            'fieldId' => 'invoice_date_' . $consumablePart->id,
                                            'fieldClass' => 'col-sm-12 text-center',
                                            'readOnly' => false,
                                            'required' => false,
                                            'showLabel' => false,
                                            'fieldValue' => $consumablePart->invoice_date,
                                            'fieldValueAlt' => $consumablePart->invoice_date_alt,
                                        ])
                                    </td>
                                    <td class="col-invoice-date">
                                        @include('SimpleWorkflowView::Core.Form.field-generator', [
                                            'fieldName' => 'order_date',
                                            'fieldId' => 'order_date_' . $consumablePart->id,
                                            'fieldClass' => 'col-sm-12 text-center',
                                            'readOnly' => false,
                                            'required' => false,
                                            'showLabel' => false,
                                            'fieldValue' => $consumablePart->additional_info?->order_date,
                                            'fieldValueAlt' => $consumablePart->additional_info?->order_date_alt,
                                        ])
                                    </td>
                                    <td class="col-invoice-date">
                                        @include('SimpleWorkflowView::Core.Form.field-generator', [
                                            'fieldName' => 'receipt_date',
                                            'fieldId' => 'receipt_date_' . $consumablePart->id,
                                            'fieldClass' => 'col-sm-12 text-center',
                                            'readOnly' => false,
                                            'required' => false,
                                            'showLabel' => false,
                                            'fieldValue' => $consumablePart->additional_info?->receipt_date,
                                            'fieldValueAlt' => $consumablePart->additional_info?->receipt_date_alt,
                                        ])
                                    </td>
                                    <td style="width:100px">
                                        <input type="text" name="amount" id="amount"
                                                value="{{ $consumablePart->amount }}" dir="ltr" class="form-control formatted-digit"
                                                style="width: 150px">
                                        
                                    </td>
                                    <td>
                                        <input type="text" name="unit_price" id="unit_price_{{ $consumablePart->id }}"
                                            value="{{ $consumablePart->additional_info?->unit_price }}" dir="ltr"
                                            class="form-control formatted-digit" style="width: 150px">
                                    </td>
                                    <td>
                                        <select name="currency" id="currency_{{ $consumablePart->id }}" class="form-control"
                                            style="width: 120px">
                                            <option value="">انتخاب کنید</option>
                                            @foreach ($currencies ?? [] as $currency)
                                                <option value="{{ $currency['key'] }}"
                                                    {{ ($consumablePart->additional_info?->currency ?? '') == $currency['key'] ? 'selected' : '' }}>
                                                    {{ $currency['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="purchased_quantity" id=""
                                            value="{{ $consumablePart->purchased_quantity }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="submit" name="" id=""
                                            class="btn btn-sm btn-primary" value="ذخیره">
                                    </td>
                                </tr>
                            </form>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection


    @section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const selects = document.querySelectorAll('.consumable-status');

            selects.forEach(function(select) {

                function togglePurchaseField() {

                    const selectedValue = select.value;
                    const id = select.dataset.id;

                    const box = document.getElementById('purchase-box-' + id);

                    if (
                        selectedValue === 'در انتظار خرید داخلی' ||
                        selectedValue === 'در انتظار خرید خارجی'
                    ) {
                        box.style.display = 'block';
                    } else {
                        box.style.display = 'none';
                    }
                }

                // بار اول
                togglePurchaseField();

                // هنگام تغییر
                select.addEventListener('change', togglePurchaseField);
            });

        });
    </script>
    <script>
        function showAdditionalInfoModal(consumablePartId){
            
            var url = `[[ route('simpleWorkflowReport.consumable-parts.additional-info.show', 'consumablePart') ]]`;
            url = url.replace('consumablePart', consumablePartId);
            open_admin_modal(url);
        }
    </script>
@endsection
