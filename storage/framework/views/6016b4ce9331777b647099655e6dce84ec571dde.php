
<?php $__env->startSection('content'); ?>
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
	  <div class="x_content">
		  <div class="row">
			  <div class="col-sm-12">

 <?php if(count($errors) > 0): ?>
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        <?php endif; ?>
<?php $__currentLoopData = $award; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="x_title">
  <h2><small><a href="<?php echo e(route('userStudentAward')); ?>" class="fa fa-angle-double-left" text="back">&nbsp;&nbsp;<?php echo e($aw->school_name); ?>: <?php echo e($aw->acad_prog_code); ?></a></small></h2>
<div class="clearfix"></div>
   </div>

  <div class="row">
    <div class="col-md-5">
      <?php if($aw->award_cert == ""): ?>
      <img src="<?php echo e(asset('certificates/blank_cert.png')); ?>" style="height:200;width:300px;">
      <?php else: ?>
       <a href="<?php echo e(asset('certificates/'.$aw->award_cert)); ?>"> 
      <img src="<?php echo e(asset('certificates/'.$aw->award_cert)); ?>" style="height:200;width:300px;"></a>
      <?php endif; ?>
    </div>
    <div class="col-md-7">
     <div class=" row">
      <center>
       
        <label style="font-size:14px;"><b><?php echo e($aw->first_name); ?> 
          <?php if($aw->middle_initial != ""): ?><?php echo e($aw->middle_initial); ?>.
          <?php endif; ?>
          <?php echo e($aw->last_name); ?><br>
          
        <?php echo e($aw->award); ?><br>
        <?php echo e($aw->title_competitions); ?></b></label><br>
      </center>
    </div>
    <div class=" row">
        <label  class="col-sm-3 col-form-label">Scope:</label>
        <label  class="col-sm-7 col-form-label"><?php echo e($aw->scope); ?></label>
    </div>
  <div class=" row">
    <label class="col-sm-3 col-form-label">Category:</label>
    <label class="col-sm-7 col-form-label"><?php echo e($aw->category); ?></label>
  </div>
  <div class=" row">
    <label class="col-sm-3 col-form-label">Participant's Classification:</label>
    <label class="col-sm-7 col-form-label"><?php echo e($aw->classification); ?></label>
  </div>
  <div class=" row">
    <label class="col-sm-3 col-form-label">Venue:</label>
    <label class="col-sm-7 col-form-label"><?php echo e($aw->venue); ?></label>
  </div>
  <div class=" row">
    <label class="col-sm-3 col-form-label">Award Giving Body:</label>
    <label class="col-sm-7 col-form-label"><?php echo e($aw->award_giving_body); ?></label>
  </div>
  <div class=" row">
    <label class="col-sm-3 col-form-label">Date:</label>
    <label class="col-sm-7 col-form-label"><?php echo e($aw->date_awarded); ?></label>
  </div>
  </div>
   <div class=" row mt-4">
    <div class="col-sm-12">
      <?php if(Auth::user()->hasPermission('edit-student')): ?>
      <a class="btn btn-info mr-2" href="<?php echo e(route('userAwardEdit', $aw->aw_id)); ?>">Edit</a>
      <?php endif; ?>
      <a class="btn btn-danger" href="<?php echo e(route('userStudentAward')); ?>"> Back</a>
    </div>
    </div>
  </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  
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
  title: 'Done!',
  text: 'Successfully updated!',
  timer: 1500
})
</script>
  <?php elseif(\Session::has('error')): ?>
  <script>
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Something went wrong!',
    footer: "<a>Back</a>"
  }) 
  </script>
  <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Accreditation\Modules/Award\Resources/views/others/award-details.blade.php ENDPATH**/ ?>