
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<?php echo $__env->make('include.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</style>
<body class="login">
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
        <h1><img src="<?php echo e(asset('images/favicon.ico')); ?>" style="width: 40px;">&nbsp;&nbsp;<span><img src="<?php echo e(asset('images/UBanner.png')); ?>" style="width: 120px;"></span></h1>
            <p>Login Form</p>
            <a class="btn btn-app" href="<?php echo e(route('staff')); ?>"><i class="fa fa-group"></i>Staff</a>
            <a class="btn btn-app" href="<?php echo e(route('alumni')); ?>"><i class="fa fa-graduation-cap"></i>Alumni Feedback Form</a>
        </section><br />
        <div class="separator">
          <div class="clearfix"></div>
          <br />

          <div>
             <p>©2020 All Rights Reserved. UB Quality Assurance Office</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Accreditation\resources\views/auth/login.blade.php ENDPATH**/ ?>