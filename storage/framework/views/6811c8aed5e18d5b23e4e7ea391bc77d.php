<aside class="main-sidebar elevation-4" style="background: <?php echo e($sidebarColor ?? '#263238'); ?>; color: #fff; min-height: 100vh;">

    <!-- User Profile -->
    <div class="sidebar p-3" style="direction: ltr;">
        <div style="direction: rtl;">
            <!-- Panel Logo -->
            <div class="sidebar-logo">
                <?php
                    $sidebarLogo = null;
                    if (class_exists(\SidebarManager\Models\SidebarImage::class)) {
                        $sidebarLogo = \SidebarManager\Models\SidebarImage::active();
                    }
                ?>

                <?php if($sidebarLogo): ?>
                    <img src="<?php echo e(url($sidebarLogo->url)); ?>"
                        alt="<?php echo e($sidebarLogo->title ?: config('app.name', 'پنل کاربری')); ?>"
                        class="sidebar-logo-img">
                <?php else: ?>
                    <div class="sidebar-logo-placeholder">
                        <i class="fa fa-layer-group"></i>
                        <span><?php echo e(config('app.name', 'پنل کاربری')); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="user-panel d-flex align-items-center mb-4 p-2 rounded" style="background: rgba(255,255,255,0.05);">
                
                <div class="info">
                    <span class="fw-bold"><?php echo e(auth()->user()->name ?? 'کاربر'); ?></span>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav>
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <?php $__currentLoopData = config('sidebar.menu'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if( access('منو >>' .$menu['fa_name']) ): ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link d-flex align-items-center" style="color: #fff; padding: 10px 15px;">
                                    <i class="fa fa-<?php echo e($menu['icon'] ?? ''); ?> me-2"></i>
                                    <span><?php echo e($menu['fa_name']); ?></span>
                                    <i class="material-icons ms-auto" style="font-size: 18px;"></i>
                                </a>
                                <ul class="nav nav-treeview ms-3" style="border-right: 2px solid rgba(255,255,255,0.1); margin-right: 10px; background: rgba(255,255,255,0.1)">
                                    <?php $__currentLoopData = $menu['submenu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if( access('منو >>' .$menu['fa_name'] . '>>' . $submenu['fa_name'] ) ): ?>
                                            <li class="nav-item">
                                                <a 
                                                    <?php if(isset($submenu['target'])): ?> target="<?php echo e($submenu['target']); ?>" <?php endif; ?>
                                                    href="<?php if(Route::has($submenu['route-name'])): ?> 
                                                                <?php echo e(route($submenu['route-name'])); ?> 
                                                            <?php elseif(isset($submenu['static-url'])): ?>
                                                                <?php echo e($submenu['static-url']); ?>

                                                            <?php else: ?>
                                                                <?php echo e(url($submenu['route-url'])); ?> 
                                                            <?php endif; ?>"
                                                    class="nav-link" 
                                                    style="color: #cfd8dc; padding: 8px 15px; transition: all 0.3s ease;">
                                                    
                                                    <span><?php echo e($submenu['fa_name']); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </nav>
        </div>
    </div>
</aside>


<style>
    /* ---------- Sidebar Logo ---------- */
    .sidebar-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        max-width: 100%;
        margin: 0 auto 16px;
        padding: 10px 0;
        overflow: hidden;
    }

    /* تصویر لوگو: کوچک و متناسب با عرض سایدبار */
    .sidebar-logo-img {
        display: block;
        width: auto;
        max-width: 100%;
        height: auto;
        max-height: 60px;
        object-fit: contain;
        object-position: center;
        border-radius: 6px;
        cursor: default;
    }

    /* حالت جایگزین وقتی لوگویی آپلود نشده است */
    .sidebar-logo-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        max-width: 100%;
        padding: 10px 8px;
        color: rgba(255, 255, 255, 0.85);
        text-align: center;
        word-break: break-word;
    }

    .sidebar-logo-placeholder i {
        font-size: 22px;
        opacity: 0.8;
    }

    .sidebar-logo-placeholder span {
        font-size: 13px;
        font-weight: 600;
        line-height: 1.6;
    }

    /* در حالت جمع شدن سایدبار (آیکونی) لوگو کوچک‌تر نمایش داده می‌شود */
    .sidebar-collapse .sidebar-logo {
        padding: 8px 0;
        margin-bottom: 10px;
    }

    .sidebar-collapse .sidebar-logo-img {
        max-height: 36px;
    }

    .sidebar-collapse .sidebar-logo-placeholder span {
        display: none;
    }

    /* ---------- Sidebar Nav ---------- */
    .nav-link {
        color: #bfbfbf !important;
        border-radius: 8px;
    }
    .nav-link:hover {
        background: rgba(255,255,255,0.08);
        color: #fff !important;
        border-radius: 8px;
    }
    .nav-treeview .nav-link:hover {
        background: rgba(255,255,255,0.05);
        padding-left: 20px !important;
    }
</style>
<?php /**PATH /var/www/html/resources/views/behin-layouts/main-sidebar.blade.php ENDPATH**/ ?>