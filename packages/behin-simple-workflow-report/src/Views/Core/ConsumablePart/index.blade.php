
@extends('behin-layouts.app')

@section('title', 'درخواست قطعات مصرفی')

@section('content')

<style>
    .parts-page {
        --parts-primary: #315da8;
        --parts-border: #e8edf4;
        --parts-muted: #778397;
        direction: rtl;
    }

    .parts-page .card {
        border: 1px solid var(--parts-border);
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(30, 50, 80, .045);
        overflow: hidden;
    }

    .parts-header {
        background: linear-gradient(120deg, #1e3c72, #315da8);
        color: white;
        padding: 17px 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .parts-header h3 {
        margin: 0;
        font-size: 17px;
        font-weight: 700;
    }

    .parts-header .subtitle {
        font-size: 11px;
        opacity: .8;
        margin-top: 5px;
    }

    .parts-header .btn {
        border-radius: 8px;
        font-weight: 600;
    }

    .parts-page .card-body {
        padding: 18px;
        background: #f6f8fc;
    }

    .parts-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .part-card {
        background: white;
        border: 1px solid #e8edf4;
        border-radius: 11px;
        overflow: hidden;
        transition: .2s;
    }

    .part-card:hover {
        border-color: #c8d7ef;
        box-shadow: 0 4px 14px rgba(40, 70, 120, .07);
    }

    .part-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 11px 15px;
        background: #fbfcfe;
        border-bottom: 1px solid #edf0f5;
        flex-wrap: wrap;
    }

    .part-title {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .part-icon {
        width: 35px;
        height: 35px;
        border-radius: 9px;
        background: #edf3ff;
        color: #315da8;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 17px;
    }

    .part-title strong {
        font-size: 13px;
        color: #26364d;
        display: block;
    }

    .part-title small {
        color: var(--parts-muted);
        font-size: 11px;
        display: block;
        margin-top: 3px;
    }

    .part-body {
        padding: 13px 15px;
    }

    .part-info-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 10px 14px;
    }

    .info-item {
        min-width: 0;
    }

    .info-label {
        font-size: 10px;
        color: #8994a5;
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 12px;
        color: #344258;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .part-edit-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        margin-top: 13px;
        padding-top: 12px;
        border-top: 1px dashed #e5eaf1;
    }

    .field-box {
        min-width: 0;
    }

    .field-box label {
        font-size: 10px;
        color: #68768a;
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
    }

    .field-box .form-control {
        height: 33px;
        font-size: 11px;
        border-radius: 7px;
        border-color: #e1e7ef;
        box-shadow: none;
        padding: 5px 9px;
        min-width: 0;
    }

    .field-box .form-control:focus {
        border-color: #6b92d2;
        box-shadow: 0 0 0 2px rgba(49, 93, 168, .08);
    }

    .field-box .form-group {
        margin-bottom: 0;
    }

    .part-footer {
        background: #fafbfd;
        border-top: 1px solid #edf0f5;
        padding: 10px 15px;
        display: grid;
        grid-template-columns: minmax(220px, 1fr) minmax(180px, 1.5fr) auto;
        gap: 10px;
        align-items: end;
    }

    .purchase-quantity-box {
        margin-top: 7px;
    }

    .purchase-quantity-box .alert {
        font-size: 10px;
        padding: 5px 8px;
    }

    .save-btn {
        height: 33px;
        min-width: 90px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 600;
        padding: 5px 14px;
    }

    .part-date {
        font-size: 11px;
        color: #778397;
        white-space: nowrap;
    }

    .part-badge {
        font-size: 10px;
        background: #edf3ff;
        color: #315da8;
        border-radius: 6px;
        padding: 4px 7px;
        text-decoration: none;
    }

    .part-badge:hover {
        color: #1e3c72;
    }

    .empty-parts {
        padding: 40px 15px;
        text-align: center;
        color: #8a95a5;
        background: white;
        border-radius: 10px;
    }

    .empty-parts i {
        font-size: 30px;
        display: block;
        margin-bottom: 10px;
    }

    @media(max-width: 1100px) {
        .part-info-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .part-edit-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media(max-width: 650px) {
        .parts-page .card-body {
            padding: 9px;
        }

        .part-card-header {
            padding: 10px;
        }

        .part-body {
            padding: 10px;
        }

        .part-info-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px 8px;
        }

        .part-edit-grid {
            grid-template-columns: 1fr 1fr;
            gap: 9px;
        }

        .part-footer {
            grid-template-columns: 1fr;
            padding: 10px;
        }

        .save-btn {
            width: 100%;
        }

        .parts-header {
            padding: 14px;
        }
    }
</style>

<div class="parts-page">

    @if (access('مدیریت انبار قطعات مصرفی'))

        <div class="card">

            <div class="parts-header">
                <div>
                    <h3>
                        <i class="fas fa-boxes ml-2"></i>
                        درخواست قطعات مصرفی
                    </h3>
                    <div class="subtitle">
                        مدیریت تحویل، تامین و وضعیت درخواست قطعات
                    </div>
                </div>

                <a href="{{ route('simpleWorkflowReport.consumable-parts.export-requests') }}"
                   class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel"></i>
                    خروجی Excel
                </a>
            </div>

            <div class="card-body">

                @php
                    $activeParts = $consumableParts->whereIn(
                        'consumable_part_status',
                        [
                            'در انتظار تحویل انبار',
                            'در انتظار تحویل بازگشتی ها توسط انبار',
                            'در انتظار تایید بازگشتی ها توسط انبار'
                        ]
                    );
                @endphp

                @if($activeParts->isEmpty())

                    <div class="empty-parts">
                        <i class="fas fa-inbox"></i>
                        در حال حاضر درخواست فعالی وجود ندارد.
                    </div>

                @else

                    <div class="parts-list">

                        @foreach ($activeParts as $consumablePart)

                            <form class="part-card"
                                  action="{{ route('simpleWorkflowReport.consumable-parts.deliver', $consumablePart->id) }}"
                                  method="post">

                                @csrf
                                @method('PUT')

                                {{-- سربرگ درخواست --}}
                                <div class="part-card-header">

                                    <div class="part-title">

                                        <div class="part-icon">
                                            <i class="fas fa-cube"></i>
                                        </div>

                                        <div>
                                            <strong>
                                                {{ $consumablePart->product_name }}
                                            </strong>

                                            <small>
                                                پرونده:
                                                {{ $consumablePart->case_number ?? '---' }}
                                            </small>
                                        </div>

                                    </div>

                                    <div class="part-date">
                                        <i class="fa fa-calendar-alt"></i>
                                        تاریخ درخواست
                                        <span dir='ltr'>{{ toJalali($consumablePart->created_at) }}</span>
                                    </div>

                                </div>

                                <div class="part-body">

                                    {{-- اطلاعات اصلی --}}
                                    
<div class="part-info-grid">

    <div class="info-item">
        <div class="info-label">نام مشتری</div>
        <div class="info-value">
            {{ $consumablePart->case()?->customerName() ?? $consumablePart->customer_name ?? '---' }}
        </div>
    </div>

    <div class="info-item">
        <div class="info-label">درخواست کننده</div>
        <div class="info-value">
            {{ $consumablePart->created_by ? getUserInfo($consumablePart->created_by)?->name : '---' }}
        </div>
    </div>

    <div class="info-item">
        <div class="info-label">تعداد مورد نیاز</div>
        <div class="info-value">
            {{ $consumablePart->requested_quantity }}
        </div>
    </div>

    <div class="field-box">
        <label>تعداد تحویل شده</label>

        @if ($consumablePart->consumable_part_status == 'در انتظار تحویل انبار')
            <input type="number"
                   name="delivered_quantity"
                   value="{{ $consumablePart->delivered_quantity }}"
                   class="form-control"
                   min="0"
                   required
                   title="تعداد تحویل داده شده الزامی است">
        @else
            <div class="info-value">
                {{ $consumablePart->delivered_quantity ?? 0 }}
            </div>
        @endif
    </div>

    <div class="info-item">
        <div class="info-label">تعداد بازگشتی</div>
        <div class="info-value">
            {{ $consumablePart->returned_quantity ?? 0 }}
        </div>
    </div>

</div>


                                    {{-- اطلاعات تامین و فاکتور --}}
                                    @if ($consumablePart->external_buying_is_done != 1)

                                        <div class="part-edit-grid">

                                            <div class="field-box">
                                                <label>منبع تامین</label>
                                                <input type="text"
                                                       name="supply_source"
                                                       value="{{ $consumablePart->supply_source }}"
                                                       class="form-control"
                                                       placeholder="منبع تامین">
                                            </div>

                                            <div class="field-box">
                                                <label>شماره فاکتور</label>
                                                <input type="text"
                                                       name="invoice_number"
                                                       value="{{ $consumablePart->invoice_number }}"
                                                       class="form-control"
                                                       placeholder="شماره فاکتور">
                                            </div>

                                            <div class="field-box">
                                                <label>تاریخ فاکتور</label>

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
                                            </div>

                                            <div class="field-box">
                                                <label>مبلغ</label>
                                                <input type="text"
                                                       name="amount"
                                                       value="{{ $consumablePart->amount }}"
                                                       dir="ltr"
                                                       class="form-control formatted-digit"
                                                       placeholder="مبلغ">
                                            </div>

                                        </div>

                                    @endif

                                </div>

                                {{-- فیلدهای عملیاتی --}}
                                <div class="part-footer">

                                    <div class="field-box">

                                        <label>وضعیت درخواست</label>

                                        <select name="consumable_part_status"
                                                class="form-control consumable-status"
                                                data-id="{{ $consumablePart->id }}">

                                            @foreach (collect($statuses)->whereNotIn('key', ['inquiring_price']) as $status)

                                                <option value="{{ $status['label'] }}"
                                                    {{ $status['label'] == $consumablePart->consumable_part_status ? 'selected' : '' }}>

                                                    {{ $status['label'] }}
                                                    {{ !empty($status['assignee']) ? ' (' . $status['assignee'] . ')' : '' }}

                                                </option>

                                            @endforeach

                                        </select>

                                        <div class="purchase-quantity-box"
                                             id="purchase-box-{{ $consumablePart->id }}"
                                             style="display:none;">

                                            <div class="alert alert-warning mb-1">
                                                تعداد مورد نیاز برای خرید
                                            </div>

                                            <input type="number"
                                                   name="required_quantity_to_purchase"
                                                   class="form-control"
                                                   placeholder="تعداد"
                                                   min="1"
                                                   value="{{ $consumablePart->required_quantity_to_purchase }}">

                                        </div>

                                    </div>

                                    <div class="field-box">
                                        <label>توضیحات</label>

                                        <input type="text"
                                               name="description"
                                               value="{{ $consumablePart->description ?? '' }}"
                                               class="form-control"
                                               placeholder="توضیحات درخواست">
                                    </div>

                                    <div class="field-box">
                                        <label>قیمت واحد</label>

                                        <input type="text"
                                               name="unit_price"
                                               value="{{ $consumablePart->additional_info?->unit_price ?? '' }}"
                                               dir="ltr"
                                               class="form-control formatted-digit"
                                               placeholder="قیمت واحد">
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-primary save-btn">
                                            <i class="fas fa-save"></i>
                                            ذخیره تغییرات
                                        </button>
                                    </div>

                                </div>

                            </form>

                        @endforeach

                    </div>

                @endif

            </div>

        </div>

    @endif

</div>

@endsection

@section('script')

<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.consumable-status').forEach(function (select) {

            function togglePurchaseField() {

                const id = select.dataset.id;
                const box = document.getElementById('purchase-box-' + id);

                if (!box) return;

                const selectedValue = select.value;

                box.style.display = [
                    'در انتظار خرید داخلی',
                    'در انتظار خرید خارجی'
                ].includes(selectedValue) ? 'block' : 'none';

            }

            togglePurchaseField();

            select.addEventListener('change', togglePurchaseField);

        });

    });
</script>

<script>
    function showAdditionalInfoModal(consumablePartId) {

        var url = `{{ route('simpleWorkflowReport.consumable-parts.additional-info.show', 'consumablePart') }}`;

        url = url.replace('consumablePart', consumablePartId);

        open_admin_modal(url);

    }
</script>

@endsection
