

<?php $__env->startSection('title'); ?>
    مپا سنتر
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">مپا سنتر</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="draft-list">
                    <thead>
                        <tr>
                            
                            <th class="d-none">شناسه</th>
                            <th>شماره پرونده</th>
                            <th>دستگاه</th>
                            <th>نام مشتری</th>
                            <th>مدل دستگاه</th>
                            <th>سریال مپا</th>
                            <th>تاریخ ایجاد</th>
                            <th>اقدام</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $process->cases->where('parent_id', null); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($case->getVariable('end_of_repair') != 'yes'): ?>
                                <tr
                                    ondblclick="window.location.href='<?php echo e(route('simpleWorkflowReport.mapa-center.show', ['mapa_center' => $case->id])); ?>'">
                                    
                                    <td class="d-none"><?php echo e($case->id); ?></td>
                                    <td><?php echo e($case->number); ?>

                                        <a
                                            href="<?php echo e(route('simpleWorkflowReport.mapa-center.show', ['mapa_center' => $case->id])); ?>"><i
                                                class="fa fa-external-link"></i></a>
                                    </td>
                                    <td><?php echo e($case->getVariable('device_name')); ?></td>
                                    <td><?php echo e($case->getVariable('customer_workshop_or_ceo_name')); ?></td>
                                    <td><?php echo e($case->getVariable('device_model')); ?></td>
                                    <td><?php echo e($case->getVariable('mapa_serial')); ?></td>
                                    <td dir="ltr"><?php echo e(toJalali($case->created_at)->format('Y-m-d H:i')); ?></td>
                                    <td><a
                                            href="<?php echo e(route('simpleWorkflowReport.mapa-center.show', ['mapa_center' => $case->id])); ?>"><button
                                                class="btn btn-primary btn-sm"><?php echo e(trans('fields.Show More')); ?></button></a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        $('#draft-list').DataTable({
            stateSave: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/fa.json'
            },
            order: [
                [0, 'desc']
            ]
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('behin-layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/packages/behin-simple-workflow-report/src/Views/Core/Summary/process/ab17ef68-6ec7-4dc8-83b0-5fb6ffcedc50.blade.php ENDPATH**/ ?>