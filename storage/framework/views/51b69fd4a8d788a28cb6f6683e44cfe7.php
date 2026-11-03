

<?php $__env->startSection('title'); ?>
    تاریخچه
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="">
            <div class="card table-responsive">
                <div class="card-header bg-info">
                    تاریخچه انجام کار پرونده شماره <?php echo e($rows[0]->case->number); ?>

                </div>
                <div class="card-body">
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo e(trans('fields.Process')); ?></th>
                                <th><?php echo e(trans('fields.Task')); ?></th>
                                <th><?php echo e(trans('fields. Case')); ?></th>
                                <th><?php echo e(trans('fields.Actor')); ?></th>
                                <th><?php echo e(trans('fields.Status')); ?></th>
                                <th><?php echo e(trans('fields.Created At')); ?></th>
                                <th><?php echo e(trans('fields.Done Date')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr <?php if($row->status == 'new'): ?> class='bg-warning' <?php endif; ?>>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($row->task->process->name); ?></td>
                                    <td><?php echo e($row->task->name); ?></td>
                                    <td><?php echo e($row->case_name); ?></td>
                                    <td><?php echo e(getUserInfo($row->actor)?->name); ?></td>
                                    <td><?php echo e(trans('fields.' . $row->status)); ?></td>
                                    <td dir="ltr"><?php echo e(toJalali($row->created_at)->format('Y-m-d H:i')); ?></td>
                                    <td dir="ltr"><?php echo e($row->updated_at != $row->created_at ? toJalali($row->updated_at)->format('Y-m-d H:i') : ''); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('simpleWorkflow.inbox.edit', $row->id)); ?>"
                                            class="btn btn-sm btn-primary"><?php echo e(trans('fields.Edit')); ?></a>
                                        <a href="<?php echo e(route('simpleWorkflow.inbox.changeStatus', $row->id)); ?>"
                                            class="btn btn-sm btn-warning"><?php echo e(trans('fields.Change Status')); ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('behin-layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/packages/behin-simple-workflow-g1/src/Views/Core/Inbox/history.blade.php ENDPATH**/ ?>