@extends('behin-layouts.app')

@section('title', 'درخواست قطعات مصرفی')

@section('content')
    <style>
        td,
        th {
            white-space: nowrap;
        }

        /* استایل مدرن هدر جدول‌ها */
        .table thead th {
            text-align: center;
            vertical-align: middle;
            padding: 14px 10px;
            font-size: 1.05rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: .2px;
            border: 1px solid rgba(255, 255, 255, .3) !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, .35);
        }

        .table thead th:first-child {
            border-top-right-radius: .5rem;
            border-bottom-right-radius: .5rem;
        }

        .table thead th:last-child {
            border-top-left-radius: .5rem;
            border-bottom-left-radius: .5rem;
        }

        /* هدر کارت‌ها */
        .card-header {
            padding: 14px 18px;
            border-bottom: none;
            border-radius: .5rem .5rem 0 0;
        }

        .card-header .card-title {
            margin: 0;
            text-align: center;
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            text-shadow: 0 1px 2px rgba(0, 0, 0, .25);
        }

        /* کارت ۱: درخواست قطعات مصرفی (آبی) */
        .card-header-parts {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 55%, #3a7bd5 100%);
        }

        /* کارت ۲: لیست خرید داخلی (سبز) */
        .card-header-buy-in {
            background: linear-gradient(135deg, #134e5e 0%, #1b7a5a 55%, #2fb37c 100%);
        }

        /* کارت ۳: لیست خرید خارجی (نارنجی/قرمز) */
        .card-header-buy-out {
            background: linear-gradient(135deg, #8a2b0f 0%, #c14a12 55%, #e8791b 100%);
        }

        /* هدر جدول‌ها هماهنگ با رنگ کارت خودشان (کمرنگ‌تر) */
        .table-parts thead th {
            background: linear-gradient(135deg, #4a6fa5 0%, #5f8ac0 55%, #7fadde 100%);
        }

        .table-buy-in thead th {
            background: linear-gradient(135deg, #3d7a68 0%, #4e9c84 55%, #6cbda7 100%);
        }

        .table-buy-out thead th {
            background: linear-gradient(135deg, #b06a3c 0%, #c88a4e 55%, #dda06a 100%);
        }

        /* ستون تاریخ فاکتور در لیست خرید خارجی: نمایش کامل تاریخ */
        .table-buy-out th.col-invoice-date,
        .table-buy-out td.col-invoice-date {
            min-width: 170px;
        }

        .table-buy-out td.col-invoice-date .form-group {
            margin-bottom: 0;
            min-width: 160px;
        }

        .table-buy-out td.col-invoice-date .form-control {
            width: 160px;
            display: inline-block;
        }
    </style>
    @if (access('مدیریت انبار قطعات مصرفی'))
        <div class="card">
            <div class="card-header card-header-parts">
                <h3 class="card-title">درخواست قطعات مصرفی</h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered table-parts">
                    <thead>
                        <tr>
                            <th>تاریخ درخواست</th>
                            <th>شماره پرونده</th>
                            <th>نام مشتری</th>
                            <th>درخواست کننده</th>
                            <th>قطعه</th>
                            <th>تعداد مورد نیاز</th>
                            <th>تعداد تحویل شده</th>
                            <th>تعداد بازگشت شده به انبار</th>
                            <th>منبع تامین</th>
                            <th>شماره فاکتور</th>
                            <th>تاریخ فاکتور</th>
                            <th style="width: 250px !important">مبلغ</th>
                            <th style="width: 250px !important">وضعیت</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consumableParts->whereIn('consumable_part_status', ['در انتظار تحویل انبار', 'در انتظار تایید بازگشتی ها توسط انبار']) as $consumablePart)
                            <form action="{{ route('simpleWorkflowReport.consumable-parts.deliver', $consumablePart->id) }}"
                                method="post">
                                @csrf
                                @method('PUT')
                                <tr>
                                    <td dir="ltr">{{ toJalali($consumablePart->created_at) }}</td>
                                    <td>{{ $consumablePart->case_number ?? '' }}</td>
                                    <td>{{ $consumablePart->case()?->customerName() ?? '' }}[[ $consumablePart->customer_name ]]</td>
                                    <td>{{ $consumablePart->created_by ? getUserInfo($consumablePart->created_by)?->name : '' }}
                                    </td>
                                    <td>{{ $consumablePart->product_name }}</td>
                                    <td>{{ $consumablePart->requested_quantity }}</td>
                                    <td>
                                        @if ($consumablePart->consumable_part_status == 'در انتظار تحویل انبار')
                                            <input type="number" name="delivered_quantity" id=""
                                                value="{{ $consumablePart->delivered_quantity }}" class="form-control">
                                        @else
                                            {{ $consumablePart->delivered_quantity }}
                                        @endif
                                    </td>
                                    <td>{{ $consumablePart->returned_quantity }}</td>
                                    @if ($consumablePart->external_buying_is_done == 1)
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @else
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
                                        <td>
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
                                        <td>
                                            <input type="text" name="amount" id="amount"
                                                value="{{ $consumablePart->amount }}" dir="ltr" class="form-control"
                                                style="width: 150px">
                                        </td>
                                    @endif
                                    <td style="width: 250px">
                                        <select name="consumable_part_status" id=""
                                            class="form-control consumable-status" data-id="{{ $consumablePart->id }}"
                                            style="width: 250px">
                                            @foreach (collect($statuses)->whereNotIn('key', ['inquiring_price']) as $status)
                                                <option value="{{ $status['label'] }}"
                                                    {{ $status['label'] == $consumablePart->consumable_part_status ? 'selected' : '' }}>
                                                    {{ $status['label'] }}</option>
                                            @endforeach
                                        </select>
                                        {{-- فیلد تعداد خرید --}}
                                        <div class="purchase-quantity-box mt-2" id="purchase-box-{{ $consumablePart->id }}"
                                            style="display:none;">

                                            <div class="alert alert-warning p-2 mb-2">
                                                چندتا از این بخریم؟
                                            </div>

                                            <input type="number" name="required_quantity_to_purchase" class="form-control"
                                                placeholder="تعداد مورد نیاز برای خرید">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="submit" name="" id="" class="btn btn-sm btn-primary"
                                            value="ذخیره">
                                    </td>
                                </tr>
                            </form>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if (access('مدیریت لیست خرید داخلی'))
        <div class="card">
            <div class="card-header card-header-buy-in">
                <h3 class="card-title">لیست خرید داخلی</h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered table-buy-in">
                    <thead>
                        <tr>
                            <th>تاریخ درخواست</th>
                            <th>شماره پرونده</th>
                            <th>نام مشتری</th>
                            <th>قطعه</th>
                            <th>تعداد مورد نیاز برای خرید</th>
                            <th>تعداد خریداری شده</th>
                            <th>وضعیت</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consumableParts->whereIn('consumable_part_status', ['در انتظار خرید داخلی']) as $consumablePart)
                            <form
                                action="{{ route('simpleWorkflowReport.consumable-parts.deliver', $consumablePart->id) }}"
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
                                    <td>
                                        <input type="number" name="purchased_quantity" id=""
                                            value="{{ $consumablePart->purchased_quantity }}" class="form-control">
                                    </td>
                                    <td style="width: 250px">
                                        <select name="consumable_part_status" id="" class="form-control"
                                            style="width: 250px">
                                            @foreach (collect($statuses)->whereIn('key', ['pending_buy_in', 'pending_buy_out', 'requested']) as $status)
                                                <option value="{{ $status['label'] }}"
                                                    {{ $status['label'] == $consumablePart->consumable_part_status ? 'selected' : '' }}>
                                                    {{ $status['label'] }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="submit" name="" id="" class="btn btn-sm btn-primary"
                                            value="ذخیره">
                                    </td>
                                </tr>
                            </form>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if (access('مدیریت لیست خرید خارجی'))
        <div class="card">
            <div class="card-header card-header-buy-out">
                <h3 class="card-title">لیست خرید خارجی</h3>
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
                            <th>منبع تامین</th>
                            <th>شماره فاکتور</th>
                            <th class="col-invoice-date">تاریخ فاکتور</th>
                            <th class="col-invoice-date">تاریخ سفارش</th>
                            <th class="col-invoice-date">تاریخ دریافت</th>
                            <th style="width: 250px !important">مبلغ</th>
                            <th>قیمت واحد</th>
                            <th>واحد پول</th>
                            <th>تعداد خریداری شده</th>
                            <th>وضعیت</th>
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
                                    <td style="width: 250px">
                                        <select name="consumable_part_status" id="" class="form-control"
                                            style="width: 250px">
                                            @foreach (collect($statuses)->whereIn('key', ['pending_buy_in', 'pending_buy_out', 'requested', 'inquiring_price', 'purchase_order_placed', 'waiting_to_receive_payment_from_the_customer']) as $status)
                                                <option value="{{ $status['label'] }}"
                                                    {{ $status['label'] == $consumablePart->consumable_part_status ? 'selected' : '' }}>
                                                    {{ $status['label'] }}</option>
                                            @endforeach
                                        </select>
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
