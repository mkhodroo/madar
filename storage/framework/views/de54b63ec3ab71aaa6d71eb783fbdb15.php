

<?php
    $disableBackBtn = true;
?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="header-banner material-card payment-card">
                <img src="<?php echo e(url('behin/header.png')); ?>" alt="Header">
            </div>
        </div>
        <?php if(auth()->user()->access('آیکون پذیرش دستگاه جدید ')): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-blue">

                    <div class="material-card-content"
                        onclick="window.location='<?php echo e(route('simpleWorkflow.process.startListView')); ?>'">

                        <div class="material-icon">
                            <i class="fa fa-laptop"></i>
                        </div>

                        <h3><?php echo e(trans('پذیرش دستگاه')); ?></h3>

                        <p><?php echo e(trans('ثبت پذیرش دستگاه جدید')); ?></p>

                    </div>

                </div>

            </div>
        <?php endif; ?>
        <?php if(auth()->user()->access('منو >>کارتابل>>کارتابل')): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-purple">

                    <div class="material-card-content"
                        onclick="window.location='<?php echo e(route('simpleWorkflow.inbox.index')); ?>'">

                        <div class="material-icon">
                            <i class="fa fa-inbox"></i>
                        </div>

                        <h3><?php echo e(trans('کارتابل من')); ?></h3>

                        <p><?php echo e(trans('لیست پرونده هایی که باید انجام دهید')); ?></p>

                    </div>

                </div>

            </div>
        <?php endif; ?>
        <div class="col-lg-3 col-md-4 col-sm-6">

            <div class="material-card payment-card card-orange">

                <div class="material-card-content" onclick="window.location='<?php echo e(route('todoList.index')); ?>'">

                    <div class="material-icon">
                        <i class="fa fa-bell"></i>
                    </div>

                    <h3><?php echo e(trans('اطلاع رسانی')); ?></h3>

                    <p><?php echo e(trans('آخرین اطلاع رسانی ها')); ?></p>

                </div>

            </div>

        </div>

        <?php if(auth()->user()->access('منو >>گزارشات کارتابل>>خلاصه')): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-cyan">

                    <div class="material-card-content"
                        onclick="window.location='<?php echo e(route('simpleWorkflowReport.summary-report.index')); ?>'">

                        <div class="material-icon">
                            <i class="fa fa-bar-chart"></i>
                        </div>

                        <h3><?php echo e(trans('گزارش پرونده ها')); ?></h3>

                        <p><?php echo e(trans('گزارش پرونده ها بر اساس وضعیت')); ?></p>

                    </div>

                </div>

            </div>
        <?php endif; ?>

        <?php if(auth()->user()->access('ثبت درخواست مرخصی')): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-green">

                    <div class="material-card-content"
                        onclick="if(confirm('شروع؟')) { window.location='<?php echo e(route('simpleWorkflow.process.start', [
                            'taskId' => '7f62e4ce-a96e-419a-8972-358fd642f39b',
                            'inDraft' => 0,
                            'force' => 1,
                            'redirect' => true,
                        ])); ?>'; }">

                        <div class="material-icon">
                            <i class="fa fa-calendar"></i>
                        </div>

                        <h3><?php echo e(trans('ثبت مرخصی')); ?></h3>

                        <p><?php echo e(trans('مرخصی خود را ثبت کنید')); ?></p>

                    </div>

                </div>

            </div>
        <?php endif; ?>
        <?php if(auth()->user()->access('وضعیت کارهای منقضی شده')): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-red">

                    <div class="material-card-content"
                        onclick="window.location='<?php echo e(route('simpleWorkflowReport.expired-tasks.index')); ?>'">

                        <div class="material-icon">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>

                        <h3><?php echo e(trans('کارهای منقضی')); ?></h3>

                        <p><?php echo e(trans('از این قسمت میتوانید وضعیت کارهای منقضی شده را مشاهده کنید')); ?></p>

                    </div>

                </div>

            </div>
        <?php endif; ?>
        <?php if(auth()->user()->access('لیست دستگاه های مپا سنتر')): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-blue">

                    <div class="material-card-content"
                        onclick="window.location='<?php echo e(route('simpleWorkflowReport.summary-report.show', 'ab17ef68-6ec7-4dc8-83b0-5fb6ffcedc50')); ?>'">

                        <div class="material-icon">
                            <i class="fa fa-cogs"></i>
                        </div>

                        <h3><?php echo e(trans('مپا سنتر')); ?></h3>

                        <p><?php echo e(trans('از این قسمت میتوانید لیست دستگاه های مپا سنتر را مشاهده کنید')); ?></p>

                    </div>

                </div>

            </div>
        <?php endif; ?>
        <?php if(auth()->user()->access('طرف حسابها')): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-purple">

                    <div class="material-card-content"
                        onclick="window.location='<?php echo e(route('simpleWorkflowReport.counter-party.index')); ?>'">

                        <div class="material-icon">
                            <i class="fa fa-users"></i>
                        </div>

                        <h3><?php echo e(trans('طرف حسابها')); ?></h3>

                        <p><?php echo e(trans('از این قسمت میتوانید لیست طرف حسابها را مشاهده کنید')); ?></p>

                    </div>

                </div>

            </div>
        <?php endif; ?>
        <?php if(auth()->user()->access('امور متفرقه')): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-orange">

                    <div class="material-card-content"
                        onclick="window.location='<?php echo e(route('simpleWorkflow.process.start', [
                            'taskId' => '1021591c-b6cf-4cb3-bbd8-028c5ed49253',
                            'inDraft' => 0,
                            'force' => 0,
                            'redirect' => true,
                        ])); ?>'">

                        <div class="material-icon">
                            <i class="fa fa-list-alt"></i>
                        </div>

                        <h3><?php echo e(trans('امور متفرقه')); ?></h3>

                        <p><?php echo e(trans('ثبت گزارش روزانه امور متفرقه')); ?></p>

                    </div>

                </div>

            </div>
        <?php endif; ?>
        <?php if(access('آیکون شروع فرایند ورود و خروج کالا از نگهبانی')): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-green">

                    <div class="material-card-content"
                        onclick="if(confirm('شروع؟')) { window.location='<?php echo e(route('simpleWorkflow.process.start', [
                            'taskId' => '28d862dd-9268-47ad-bf6f-aa0520e6d3d2',
                            'inDraft' => 0,
                            'force' => 1,
                            'redirect' => true,
                        ])); ?>'; }">

                        <div class="material-icon">
                            <i class="fa fa-exchange"></i>
                        </div>

                        <h3><?php echo e(trans('ورود و خروج کالا')); ?></h3>

                        <p><?php echo e(trans('ورود و خروج کالا از نگهبانی')); ?></p>

                    </div>

                </div>

            </div>
        <?php endif; ?>
        <?php if(access('آیکون شروع فرایند ماموریت')): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="material-card payment-card card-cyan">
                    <div class="material-card-content"
                        onclick="if(confirm('شروع؟')) { window.location='<?php echo e(route('simpleWorkflow.process.start', [
                            'taskId' => 'cf07ec23-686f-4a08-9cb5-5ea258c4b1a0',
                            'inDraft' => 0,
                            'force' => 1,
                            'redirect' => true,
                        ])); ?>'; }">
                        <div class="material-icon">
                            <i class="fa fa-briefcase"></i>
                        </div>
                        <h3><?php echo e(trans('مأموریت')); ?></h3>
                        <p><?php echo e(trans('مأموریت')); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="material-card payment-card card-orange">
                <div class="material-card-content"
                    onclick="window.location='<?php echo e(route('admin.warehouseDashboard')); ?>'">
                    <div class="material-icon">
                        <i class="fa fa-cubes"></i>
                    </div>
                    <h3><?php echo e(trans('انبار')); ?></h3>
                    <p><?php echo e(trans('کالای امانی، قطعات مصرفی و لیست خریدها')); ?></p>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('script'); ?>
        
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('behin-layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>