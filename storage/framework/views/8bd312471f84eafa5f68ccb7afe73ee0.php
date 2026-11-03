<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <?php
        $profile = \UserProfile\Models\UserProfile::where('user_id', auth()->id())->first();
        $headerColor = $profile->header_background ?? '#1976d2';
        $sidebarColor = $profile->sidebar_background ?? '#212121';
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" href="<?php echo e(url('behin/logo.ico') . '?' . config('app.version')); ?>">
    <link rel="manifest" href="<?php echo e(url('manifest.json') . '?' . config('app.version')); ?>">

    <title><?php echo $__env->yieldContent('title'); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="<?php echo e(url('behin/behin-dist/plugins/font-awesome/css/font-awesome.min.css') . '?' . config('app.version')); ?>">
    <!-- Ionicons -->
    
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(url('behin/behin-dist/dist/css/adminlte.min.css') . '?' . config('app.version')); ?>">
    <!-- Date Picker -->
    <link rel="stylesheet"
        href="<?php echo e(url('behin/behin-dist/plugins/datepicker/datepicker3.css') . '?' . config('app.version')); ?>">
    <!-- Daterange picker -->
    <link rel="stylesheet"
        href="<?php echo e(url('behin/behin-dist/plugins/daterangepicker/daterangepicker-bs3.css') . '?' . config('app.version')); ?>">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet"
        href="<?php echo e(url('behin/behin-dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') . '?' . config('app.version')); ?>">
    <!-- Google Font: Source Sans Pro -->
    
    <!-- bootstrap rtl -->
    <link rel="stylesheet"
        href="<?php echo e(url('behin/behin-dist/dist/css/bootstrap-rtl.min.css') . '?' . config('app.version')); ?>">
    <!-- template rtl version -->
    <link rel="stylesheet"
        href="<?php echo e(url('behin/behin-dist/dist/css/custom-style.css') . '?' . config('app.version')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('behin/behin-dist/dist/css/custom.css') . '?' . config('app.version')); ?>">

    
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(url('behin/behin-dist/plugins/datatables/dataTables.bootstrap4.css') . '?' . config('app.version')); ?>" />
    <link rel="stylesheet"
        href="<?php echo e(url('behin/behin-dist/dist/css/dropzone.min.css') . '?' . config('app.version')); ?>">
    <link rel="stylesheet"
        href="<?php echo e(url('behin/behin-dist/plugins/toastr/toastr.min.css') . '?' . config('app.version')); ?>">
    
    
    <link rel="stylesheet" href="<?php echo e(url('behin/behin-dist/plugins/select2/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('behin/behin-dist/persian-date-picker/persian-datepicker.css')); ?>">
    <link rel="stylesheet"
        href="<?php echo e(url('behin/behin-dist/plugins/mapp/css/mapp.min.css') . '?' . config('app.version')); ?>">
    <link rel="stylesheet"
        href="<?php echo e(url('behin/behin-dist/plugins/mapp/css/fa/style.css') . '?' . config('app.version')); ?>">
    
    <!-- Material Icons اضافه -->
    <link href="<?php echo e(url('behin/behin-dist/dist/css/icon.css') . '?' . config('app.version')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(url('behin/behin-dist/plugins/sweetalert/sweetalert2.min.css')); ?>">



    <!-- استایل سفارشی متریال -->
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .btn {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .main-header.navbar {
            background-color: <?php echo e($headerColor); ?> !important;
        }

        .main-sidebar {
            border-top-right-radius: 12px;
            background-color: <?php echo e($sidebarColor); ?> !important;
        }

        .main-footer {
            background-color: #fff;
            border-top: 1px solid #ddd;
            padding: 12px;
            text-align: center;
            font-size: 13px;
            color: #666;
        }

        /* جدول‌ها کمی متریال‌تر */
        table.dataTable {
            border-radius: 8px;
            overflow: hidden;
        }

        table.dataTable thead {
            background-color: #eeeeee;
        }

        .more-text {
            display: none;
        }

        .show-more-btn {
            cursor: pointer;
            color: #1976d2;
            font-size: 14px;
            vertical-align: middle;
        }

        .show-more-btn:hover {
            text-decoration: underline;
        }

        .select2-container .select2-selection--single {
            height: 38px !important;
            /* ارتفاع form-control */
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px !important;
        }

        i::before {
            font-family: "FontAwesome" !important;
            /* یا نسخه‌ای که داری */
            font-weight: 900;
        }

        i {
            font-family: "Vazir", sans-serif !important;
            /* فونت متن */
            font-style: normal;
            vertical-align: middle !important;
        }

        i::after {
            font-family: "Vazirmatn", sans-serif;
            margin-inline-start: 6px;
            opacity: 0;
            transition: opacity .2s ease;
            white-space: nowrap;
        }

        /* hover موس */
        i:hover::after {
            opacity: 1;
        }
    </style>
    <?php echo $__env->yieldContent('style'); ?>

    <script src="<?php echo e(url('behin/behin-dist/plugins/jquery/jquery.min.js') . '?' . config('app.version')); ?>"></script>
    
    <script src="<?php echo e(url('behin/behin-dist/plugins/datatables/jquery.dataTables.js') . '?' . config('app.version')); ?>">
    </script>
    <script src="<?php echo e(url('behin/behin-dist/plugins/datatables/dataTables.bootstrap4.js') . '?' . config('app.version')); ?>">
    </script>
    <script src="<?php echo e(url('behin/behin-dist/persian-date-picker/persian-date.js') . '?' . config('app.version')); ?>"></script>
    <script src="<?php echo e(url('behin/behin-dist/persian-date-picker/persian-datepicker.js') . '?' . config('app.version')); ?>">
    </script>



    <script src="<?php echo e(url('behin/behin-dist/plugins/mapp/js/mapp.env.js') . '?' . config('app.version')); ?>"></script>

    <script>
        window.appUrl = <?php echo json_encode(rtrim(config('app.url'), '/') . '/', 512) ?>;
    </script>
    <script src="<?php echo e(url('behin/behin-js/scripts.js') . '?' . config('app.version')); ?>"></script>
    <script src="<?php echo e(url('behin/behin-js/ajax.js') . '?' . config('app.version')); ?>"></script>
    <script src="<?php echo e(url('behin/behin-js/dataTable.js') . '?' . config('app.version')); ?>"></script>
    <script src="<?php echo e(url('behin/behin-js/dropzone.js') . '?' . config('app.version')); ?>"></script>
    
    <script src="<?php echo e(url('behin/behin-dist/plugins/autonumeric/autoNumeric.min.js') . '?' . config('app.version')); ?>">
    </script>

    
    <script src=<?php echo e(url('behin/behin-dist/plugins/ace/1.13.1/ace.js')); ?>></script>
    <script src=<?php echo e(url('behin/behin-dist/plugins/ace/1.13.1/mode-php.js')); ?>></script>
    <script src=<?php echo e(url('behin/behin-dist/plugins/ace/1.13.1/theme-monokai.js')); ?>></script>
    <script src=<?php echo e(url('behin/behin-dist/plugins/ace/1.13.1/ext-language_tools.min.js')); ?>></script>


    <?php echo $__env->yieldContent('script_in_head'); ?>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php echo $__env->make('behin-layouts.header', ['headerColor' => $headerColor], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('behin-layouts.main-sidebar', ['sidebarColor' => $sidebarColor], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <?php if(!isset($disableBackBtn)): ?>
                        <div class="card">
                            <div class="card-body">
                                <a href="<?php echo e($backUrl ?? 'javascript:history.back()'); ?>"
                                    class="btn btn-sm btn-outline-primary float-left">
                                    <i class="fa fa-arrow-left"></i> <?php echo e(trans('fields.Back')); ?>

                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(!isset($disableSessionMsg)): ?>
                        <?php if(session('error')): ?>
                            <div class="alert alert-danger">
                                <?php echo e(session('error')); ?>

                            </div>
                        <?php endif; ?>
                        <?php if(session('success')): ?>
                            <div class="alert alert-success">
                                <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
        </div>
        <div class="container-fluid p-2">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </section>
</div>



<footer class="main-footer">
    <?php echo $__env->make('behin-layouts.mobile-navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
</footer>

<aside class="control-sidebar control-sidebar-dark">
</aside>
</div>

<script src="<?php echo e(url('behin/behin-dist/plugins/bootstrap/js/bootstrap.bundle.min.js') . '?' . config('app.version')); ?>">
</script>

<script src="<?php echo e(url('behin/behin-dist/plugins/knob/jquery.knob.js') . '?' . config('app.version')); ?>"></script>
<script src="<?php echo e(url('behin/behin-dist/plugins/daterangepicker/daterangepicker.js') . '?' . config('app.version')); ?>">
</script>
<script src="<?php echo e(url('behin/behin-dist/plugins/datepicker/bootstrap-datepicker.js') . '?' . config('app.version')); ?>">
</script>
<script
    src="<?php echo e(url('behin/behin-dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') . '?' . config('app.version')); ?>">
</script>
<script src="<?php echo e(url('behin/behin-dist/dist/js/adminlte.js') . '?' . config('app.version')); ?>"></script>

<script src="<?php echo e(url('behin/behin-dist/plugins/select2/select2.min.js')); ?>"></script>
<script src="<?php echo e(url('behin/behin-dist/plugins/mapp/js/mapp.min.js') . '?' . config('app.version')); ?>"></script>
<script src="<?php echo e(url('behin/behin-dist/plugins/toastr/toastr.min.js') . '?' . config('app.version')); ?>"></script>
<script src="<?php echo e(url('behin/behin-dist/plugins/sweetalert/sweetalert2.all.min.js')); ?>"></script>

<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
<script>
    const beamsClient = new PusherPushNotifications.Client({
        instanceId: "<?php echo e(config('broadcasting.pusher.instanceId')); ?>",
    });
    const beamsTokenProvider = new PusherPushNotifications.TokenProvider({
        url: "<?php echo e(url('/pusher/beams-auth')); ?>"
    });

    beamsClient.getUserId()
        .then(userId => {
            if (!userId) {
                beamsClient.start().then(() => {
                    const beamsTokenProvider = new PusherPushNotifications.TokenProvider({
                        url: "<?php echo e(url('/pusher/beams-auth')); ?>"
                    });
                    beamsClient.setUserId(
                        "<?php echo e(config('broadcasting.pusher.prefix_user')); ?><?php echo e(Auth::id()); ?>",
                        beamsTokenProvider)
                })
            } else {
                console.log('User ID:', userId);
            }
        })
        .catch(console.error);
</script>
<script>
    function checkNotificationPermission() {
        if (!('Notification' in window)) {
            alert('این مرورگر از نوتیفیکیشن پشتیبانی نمی‌کند.');
            return;
        }

        if (Notification.permission === 'granted') {
            new Notification('نوتیفیکیشن فعال است', {
                body: 'شما قبلاً مجوز داده‌اید!',
                icon: '<?php echo e(url('behin/logo.ico')); ?>'
            });
        } else if (Notification.permission === 'denied') {
            alert('شما مجوز نوتیفیکیشن را رد کرده‌اید. لطفاً از تنظیمات مرورگر آن را فعال کنید.');
        } else {
            Notification.requestPermission().then(permission => {
                if (permission === 'granted') {
                    new Notification('متشکریم!', {
                        body: 'شما نوتیفیکیشن را فعال کردید.'
                    });
                }
            });
        }
    }
</script>
<script>
    function logout() {
        // beamsClient.stop().catch(console.error);
        window.location = "<?php echo e(route('logout')); ?>"
    }
</script>



<script>
    $(document).ready(function() {
        initial_view()
    })

    function initial_view() {
        $('.select2').select2();
        $('.select2').css('width', '100%')
        $(".persian-date").persianDatepicker({
            viewMode: 'day',
            initialValue: false,
            format: 'YYYY-MM-DD',
            initialValueType: 'persian',
            calendar: {
                persian: {
                    leapYearMode: 'astronomical',
                }
            }
        });
        $(".persian-datetime").persianDatepicker({
            viewMode: 'day',
            initialValue: false,
            format: 'YYYY-MM-DD HH:mm',
            initialValueType: 'persian',
            timePicker: {
                enabled: true,
                second: {
                    enabled: false
                }
            },
            calendar: {
                persian: {
                    leapYearMode: 'astronomical',
                    locale: 'en'
                }
            }
        });
        // $('.timepicker').timepicker({
        //     timeFormat: 'HH:mm', // فرمت 24 ساعته
        //     interval: 1, // نمایش با فاصله 5 دقیقه‌ای
        //     dynamic: false,
        //     dropdown: true,
        //     scrollbar: true
        // });
        AutoNumeric.multiple('.formatted-digit', {
            digitGroupSeparator: ',',
            decimalCharacter: '.',
            decimalPlaces: 0,
            unformatOnSubmit: true
        });

        $('table tbody td .show-less').each(function() {
            let $cell = $(this);

            // اگر دکمه یا اسپن توی همین لحظه وجود داره یعنی قبلا پردازش شده
            if ($cell.find('.toggle-btn').length) return;

            let originalHtml = $cell.html();
            let textOnly = $cell.clone().children().remove().end().text()
                .trim(); // حذف تگ‌ها برای شمارش دقیق

            if (textOnly.length > 25) {
                let shortText = textOnly.substr(0, 25);

                $cell.html(`
            <span class="short-text">${shortText}</span>
            <span class="full-text" style="display:none;">${originalHtml}</span>
            <button class="toggle-btn show-more-btn material-icons" style="border:none;background:none;cursor:pointer;">more_horiz</button>
        `);
            }
        });

        $(document).on('click', '.toggle-btn', function() {
            let $cell = $(this).closest('td');
            $cell.find('.short-text, .full-text').toggle();
            $(this).text($(this).text() === 'more_horiz' ? 'expand_less' : 'more_horiz');
        });

        initAceEditor('.ace-editor')

        function initAceEditor(selector, options = {}) {
            $(selector).each(function() {
                var id = $(this).attr('id');
                if (!id) return;

                var editor = ace.edit(id);

                editor.setTheme(options.theme || "ace/theme/monokai");
                editor.session.setMode(options.mode || "ace/mode/php");

                editor.setOptions({
                    enableBasicAutocompletion: true,
                    enableLiveAutocompletion: true,
                    ...(options.editorOptions || {})
                });

                editor.getSession().setUseWorker(false);
                editor.setOption("wrap", options.wrap ?? true);

                if (typeof options.onInit === "function") {
                    options.onInit(editor);
                }
            });
        }

    }
</script>

<script src="<?php echo e(url('behin/behin-js/loader.js') . '?' . config('app.version')); ?>"></script>
<?php echo $__env->yieldContent('script'); ?>



</body>

</html>
<?php /**PATH /var/www/html/resources/views/behin-layouts/app.blade.php ENDPATH**/ ?>