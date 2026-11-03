<!DOCTYPE html>
<html lang="en">

<head>
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
    <link rel="stylesheet"
        href="<?php echo e(url('behin/behin-dist/dist/css/adminlte.min.css') . '?' . config('app.version')); ?>">
    <link rel="stylesheet"
        href="<?php echo e(url('behin/behin-dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') . '?' . config('app.version')); ?>">
    <!-- Google Font: Source Sans Pro -->
    
    <!-- bootstrap rtl -->
    <link rel="stylesheet"
        href="<?php echo e(url('behin/behin-dist/dist/css/bootstrap-rtl.min.css') . '?' . config('app.version')); ?>">
    <!-- template rtl version -->
    <link rel="stylesheet"
        href="<?php echo e(url('behin/behin-dist/dist/css/custom-style.css') . '?' . config('app.version')); ?>">
    <link rel="stylesheet"
        href="<?php echo e(url('behin/behin-dist/dist/css/custom.css') . '?' . config('app.version')); ?>">
    <link rel="stylesheet"
        href="<?php echo e(url('behin/behin-dist/plugins/select2/select2.min.css') . '?' . config('app.version')); ?>">
    

    <link rel="stylesheet"
        href="<?php echo e(url('behin/behin-dist/plugins/toastr/toastr.min.css') . '?' . config('app.version')); ?>">

    <?php echo $__env->yieldContent('style'); ?>

    <script src="<?php echo e(url('behin/behin-dist/plugins/jquery/jquery.min.js') . '?' . config('app.version')); ?>">
    </script>
    <script src="<?php echo e(url('behin/behin-dist/plugins/toastr/toastr.min.js') . '?' . config('app.version')); ?>">
    </script>

    <script src="<?php echo e(url('behin/behin-js/ajax.js') . '?' . config('app.version')); ?>"></script>
    <script src="<?php echo e(url('behin/behin-js/dataTable.js') . '?' . config('app.version')); ?>"></script>
    <script src="<?php echo e(url('behin/behin-js/dropzone.js') . '?' . config('app.version')); ?>"></script>

</head>

<body>

    <div class="limiter">
        <?php echo $__env->make('behin-layouts.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="container-login100" style="">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="<?php echo e(url('behin/behin-js/loader.js') . '?' . config('app.version')); ?>"></script>
    <script src="<?php echo e(url('behin/behin-js/scripts.js') . '?' . config('app.version')); ?>"></script>
    <script src="<?php echo e(url('behin/behin-dist/plugins/select2/select2.full.min.js') . '?' . config('app.version')); ?>">
    </script>
    

    <script>
        $('.select2').select2();

        function initial_view() {
            $('.select2').select2();
            $('.select2').css('width', '100%')
            // $(".persian-date").persianDatepicker({
            //     viewMode: 'year',
            //     format: 'YYYY-MM-DD',
            //     initialValueType: 'persian'
            // });
        }
    </script>

    <?php echo $__env->yieldContent('script'); ?>
</body>

</html>
<?php /**PATH /var/www/html/resources/views/behin-layouts/welcome.blade.php ENDPATH**/ ?>