
<?php $__env->startSection('content'); ?>
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
	  <div class="x_content">
		  <div class="row">
			  <div class="col-sm-12">
   <div class="alert"></div>
  
  <?php if(Session::has('message')): ?>
        <div class="alert alert-dismissible alert-info">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <div>The program <?php $__currentLoopData = $expiring; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <strong><?php echo e($exp->acad_prog_code); ?></strong> from the <strong><?php echo e($exp->school_code); ?></strong><br>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> accreditation will expire in less than a year</div>
          
        </div>
        
<?php endif; ?>
<div class="row col-md-12" style="display: inline-block;" >
    <div class="tile_count">
      
      <div class="col-md-2 col-sm-4 col-xs-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-level-up"></i> Orientation</span>
        <div class="count"><?php echo e($count5); ?></div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-level-up"></i> Candidate Status</span>
        <div class="count"><?php echo e($count6); ?></div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-level-up"></i> Level I</span>
        <div class="count"><?php echo e($count1); ?></div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-level-up"></i> Level II</span>
        <div class="count"><?php echo e($count2); ?></div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-level-up"></i> Level III</span>
        <div class="count"><?php echo e($count3); ?></div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-level-up"></i> Level IV</span>
        <div class="count"><?php echo e($count4); ?></div>
      </div>
    </div>
  </div>
  <div class="row col-md-12" style="display: inline-block;">
    <div class="top_tiles">
      <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 ">
        <div class="tile-stats">
          <div class="icon"><i class="fa "></i></div>
          <div class="count"><?php echo e($topnotcher); ?></div>
          <h3>Topnotchers</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 ">
        <div class="tile-stats">
          <div class="icon"><i class="fa "></i></div>
          <div class="count"><?php echo e($activeP); ?></div>
          <h3>Active Partners</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 ">
        <div class="tile-stats">
          <div class="icon"><i class="fa "></i></div>
          <div class="count"><?php echo e($inactiveP); ?></div>
          <h3>Inactive Partners</h3>
        </div>
      </div>
    </div>
  </div>
              </div>
          </div>
      </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php if(\Session::has('success')): ?>
<script>
Swal.fire({
  icon: 'success',
  title: 'Your password has been updated!',
  showConfirmButton: false,
  timer: 1500
})
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Accreditation\Modules/Accreditation\Resources/views/dashboard.blade.php ENDPATH**/ ?>