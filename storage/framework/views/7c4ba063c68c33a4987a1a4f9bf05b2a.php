<?php
use App\CustomClasses\Access;
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand"
    style="background-color: <?php echo e($headerColor ?? '#263238'); ?>; color: #fff; border-bottom: none;">

    <!-- Left navbar links -->
    <ul class="navbar-nav align-items-center">
        <!-- Menu Toggle -->
        <li class="nav-item">
            <a class="nav-link text-white" data-widget="pushmenu" href="#">
                <i class="fa fa-bars"></i>
            </a>
        </li>

        <!-- Send SMS -->
        <?php if(access('send-sms')): ?>
            <li class="nav-item">
                <a href="<?php echo e(url('admin/send-sms')); ?>" class="btn btn-sm btn-outline-light ms-2">
                    <i class="material-icons" style="font-size:18px;">sms</i>
                    ارسال پیامک
                </a>
            </li>
        <?php endif; ?>

        <!-- Test Notification -->
        <li class="nav-item d-none d-md-block">
            <a href="<?php echo e(route('send-notification')); ?>" class="btn btn-sm btn-warning">
                <i class="fa fa-bell"></i>
                تست نوتیفیکیشن
            </a>
        </li>
        <li class="nav-item d-md-block">
            <button type="button" class="btn btn-sm btn-warning" onclick="checkNotificationPermission()">
                <i class="fa fa-bell"></i>
            </button>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ms-auto align-items-center">

        <!-- Refresh -->
        <li class="mr-2">
            <button type="button" class="btn btn-sm btn-outline-light" onclick="window.location.reload()"
                ondblclick="window.location.href = '<?php echo e(url('/build-app')); ?>'">
                <i class="fa fa-refresh"></i>
                <?php echo e(__('Refresh')); ?>

            </button>
        </li>

        <!-- Home -->
        <li class="mr-2">
            <a href="<?php echo e(url('admin')); ?>" class="btn btn-sm btn-primary">
                <i class="fa fa-home"></i>
            </a>
        </li>

        <!-- Notifications -->
        <li class="mr-2 position-relative">
            <a href="<?php echo e(route('notifications.index')); ?>" class="btn btn-sm btn-outline-light notification-button"
                title="اعلان‌ها">

                <i class="fa fa-bell"></i>

                <span id="notification-count" class="notification-badge d-none">
                    0
                </span>
            </a>
        </li>

        <!-- Todo List -->
        <?php echo $__env->make('TodoListViews::partial-views.todo-list-icon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- User Profile -->
        <?php echo $__env->make('UserProfileViews::partial-views.user-profile-icon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Logout -->
        <li class="mr-2">
            <button class="btn btn-sm btn-danger" onclick="logout()">
                <i class="fa fa-sign-out"></i>
            </button>
        </li>
    </ul>
</nav>


<style>
    .navbar .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .navbar .btn-outline-light:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .navbar .btn-warning {
        color: #000;
        font-weight: 600;
    }

    .navbar .nav-link:hover {
        background: rgba(255, 255, 255, 0.08);
        border-radius: 8px;
    }

    .navbar-expand {
        justify-content: space-between !important;
    }

    .notification-button {
        position: relative;
    }

    .notification-badge {
        position: absolute;
        top: -8px;
        right: -8px;

        min-width: 20px;
        height: 20px;

        padding: 0 5px;

        border-radius: 50px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #dc3545;
        color: #fff;

        font-size: 11px;
        font-weight: bold;

        border: 2px solid <?php echo e($headerColor ?? '#263238'); ?>;
    }

    .notification-badge.d-none {
        display: none !important;
    }
</style>

<script>
    function loadNotificationCount() {

        fetch("<?php echo e(route('api.notifications.count')); ?>", {
            method: "GET",
            headers: {
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            credentials: "same-origin"
        })
        .then(response => {

            if (!response.ok) {
                throw new Error('خطا در دریافت تعداد نوتیفیکیشن');
            }

            return response.json();
        })
        .then(data => {

            const badge = document.getElementById('notification-count');
            const count = parseInt(data.count || 0);

            if (count > 0) {

                badge.innerText = count > 99 ? '99+' : count;

                badge.classList.remove('d-none');

            } else {

                // badge.classList.add('d-none');

            }

        })
        .catch(error => {
            console.error(error);
        });
    }


    document.addEventListener('DOMContentLoaded', function () {

        // بار اول
        loadNotificationCount();

        // هر 30 ثانیه
        setInterval(loadNotificationCount, 30000);

    });
</script>
<?php /**PATH /var/www/html/resources/views/behin-layouts/header.blade.php ENDPATH**/ ?>