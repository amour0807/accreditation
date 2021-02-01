
<?php $__env->startSection('content'); ?>
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
      <h2>Scholarship / Grants</h2>
      <a class="btn btn-app float-right" data-toggle="modal" data-target="#add_status">
        <i class="fa fa-plus-square-o"></i> Add scholarship
      </a>
      <div class="clearfix"></div>
    </div>
	  <div class="x_content">
		  <div class="row">
			  <div class="col-sm-12">
          <div class="table-responsive">
            <table id="history_table" class="table table-striped jambo_table action_bulk" style="width: 100%;">
              <thead>
                <tr class="headings">
      <th>Scholarship / Grants</th>
      <th>Category</th>
      <th>Company / Organization</th>
      <th >Actions</th>
    </tr>
  </thead>
      <tbody>
      </tbody>
    </table> 
          </div>
   
<!-- Add Modal -->
<div class="modal fade" id="add_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
      <form method="POST" action="<?php echo e(route('addList')); ?>">
        <?php echo csrf_field(); ?>
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Scholarship</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          
			<label><span class="text-danger">* Required Fields</span></label>
            <div class="form-group">
            <label><span class="text-danger">*</span>Scholarship Title</label>
            <input type="text" name="scholartitle" required class="form-control">
            </div>
            <div class="row form-group">
              
              <div class="col-md-6 col-sm-6">
                <label><span class="text-danger">*</span>Type</label>
              <select class="form-control small" name="type" required>
                  <option disabled selected value> -- --  </option>
                  <option value = 'Grant'> Grant </option>
                  <option value = 'Scholarship'> Scholarship  </option>
						</select>
              </div>
              <div class="col-md-6 col-sm-6">
                <label><span class="text-danger">*</span>Category</label>
              <select class="form-control small" name="category" onchange='CheckAward(this.value);' required>
						   <option disabled selected value> -- --  </option>
						  
							<option value = 'Internal'> Internal </option>
							<option value = 'External'> External  </option>
						</select>
            <div id="others2" style='display:none;'>
					    	<span class="text-danger">*</span><input type="text" class="form-control"  name="company"   placeholder="... company / organization">
            </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" >Save changes</button>
          </div>
      </form>
    </div>
  </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST" id='edit_status_form'>
        <?php echo csrf_field(); ?>
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Scholarship / Grants</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="editBody">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" >Save changes</button>
          </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php if(\Session::has('success')): ?>
<script>
Swal.fire({
  title: 'Successfully saved!',
  text: "Add another record?",
  icon: 'success',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes',
  cancelButtonText: 'Back to List'
}).then((result) => {
  if (result.isConfirmed) {
	$('#add_status').modal('show');
  }
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

  $.ajaxSetup({
    headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var token = $("input[name='_token']").val();

function CheckAward(val){
 var element=document.getElementById('others2');
 if(val=='External')
   element.style.display='block';
 else
   element.style.display='none';
}

 // program table

      var dataTable= $('#history_table').DataTable( {
        responsive: true,
        "ordering": false,
        "ajax": "<?php echo e(route('list_dtb')); ?>",
        
        "columns": [
            { "data": "scholar_title" },
            { "data": "category" },
            { "data": "company" },
            { "data": "actions" },
        ],
      
      
        });
$('.alert').hide();
    //delete
     $(document).on('click','.destroy',function(){
      var id = $(this).attr('statusid');

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
          url:"<?php echo e(route('deleteList')); ?>",
          method:"POST",
          data:{
            id:id,
            _token:token
          },
          success:function(data){
            
          dataTable.ajax.reload();
            Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          ) 
          },
          error: function(jqxhr, status, exception) {
            Swal.fire(
            'Cannot be Deleted!',
            'Record not deleted. There are records associated with this Record',
            'error'
          )
         }
        }); 
        }
  });
});

     //show edit form
    $(document).on('click','.edit',function(){
        var id = $(this).attr('statusid');

        $.ajax({
          url:"<?php echo e(route('editList')); ?>",
          method:"POST",
          data:{
            id:id,
            _token:token
          },
          success:function(data){
            $('#editModal').modal('show');
            $('#editBody').html(data);
           
          }   
        });  
      });

      //Implement edit

    $( "#edit_status_form" ).submit(function( event ) {
        event.preventDefault();
      
        $.ajax({
          url:"<?php echo e(route('updateList')); ?>",
          method:"POST",
          data:$("#edit_status_form").serialize(),
          success: function (results) {
                        if (results.success === true) {
                          $("#edit_status_form")[0].reset();
                          $('#editModal').modal('hide');
                            dataTable.ajax.reload();
                            swal.fire("Done!", results.message, "success");
                        } else {
                            swal.fire("Error!", results.message, "error");
                        }
                    }
        }); 
    }); 
  

  </script>
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Accreditation\Modules/QuantitativeReport\Resources/views/scholarship/list-scholar.blade.php ENDPATH**/ ?>