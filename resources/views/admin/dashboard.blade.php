@extends('behin-layouts.app')

@php
    $disableBackBtn = true;
@endphp

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="header-banner material-card payment-card">
                <img src="{{ url('behin/header.png') }}" alt="Header">
            </div>
        </div>
        @if (auth()->user()->access('آیکون پذیرش دستگاه جدید '))
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-blue">

                    <div class="material-card-content"
                        onclick="window.location='{{ route('simpleWorkflow.process.startListView') }}'">

                        <div class="material-icon">
                            <i class="fa fa-laptop"></i>
                        </div>

                        <h3>{{ trans('پذیرش دستگاه') }}</h3>

                        <p>{{ trans('ثبت پذیرش دستگاه جدید') }}</p>

                    </div>

                </div>

            </div>
        @endauth
        @if (auth()->user()->access('منو >>کارتابل>>کارتابل'))
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-purple">

                    <div class="material-card-content"
                        onclick="window.location='{{ route('simpleWorkflow.inbox.index') }}'">

                        <div class="material-icon">
                            <i class="fa fa-inbox"></i>
                        </div>

                        <h3>{{ trans('کارتابل من') }}</h3>

                        <p>{{ trans('لیست پرونده هایی که باید انجام دهید') }}</p>

                    </div>

                </div>

            </div>
        @endauth
        <div class="col-lg-3 col-md-4 col-sm-6">

            <div class="material-card payment-card card-orange">

                <div class="material-card-content" onclick="window.location='{{ route('todoList.index') }}'">

                    <div class="material-icon">
                        <i class="fa fa-bell"></i>
                    </div>

                    <h3>{{ trans('اطلاع رسانی') }}</h3>

                    <p>{{ trans('آخرین اطلاع رسانی ها') }}</p>

                </div>

            </div>

        </div>

        @if (auth()->user()->access('منو >>گزارشات کارتابل>>خلاصه'))
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-cyan">

                    <div class="material-card-content"
                        onclick="window.location='{{ route('simpleWorkflowReport.summary-report.index') }}'">

                        <div class="material-icon">
                            <i class="fa fa-bar-chart"></i>
                        </div>

                        <h3>{{ trans('گزارش پرونده ها') }}</h3>

                        <p>{{ trans('گزارش پرونده ها بر اساس وضعیت') }}</p>

                    </div>

                </div>

            </div>
        @endif

        @if (auth()->user()->access('ثبت درخواست مرخصی'))
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-green">

                    <div class="material-card-content"
                        onclick="if(confirm('شروع؟')) { window.location='{{ route('simpleWorkflow.process.start', [
                            'taskId' => '7f62e4ce-a96e-419a-8972-358fd642f39b',
                            'inDraft' => 0,
                            'force' => 1,
                            'redirect' => true,
                        ]) }}'; }">

                        <div class="material-icon">
                            <i class="fa fa-calendar"></i>
                        </div>

                        <h3>{{ trans('ثبت مرخصی') }}</h3>

                        <p>{{ trans('مرخصی خود را ثبت کنید') }}</p>

                    </div>

                </div>

            </div>
        @endif
        @if (auth()->user()->access('وضعیت کارهای منقضی شده'))
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-red">

                    <div class="material-card-content"
                        onclick="window.location='{{ route('simpleWorkflowReport.expired-tasks.index') }}'">

                        <div class="material-icon">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>

                        <h3>{{ trans('کارهای منقضی') }}</h3>

                        <p>{{ trans('از این قسمت میتوانید وضعیت کارهای منقضی شده را مشاهده کنید') }}</p>

                    </div>

                </div>

            </div>
        @endif
        @if (auth()->user()->access('لیست دستگاه های مپا سنتر'))
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-blue">

                    <div class="material-card-content"
                        onclick="window.location='{{ route('simpleWorkflowReport.summary-report.show', 'ab17ef68-6ec7-4dc8-83b0-5fb6ffcedc50') }}'">

                        <div class="material-icon">
                            <i class="fa fa-cogs"></i>
                        </div>

                        <h3>{{ trans('مپا سنتر') }}</h3>

                        <p>{{ trans('از این قسمت میتوانید لیست دستگاه های مپا سنتر را مشاهده کنید') }}</p>

                    </div>

                </div>

            </div>
        @endif
        @if (auth()->user()->access('طرف حسابها'))
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-purple">

                    <div class="material-card-content"
                        onclick="window.location='{{ route('simpleWorkflowReport.counter-party.index') }}'">

                        <div class="material-icon">
                            <i class="fa fa-users"></i>
                        </div>

                        <h3>{{ trans('طرف حسابها') }}</h3>

                        <p>{{ trans('از این قسمت میتوانید لیست طرف حسابها را مشاهده کنید') }}</p>

                    </div>

                </div>

            </div>
        @endif
        @if (auth()->user()->access('امور متفرقه'))
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-orange">

                    <div class="material-card-content"
                        onclick="window.location='{{ route('simpleWorkflow.process.start', [
                            'taskId' => '1021591c-b6cf-4cb3-bbd8-028c5ed49253',
                            'inDraft' => 0,
                            'force' => 0,
                            'redirect' => true,
                        ]) }}'">

                        <div class="material-icon">
                            <i class="fa fa-list-alt"></i>
                        </div>

                        <h3>{{ trans('امور متفرقه') }}</h3>

                        <p>{{ trans('ثبت گزارش روزانه امور متفرقه') }}</p>

                    </div>

                </div>

            </div>
        @endif
        @if (access('آیکون شروع فرایند ورود و خروج کالا از نگهبانی'))
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-green">

                    <div class="material-card-content"
                        onclick="if(confirm('شروع؟')) { window.location='{{ route('simpleWorkflow.process.start', [
                            'taskId' => '28d862dd-9268-47ad-bf6f-aa0520e6d3d2',
                            'inDraft' => 0,
                            'force' => 1,
                            'redirect' => true,
                        ]) }}'; }">

                        <div class="material-icon">
                            <i class="fa fa-exchange"></i>
                        </div>

                        <h3>{{ trans('ورود و خروج کالا') }}</h3>

                        <p>{{ trans('ورود و خروج کالا از نگهبانی') }}</p>

                    </div>

                </div>

            </div>
        @endauth
        @if (access('آیکون شروع فرایند ماموریت'))
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="material-card payment-card card-cyan">
                    <div class="material-card-content"
                        onclick="if(confirm('شروع؟')) { window.location='{{ route('simpleWorkflow.process.start', [
                            'taskId' => 'cf07ec23-686f-4a08-9cb5-5ea258c4b1a0',
                            'inDraft' => 0,
                            'force' => 1,
                            'redirect' => true,
                        ]) }}'; }">
                        <div class="material-icon">
                            <i class="fa fa-briefcase"></i>
                        </div>
                        <h3>{{ trans('مأموریت') }}</h3>
                        <p>{{ trans('مأموریت') }}</p>
                    </div>
                </div>
            </div>
        @endauth
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="material-card payment-card card-orange">
                <div class="material-card-content"
                    onclick="window.location='{{ route('admin.warehouseDashboard') }}'">
                    <div class="material-icon">
                        <i class="fa fa-cubes"></i>
                    </div>
                    <h3>{{ trans('انبار') }}</h3>
                    <p>{{ trans('کالای امانی، قطعات مصرفی و لیست خریدها') }}</p>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        {{-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            send_ajax_get_request(
                "{{ route('pmAdmin.api.numberOfCaseByLastStatus') }}",
                function(response) {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Last Status');
                    data.addColumn('number', 'Total Records');
                    console.log(data);

                    response.forEach(function(item) {
                        data.addRows([item.last_status, item.total_records])
                    })
                    console.log(data);



                    // Set chart options
                    var options = {
                        'title': 'Last Status Distribution',
                        'width': 600,
                        'height': 400,
                        'pieHole': 0.4, // Optional: To make it a Donut chart
                        'is3D': true // Optional: For a 3D Pie Chart
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                    chart.draw(data, options);
                }
            )



        }
    </script> --}}
    @endsection
