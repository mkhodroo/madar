

<?php $__env->startSection('title'); ?>
    مپا سنتر
<?php $__env->stopSection(); ?>

<?php
    use Behin\SimpleWorkflow\Controllers\Core\ViewModelController;
    $disableBackBtn = true;
    $installPartViewModelId = '218c2926-67c3-4344-a54d-5f718eba3882';
    $installPartViewModel = ViewModelController::getById($installPartViewModelId);
    $installPartViewModelUpdateForm = $installPartViewModel->update_form;
    $installPartViewModelApikey = $installPartViewModel->api_key;
?>

<?php
    if (auth()->user()->access('مپاسنتر: امکان ویرایش اطلاعات مشتری')) {
        $customerForm = getFormInformation('240c03a0-c013-4bae-be3d-5b028e3b0f36');
    } else {
        $customerForm = getFormInformation('ac67f40d-4aa1-417a-9284-6a5c2f571ea1');
    }
    $deviceForm = getFormInformation('1edaccc5-ee2c-461e-b2b3-2f5024d90a9a');
    $fixForm = getFormInformation('14a68757-f609-44e1-82e9-4dc5ac35d60e');
    $variables = $case->variables();
?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <a href="javascript:history.back()" class="btn btn-outline-primary float-left">
                <i class="fa fa-arrow-left"></i> <?php echo e(trans('fields.Back')); ?>

            </a>
        </div>
    </div>
    <div class="card">
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($error); ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
        <div class="card-header">
            <h3 class="card-title">مپا سنتر</h3>
            شماره پرونده: <?php echo e($case->number); ?><br>
            <input type="hidden" id="caseId" value="<?php echo e($case->id); ?>">

            نام دستگاه: <?php echo e($case->getVariable('device_name')); ?>

        </div>
        <div class="card-body">
            <div class="card">
                <form action="<?php echo e(route('simpleWorkflowReport.mapa-center.update-case-info', $case->id)); ?>" method="POST"
                    onsubmit="return confirm('آیا از اینکه اطلاعات را ویرایش میکنید مطمئن هستید؟')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <?php echo $__env->make('SimpleWorkflowView::Core.Form.preview', [
                        'form' => $customerForm,
                        'case' => $case,
                        'variables' => $variables,
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php if(auth()->user()->access('مپاسنتر: امکان ویرایش اطلاعات مشتری')): ?>
                        <input type="submit" value="ویرایش" class="btn btn-primary m-2">
                    <?php endif; ?>
                </form>
            </div>

            <div class="card">
                <form action="<?php echo e(route('simpleWorkflowReport.mapa-center.update-case-info', $case->id)); ?>" method="POST"
                    onsubmit="return confirm('آیا از اینکه اطلاعات را ویرایش میکنید مطمئن هستید؟')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <?php echo $__env->make('SimpleWorkflowView::Core.Form.preview', [
                        'form' => $deviceForm,
                        'case' => $case,
                        'variables' => $variables,
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php if(auth()->user()->access('مپاسنتر: امکان ویرایش اطلاعات دستگاه')): ?>
                        <input type="submit" value="ویرایش" class="btn btn-primary m-2">
                    <?php endif; ?>
                </form>
            </div>

            <div class="card">
                <div class="card-header bg-info text-center">
                    قطعات تعمیر شده
                </div>
                <div class="card-body">
                    <div class="col-sm-12">
                        <div class="row table-responsive">
                            <table class="table table-bordered" id="parts-table">
                                <tr>
                                    <th>قطعه</th>
                                    <th>سرپرست</th>
                                    <th>تعمیرکار</th>
                                    <th>سریال مپا</th>
                                    <th>واحد</th>
                                    <th>گزارش</th>
                                    <th>تایید تعمیرات</th>
                                    <th>تصویر</th>
                                    <th>اعزام کارشناس</th>
                                    <th>کارشناس اعزام شده</th>
                                    <th>توضیحات اعزام کارشناس</th>
                                    <th>تاریخ پایان کار</th>
                                    <th>ساعت پایان کار</th>
                                    <th>مدت تعمیرات</th>
                                    <th><?php echo e(trans('fields.see_the_problem')); ?></th>
                                    <th><?php echo e(trans('fields.final_result_and_test')); ?></th>
                                    <th><?php echo e(trans('fields.test_possibility')); ?></th>
                                    <th><?php echo e(trans('fields.final_result')); ?></th>
                                    <th><?php echo e(trans('fields.problem_seeing')); ?></th>
                                    <th><?php echo e(trans('fields.sending_for_test_and_troubleshoot')); ?></th>
                                    <th><?php echo e(trans('fields.test_in_another_place')); ?></th>
                                    <th><?php echo e(trans('fields.job_rank')); ?></th>
                                    <th><?php echo e(trans('fields.other_parts')); ?></th>
                                    <th><?php echo e(trans('fields.special_parts')); ?></th>
                                    <th><?php echo e(trans('fields.power')); ?></th>
                                    <th><?php echo e(trans('fields.has_attachment')); ?></th>
                                    <th><?php echo e(trans('fields.attachment_image')); ?></th>
                                </tr>
                                <?php $__currentLoopData = $parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($part->name); ?></td>
                                        <td><?php echo e(getUserInfo($part->mapa_expert_head)->name ?? ''); ?></td>
                                        <td><?php echo e(getUserInfo($part->mapa_expert)->name ?? ''); ?></td>
                                        <td><?php echo e($part->mapa_serial); ?></td>
                                        <td><?php echo e($part->refer_to_unit); ?></td>
                                        <td><?php echo e($part->fix_report); ?></td>
                                        <td><?php echo e($part->repair_is_approved); ?></td>
                                        <td>
                                            <?php if($part->initial_part_pic): ?>
                                                <a href="<?php echo e(url("public/$part->initial_part_pic")); ?>" download>دانلود</a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($part->dispatched_expert_needed); ?></td>
                                        <td><?php echo e($part->dispatched_expert); ?></td>
                                        <td><?php echo e($part->dispatched_expert_description); ?></td>
                                        <td><?php echo e($part->doneAt ? toJalali($part->doneAt)->format('Y-m-d') : ''); ?></td>
                                        <td><?php echo e($part->doneAt ? toJalali($part->doneAt)->format('H:i') : ''); ?></td>
                                        <td><?php echo e($part->repair_duration); ?></td>
                                        <td><?php echo e($part->see_the_problem); ?></td>
                                        <td><?php echo e($part->final_result_and_test); ?></td>
                                        <td><?php echo e($part->test_possibility); ?></td>
                                        <td><?php echo e($part->final_result); ?></td>
                                        <td><?php echo e($part->problem_seeing); ?></td>
                                        <td><?php echo e($part->sending_for_test_and_troubleshoot); ?></td>
                                        <td><?php echo e($part->test_in_another_place); ?></td>
                                        <td><?php echo e($part->job_rank); ?></td>
                                        <td><?php echo e($part->other_parts); ?></td>
                                        <td><?php echo e($part->special_parts); ?></td>
                                        <td><?php echo e($part->power); ?></td>
                                        <td><?php echo e($part->has_attachment); ?></td>
                                        <td>
                                            <?php if($part->attachment_image): ?>
                                                <a href="<?php echo e(url("public/$part->attachment_image")); ?>" download>دانلود</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-info text-center">
                    گزارشات تعمیر
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-stripped" id="mapa-center-reports">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>تاریخ</th>
                                <th>ساعت شروع</th>
                                <th>ساعت پایان</th>
                                <th>مدت زمان صرف شده(ساعت)</th>
                                <th>تکنسین</th>
                                <th>گزارش</th>
                                <th>اقدام</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo e($totalDuration = 0); ?>

                            <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $duration = round(((int) $report->end - (int) $report->start) / 3600, 2);
                                    $totalDuration += $duration;
                                ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td dir="ltr"><?php echo e(toJalali((int) $report->start)->format('Y-m-d')); ?></td>
                                    <td dir="ltr"><?php echo e(toJalali((int) $report->start)->format('H:i')); ?></td>
                                    <td dir="ltr"><?php echo e(toJalali((int) $report->end)->format('H:i')); ?></td>
                                    <td><?php echo e($duration); ?></td>
                                    <td><?php echo e(getUserInfo($report->expert)?->name); ?></td>
                                    <td><?php echo e($report->report); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-danger"
                                            onclick="deleteReport('<?php echo e($report->id); ?>')"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-success">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>مجموع</td>
                                <td><?php echo e($totalDuration); ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="card ">
                <div class="card-header bg-info text-center">
                    خارج کردن قطعه از دستگاه
                </div>
                <div class="card-body">
                    <p>چنانچه قطعه ای از دستگاه خارج کردید با کلیک بر روی دکمه زیر نام قطعه را وارد کنید و ادامه مراحل در
                        فرایند داخلی طی خواهد شد</p>
                    <button class="btn btn-sm btn-danger" onclick="excludeDevice()">خارج کردن قطعه از دستگاه</button>
                    <form class="m-2" action="<?php echo e(route('simpleWorkflowReport.mapa-center.exclude-device', $case->id)); ?>"
                        method="POST" id="excludeDeviceForm" style="display: none;">
                        <?php echo csrf_field(); ?>
                        <input type="text" name="part_name" class="form-control" placeholder="نام قطعه">
                        <input type="submit" value="ثبت" class="btn btn-primary">
                    </form>
                    <script>
                        function excludeDevice() {
                            if ($('#excludeDeviceForm').is(':visible')) {
                                $('#excludeDeviceForm').hide();
                            } else {
                                $('#excludeDeviceForm').show();
                            }
                        }
                    </script>
                </div>
                
            </div>

            <div class="card mb-3" id="required-parts-details">
                <div class="card-body">
                    <?php if(auth()->user()->access('مپاسنتر: نمایش جزئیات فاکتور قطعات نصب شده')): ?>
                <?php echo $__env->make('SimpleWorkflowView::Core.Form.field-generator', [
                    'fieldName' => 'لیست قطعات مورد نیاز از انبار به همراه قیمت',
                    'fieldId' => 'consumable-parts',
                    'fieldClass' => 'col-sm-12 text-center',
                    'readOnly' => false,
                    'required' => false,
                    'fieldValue' => null,
                    'fieldValueAlt' => null,
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <script>
                    $('#consumable-parts .card-header').css('text-align', 'center')
                    $('#consumable-parts .card-header').css('background', '#eebef9')
                </script>
            <?php else: ?>
                <?php echo $__env->make('SimpleWorkflowView::Core.Form.field-generator', [
                    'fieldName' => 'قطعات مورد نیاز از انبار',
                    'fieldId' => 'consumable-parts',
                    'fieldClass' => 'col-sm-12 text-center',
                    'readOnly' => false,
                    'required' => false,
                    'fieldValue' => null,
                    'fieldValueAlt' => null,
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <script>
                    $('#consumable-parts .card-header').css('text-align', 'center')
                    $('#consumable-parts .card-header').css('background', '#eebef9')
                </script>
                    <?php endif; ?>
            <?php if(auth()->user()->access('گزارش مالی مپا سنتر')): ?>
                <?php echo $__env->make('SimpleWorkflowView::Core.Form.field-generator', [
                    'fieldName' => 'هزینه‌های انجام شده از تنخواه',
                    'fieldId' => 'hazinehaye_tankhah',
                    'fieldClass' => 'col-sm-12',
                    'readOnly' => true,
                    'required' => false,
                    'fieldValue' => null,
                    'fieldValueAlt' => null,
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>



            <?php if(auth()->user()->access('گزارش مالی مپا سنتر')): ?>
                <div class="card">
                    <div class="card-header bg-info text-center">گزارش مالی</div>
                    <div class="card-body row table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th><?php echo e(trans('fields.process_name')); ?></th>
                                <th><?php echo e(trans('fields.fix_cost_type')); ?></th>
                                <th><?php echo e(trans('fields.fix_cost_date')); ?></th>
                                <th><?php echo e(trans('fields.cost')); ?></th>
                                <th><?php echo e(trans('fields.destination_account')); ?></th>
                                <th><?php echo e(trans('fields.destination_account_name')); ?></th>
                                <th><?php echo e(trans('fields.payment')); ?></th>
                                <th><?php echo e(trans('fields.payment_date')); ?></th>
                                <th><?php echo e(trans('fields.payment_after_completion')); ?></th>
                            </tr>
                            <?php $__currentLoopData = $financials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($fin->process_name); ?></td>
                                    <td><?php echo e($fin->fix_cost_type); ?></td>
                                    <td><?php echo e($fin->fix_cost_date ? toJalali((int) $fin->fix_cost_date)->format('Y-m-d') : ''); ?>

                                    </td>
                                    <td><?php echo e(number_format($fin->cost)); ?>

                                        <?php if($fin->cost2): ?>
                                            <br>
                                            <?php echo e(number_format($fin->cost2)); ?>

                                        <?php endif; ?>
                                        <?php if($fin->cost3): ?>
                                            <br>
                                            <?php echo e(number_format($fin->cost3)); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($fin->destination_account); ?>

                                        <?php if($fin->destination_account_2): ?>
                                            <br>
                                            <?php echo e($fin->destination_account_2); ?>

                                        <?php endif; ?>
                                        <?php if($fin->destination_account_3): ?>
                                            <br>
                                            <?php echo e($fin->destination_account_3); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($fin->destination_account_name); ?>

                                        <?php if($fin->destination_account_name_2): ?>
                                            <br>
                                            <?php echo e($fin->destination_account_name_2); ?>

                                        <?php endif; ?>
                                        <?php if($fin->destination_account_name_3): ?>
                                            <br>
                                            <?php echo e($fin->destination_account_name_3); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e(number_format($fin->payment)); ?>

                                    </td>
                                    <td><?php echo e($fin->payment_date ? toJalali((int) $fin->payment_date)->format('Y-m-d') : ''); ?>

                                    </td>
                                    <td><?php echo e($fin->payment_after_completion); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card">
                <form action="<?php echo e(route('simpleWorkflowReport.mapa-center.update', $case->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <?php echo $__env->make('SimpleWorkflowView::Core.Form.preview', [
                        'form' => $fixForm,
                        'case' => $case,
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <input type="submit" value="ذخیره" class="btn btn-primary m-2">
                </form>
            </div>
            <?php if(access('مپاسنتر: تخمین هزینه')): ?>
                <?php echo $__env->make('SimpleWorkflowView::Core.Form.field-generator', [
                    'fieldName' => 'تخمین هزینه پرونده',
                    'fieldId' => 'case_cost_estimate',
                    'fieldClass' => 'col-sm-12 text-center',
                    'readOnly' => false,
                    'required' => false,
                    'fieldValue' => null,
                    'fieldValueAlt' => null,
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(auth()->user()->access('ثبت پایان کار مپا سنتر')): ?>
                <div class="card row">
                    <div class="card-header bg-info">
                        پایان کار
                    </div>
                    <div class="card-body row">
                        <div class="col-sm-4 mt-2">
                            <button class="btn btn-warning" onclick="sendForOnAccountPayment()">ارسال برای دریافت هزینه
                                علی
                                الحساب</button>
                        </div>
                        <div class="col-sm-4 mt-2">
                            <button class="btn btn-danger" onclick="sendForFixPrice()">ثبت پایان تعمیرات</button>
                        </div>
                    </div>
                    <script>
                        function sendForFixPrice() {
                            if (confirm('آیا از ثبت پایان تعمیرات مطمئن هستید؟')) {
                                var scriptId = "7ac4388d-c783-4ac2-8f9b-0bb01bee5818";
                                var fd = new FormData();
                                fd.append('caseId', '<?php echo e($case->id); ?>')
                                runScript(scriptId, fd, function(response) {
                                    alert('خسته نباشید')
                                    window.location.href = '<?php echo e(route('simpleWorkflowReport.mapa-center.index')); ?>';
                                })
                            }
                        }

                        function sendForOnAccountPayment() {
                            if (confirm('آیا از ارسال برای دریافت هزینه علی الحساب مطمئن هستید؟')) {
                                var scriptId = "3861c846-4735-443e-bbdf-aa502f44239a";
                                var fd = new FormData();
                                fd.append('caseId', '<?php echo e($case->id); ?>')
                                runScript(scriptId, fd, function(response) {
                                    show_message('ارسال شد برای دریافت هزینه علی الحساب')
                                    show_message('چند لحظه منتظر بمانید')

                                    console.log(response)

                                    // صبر کن 3 ثانیه بعد ریدایرکت کن
                                    setTimeout(function() {
                                        location.reload();
                                    }, 3000);
                                })
                            }
                        }
                    </script>
                </div>
            <?php endif; ?>
                </div>
            </div>


            <!-- باکس افزودن قطعه -->
            

            <!-- جدول قطعات نصب‌شده -->
            <div class="card">
                <div class="card-header bg-warning text-center">لیست قطعات نصب‌شده</div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id="install-parts-list-table">
                        <thead>
                            <tr>
                                <th>نام قطعه</th>
                                <th>مقدار</th>
                                <th>تاریخ ثبت</th>
                                <?php if(auth()->user()->access('مپاسنتر: نمایش جزئیات فاکتور قطعات نصب شده')): ?>
                                    <th>منبع تامین</th>
                                    <th>شماره فاکتور</th>
                                    <th>تاریخ فاکتور</th>
                                    <th>مبلغ</th>
                                <?php endif; ?>
                                <th>حذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $colspan = 4;
                                if (auth()->user()->access('مپاسنتر: نمایش جزئیات فاکتور قطعات نصب شده')) {
                                    $colspan = 8;
                                }
                                $totalAmount = 0;
                            ?>
                            <?php $__empty_1 = true; $__currentLoopData = $installParts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($part->name); ?></td>
                                    <td><?php echo e($part->value); ?></td>
                                    <td><?php echo e(jdate($part->created_at)->format('Y/m/d')); ?></td>
                                    <?php if(auth()->user()->access('مپاسنتر: نمایش جزئیات فاکتور قطعات نصب شده')): ?>
                                        <?php
                                            $totalAmount += (int) str_replace(',', '', $part->amount);
                                        ?>
                                        <td><?php echo e($part->supply_source); ?></td>
                                        <td><?php echo e($part->invoice_number); ?></td>
                                        <td><?php echo e($part->invoice_date); ?></td>
                                        <td><?php echo e($part->amount); ?></td>
                                    <?php endif; ?>
                                    <td>
                                        <?php if(auth()->user()->access('مپاسنتر: امکان ویرایش قطعات نصب شده')): ?>
                                            <i class="btn btn-sm btn-primary fa fa-edit"
                                                onclick="open_view_model_form(`<?php echo e($installPartViewModelUpdateForm); ?>`, `<?php echo e($installPartViewModelId); ?>`, `<?php echo e($part->id); ?>`, `<?php echo e($installPartViewModelApikey); ?>`)"></i>
                                        <?php endif; ?>
                                        <?php if(auth()->user()->access('مپاسنتر: امکان حذف قطعات نصب شده')): ?>
                                            <a href="<?php echo e(route('simpleWorkflowReport.mapa-center.delete-install-part', $part->id)); ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('آیا از حذف قطعه <?php echo e($part->name); ?> مطمئن هستید؟')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="<?php echo e($colspan); ?>" class="text-center">قطعه‌ای ثبت نشده است.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <?php if(auth()->user()->access('مپاسنتر: نمایش جزئیات فاکتور قطعات نصب شده')): ?>
                            <tfoot>
                                <tr>
                                    <td colspan="<?php echo e($colspan - 2); ?>" class="text-center">مجموع</td>
                                    <td><?php echo e(number_format($totalAmount)); ?></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        <?php endif; ?>
                    </table>
                </div>
            </div>

        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        initial_view()
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#mapa-center-reports').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/fa.json'
                },
                order: [
                    [1, 'desc']
                ]
            });

            // اجرا بعد از هر بار لود/رفرش جدول
            table.on('draw.dt', function() {
                initial_view();
            });

            $('#install-parts-list-table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/fa.json'
                },
                order: [
                    [2, 'desc']
                ]
            });

            $('#parts-table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/fa.json'
                },
            });

        });

        function deleteReport(id) {
            var scriptId = "05a8fc79-b957-441b-8de4-275d7893c827";
            var fd = new FormData();
            fd.append('reportId', id)
            if (confirm("آیا از حذف این گزارش مطمئن هستید؟")) {
                runScript(scriptId, fd, function(response) {
                    alert(response)
                    window.location.reload();
                })
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('behin-layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/packages/behin-simple-workflow-report/src/Views/Core/MapaCenter/show.blade.php ENDPATH**/ ?>