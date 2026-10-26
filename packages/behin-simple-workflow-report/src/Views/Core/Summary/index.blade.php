```blade
@extends('behin-layouts.app')

@section('title')
    گزارش‌های گردش کار
@endsection

@section('style')
    <style>
        .reports-grid {
            margin-right: -10px;
            margin-left: -10px;
        }

        .reports-grid > [class*="col-"] {
            padding-right: 10px;
            padding-left: 10px;
        }

        .report-box {
            min-height: 215px;
            height: 100%;
            border-radius: 14px;
            padding: 22px 18px;
            color: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.10);
            transition: all 0.2s ease-in-out;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .report-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.16);
        }

        .report-box-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
            margin-bottom: 14px;
        }

        .report-box-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .report-box h5 {
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            line-height: 1.8;
            margin: 0 0 8px;
        }

        .report-box p {
            color: rgba(255, 255, 255, 0.88);
            font-size: 12px;
            line-height: 1.8;
            margin: 0 0 15px;
            min-height: 43px;
        }

        .report-box .btn {
            align-self: flex-start;
            margin-top: auto;
            border: 0;
            border-radius: 7px;
            color: #333;
            font-weight: 600;
            padding: 6px 13px;
        }

        .report-box-blue { background: linear-gradient(135deg, #1976d2, #42a5f5); }
        .report-box-purple { background: linear-gradient(135deg, #6a1b9a, #ab47bc); }
        .report-box-red { background: linear-gradient(135deg, #c62828, #ef5350); }
        .report-box-green { background: linear-gradient(135deg, #2e7d32, #66bb6a); }
        .report-box-orange { background: linear-gradient(135deg, #ef6c00, #ffa726); }
        .report-box-cyan { background: linear-gradient(135deg, #00838f, #26c6da); }
        .report-box-indigo { background: linear-gradient(135deg, #3949ab, #7986cb); }
        .report-box-teal { background: linear-gradient(135deg, #00796b, #26a69a); }
        .report-box-pink { background: linear-gradient(135deg, #ad1457, #ec407a); }
        .report-box-violet { background: linear-gradient(135deg, #4527a0, #7e57c2); }
        .report-box-lime { background: linear-gradient(135deg, #558b2f, #9ccc65); }
        .report-box-amber { background: linear-gradient(135deg, #ff8f00, #ffca28); }
        .report-box-navy { background: linear-gradient(135deg, #283593, #5c6bc0); }
        .report-box-olive { background: linear-gradient(135deg, #827717, #afb42b); }
        .report-box-rose { background: linear-gradient(135deg, #880e4f, #d81b60); }
        .report-box-sky { background: linear-gradient(135deg, #0277bd, #29b6f6); }
        .report-box-fuchsia { background: linear-gradient(135deg, #6a1b9a, #d81b60); }
        .report-box-sea { background: linear-gradient(135deg, #00695c, #26a69a); }
        .report-box-brown { background: linear-gradient(135deg, #5d4037, #8d6e63); }
        .report-box-dark-blue { background: linear-gradient(135deg, #1565c0, #1e88e5); }
        .report-box-dark-green { background: linear-gradient(135deg, #1b5e20, #43a047); }
        .report-box-gray { background: linear-gradient(135deg, #455a64, #78909c); }

        @media (max-width: 767px) {
            .report-box {
                min-height: 195px;
            }
        }

        .has-value {
            border: 2px solid #28a745 !important;
            /* سبز برای مثال */
            background-color: #e8f5e9;
            /* سبز روشن پس‌زمینه */
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-12">
                @if (auth()->user()->access('هرچه میخواهد دل تنگت بجوی'))
                    <div class="card">
                        <div class="card-header text-center bg-info">جستجو</div>
                        <div class="card-body">
                            <div>
                                <label for="">هر چه میخواهد دل تنگت بجوی</label>
                                <form action="javascript:void(0)" method="POST" id="search-form" class="row">
                                    <div class="form-group col-sm-3">
                                        <div class="input-group">
                                            <select name="actor" id="" class="form-control"
                                                placeholder="کارشناس">
                                                <option value="">کارشناس</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <div class="input-group">
                                            <input type="text" name="customer" id="" class="form-control"
                                                placeholder="نام مشتری">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <div class="input-group">
                                            <input type="text" name="number" id="" class="form-control"
                                                placeholder="شماره پرونده">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <div class="input-group">
                                            <input type="text" name="device_name" id="" class="form-control"
                                                placeholder="نام دستگاه">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <div class="input-group">
                                            <input type="text" name="mapa_serial" id="" class="form-control"
                                                placeholder="سریال مپا">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-3"></div>
                                    <div class="form-group col-sm-3"></div>
                                    <div class="form-group col-sm-3">
                                        <button class="btn btn-info" onclick="search()" style="width: 100%">
                                            جستجو
                                        </button>
                                    </div>
                                    <div class="col-sm-12 table-responsive d-none" id="search-result">
                                        <table class="table table-bordered" id="search-result-table">
                                            <thead>
                                                <tr>
                                                    <th>شماره پرونده</th>
                                                    <th>نام مشتری</th>
                                                    <th style='width: 70px'>نام دستگاه</th>
                                                    <th>آخرین وضعیت</th>
                                                    <th>تاریخ ایجاد</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </form>

                                <script>
                                    var summarySearchStorageKey = 'workflow-summary-search-context';
                                    $('#search-form').on('submit', function(e) {
                                        e.preventDefault();
                                        search(true);
                                    });

                                    function getSummarySearchFormData() {
                                        var data = {};
                                        $('#search-form').serializeArray().forEach(function(item) {
                                            data[item.name] = item.value;
                                        });
                                        return data;
                                    }

                                    function saveSummarySearchContext() {
                                        try {
                                            sessionStorage.setItem(summarySearchStorageKey, JSON.stringify(getSummarySearchFormData()));
                                        } catch (err) {}
                                    }

                                    function restoreSummarySearchContext() {
                                        try {
                                            var raw = sessionStorage.getItem(summarySearchStorageKey);
                                            if (!raw) return false;
                                            var data = JSON.parse(raw);
                                            var hasValue = false;
                                            Object.keys(data).forEach(function(name) {
                                                var $field = $('#search-form [name="' + name + '"]');
                                                if ($field.length && data[name] !== undefined) {
                                                    $field.val(data[name]);
                                                    if (data[name]) hasValue = true;
                                                }
                                            });
                                            return hasValue;
                                        } catch (err) { return false; }
                                    }

                                    function renderSummarySearchResult(response) {
                                        console.log(response)
                                        $('#search-result').removeClass('d-none')

                                        if (!response || response.length == 0) {
                                            $('#search-result').addClass('d-none')
                                        }

                                        if ($.fn.DataTable.isDataTable('#search-result-table')) {
                                            $('#search-result-table').DataTable().destroy()
                                        }
                                        $('#search-result tbody').html(response)
                                        $('#search-result-table').DataTable({
                                            "stateSave": true,
                                            "order": [
                                                [3, "desc"]
                                            ],
                                            "language": {
                                                "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Persian.json"
                                            },
                                        })
                                    }

                                    function search(persist) {
                                        if (persist !== false) {
                                            saveSummarySearchContext();
                                        }
                                        var fd = new FormData($('#search-form')[0])
                                        send_ajax_formdata_request(
                                            "{{ route('simpleWorkflowReport.external-internal.search') }}",
                                            fd,
                                            function(response) {
                                                renderSummarySearchResult(response);
                                            }
                                        )
                                    }

                                    $(document).ready(function() {
                                        if (restoreSummarySearchContext()) {
                                            search(false);
                                        }
                                    });
                                </script>

                                <script>
                                    $(document).ready(function() {
                                        $('#search-form input, #search-form select').each(function() {
                                            toggleHasValueClass($(this));

                                            $(this).on('input change', function() {
                                                toggleHasValueClass($(this));
                                            });
                                        });

                                        function toggleHasValueClass($el) {
                                            if ($el.val()) {
                                                $el.addClass('has-value');
                                            } else {
                                                $el.removeClass('has-value');
                                            }
                                        }
                                    });
                                </script>

                            </div>
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">گزارش‌های گردش کار</div>

                    <div class="card-body">
                        <div class="row reports-grid">

                            @foreach ($processes as $process)
                                @if (auth()->user()->access('خلاصه گزارش فرایند: ' . $process->name))
                                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                        <div class="report-box report-box-blue">
                                            <div class="report-box-icon">
                                                <i class="fa fa-bar-chart"></i>
                                            </div>
                                            <div class="report-box-content">
                                                <h5>{{ $process->name }}</h5>
                                                <p>{{ $process->description }}</p>
                                                <a href="{{ route('simpleWorkflowReport.summary-report.show', ['summary_report' => $process]) }}"
                                                    class="btn btn-light btn-sm">
                                                    مشاهده گزارش
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            @if (auth()->user()->access('گزارش مپاسنتر'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-purple">
                                        <div class="report-box-icon">
                                            <i class="fa fa-cogs"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش مپاسنتر</h5>
                                            <p>گزارش مپاسنتر</p>
                                            <a href="{{ route('simpleWorkflowReport.mapa-center.index') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (auth()->user()->access('پرونده های حذف شده'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-red">
                                        <div class="report-box-icon">
                                            <i class="fa fa-trash"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش پرونده های حذف شده</h5>
                                            <p>گزارش پرونده های حذف شده</p>
                                            <a href="{{ route('simpleWorkflowReport.summary-report.show', ['summary_report' => '243225f2-30b9-4fd7-abc7-fbcf97862a1b']) }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (auth()->user()->access('دفتر تلفن'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-green">
                                        <div class="report-box-icon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>دفتر تلفن</h5>
                                            <p>دفتر تلفن</p>
                                            <a href="{{ route('simpleWorkflowReport.phonebook.index') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (auth()->user()->access('امور جاری: گزارش فرایند های داخلی و خارجی'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-orange">
                                        <div class="report-box-icon">
                                            <i class="fa fa-tasks"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش امور جاری</h5>
                                            <p>گزارش کامل فرایند های داخلی و خارجی</p>
                                            <a href="{{ route('simpleWorkflowReport.external-internal.index') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (auth()->user()->access('بایگانی: گزارش پرونده های بایگانی شده'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-cyan">
                                        <div class="report-box-icon">
                                            <i class="fa fa-archive"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش بایگانی</h5>
                                            <p>گزارش کامل پرونده های بایگانی شده</p>
                                            <a href="{{ route('simpleWorkflowReport.external-internal-archive') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (auth()->user()->access('مپا سنتر: پرونده های پایان یافته'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-indigo">
                                        <div class="report-box-icon">
                                            <i class="fa fa-check-circle"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش مپاسنتر: پرونده های پایان یافته</h5>
                                            <p>گزارش کامل پرونده های پایان یافته مپاسنتر</p>
                                            <a href="{{ route('simpleWorkflowReport.mapa-center-archive') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (auth()->user()->access('گزارش درآمد تقریبی'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-teal">
                                        <div class="report-box-icon">
                                            <i class="fa fa-money"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش درآمد(هزینه و پرسنل)</h5>
                                            <p>گزارش درآمد</p>
                                            <a href="{{ route('simpleWorkflowReport.fin.totalCost') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- @if (auth()->user()->access('گزارش کل تعیین هزینه ها و دریافت هزینه ها'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-brown">
                                        <div class="report-box-icon">
                                            <i class="fa fa-credit-card"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>هزینه ها</h5>
                                            <p>گزارش کامل تعیین هزینه ها و دریافت هزینه ها</p>
                                            <a href="{{ route('simpleWorkflowReport.fin.allPayments') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif --}}

                            @if (auth()->user()->access('گزارش چک ها'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-pink">
                                        <div class="report-box-icon">
                                            <i class="fa fa-credit-card"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش دفتر چک ها</h5>
                                            <p>گزارش کامل چک ها و تاریخ سررسید آنها</p>
                                            <a href="{{ route('simpleWorkflowReport.cheque-report.index') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- @if (auth()->user()->access('گزارش حساب دفتری'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-slate">
                                        <div class="report-box-icon">
                                            <i class="fa fa-book"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>حساب دفتری</h5>
                                            <p>گزارش کامل حساب دفتری</p>
                                            <a href="{{ route('simpleWorkflowReport.on-credit-report.index') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif --}}

                            {{-- @if (auth()->user()->access('گزارش بدهکاران'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-dark">
                                        <div class="report-box-icon">
                                            <i class="fa fa-user-times"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>بدهکاران</h5>
                                            <p>گزارش کامل بدهکاران</p>
                                            <a href="{{ route('simpleWorkflowReport.on-credit-report.showAll') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif --}}

                            @if (auth()->user()->access('گزارش اقدامات پرسنل'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-violet">
                                        <div class="report-box-icon">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش اقدامات پرسنل</h5>
                                            <p>گزارش کامل</p>
                                            <a href="{{ route('simpleWorkflowReport.personel-activity.index') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (auth()->user()->access('گزارش روزانه'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-lime">
                                        <div class="report-box-icon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش روزانه پرسنل</h5>
                                            <p>گزارش کامل</p>
                                            <a href="{{ route('simpleWorkflowReport.daily-report.index') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (auth()->user()->access('گزارش جرایم پیامک ها'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-amber">
                                        <div class="report-box-icon">
                                            <i class="fa fa-bell"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش جرایم و پاداش ها</h5>
                                            <p>گزارش کامل</p>
                                            <a href="{{ route('simpleWorkflowReport.daily-report.reminder-summary') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- @if (auth()->user()->access('گزارش لیست طلبکاران'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-brown">
                                        <div class="report-box-icon">
                                            <i class="fa fa-list"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش لیست طلبکاران</h5>
                                            <p>گزارش کامل لیست طلبکاران</p>
                                            <a href="" class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif --}}

                            @if (auth()->user()->access('گزارش دفتر معین'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-navy">
                                        <div class="report-box-icon">
                                            <i class="fa fa-book"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش دفتر معین</h5>
                                            <p>گزارش کامل دفتر معین</p>
                                            <a href="{{ route('simpleWorkflowReport.financial-transactions.index') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (auth()->user()->access('گزارش تنخواه'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-olive">
                                        <div class="report-box-icon">
                                            <i class="fa fa-shopping-basket"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش ریز خرج کرد</h5>
                                            <p>گزارش تنخواه</p>
                                            <a href="{{ route('simpleWorkflowReport.petty-cash.index') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (auth()->user()->access('گزارش لیست مساعده پرسنل'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-rose">
                                        <div class="report-box-icon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش لیست مساعده پرسنل</h5>
                                            <p>گزارش کامل لیست مساعده پرسنل</p>
                                            <a href="{{ route('simpleWorkflowReport.financial-transactions.user') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (access('گزارش ورود کالاها در نگهبانی'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-sky">
                                        <div class="report-box-icon">
                                            <i class="fa fa-sign-in"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش ورود کالاها در نگهبانی</h5>
                                            <p>گزارش کامل ورود کالاها در نگهبانی</p>
                                            <a href="{{ route('simpleWorkflowReport.goods-in.index') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (access('گزارش ماموریت'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-fuchsia">
                                        <div class="report-box-icon">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش ماموریت</h5>
                                            <p>گزارش کامل ماموریت</p>
                                            <a href="{{ route('simpleWorkflowReport.missions.index') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (auth()->user()->access('گزارش لیست حقوق پرسنل'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-sea">
                                        <div class="report-box-icon">
                                            <i class="fa fa-money"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش لیست حقوق پرسنل</h5>
                                            <p>گزارش کامل بدهکاران</p>
                                            <a href="{{ route('simpleWorkflowReport.employee-salaries.index') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (access('گزارش کالاهای امانی'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-brown">
                                        <div class="report-box-icon">
                                            <i class="fa fa-cubes"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش لیست کالاهای امانی</h5>
                                            <p>گزارش کالاهای امانی</p>
                                            <a href="{{ route('simpleWorkflowReport.borrow-requests.report') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (access('گزارش قطعات درخواستی از انبار'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-dark-blue">
                                        <div class="report-box-icon">
                                            <i class="fa fa-wrench"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش قطعات درخواستی از انبار</h5>
                                            <p>گزارش قطعات درخواستی از انبار</p>
                                            <a href="{{ route('simpleWorkflowReport.consumable-parts.report') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (access('تنخواه گردانی'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-dark-green">
                                        <div class="report-box-icon">
                                            <i class="fa fa-calculator"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>تنخواه گردانی</h5>
                                            <p>تنخواه گردانی</p>
                                            <a href="{{ route('petty-cash.index') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (access('گزارش دفتر رسمی'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-gray">
                                        <div class="report-box-icon">
                                            <i class="fa fa-file-text"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش تراکنش‌های دفتر معین</h5>
                                            <p>گزارش دفتر رسمی</p>
                                            <a href="{{ route('official-office-transactions.index') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- @if (access('گزارش درآمدها'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-teal">
                                        <div class="report-box-icon">
                                            <i class="fa fa-line-chart"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>درآمدها</h5>
                                            <p>گزارش درآمدها</p>
                                            <a href="{{ route('incomes-report.index') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (access('گزارش هزینه‌ها'))
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="report-box report-box-red">
                                        <div class="report-box-icon">
                                            <i class="fa fa-credit-card"></i>
                                        </div>
                                        <div class="report-box-content">
                                            <h5>گزارش هزینه‌ها</h5>
                                            <p>گزارش هزینه‌ها</p>
                                            <a href="{{ route('outcomes-report.index') }}"
                                                class="btn btn-light btn-sm">مشاهده گزارش</a>
                                        </div>
                                    </div>
                                </div>
                            @endif --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
```
