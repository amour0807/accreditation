
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
          <form id="my_form" method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="role" value="staff" >
            <h1><img src="<?php echo e(asset('images/favicon.ico')); ?>" style="width: 40px;">&nbsp;&nbsp;<span><img src="<?php echo e(asset('images/UBanner.png')); ?>" style="width: 120px;"></span></h1>
            <p><a href="<?php echo e(route('login')); ?>" class="fa fa-angle-double-left" text="back">&nbsp;&nbsp;Back&nbsp;&nbsp;</a>Login Form</p>
            <p>Staff</p>
            <div>
              <input id="username" type="text" class="form-control<?php echo e($errors->has('username') ? ' is-invalid' : ''); ?>" name="username" value="<?php echo e(old('username')); ?>" placeholder="Username" required autofocus>

              <?php if($errors->has('username')): ?>
                  <span class="invalid-feedback" role="alert">
                      <strong><?php echo e($errors->first('username')); ?></strong>
                  </span>
              <?php endif; ?>
            </div>
            <div>
              <input id="password" type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" placeholder="Password" >

              <?php if($errors->has('password')): ?>
                  <span class="invalid-feedback" role="alert">
                      <strong><?php echo e($errors->first('password')); ?></strong>
                  </span>
              <?php endif; ?>
            </div>
            <div>
              <a class="btn btn-default" href="javascript:{}" onclick="document.getElementById('my_form').submit();">Log in</a>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
             

              <div class="clearfix"></div>
              <br />

              <div>
                 <p>©2020 All Rights Reserved. UB Quality Assurance Office</p>
              </div>
            </div>
          </form> 
        </section>
      </div>
    </div>
  </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Accreditation\resources\views/auth/staffLogin.blade.php ENDPATH**/ ?>