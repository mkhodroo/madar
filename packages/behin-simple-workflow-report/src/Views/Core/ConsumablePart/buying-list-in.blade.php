@extends('behin-layouts.app')

@section('title', 'لیست خرید داخلی')

@section('content')
    @if (access('مدیریت لیست خرید داخلی'))
        <div class="card">
            <div class="card-header card-header-buy-in">
                <h3 class="card-title">لیست خرید داخلی</h3>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('simpleWorkflowReport.consumable-parts.export-buying-in') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-file-excel"></i> خروجی Excel خرید داخلی
                </a>
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
                                    <td>
                                        {{ $consumablePart->product_name }}
                                        @if($consumablePart->product_sample_image)
                                            <a href="{{ $consumablePart->product_sample_image }}" class="badge badge-info" target="_blank">
                                                دانلود تصویر
                                            </a>
                                        @endif
                                    </td>
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
                                            style="width: 350px">
                                            @foreach (collect($statuses)->whereIn('key', ['pending_buy_in', 'pending_buy_out', 'requested']) as $status)
                                                <option value="{{ $status['label'] }}"
                                                    {{ $status['label'] == $consumablePart->consumable_part_status ? 'selected' : '' }}>
                                                {{ $status['label'] }}{{ !empty($status['assignee']) ? ' (' . $status['assignee'] . ')' : '' }}</option>
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
