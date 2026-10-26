@extends('behin-layouts.app')

@section('title', 'گزارش قطعات درخواستی از انبار')

@section('content')

    <div class="card-body row">
        <div class="filter-card">

            <div class="filter-card-header">
                <div class="filter-title">
                    <div class="filter-icon">
                        <i class="fa fa-filter"></i>
                    </div>

                    <div>
                        <h5>فیلتر و جستجو</h5>
                        <span>برای محدود کردن نتایج گزارش، فیلترهای موردنظر را انتخاب کنید.</span>
                    </div>
                </div>
            </div>


            <form action="{{ route('simpleWorkflowReport.consumable-parts.report') }}" method="GET" id="search-form">

                <div class="row">

                    {{-- نام کالا --}}
                    <div class="col-lg-4 col-md-6 mb-3">
                        <label class="filter-label">
                            نام کالا
                        </label>

                        <div class="input-wrapper">
                            <i class="fa fa-cube"></i>

                            <input type="text" class="form-control material-input" name="item_name"
                                value="{{ request('item_name') }}" placeholder="نام کالا را وارد کنید">
                        </div>
                    </div>


                    {{-- درخواست کننده --}}
                    <div class="col-lg-4 col-md-6 mb-3">
                        <label class="filter-label">
                            درخواست کننده
                        </label>

                        <select name="requester_id" class="form-control select2 material-select">

                            <option value="">همه درخواست‌کنندگان</option>

                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ request('requester_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>


                    {{-- وضعیت --}}
                    <div class="col-lg-4 col-md-6 mb-3">
                        <label class="filter-label">
                            وضعیت
                        </label>

                        <select name="status" id="status" class="form-control material-select">

                            <option value="">همه وضعیت‌های ستاره دار (به جز تایید)</option>

                            @foreach ($statuses as $statusKey => $statusValue)
                                @php
                                    $isStarredStatus = ($statusValue['key'] ?? $statusKey) != 'confirmed';
                                @endphp
                                <option value="{{ $statusValue['label'] }}"
                                    {{ request('status') == $statusValue['label'] ? 'selected' : '' }}>
                                    {{ $statusValue['label'] }}@if ($isStarredStatus)
                                        *
                                    @endif
                                </option>
                            @endforeach

                        </select>

                        <small class="text-muted d-block mt-1">
                            گزینه «همه وضعیت‌های ستاره دار (به جز تایید)» یعنی همه وضعیت‌هایی که ستاره دارند؛ وضعیت «تایید»
                            فقط زمانی نمایش داده می‌شود که خودش انتخاب شود.
                        </small>
                    </div>


                    {{-- ستون تاریخ --}}
                    <div class="col-lg-4 col-md-6 mb-3">
                        <label class="filter-label">
                            نوع تاریخ
                        </label>

                        <select name="date_column" id="date_column" class="form-control material-select">

                            <option value="created_at" {{ request('date_column') == 'created_at' ? 'selected' : '' }}>
                                تاریخ درخواست
                            </option>

                        </select>
                    </div>


                    {{-- از تاریخ --}}
                    <div class="col-lg-4 col-md-6 mb-3">
                        <label class="filter-label">
                            از تاریخ
                        </label>

                        <div class="input-wrapper">
                            <i class="fa fa-calendar"></i>

                            <input type="text" class="form-control material-input persian-date" name="from_date"
                                value="{{ request('from_date') }}" placeholder="از تاریخ">
                        </div>
                    </div>


                    {{-- تا تاریخ --}}
                    <div class="col-lg-4 col-md-6 mb-3">
                        <label class="filter-label">
                            تا تاریخ
                        </label>

                        <div class="input-wrapper">
                            <i class="fa fa-calendar"></i>

                            <input type="text" class="form-control material-input persian-date" name="to_date"
                                value="{{ request('to_date') }}" placeholder="تا تاریخ">
                        </div>
                    </div>


                    {{-- دکمه‌ها --}}
                    <div class="col-12">

                        <div class="filter-actions">

                            <button type="submit" class="btn material-search-btn">

                                <i class="fa fa-search"></i>
                                جستجو

                            </button>


                            <a href="{{ route('simpleWorkflowReport.consumable-parts.report') }}"
                                class="btn material-reset-btn">

                                <i class="fa fa-refresh"></i>
                                پاک کردن فیلترها

                            </a>

                            @if (auth()->user()->access('خروجی اکسل گزارش قطعات مصرفی'))
                                <a href="{{ route('simpleWorkflowReport.consumable-parts.report.export', request()->query()) }}"
                                    class="btn material-search-btn" style="background: #2e7d32;">

                                    <i class="fa fa-file-excel-o"></i>
                                    خروجی اکسل

                                </a>
                            @endif

                        </div>

                    </div>

                </div>

            </form>

        </div>


        <style>
            /* =========================
                   Filter Card
                ========================= */

            .filter-card {
                background: #fff;
                border: 1px solid #edf0f2;
                border-radius: 16px;
                margin-bottom: 25px;
                overflow: hidden;
                box-shadow: 0 3px 12px rgba(0, 0, 0, .045);
            }


            /* Header */

            .filter-card-header {
                padding: 18px 22px;
                border-bottom: 1px solid #f0f2f4;
                background: #fafbfc;
            }

            .filter-title {
                display: flex;
                align-items: center;
                gap: 13px;
            }

            .filter-icon {
                width: 42px;
                height: 42px;

                display: flex;
                align-items: center;
                justify-content: center;

                border-radius: 12px;

                background: #e3f2fd;
                color: #1976d2;

                font-size: 17px;
            }

            .filter-title h5 {
                margin: 0 0 4px;

                color: #263238;
                font-size: 15px;
                font-weight: 700;
            }

            .filter-title span {
                color: #90a4ae;
                font-size: 11px;
            }


            /* Body */

            .filter-card form {
                padding: 22px;
            }


            /* Labels */

            .filter-label {
                display: block;

                margin-bottom: 7px;

                color: #546e7a;

                font-size: 12px;
                font-weight: 600;
            }


            /* Inputs */

            .material-input,
            .material-select {
                height: 42px;

                border: 1px solid #dfe5e8;
                border-radius: 9px;

                color: #37474f;

                font-size: 13px;

                box-shadow: none !important;

                transition: all .2s ease;
            }

            .material-input:focus,
            .material-select:focus {
                border-color: #90caf9;

                box-shadow: 0 0 0 3px rgba(25, 118, 210, .08) !important;
            }


            .material-input::placeholder {
                color: #b0bec5;
            }


            /* Input with icon */

            .input-wrapper {
                position: relative;
            }

            .input-wrapper>i {
                position: absolute;

                right: 13px;
                top: 50%;

                transform: translateY(-50%);

                color: #90a4ae;

                font-size: 13px;

                z-index: 2;
            }

            .input-wrapper .material-input {
                padding-right: 38px;
            }


            /* Select2 */

            .material-select+.select2-container {
                width: 100% !important;
            }

            .material-select+.select2-container .select2-selection {
                height: 42px;

                border: 1px solid #dfe5e8;
                border-radius: 9px;

                display: flex;
                align-items: center;

                box-shadow: none;
            }

            .material-select+.select2-container .select2-selection__rendered {
                color: #37474f;
                font-size: 13px;
                line-height: 40px;
                padding-right: 12px;
            }

            .material-select+.select2-container .select2-selection__arrow {
                height: 40px;
            }


            /* Actions */

            .filter-actions {
                display: flex;

                align-items: center;

                gap: 9px;

                padding-top: 5px;

                border-top: 1px solid #f1f3f4;
                margin-top: 5px;
                padding-top: 18px;
            }


            .material-search-btn {
                min-width: 105px;

                height: 40px;

                border: 0;
                border-radius: 9px;

                background: #1976d2;
                color: #fff;

                font-size: 12px;
                font-weight: 600;

                box-shadow: 0 3px 8px rgba(25, 118, 210, .2);

                transition: all .2s ease;
            }

            .material-search-btn:hover {
                background: #1565c0;
                color: #fff;

                transform: translateY(-1px);
            }

            .material-search-btn i {
                margin-left: 6px;
            }


            .material-reset-btn {
                height: 40px;

                padding: 0 15px;

                display: flex;
                align-items: center;

                border: 1px solid #e0e5e8;
                border-radius: 9px;

                background: #fff;
                color: #607d8b;

                font-size: 12px;
            }

            .material-reset-btn:hover {
                background: #f5f7f8;
                color: #37474f;
            }

            .material-reset-btn i {
                margin-left: 6px;
            }


            /* Mobile */

            @media (max-width: 576px) {

                .filter-card form {
                    padding: 17px;
                }

                .filter-card-header {
                    padding: 16px;
                }

                .filter-title span {
                    display: none;
                }

                .filter-actions {
                    flex-direction: column;
                    align-items: stretch;
                }

                .material-search-btn,
                .material-reset-btn {
                    width: 100%;
                    justify-content: center;
                }

            }
        </style>

    </div>

    <div class="card">
        <div class="card-header">تمام کالاها</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>قطعه</th>
                        <th>درخواست کننده</th>
                        <th>تعداد درخواست شده</th>
                        <th>تعداد تحویل شده</th>
                        <th>تعداد بازگشت داده شده</th>
                        <th>وضعیت</th>
                        <th>تاریخ درخواست</th>
                        @if (access('گزارش قطعات درخواستی از انبار - مشاهده ستون های مرتبط با قیمت'))
                            <th>قیمت</th>
                            <th>قیمت واحد</th>
                            <th>واحد پول</th>
                            <th>منبع تامین</th>
                            <th>تاریخ فاکتور</th>
                            <th>شماره فاکتور</th>
                            <th>تاریخ سفارش</th>
                            <th>تاریخ دریافت</th>
                        @endif
                        <th>اقدامات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($allRequests as $request)
                        <tr>
                            <td>
                                <div>{{ $request->product_name }}</div>
                                @if ($request->item_id)
                                    <div class="text-muted small">شناسه: {{ $request->item_id }}</div>
                                @endif
                            </td>
                            <td>{{ getUserInfo($request->created_by)->name ?? '' }}</td>
                            <td>{{ $request->requested_quantity }}</td>
                            <td>{{ $request->delivered_quantity }}</td>
                            <td>{{ $request->returned_quantity }}</td>
                            <td>
                                @php
                                    $status = collect($statuses)
                                        ->where('label', $request->consumable_part_status)
                                        ->first();
                                @endphp
                                <span class="badge"
                                    style="background: {{ $status['color'] ?? '#cccccc' }}">{{ $request->consumable_part_status }}</span>
                            </td>
                            <td dir="ltr">
                                @if ($request->created_at)
                                    {{ toJalali($request->created_at)->format('Y-m-d H:i') }} <br>
                                @else
                                    ـ
                                @endif
                            </td>
                            @if (access('گزارش قطعات درخواستی از انبار - مشاهده ستون های مرتبط با قیمت'))
                                <td>[[ $request->amount ? number_format($request->amount) : $request->amount ]]</td>
                                <td>[[ $request->additional_info?->unit_price ?
                                    number_format($request->additional_info->unit_price) :
                                    $request->additional_info?->unit_price ]]</td>
                                <td>{{ $request->additional_info?->currencyLabel() }}</td>
                                <td>{{ $request->supply_source }}</td>
                                <td>{{ $request->invoice_date }}</td>
                                <td>{{ $request->invoice_number }}</td>
                            @endif
                            <td>{{ $request->additional_info?->order_date }}</td>
                            <td>{{ $request->additional_info?->receipt_date }}</td>
                            <td>
                                @if (access('گزارش قطعات درخواستی از انبار - حذف رکورد'))
                                    <button class="btn btn-sm btn-danger"
                                        onclick="confirmDelete('{{ route('simpleWorkflowReport.consumable-parts.delete', $request->id) }}')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ access('گزارش قطعات درخواستی از انبار - مشاهده ستون های مرتبط با قیمت') ? 16 : 10 }}"
                                class="text-center text-muted">درخواستی ثبت نشده است.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($allRequests->hasPages())
                <div class="text-center mt-2">
                    <span class="mx-2">
                        صفحه {{ $allRequests->currentPage() }} از {{ $allRequests->lastPage() }}
                    </span>
                    <a href="{{ $allRequests->previousPageUrl() }}" class="btn btn-outline-secondary btn-sm">قبلی</a>
                    @for ($i = 1; $i <= $allRequests->lastPage(); $i++)
                        <a href="{{ $allRequests->url($i) }}" class="btn btn-outline-secondary btn-sm"
                            @if ($allRequests->currentPage() == $i) style="background-color: #007bff" @endif>{{ $i }}</a>
                    @endfor
                    <a href="{{ $allRequests->nextPageUrl() }}" class="btn btn-outline-secondary btn-sm">بعدی</a>
                </div>
            @endif

        </div>
    </div>

@endsection

<script>
    function confirmDelete(url) {
        if (confirm("آیا مطمئن هستید؟")) {
            window.location.href = url
        }
        return null;
    }
</script>
