

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
        <div class="col-lg-3 col-md-4 col-sm-6">

            <div class="material-card payment-card card-blue">

                <div class="material-card-content"
                    onclick="window.location='<?php echo e(route('simpleWorkflowReport.borrow-requests.index')); ?>'">

                    <div class="material-icon">
                        <i class="fa fa-cube"></i>
                    </div>

                    <h3><?php echo e(trans('کالای امانی')); ?></h3>

                    <p><?php echo e(trans('ثبت و مدیریت کالاهای امانی')); ?></p>

                </div>

            </div>

        </div>
        <?php if(access('درخواست قطعات مصرفی')): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-purple">

                    <div class="material-card-content"
                        onclick="window.location='<?php echo e(route('simpleWorkflowReport.consumable-parts.index')); ?>'">

                        <div class="material-icon">
                            <i class="fa fa-cogs"></i>
                        </div>

                        <h3><?php echo e(trans('درخواست قطعات مصرفی')); ?></h3>

                        <p><?php echo e(trans('ثبت درخواست قطعات مصرفی')); ?></p>

                    </div>

                </div>

            </div>
        <?php endif; ?>
        <?php if(access('گزارش قطعات درخواستی از انبار')): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-cyan">

                    <div class="material-card-content"
                        onclick="window.location='<?php echo e(route('simpleWorkflowReport.consumable-parts.report')); ?>'">

                        <div class="material-icon">
                            <i class="fa fa-list-alt"></i>
                        </div>

                        <h3><?php echo e(trans('گزارش قطعات درخواستی از انبار')); ?></h3>

                        <p><?php echo e(trans('گزارش قطعات درخواستی از انبار')); ?></p>

                    </div>

                </div>

            </div>
        <?php endif; ?>
        <?php if(access('لیست خرید داخلی و خارجی')): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-cyan">

                    <div class="material-card-content"
                        onclick="window.location='<?php echo e(route('simpleWorkflowReport.consumable-parts.buyingList')); ?>'">

                        <div class="material-icon">
                            <i class="fa fa-shopping-cart"></i>
                        </div>

                        <h3><?php echo e(trans('لیست خرید')); ?></h3>

                        <p><?php echo e(trans('لیست خرید داخلی و خارجی')); ?></p>

                    </div>

                </div>

            </div>
        <?php endif; ?>
        <?php if(access('دریافت کالا از انبار')): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card payment-card card-green">

                    <div class="material-card-content"
                        onclick="window.location='<?php echo e(route('simpleWorkflowReport.consumable-parts.create')); ?>'">

                        <div class="material-icon">
                            <i class="fa fa-truck"></i>
                        </div>

                        <h3><?php echo e(trans('دریافت کالا از انبار')); ?></h3>

                        <p><?php echo e(trans('ثبت درخواست دریافت کالای مصرفی از انبار')); ?></p>

                    </div>

                </div>

            </div>
        <?php endif; ?>
    </div>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('script'); ?>
        
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('behin-layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/warehouse.blade.php ENDPATH**/ ?>