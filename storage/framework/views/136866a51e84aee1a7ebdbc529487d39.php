

<?php $__env->startSection('title', 'گزارش قطعات درخواستی از انبار'); ?>

<?php $__env->startSection('content'); ?>

    <div class="card-body row">
        <div class="filter-card">

            <div class="filter-card-header">
                <div class="filter-title">
                    <div class="filter-icon">
                        <i class="fa fa-filter"></i>
                    </div>

                    <div>
                        <h5>فیلتر و جستجو</h5>
                        <span>برای محدود کردن نتایج گزارش، فیلترهای موردنظر را انتخاب کنید.</span>
                    </div>
                </div>
            </div>


            <form action="<?php echo e(route('simpleWorkflowReport.consumable-parts.report')); ?>" method="GET" id="search-form">

                <div class="row">

                    
                    <div class="col-lg-4 col-md-6 mb-3">
                        <label class="filter-label">
                            نام کالا
                        </label>

                        <div class="input-wrapper">
                            <i class="fa fa-cube"></i>

                            <input type="text" class="form-control material-input" name="item_name"
                                value="<?php echo e(request('item_name')); ?>" placeholder="نام کالا را وارد کنید">
                        </div>
                    </div>


                    
                    <div class="col-lg-4 col-md-6 mb-3">
                        <label class="filter-label">
                            درخواست کننده
                        </label>

                        <select name="requester_id" class="form-control select2 material-select">

                            <option value="">همه درخواست‌کنندگان</option>

                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>"
                                    <?php echo e(request('requester_id') == $user->id ? 'selected' : ''); ?>>
                                    <?php echo e($user->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>
                    </div>


                    
                    <div class="col-lg-4 col-md-6 mb-3">
                        <label class="filter-label">
                            وضعیت
                        </label>

                        <select name="status" id="status" class="form-control material-select">

                            <option value="">همه وضعیت‌های ستاره دار (به جز تایید)</option>

                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusKey => $statusValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $isStarredStatus = ($statusValue['key'] ?? $statusKey) != 'confirmed';
                                ?>
                                <option value="<?php echo e($statusValue['label']); ?>"
                                    <?php echo e(request('status') == $statusValue['label'] ? 'selected' : ''); ?>>
                                    <?php echo e($statusValue['label']); ?><?php echo e($isStarredStatus ? ' *' : ''); ?><?php echo e(!empty($statusValue['assignee']) ? ' (' . $statusValue['assignee'] . ')' : ''); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                        <small class="text-muted d-block mt-1">
                            گزینه «همه وضعیت‌های ستاره دار (به جز تایید)» یعنی همه وضعیت‌هایی که ستاره دارند؛ وضعیت «تایید»
                            فقط زمانی نمایش داده می‌شود که خودش انتخاب شود.
                        </small>
                    </div>


                    
                    <div class="col-lg-4 col-md-6 mb-3">
                        <label class="filter-label">
                            نوع تاریخ
                        </label>

                        <select name="date_column" id="date_column" class="form-control material-select">

                            <option value="created_at" <?php echo e(request('date_column') == 'created_at' ? 'selected' : ''); ?>>
                                تاریخ درخواست
                            </option>

                        </select>
                    </div>


                    
                    <div class="col-lg-4 col-md-6 mb-3">
                        <label class="filter-label">
                            از تاریخ
                        </label>

                        <div class="input-wrapper">
                            <i class="fa fa-calendar"></i>

                            <input type="text" class="form-control material-input persian-date" name="from_date"
                                value="<?php echo e(request('from_date')); ?>" placeholder="از تاریخ">
                        </div>
                    </div>


                    
                    <div class="col-lg-4 col-md-6 mb-3">
                        <label class="filter-label">
                            تا تاریخ
                        </label>

                        <div class="input-wrapper">
                            <i class="fa fa-calendar"></i>

                            <input type="text" class="form-control material-input persian-date" name="to_date"
                                value="<?php echo e(request('to_date')); ?>" placeholder="تا تاریخ">
                        </div>
                    </div>


                    
                    <div class="col-12">

                        <div class="filter-actions">

                            <button type="submit" class="btn material-search-btn">

                                <i class="fa fa-search"></i>
                                جستجو

                            </button>


                            <a href="<?php echo e(route('simpleWorkflowReport.consumable-parts.report')); ?>"
                                class="btn material-reset-btn">

                                <i class="fa fa-refresh"></i>
                                پاک کردن فیلترها

                            </a>

                            <?php if(auth()->user()->access('خروجی اکسل گزارش قطعات مصرفی')): ?>
                                <a href="<?php echo e(route('simpleWorkflowReport.consumable-parts.report.export', request()->query())); ?>"
                                    class="btn material-search-btn" style="background: #2e7d32;">

                                    <i class="fa fa-file-excel-o"></i>
                                    خروجی اکسل

                                </a>
                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </form>

        </div>


        <style>
            /* =========================
                   Filter Card
                ========================= */

            .filter-card {
                background: #fff;
                border: 1px solid #edf0f2;
                border-radius: 16px;
                margin-bottom: 25px;
                overflow: hidden;
                box-shadow: 0 3px 12px rgba(0, 0, 0, .045);
            }


            /* Header */

            .filter-card-header {
                padding: 18px 22px;
                border-bottom: 1px solid #f0f2f4;
                background: #fafbfc;
            }

            .filter-title {
                display: flex;
                align-items: center;
                gap: 13px;
            }

            .filter-icon {
                width: 42px;
                height: 42px;

                display: flex;
                align-items: center;
                justify-content: center;

                border-radius: 12px;

                background: #e3f2fd;
                color: #1976d2;

                font-size: 17px;
            }

            .filter-title h5 {
                margin: 0 0 4px;

                color: #263238;
                font-size: 15px;
                font-weight: 700;
            }

            .filter-title span {
                color: #90a4ae;
                font-size: 11px;
            }


            /* Body */

            .filter-card form {
                padding: 22px;
            }


            /* Labels */

            .filter-label {
                display: block;

                margin-bottom: 7px;

                color: #546e7a;

                font-size: 12px;
                font-weight: 600;
            }


            /* Inputs */

            .material-input,
            .material-select {
                height: 42px;

                border: 1px solid #dfe5e8;
                border-radius: 9px;

                color: #37474f;

                font-size: 13px;

                box-shadow: none !important;

                transition: all .2s ease;
            }

            .material-input:focus,
            .material-select:focus {
                border-color: #90caf9;

                box-shadow: 0 0 0 3px rgba(25, 118, 210, .08) !important;
            }


            .material-input::placeholder {
                color: #b0bec5;
            }


            /* Input with icon */

            .input-wrapper {
                position: relative;
            }

            .input-wrapper>i {
                position: absolute;

                right: 13px;
                top: 50%;

                transform: translateY(-50%);

                color: #90a4ae;

                font-size: 13px;

                z-index: 2;
            }

            .input-wrapper .material-input {
                padding-right: 38px;
            }


            /* Select2 */

            .material-select+.select2-container {
                width: 100% !important;
            }

            .material-select+.select2-container .select2-selection {
                height: 42px;

                border: 1px solid #dfe5e8;
                border-radius: 9px;

                display: flex;
                align-items: center;

                box-shadow: none;
            }

            .material-select+.select2-container .select2-selection__rendered {
                color: #37474f;
                font-size: 13px;
                line-height: 40px;
                padding-right: 12px;
            }

            .material-select+.select2-container .select2-selection__arrow {
                height: 40px;
            }


            /* Actions */

            .filter-actions {
                display: flex;

                align-items: center;

                gap: 9px;

                padding-top: 5px;

                border-top: 1px solid #f1f3f4;
                margin-top: 5px;
                padding-top: 18px;
            }


            .material-search-btn {
                min-width: 105px;

                height: 40px;

                border: 0;
                border-radius: 9px;

                background: #1976d2;
                color: #fff;

                font-size: 12px;
                font-weight: 600;

                box-shadow: 0 3px 8px rgba(25, 118, 210, .2);

                transition: all .2s ease;
            }

            .material-search-btn:hover {
                background: #1565c0;
                color: #fff;

                transform: translateY(-1px);
            }

            .material-search-btn i {
                margin-left: 6px;
            }


            .material-reset-btn {
                height: 40px;

                padding: 0 15px;

                display: flex;
                align-items: center;

                border: 1px solid #e0e5e8;
                border-radius: 9px;

                background: #fff;
                color: #607d8b;

                font-size: 12px;
            }

            .material-reset-btn:hover {
                background: #f5f7f8;
                color: #37474f;
            }

            .material-reset-btn i {
                margin-left: 6px;
            }


            /* Mobile */

            @media (max-width: 576px) {

                .filter-card form {
                    padding: 17px;
                }

                .filter-card-header {
                    padding: 16px;
                }

                .filter-title span {
                    display: none;
                }

                .filter-actions {
                    flex-direction: column;
                    align-items: stretch;
                }

                .material-search-btn,
                .material-reset-btn {
                    width: 100%;
                    justify-content: center;
                }

            }
        </style>

    </div>

    <div class="card">
        <div class="card-header">تمام کالاها</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>قطعه</th>
                        <th>درخواست کننده</th>
                        <th>تعداد درخواست شده</th>
                        <th>تعداد تحویل شده</th>
                        <th>تعداد بازگشت داده شده</th>
                        <th>وضعیت</th>
                        <th>تاریخ درخواست</th>
                        <?php if(access('گزارش قطعات درخواستی از انبار - مشاهده ستون های مرتبط با قیمت')): ?>
                            <th>قیمت</th>
                            <th>قیمت واحد</th>
                            <th>واحد پول</th>
                            <th>منبع تامین</th>
                            <th>تاریخ فاکتور</th>
                            <th>شماره فاکتور</th>
                            <th>تاریخ سفارش</th>
                            <th>تاریخ دریافت</th>
                        <?php endif; ?>
                        <th>اقدامات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $allRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div><?php echo e($request->product_name); ?></div>
                                <?php if($request->item_id): ?>
                                    <div class="text-muted small">شناسه: <?php echo e($request->item_id); ?></div>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e(getUserInfo($request->created_by)->name ?? ''); ?></td>
                            <td><?php echo e($request->requested_quantity); ?></td>
                            <td><?php echo e($request->delivered_quantity); ?></td>
                            <td><?php echo e($request->returned_quantity); ?></td>
                            <td>
                                <?php
                                    $status = collect($statuses)
                                        ->where('label', $request->consumable_part_status)
                                        ->first();
                                ?>
                                <span class="badge"
                                    style="background: <?php echo e($status['color'] ?? '#cccccc'); ?>"><?php echo e($request->consumable_part_status); ?></span>
                                <?php if(!empty($status['assignee'])): ?>
                                    <small class="text-muted">(<?php echo e($status['assignee']); ?>)</small>
                                <?php endif; ?>
                            </td>
                            <td dir="ltr">
                                <?php if($request->created_at): ?>
                                    <?php echo e(toJalali($request->created_at)->format('Y-m-d H:i')); ?> <br>
                                <?php else: ?>
                                    ـ
                                <?php endif; ?>
                            </td>
                            <?php if(access('گزارش قطعات درخواستی از انبار - مشاهده ستون های مرتبط با قیمت')): ?>
                                <td><?php try { echo e($request->amount ? number_format($request->amount) : $request->amount); } catch (\Throwable $e) { echo $e->getMessage(); } ?></td>
                                <td><?php try { echo e($request->additional_info?->unit_price ?
                                    number_format($request->additional_info->unit_price) :
                                    $request->additional_info?->unit_price); } catch (\Throwable $e) { echo $e->getMessage(); } ?></td>
                                <td><?php echo e($request->additional_info?->currencyLabel()); ?></td>
                                <td><?php echo e($request->supply_source); ?></td>
                                <td><?php echo e($request->invoice_date); ?></td>
                                <td><?php echo e($request->invoice_number); ?></td>
                            <?php endif; ?>
                            <td><?php echo e($request->additional_info?->order_date); ?></td>
                            <td><?php echo e($request->additional_info?->receipt_date); ?></td>
                            <td>
                                <?php if(access('گزارش قطعات درخواستی از انبار - حذف رکورد')): ?>
                                    <button class="btn btn-sm btn-danger"
                                        onclick="confirmDelete('<?php echo e(route('simpleWorkflowReport.consumable-parts.delete', $request->id)); ?>')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="<?php echo e(access('گزارش قطعات درخواستی از انبار - مشاهده ستون های مرتبط با قیمت') ? 16 : 10); ?>"
                                class="text-center text-muted">درخواستی ثبت نشده است.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php if($allRequests->hasPages()): ?>
                <div class="text-center mt-2">
                    <span class="mx-2">
                        صفحه <?php echo e($allRequests->currentPage()); ?> از <?php echo e($allRequests->lastPage()); ?>

                    </span>
                    <a href="<?php echo e($allRequests->previousPageUrl()); ?>" class="btn btn-outline-secondary btn-sm">قبلی</a>
                    <?php for($i = 1; $i <= $allRequests->lastPage(); $i++): ?>
                        <a href="<?php echo e($allRequests->url($i)); ?>" class="btn btn-outline-secondary btn-sm"
                            <?php if($allRequests->currentPage() == $i): ?> style="background-color: #007bff" <?php endif; ?>><?php echo e($i); ?></a>
                    <?php endfor; ?>
                    <a href="<?php echo e($allRequests->nextPageUrl()); ?>" class="btn btn-outline-secondary btn-sm">بعدی</a>
                </div>
            <?php endif; ?>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<script>
    function confirmDelete(url) {
        if (confirm("آیا مطمئن هستید؟")) {
            window.location.href = url
        }
        return null;
    }
</script>

<?php echo $__env->make('behin-layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/packages/behin-simple-workflow-report/src/Views/Core/ConsumablePart/report.blade.php ENDPATH**/ ?>