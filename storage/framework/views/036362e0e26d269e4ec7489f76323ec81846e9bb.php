
<?php $__env->startSection('content'); ?>
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
      <h2>School Awards And Recognition</h2>
      <?php if(Auth::user()->hasPermission('create-schoolAward')): ?>
      <a class="btn btn-app float-right" data-toggle="modal"  data-target="#addAwardModal">
        <i class="fa fa-plus-square-o"></i> Add Award
      </a>
        <?php endif; ?>
      <div class="clearfix"></div>
    </div>
    <form class="mb-4" action="<?php echo e(route('schoolAwardfilterReport')); ?>" target="_blank" method="POST">
      <?php echo csrf_field(); ?> 
   <div class="row">
        <div class="col-md-6">
           <strong>Sort by:</strong>
        </div>
        <div class="col-md-6">
          <strong>Range of Award:</strong>
        </div>
      </div>
     <div class="form-group row">
       <div class="row col">
        <div class="col-md-4 ">
          <label >School</label>
          <select name="school1" id="school" class="form-control" required>
            <option> All  </option>
          <?php $__currentLoopData = $school; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option><?php echo e($a->school_code); ?> </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        </div>
      <div class="col-md-4 ">
        <label >Award</label>
        <select name="award1" id="award" class="form-control" required>
          <option> All  </option>
        <?php $__currentLoopData = $award; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option><?php echo e($a->award); ?> </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
      </div>
      <div class="col-md-4 ">
        <label >Scope</label>
        <select name="scope1" id="scope" class="form-control small" required>
          <option>All</option>
          <option value="School">School</option>
          <option value="Institutional">Institutional</option>
          <option value="Local">Local</option>
          <option value="National">National</option>
          <option value="International">International</option>
        </select>
      </div>
      </div>
    <div class="row col">
      <div class="col-6 col-md-6">
        <label>From </label>
        <select  class="form-control" name="min" id="min">
          <option>All</option>
        </select>
      </div>
      <div class="col-6 col-md-6">
      <label>To</label>
      <select  class="form-control" name="max" id="max">
          <option>All</option>
        </select>
    </div>
    </div>
    </div>
    <div class="row">
     <div class="col-md-8">
     </div>
    <div class="col-md-4">
     <div class="float-right">
       <a id="exportLink" class="btn btn-outline-success btn-sm edit " target="_blank" title="view excel" ><i class="fa fa-file-excel-o"></i></a>
         <button type="submit" class="btn btn-outline-danger btn-sm edit " target="_blank" title="view pdf" id="addBtn"><i class="fa fa-file-pdf-o"></i></button>
     </div><br><br>
     </div>
   </div>
  </form>
  </div>
</div>
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

    <!-- Table showing awards -->
    <div class="table-responsive">
      <table id="instawardtable" class="table table-striped jambo_table bulk_action" style="width: 100%;">
        <thead>
        <tr class="headings">
                <th>School</th>
                <th>Award Title</th>
                <th>Scope</th>
	            	<th>Valid From</th>
                <th>Valid To</th>
	            	<th>Venue</th>
                <th>Award <br>Giving Body</th>
                <th>Supporting <br>Document</th>
                    <th>Action</th>
	            </tr>
		    </thead>   
    </table>
    </div>
    <!-- Modal -->
	<div class="modal fade" id="addAwardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Add School Awards And Recognitions</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>

	       <form id="studentForm" enctype="multipart/form-data" autocomplete="off" class="form-horizontal form-bordered" style="padding: 0px 8px 0px 16px;">
                                            <?php echo e(csrf_field()); ?>

          
        <span class="text-danger">* Required Fields</span><br>
        <div class="modal-body">
          <div class="row form-group">
              <label><span class="text-danger">*</span>Title of Award</label>
		        	<input type="text" class="form-control" name="award" placeholder="" required>
          </div>
          
		    	<div class="form-group">
            <label><span class="text-danger">*</span><?php if(!Auth::user()->hasRole('admin')): ?><?php echo e($school->school_code); ?><?php endif; ?> Schools:</label>

        <select class="form-control small" name="school_id" required>
           <option disabled selected value> -- --  </option>
          <?php $__currentLoopData = $school; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value = '<?php echo e($sc->id); ?>'> <?php echo e($sc->school_name); ?>  </option>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
          </div>
          <div class= "row form-group"> 
		        <label><span class="text-danger">*</span>Scope:</label>
					<select name="scope" class="form-control small" required>
					  <option disabled selected value> -- --  </option>
					  <option value="School">School</option>
					  <option value="Institutional">Institutional</option>
					  <option value="Local">Local</option>
					  <option value="National">National</option>
					  <option value="International">International</option>
					</select>
					</div>
          <div class="row form-group">
            <div class="col-md-6">
                <label><span class="text-danger"></span>From</label>
                <input type="date" class="form-control" name="from" id="fromVal" placeholder="" >
            </div>
            <div class="col-md-6">
                <label><span class="text-danger"></span>To</label>
                <input type="date" class="form-control" name="to" id="toVal" placeholder="" >
                <span id="spnErrorDate" class="error text-danger" style="display: none;">*Must be greater than the starting Date.</span>
            </div>
          </div>
          <div class="row form-group">
              <label><span class="text-danger"></span>Venue</label>
		        	<input type="text" class="form-control" name="venue" placeholder="" >
          </div>
          <div class="row form-group">
              <label><span class="text-danger">*</span>Award Giving Body</label>
		        	<input type="text" class="form-control" name="award_gb" placeholder="" required>
          </div>
          <div class="row form-group">
		        	<i class="fa fa-upload">Supporting Document</i><br>
		        	<input type="file" name="supporting_doc" class="form-control">
		        </div>
		      <div class="modal-footer" id="clasValidate"> 
		       
            <a type="button" class="btn btn-danger" data-dismiss="modal">Close</a>
            <button type="submit" class="btn btn-info">Add Award</button>
	      	<div>
	      	</div>
             </form>
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
  title: 'Done!',
  text: 'Successfully Saved!',
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
  <?php elseif(\Session::has('success_add')): ?>
  <script>
    Swal.fire({
        title: 'Done',
        text: "Successfully Saved!",
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'add another award'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#addAwardModal').modal('show');
        }
      })
  </script>
  <?php endif; ?>
