
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

<?php if(session('success')): ?>
     <div class="alert alert-info alert-block">
            <strong><?php echo e(session('success')); ?></strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
     
<?php endif; ?>
<a href="<?php echo e(route('adminAcred_prog')); ?>" class="fa fa-angle-double-left" text="back">&nbsp;&nbsp;Back</a>
    <br><br>
  <div class=" row">
    <label class="col-sm-2 col-form-label">Visit Date From:</label>
    <label class="col-sm-10 col-form-label"><?php echo e($program->visit_date_from.' - '.$program->visit_date_to); ?></label>
  </div>

   <div class=" row ">
    <label class="col-sm-2 col-form-label">Valid From:</label>
    <label class="col-sm-10 col-form-label"><?php echo e($program->from.' - '.$program->to); ?></label>
   </div>

   <div class=" row ">
    <label class="col-sm-2 col-form-label">Remarks:</label>
    <div class="col-sm-10">
      <textarea class="form-control form-control-sm" id="remarks" rows="4" name="remarks" disabled=""><?php echo e($program->remarks); ?></textarea>
    </div>
   </div>

   <div class=" row mt-4">
    <div class="col-sm-12">
      <?php if(Auth::user()->hasRole('admin')): ?>
      <a class="btn btn-info mr-2" href="<?php echo e(route('accredEdit', $program->id)); ?>">Edit</a>
      <?php endif; ?>
      <a class="btn btn-danger" href="<?php echo e(route('adminAcred_prog')); ?>"> Back</a>
  	</div>
   </div>
  <hr>
<?php if(!$program->faap_cert): ?>
  <?php if(Auth::user()->hasRole('admin')): ?>
  <form id="fcForm" method="POST" enctype="multipart/form-data" action="<?php echo e(route('addFile')); ?>">
    <?php echo csrf_field(); ?>
      <input type="hidden" name="typeForm" value="fc">
      <input type="hidden" name="id" value="<?php echo e($program->id); ?>">


    <div class="form-group row mt-4">
        <label class="col-sm-2 col-form-label">FAAP Certificate:</label>
        <div class="col-md-4 col-sm-4">
          <input type="file" name="faap_cert" class="form-control" required>
		    <span class="small">Files accepted: jpeg,jpg, png, pdf </span>
        </div>
        <div class="col-md-1 col-sm-1">
          <button class="btn btn-success" type="submit">save</button>
        </div>
     </div>
  </form>
     <?php endif; ?>
   <?php else: ?>
      <div class="form-group row mt-4">
        <label class="col-sm-2 col-form-label">FAAP Certificate:</label>
        
          <div class="col-md-2 col-sm-12  ">
              <a class="btn btn-info btn-block" href="<?php echo e(asset('uploads/'.$program->faap_cert)); ?>" target="_blank">View </a>
          </div>
          <?php if(Auth::user()->hasPermission('delete-accred')): ?>
          <div class="col-md-2 col-sm-12">
          <button class="btn btn-danger btn-block deleteCert" type ="fc" fileId="<?php echo e($program->id); ?>" >Remove</button>
          </div>
          <?php endif; ?>
    
     </div>
   <?php endif; ?>
   <?php if(!$program->pacucoa_cert): ?>
   <?php if(Auth::user()->hasPermission('delete-accred')): ?>
    <form id="pcForm" method="POST" enctype="multipart/form-data" action="<?php echo e(route('addFile')); ?>">
      <?php echo csrf_field(); ?>
      <input type="hidden" name="id" value="<?php echo e($program->id); ?>">
      <input type="hidden" name="typeForm" value="pc">
       <div class="form-group row">
          <label class="col-sm-2 col-form-label">PACOCUA Certificate:</label>
          <div class="col-sm-4">
            <input type="file" name="pacucoa_cert" class="form-control" required>
		  <span class="small">Files accepted: jpeg,jpg, png, pdf </span>
          </div>  
          <div class="col-sm-1">
            <button class="btn btn-success" type="submit">save</button>
          </div>
          
       </div>
     </form>
     <?php endif; ?>
   <?php else: ?>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">PACUCOA Certificate:</label>
        <div class="col-sm-2 px-1">
          <a class="btn btn-info btn-block" href="<?php echo e(asset('uploads/'.$program->pacucoa_cert)); ?>">View</a>
        </div>
        <?php if(Auth::user()->hasPermission('delete-accred')): ?>
        <div class="col-sm-2 px-1">
          <button class="btn btn-danger btn-block deleteCert" type ="pc" fileId="<?php echo e($program->id); ?>">Remove</button>
        </div>
        <?php endif; ?>
     </div>
   <?php endif; ?>
   <?php if(!$program->pacucoa_report): ?>
   <?php if(Auth::user()->hasPermission('delete-accred')): ?>
   <form id="prForm" method="POST" enctype="multipart/form-data" action="<?php echo e(route('addFile')); ?>">
    <?php echo csrf_field(); ?>
      <input type="hidden" name="id" value="<?php echo e($program->id); ?>">
      <input type="hidden" name="typeForm" value="pr">

       <div class="form-group row">
          <label class="col-sm-2 col-form-label">Chairman's Report:</label>
          <div class="col-sm-4">
            <input type="file" name="pacucoa_report" class="form-control" required>
            
		  <span class="small">Files accepted: jpeg,jpg, png, pdf </span>
          </div>
          <div class="col-sm-1">
              <button class="btn btn-success">save</button>
          </div>
          
       </div>
     </form>
   <?php endif; ?>
   <?php else: ?>
   <div class="form-group row">
      <label class="col-sm-2 col-form-label">Chairman's Report:</label>
      <div class="col-sm-2 px-1">
          <a class="btn btn-info btn-block" href="<?php echo e(asset('uploads/'.$program->pacucoa_report)); ?>">View</a>
      </div>
      <?php if(Auth::user()->hasPermission('delete-accred')): ?>
      <div class="col-sm-2 px-1">
          <button class="btn btn-danger btn-block deleteCert" type ="pr" fileId="<?php echo e($program->id); ?>">Remove</button>
      </div>
      <?php endif; ?>
   </div>

    <?php endif; ?>
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
  <script type="text/javascript">
    //delete
    
  var token = $("input[name='_token']").val();
  
  $(document).on('click','.deleteCert',function(){
      var fileId = $(this).attr('fileId');
      var type = $(this).attr('type');
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
          url:"<?php echo e(route('deleteCert')); ?>",
          method:"POST",
          data:{
            fileId:fileId,
            type:type,
            _token:token
          },
          success:function(data){
            Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          ) 
            location.reload();
          },
          error: function(jqxhr, status, exception) {
            Swal.fire(
            'Cannot be Deleted!',
            'this record still has a task. Please delete it all then delete this project.',
            'error'
          )
         }

        }); 
         
        }
      })
    }); 
</script>
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Accreditation\Modules/Accreditation\Resources/views/accreditation-details.blade.php ENDPATH**/ ?>