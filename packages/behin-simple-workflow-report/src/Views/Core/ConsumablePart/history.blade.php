<div class="">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>وضعیت قبلی</th>
                <th>وضعیت بعد از تغییر</th>
                <th dir="ltr">تاریخ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($history as $item)
                <tr>
                    <td>{{ $item->status_before_change }}</td>
                    <td>{{ $item->status_after_change }}</td>
                    <td dir="ltr">{{ toJalali($item->created_at) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>