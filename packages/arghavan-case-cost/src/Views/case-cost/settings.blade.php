@extends('behin-layouts.app')

@section('content')
    <div class="card">
        <div class="card-body table-responsive">
            <div class="alert alert-warning p-2">
                نحوه محاسبه هزینه تعمیرات داخلی پرسنل = مدت تعمیرات * حقوقی ساعتی کارشناس<br>
                نحوه محاسبه هزینه تعمیرات داخلی پرسنل = مدت تعمیرات * حقوقی ساعتی کارشناس * درصد رتبه کار مربوطه<br>
                نحوه محاسبه هزینه تعمیرات خارجی = مدت تعمیرات * حقوقی ساعتی کارشناس<br>
                نحوه محاسبه هزینه تعمیرات خارجی = مدت تعمیرات * حقوقی ساعتی کارشناس * درصد رتبه کار مربوطه<br>
                نحوه محاسبه هزینه رفت و برگشت = مدت زمان رفت و برگشت * حقوقی ساعتی کارشناس  <br>
                نحوه محاسبه هزینه سربار = مجموع تمام هزینه ها به جز قطعات مصرفی * درصد سربار
            </div>
            <form action="{{ route('case-cost.settings.update') }}" method="POST">
                @csrf
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>نام</th>
                            <th>درصد</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i <= 10; $i++)
                            @php
                                $setting = $settings->where('name', 'job_rank_' . $i . '_percentage')->first();
                            @endphp

                            <tr>
                                <td>{{ $setting?->label }}</td>
                                <td>
                                    <input type="number" name="job_rank_{{ $i }}_percentage"
                                        value="{{ $setting?->percentage }}" min="0" step="1"
                                        class="form-control">
                                </td>
                            </tr>
                        @endfor
                        <tr>
                             @php
                                $setting = $settings->where('name', 'overhead_cost')->first();
                            @endphp
                            <td>[[ $setting?->label ]]</td>
                            <td>
                                <input type="number" name="overhead_cost"
                                    value="{{ $setting?->percentage }}" min="0" step="0.01"
                                    class="form-control">
                            </td>
                        </tr>
                        <tr>
                             @php
                                $setting = $settings->where('name', 'round_trip_repair_cost')->first();
                            @endphp
                            <td>[[ $setting?->label ]]</td>
                            <td>
                                <input type="number" name="round_trip_repair_cost"
                                    value="{{ $setting?->percentage }}" min="0" step="0.01"
                                    class="form-control">
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><button type="submit" class="btn btn-sm">ذخیره</button></td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
@endsection
