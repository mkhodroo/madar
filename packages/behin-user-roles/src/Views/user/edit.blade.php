@extends('behin-layouts.app')

@section('title')
    ویرایش کاربر | {{ $user->name }}
@endsection

@section('content')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fa fa-check"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fa fa-ban"></i> {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center flex-wrap">
                <h3 class="m-0">
                    <i class="fa fa-user-circle-o text-primary"></i>
                    ویرایش کاربر: {{ $user->name }}
                    @if ($user->is_disabled)
                        <span class="badge badge-danger">غیرفعال</span>
                    @else
                        <span class="badge badge-success">فعال</span>
                    @endif
                </h3>
                <a href="{{ route('user.all', 'all') }}" class="btn btn-default mt-2">
                    <i class="fa fa-arrow-right"></i> بازگشت به لیست کاربران
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-id-card-o"></i> اطلاعات اصلی</h3>
                    </div>
                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>شناسه</label>
                                        <input type="text" class="form-control" value="{{ $user->id }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="number">شماره پرسنلی</label>
                                        <input type="text" name="number" id="number" class="form-control" value="{{ old('number', $user->number) }}" dir="ltr">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ename">نام</label>
                                        <input type="text" name="name" id="ename" class="form-control" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="eemail">نام کاربری</label>
                                        <input type="text" name="email" id="eemail" class="form-control" value="{{ old('email', $user->email) }}" dir="ltr" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="login_with_ip">ورود با آیپی</label>
                                        <select name="login_with_ip" id="login_with_ip" class="form-control">
                                            <option value="1" {{ old('login_with_ip', $user->login_with_ip) ? 'selected' : '' }}>فعال</option>
                                            <option value="0" {{ old('login_with_ip', $user->login_with_ip) ? '' : 'selected' }}>غیرفعال</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="valid_ip">آیپی مجاز</label>
                                        <input type="text" name="valid_ip" id="valid_ip" class="form-control" value="{{ old('valid_ip', $user->valid_ip) }}" placeholder="1.1.1.1" dir="ltr">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sms_reminder_enabled">ارسال پیامک یادآوری</label>
                                        <select name="sms_reminder_enabled" id="sms_reminder_enabled" class="form-control">
                                            <option value="1" {{ old('sms_reminder_enabled', $user->sms_reminder_enabled) ? 'selected' : '' }}>فعال</option>
                                            <option value="0" {{ old('sms_reminder_enabled', $user->sms_reminder_enabled) ? '' : 'selected' }}>غیرفعال</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-left">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> ویرایش</button>
                        </div>
                    </form>
                </div>

                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-key"></i> رمز عبور جدید</h3>
                    </div>
                    <form action="{{ route('user.ChangePass', ['id' => $user->id]) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="input-group">
                                <input type="password" class="form-control" name="pass" placeholder="رمز عبور جدید" required>
                                <div class="input-group-append">
                                    <button class="btn btn-warning" type="submit">تغییر</button>
                                </div>
                            </div>
                            <small class="form-text text-muted">رمز جدید را وارد و دکمه تغییر را بزنید.</small>
                        </div>
                    </form>
                </div>
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-shield"></i> نقش</h3>
                    </div>
                    <form action="{{ route('role.changeUserRole') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="card-body">
                            <div class="input-group">
                                <select class="custom-select" name="role_id" id="role_id">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" @if ($user->role_id == $role->id) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-info" type="submit">تغییر</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card card-secondary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-sitemap"></i> دپارتمان</h3>
                    </div>
                    <div class="card-body">
                        @forelse ($user->departments() as $item)
                            <span class="badge badge-primary p-2 mb-2" style="font-size:13px;">
                                {{ $item->department()->name }}
                                <form method="post" action="{{ route('user.removeFromDepartment', ['id' => $user->id]) }}" class="d-inline" onsubmit="return confirm('حذف از دپارتمان؟');">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="departmentId" value="{{ $item->department()->id }}">
                                    <button type="submit" class="btn btn-xs btn-danger ml-1" title="حذف"><i class="fa fa-times"></i></button>
                                </form>
                            </span>
                        @empty
                            <p class="text-muted mb-2">عضو هیچ دپارتمانی نیست.</p>
                        @endforelse
                        <form method="post" action="{{ route('user.addToDepartment', ['id' => $user->id]) }}">
                            @csrf
                            <div class="input-group mt-2">
                                <select class="custom-select" name="department_id" id="department_id">
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="submit">افزودن</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-users"></i> طرف حساب‌های مرتبط</h3>
                    </div>
                    @php
                        $selectedCounterParties = old('counterparty_ids', $user->counterParties->pluck('id')->toArray());
                    @endphp
                    <form method="post" action="{{ route('user.updateCounterParties', ['id' => $user->id]) }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <select class="form-control select2" name="counterparty_ids[]" id="counterparty_ids" multiple style="width:100%;">
                                    @foreach ($counterParties as $counterParty)
                                        @php
                                            $isSelected = in_array($counterParty->id, $selectedCounterParties, true);
                                            $assignedToOtherUser = $counterParty->user && $counterParty->user->id !== $user->id;
                                        @endphp
                                        <option value="{{ $counterParty->id }}" {{ $isSelected ? 'selected' : '' }}>
                                            {{ $counterParty->name }} - {{ $counterParty->account_number ?? 'بدون شماره حساب' }}
                                            @if ($assignedToOtherUser)
                                                (اختصاص یافته به {{ $counterParty->user->name }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('counterparty_ids')
                                    <span class="text-danger d-block">{{ $message }}</span>
                                @enderror
                                @error('counterparty_ids.*')
                                    <span class="text-danger d-block">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">برای انتخاب چند گزینه از کلیدهای Ctrl یا Shift استفاده کنید.</small>
                            </div>
                            <h6>طرف حساب‌های فعلی کاربر</h6>
                            <ul class="list-group">
                                @forelse ($user->counterParties as $counterParty)
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                        <span>{{ $counterParty->name }}</span>
                                        <span class="badge badge-primary badge-pill" dir="ltr">{{ $counterParty->account_number ?? '-' }}</span>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted py-2">طرف حسابی برای این کاربر تعریف نشده است.</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="card-footer text-left">
                            <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> ثبت طرف حساب‌ها</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-widget widget-user">
                    <div class="widget-user-header bg-{{ $user->is_disabled ? 'danger' : 'primary' }}">
                        <h3 class="widget-user-username">{{ $user->name }}</h3>
                        <h5 class="widget-user-desc">{{ $user->email }}</h5>
                    </div>
                    <div class="widget-user-image">
                        <span class="fa-stack fa-2x">
                            <i class="fa fa-circle fa-stack-2x text-secondary"></i>
                            <i class="fa fa-user fa-stack-1x fa-inverse"></i>
                        </span>
                    </div>
                    <div class="card-footer">
                        <div class="row text-center">
                            <div class="col-4 border-left">
                                <h6 class="mb-0">{{ $user->id }}</h6>
                                <small class="text-muted">شناسه</small>
                            </div>
                            <div class="col-4 border-left">
                                <h6 class="mb-0">{{ $user->number ?? '—' }}</h6>
                                <small class="text-muted">پرسنلی</small>
                            </div>
                            <div class="col-4">
                                <h6 class="mb-0">{{ $user->counterParties->count() }}</h6>
                                <small class="text-muted">طرف حساب</small>
                            </div>
                        </div>
                        <hr>
                        <p class="mb-1"><i class="fa fa-shield text-info"></i> نقش:
                            <strong>{{ optional($roles->firstWhere('id', $user->role_id))->name ?? '—' }}</strong>
                        </p>
                        <p class="mb-1"><i class="fa fa-bell text-warning"></i> پیامک یادآوری:
                            <strong>{{ $user->sms_reminder_enabled ? 'فعال' : 'غیرفعال' }}</strong>
                        </p>
                        <p class="mb-0"><i class="fa fa-globe text-success"></i> ورود با آیپی:
                            <strong>{{ $user->login_with_ip ? 'فعال' : 'غیرفعال' }}</strong>
                            @if ($user->valid_ip)
                                <span dir="ltr">({{ $user->valid_ip }})</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="card card-danger card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-exclamation-triangle"></i> ناحیه خطر</h3>
                    </div>
                    <div class="card-body p-2">
                        <form action="{{ route('user.disable', $user->id) }}" method="POST" class="mb-2" onsubmit="return confirm('{{ $user->is_disabled ? 'کاربر فعال شود؟' : 'کاربر غیرفعال و از همه دستگاه‌ها خارج شود؟' }}');">
                            @csrf
                            <button type="submit" class="btn btn-block {{ $user->is_disabled ? 'btn-success' : 'btn-warning' }}">
                                <i class="fa fa-{{ $user->is_disabled ? 'check' : 'ban' }}"></i>
                                {{ $user->is_disabled ? 'فعال کردن کاربر' : 'غیرفعال کردن کاربر' }}
                            </button>
                        </form>
                        <form action="{{ route('user.invalidateSessions', $user->id) }}" method="POST" class="mb-2" onsubmit="return confirm('کاربر از همه دستگاه‌ها خارج شود؟');">
                            @csrf
                            <button type="submit" class="btn btn-block btn-danger">
                                <i class="fa fa-sign-out"></i> خروج از همه دستگاه‌ها
                            </button>
                        </form>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('حذف کاربر قطعی است. مطمئن هستید؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-block btn-outline-danger">
                                <i class="fa fa-trash"></i> حذف کاربر
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            if ($.fn.select2) {
                $('#counterparty_ids').select2({
                    placeholder: 'طرف حساب‌ها را انتخاب کنید',
                    allowClear: true,
                    dir: 'rtl',
                    width: '100%'
                });
            }
        });
    </script>
@endsection
