
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
        <a href="<?php echo e(route('schoolAward')); ?>" class="fa fa-angle-double-left" text="back">&nbsp;&nbsp;Back</a>
        <br><br>
 <form id="form" action="<?php echo e(route('updateSchoolAward')); ?>" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered">
                                            <?php echo e(csrf_field()); ?>

<input type="text" class="form-control" name="awardID" value="<?php echo e($schoolAward->id); ?>" hidden>
<div class="col-md-12" style="float: center;">
  <div class="row">
    <div class="col-md-5">
    <?php if($schoolAward->supporting_doc == ""): ?>
    <div > No Supporting Document</div><br><br>
    <?php else: ?>

    <a href="<?php echo e(asset('certificates/'.$schoolAward->supporting_doc)); ?>" target="_blank;"> 
    <?php  $imageExtensions = ['jpg', 'jpeg', 'png', 'pdf'];

      $explodeImage = explode('.', 'certificates/'.$schoolAward->supporting_doc);
      $extension = end($explodeImage);
      
      if(in_array($extension, $imageExtensions)){  ?>
          <img src="<?php echo e(asset('certificates/'.$schoolAward->supporting_doc)); ?>" style="height:220px;width:220px;border: 1px solid gray;">
          <a class="btn btn-danger deleteDocu" fileId="<?php echo e($schoolAward->id); ?>" style="color: white">Remove Document</a> <br>
          <?php }else { ?>
        <img src="<?php echo e(asset('images/pdf.png')); ?>" style="height:220px;width:220px;border: 1px solid gray;">
       <?php }?>
   </a>
    <?php endif; ?>
    <div class="form-group">
      <i class="fa fa-upload">Supporting Document</i>
      <input type="text"  id="award_cert" name="award_cert" class="form-control" value="<?php echo e($schoolAward->supporting_doc); ?>" hidden>
      <input type="file"  id="award_cert_file" name="award_cert_file" class="form-control" onchange="ViewSave('award_cert_file');"><br>
      <div style="display:inline-block; vertical-align: middle;">
       <button type="submit" id="saveimage" class="btn btn-primary" hidden>Save Document</button>
       
     </div>
    </div>
     
     </div>
    <div class="col-md-7">
      <span class="text-danger">* Required Fields</span><br>
        <div class="row form-group">
              <label><span class="text-danger">*</span>Title of Award</label>
              <input type="text" class="form-control" name="award" value="<?php echo e($schoolAward->award); ?>" required>
          </div>
          <div class="row form-group">
            <label><span class="text-danger">*</span>School</label>
        <select class="form-control small" name="school_id" required>
         <?php $__currentLoopData = $school; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           <option value = '<?php echo e($sc->id); ?>' <?=$schoolAward->school_id == '{{ $sc->id }}' ? ' selected="selected"' : '';?>> <?php echo e($sc->school_name); ?>   </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
       </select>
      </div>
          <div class=" row form-group">
        <label  class="col-sm-3 col-form-label"><span class="text-danger">*</span>Scope:</label>
        <div  class="col-sm-7">
           <select id="scope" name="scope" class="form-control" required >
            
            <option value="School" <?=$schoolAward->scope == 'School' ? ' selected="selected"' : '';?>>School</option>
            <option value="Institutional" <?=$schoolAward->scope == 'Institutional' ? ' selected="selected"' : '';?>>Institutional</option>
            <option value="Local" <?=$schoolAward->scope == 'Local' ? ' selected="selected"' : '';?>>Local</option>
            <option value="National" <?=$schoolAward->scope == 'National' ? ' selected="selected"' : '';?>>National</option>
            <option value="International" <?=$schoolAward->scope == 'International' ? ' selected="selected"' : '';?>>International</option>
           
          </select>
        </div>
    </div>
          <div class="row form-group">
            <div class="col-md-6">
                <label><span class="text-danger"></span>From</label>
                <input type="date" class="form-control" name="from" id="fromVal" value="<?php echo e($schoolAward->from); ?>" >
            </div>
            <div class="col-md-6">
                <label><span class="text-danger"></span>To</label>
                <input type="date" class="form-control" name="to" id="toVal" value="<?php echo e($schoolAward->to); ?>" >
                <span id="spnErrorDate" class="error text-danger" style="display: none;">*Must be greater than the starting Date.</span>
            </div>
          </div>
          <div class="row form-group">
              <label><span class="text-danger"></span>Venue</label>
              <input type="text" class="form-control" name="venue"  value="<?php echo e($schoolAward->venue); ?>" >
          </div>
          <div class="row form-group">
              <label><span class="text-danger">*</span>Award Giving Body</label>
              <input type="text" class="form-control" name="award_gb"  value="<?php echo e($schoolAward->award_giving_body); ?>" required>
          </div>
   <div class=" row mt-4">
    <div class="col-sm-12" id="clasValidate">
      <button type="submit" id="save" class="btn btn-primary" >Save Changes</button>
      <a class="btn btn-danger" href="<?php echo e(route('schoolAward')); ?>"> Back</a>
    </div>
    </div>
  </div>
  </div>
   </div>
 </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php echo $__env->make('common.inputVal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script type="text/javascript">
    $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    var token = $("input[name='_token']").val();

$(document).on('click','.destroy',function(){
	var id = $(this).attr('awardID');
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
			  url:"<?php echo e(route('deleteSchoolAward')); ?>",
			  method:"POST",
			  data:{
				id:id,
				_token:token
			  },
          success:function(data){
            Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          ) 
          dataTable.ajax.reload();
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

  function CheckAward(val){
   var element=document.getElementById('others1');
   var element2=document.getElementById('others2');
   if(val=='others')
     element.style.display='block';
   else
     element.style.display='none';

  if(val=='others2')
     element2.style.display='block';
   else 
    element2.style.display='none';
    
  }

  function ViewSave(val){
   if(val !='' || val !='No file chosen')
    document.getElementById("saveimage").hidden = false;
  }
  
  //delete
  $(document).on('click','.deleteDocu',function(){
      var fileId = $(this).attr('fileId');
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
        url:"<?php echo e(route('deleteDocu')); ?>",
        method:"POST",
        data:{
          fileId:fileId,
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Accreditation\Modules/Award\Resources/views/schoolAward-edit.blade.php ENDPATH**/ ?>