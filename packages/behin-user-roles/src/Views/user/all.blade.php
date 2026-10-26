@extends('behin-layouts.app')

@section('title')
    کاربران
@endsection

@section('content')
    <div class="container-fluid px-4">
        <div class="card shadow-sm">
            <div class="card-header py-3 bg-white">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <a href="{{ route('users.create') }}">
                        <button class="btn btn-primary">
                            <i class="fa fa-plus"></i> ایجاد کاربر
                        </button>
                    </a>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="badge bg-success">
                            <i class="fa fa-check-circle me-1"></i>فعال: {{ ($activeUsers ?? $users->where('is_disabled', false))->count() }}
                        </span>
                        <span class="badge bg-danger">
                            <i class="fa fa-times-circle me-1"></i>غیرفعال: {{ ($disabledUsers ?? $users->where('is_disabled', true))->count() }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <ul class="nav nav-tabs nav-justified" id="userTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active text-success" style="color: black !important" id="active-tab" data-toggle="tab" href="#activeUsers" role="tab">
                            <i class="fa fa-user-circle me-2 text-success"></i>کاربران فعال
                            <span class="badge bg-success ms-2 rounded-pill">{{ ($activeUsers ?? $users->where('is_disabled', false))->count() }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="disabled-tab" style="color: black !important" data-toggle="tab" href="#disabledUsers" role="tab">
                            <i class="fa fa-user-slash me-2 text-danger"></i>کاربران غیرفعال
                            <span class="badge bg-danger ms-2 rounded-pill">{{ ($disabledUsers ?? $users->where('is_disabled', true))->count() }}</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content pt-3 border rounded" id="userTabsContent">
                    <div class="tab-pane fade show active" id="activeUsers" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover user-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>شناسه</th>
                                        <th>شماره پرسنلی</th>
                                        <th>نام</th>
                                        <th>نام کاربری</th>
                                        <th>نقش</th>
                                        <th>وضعیت</th>
                                        <th>ویرایش</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(($activeUsers ?? $users->where('is_disabled', false)) as $user)
                                        <tr class="align-middle">
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->number }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td><a href="{{ route('role.show', $user->role()->id) }}" class="text-primary">{{ $user->role()->name ?? '' }}</a></td>
                                            <td><span class="badge bg-success">فعال</span></td>
                                            <td class="text-center">
                                                <a href="{{ $user->id }}" class="text-decoration-none">
                                                    <i class="fa fa-edit text-primary" style="font-size: 1.1em;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-3">
                                                <i class="fa fa-inbox me-2"></i>هیچ کاربری یافت نشد
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="disabledUsers" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover user-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>شناسه</th>
                                        <th>شماره پرسنلی</th>
                                        <th>نام</th>
                                        <th>نام کاربری</th>
                                        <th>نقش</th>
                                        <th>وضعیت</th>
                                        <th>ویرایش</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(($disabledUsers ?? $users->where('is_disabled', true)) as $user)
                                        <tr class="align-middle">
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->number }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td><a href="{{ route('role.show', $user->role()->id) }}" class="text-primary">{{ $user->role()->name ?? '' }}</a></td>
                                            <td><span class="badge bg-danger">غیرفعال</span></td>
                                            <td class="text-center">
                                                <a href="{{ $user->id }}" class="text-decoration-none">
                                                    <i class="fa fa-edit text-primary" style="font-size: 1.1em;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-3">
                                                <i class="fa fa-inbox me-2"></i>هیچ کاربر غیرفعال یافت نشد
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.user-table').DataTable({
                responsive: true,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Persian.json",
                },
                pageLength: 10,
            });
            // وقتی تب عوض می‌شود ستون‌های دیتاتیبل دوباره تنظیم شوند
            $('a[data-toggle="tab"]').on('shown.bs.tab', function() {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
            });
        });
    </script>
    <style>
        /* اطمینان از visibility متن روی پس‌زمینه سفید */
        .table-responsive {
            background: #ffffff;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        .nav-tabs .nav-link {
            color: #495057;
            border: 1px solid #dee2e6;
            border-radius: 6px 6px 0 0;
            padding: 10px 20px;
            font-weight: 500;
        }
        .nav-tabs .nav-link.active {
            background-color: #ffffff;
            border-bottom-color: #ffffff;
            color: #ffffff;
            box-shadow: 0 -2px 0 #0d6efd;
        }
        .nav-tabs .nav-link:focus,
        .nav-tabs .nav-link:hover {
            border-color: #dee2e6;
        }
        .badge {
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
        }
        @media (max-width: 768px) {
            .nav-tabs.nav-justified {
                display: block !important;
                flex-direction: column !important;
            }
            .nav-tabs.nav-justified .nav-item {
                width: 100%;
            }
            .nav-tabs.nav-justified .nav-link {
                width: 100%;
                border-radius: 6px 6px 0 0;
            }
            .nav-tabs.nav-justified .nav-link.active {
                border-bottom-color: transparent;
                border-bottom-left-radius: 0;
                border-bottom-right-radius: 0;
            }
        }
    </style>
@endsection