<?php echo $__env->make('common.inputVal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
	<script type="text/javascript">

    $.ajaxSetup({
	    headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
    });

     
    var token = $("input[name='_token']").val();

    var count = 0;
    $( "#studentForm" ).submit(function( event ) {
        event.preventDefault();
        $.ajax({
                    type: 'POST',
                    url: "<?php echo e(route('addSchoolAward')); ?>",
                    data:$("#studentForm").serialize(),
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {
                            $("#studentForm")[0].reset();
                            $('#addAwardModal').modal('hide');
                            dataTable.ajax.reload();
                            swal.fire("Done!", results.message, "success");
                          
                        } else {
                            swal.fire("Error!", results.message, "error");
                        }
                    }
                });
    }); 
    $('#min').each(function() {

      var year = (new Date()).getFullYear();
      year -= 30;
      for (var i = 30; i > 0; i--) {

        $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
      }
      })
      $('#max').each(function() {

      var year = (new Date()).getFullYear();
      year += 4;
      year -= 30;
      for (var i = 30; i > 0; i--) {

        $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
      }
      })
  $.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
      var from = $('#min').val()
			    to = $('#max').val()
			    dfrom = data[3].split(' '); 
			    dto = data[4].split(' '); 
			if ( ( isNaN( from ) && isNaN( to ) ) ||
				 ( isNaN( from ) && dfrom[2] <= to ) ||
				 ( from <= dfrom[2]   && isNaN( to ) ) ||
				 ( from <= dfrom[2]   && dto[2] <= to ) )
			{
				return true;
			}else{
			  return false;
			}
			
		}
  );
  $.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var award = $('#award').val()
            dbtype =  data[1]
        if (award == dbtype || award == 'All' )
          return true;
        else
        	return false;
    }
);
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var school = $('#school').val()
            dbtype =  data[0]
        if (school == dbtype || school == 'All' )
          return true;
        else
        	return false;
    }
);
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var scope = $('#scope').val()
            dbtype =  data[2]
        if (scope == dbtype || scope == 'All' )
          return true;
        else
        	return false;
    }
);

 var dataTable = $('#instawardtable').DataTable( {
          "ajax": "<?php echo e(route('schoolAward_dtb',1)); ?>",

           dom: 'Blfrtip',
          lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10', '25', '50', 'Show all' ]
        ],
        buttons: [
            'excelHtml5',
            ],

          responsive: true,
				"ordering": false,
          "columns": [
              { "data": "school_name" },
              { "data": "award" },
              { "data": "scope" },
              { "data": "from" },
              { "data": "to" },
              { "data": "venue" },
              { "data": "award_giving_body" },
              { "data": "dsupporting_doc" },
              { "data": "actions" },
          ],

        });


     $('#min, #max, #school, #award, #scope').change(function () {
                dataTable.draw();
                    });

	     //delete
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


       
    </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Accreditation\Modules/Award\Resources/views/schoolAward.blade.php ENDPATH**/ ?>