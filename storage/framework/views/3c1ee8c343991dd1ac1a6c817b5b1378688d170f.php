  <!--Change Password Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form class="form-horizontal" method="POST" action="<?php echo e(route('changePassword')); ?>">
          <?php echo e(csrf_field()); ?>

            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group<?php echo e($errors->has('current-password') ? ' has-error' : ''); ?>">
                <label for="new-password" class="col-md-4 control-label"><span class="text-danger">*</span>Current Password</label>

                <div >
                    <input id="current-password" type="password" class="form-control" name="current-password" required>

                    <?php if($errors->has('current-password')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('current-password')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group<?php echo e($errors->has('new-password') ? ' has-error' : ''); ?>">
                <label for="new-password" class="col-md-4 control-label"><span class="text-danger">*(at least 8 characters)</span>New Password </label>

                <div >
                    <input id="new-password" type="password" class="form-control" name="new-password" required>

                    <?php if($errors->has('new-password')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('new-password')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="new-password-confirm" class="control-label"><span class="text-danger">*</span>Confirm New Password</label>

                <div>
                    <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Change Password
                    </button>
                </div>
            </div>
              
            </div>
        </form>

        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\Accreditation\resources\views/common/changePassword.blade.php ENDPATH**/ ?>