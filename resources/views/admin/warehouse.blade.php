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
        <div class="col-lg-3 col-md-4 col-sm-6">

            <div class="material-card payment-card card-blue">

                <div class="material-card-content"
                    onclick="window.location='{{ route('simpleWorkflowReport.borrow-requests.index') }}'">

                    <div class="material-icon">
                        <i class="fa fa-cube"></i>
                    </div>

                    <h3>{{ trans('کالای امانی') }}</h3>

                    <p>{{ trans('ثبت و مدیریت کالاهای امانی') }}</p>

                </div>

            </div>

        </div>
        @if (access('درخواست قطعات مصرفی'))
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-purple">

                    <div class="material-card-content"
                        onclick="window.location='{{ route('simpleWorkflowReport.consumable-parts.index') }}'">

                        <div class="material-icon">
                            <i class="fa fa-cogs"></i>
                        </div>

                        <h3>{{ trans('درخواست قطعات مصرفی') }}</h3>

                        <p>{{ trans('ثبت درخواست قطعات مصرفی') }}</p>

                    </div>

                </div>

            </div>
        @endif
        @if (access('لیست خرید داخلی و خارجی'))
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-cyan">

                    <div class="material-card-content"
                        onclick="window.location='{{ route('simpleWorkflowReport.consumable-parts.buyingList') }}'">

                        <div class="material-icon">
                            <i class="fa fa-shopping-cart"></i>
                        </div>

                        <h3>{{ trans('لیست خرید') }}</h3>

                        <p>{{ trans('لیست خرید داخلی و خارجی') }}</p>

                    </div>

                </div>

            </div>
        @endif
        @if (access('دریافت کالا از انبار'))
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-green">

                    <div class="material-card-content"
                        onclick="window.location='{{ route('simpleWorkflowReport.consumable-parts.create') }}'">

                        <div class="material-icon">
                            <i class="fa fa-truck"></i>
                        </div>

                        <h3>{{ trans('دریافت کالا از انبار') }}</h3>

                        <p>{{ trans('ثبت درخواست دریافت کالای مصرفی از انبار') }}</p>

                    </div>

                </div>

            </div>
        @endif
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
