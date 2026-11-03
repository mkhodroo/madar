<!-- Bottom Navbar (only mobile) -->
<nav class="navbar navbar-light bg-white border-top shadow d-md-none fixed-bottom" id="mobile-navigation">
    <div class="container-fluid d-flex justify-content-around">
  
        <!-- Profile -->
      <a href="<?php echo e(route('simpleWorkflow.inbox.index')); ?>" class="text-center text-secondary text-decoration-none">
        <i class="bi bi-inbox fs-4"></i>
        <div class="small">کارتابل</div>
      </a>
      
      <!-- Home -->
      <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-center text-secondary text-decoration-none">
        <i class="bi bi-house fs-4"></i>
        <div class="small">خانه</div>
      </a>
  
      

      <a href="<?php echo e(route('logout')); ?>" class="text-center text-secondary text-decoration-none">
        <i class="bi bi-box-arrow-right fs-4"></i>
        <div class="small">خروج</div>
      </a>
  
    </div>
  </nav>
  
  <!-- Bootstrap Icons CDN -->
  
  <?php /**PATH /var/www/html/resources/views/behin-layouts/mobile-navigation.blade.php ENDPATH**/ ?>