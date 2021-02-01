
<?php $__env->startSection('content'); ?>
<div class="col-md-12 col-sm-12 " >
	<div class="x_panel" >
    <div class="x_title">
      <h2>Academic Programs </h2>
      <?php if(Auth::user()->hasPermission('create-school')): ?>
      <a class="btn btn-app float-right" data-toggle="modal" data-target="#add_acadProg" >
        <i class="fa fa-plus-square-o"></i> Add Academic Program
      </a>
      <?php endif; ?>
      <div class="clearfix"></div>
    </div>
  <form class="mb-4" action="<?php echo e(route('acadprogReport')); ?>" method="POST" target="_blank" >
    <?php echo csrf_field(); ?> 
    <input type="hidden" name="reportType" value="notHistory">
    
      <div class="form-group row" >
        <div class="col-md-1"> <strong>Sort by:</strong>
          <label >School</label></div>
        <div class="col-md-3 ">
          <div id="filters1">
          </div>
        </div>
        
     <div class="col-md-4">
      <div class="float-right">
        <a id="exportLink" class="btn btn-outline-success btn-sm edit " target="_blank" title="view excel" ><i class="fa fa-file-excel-o"></i></a>
          <button type="submit" class="btn btn-outline-danger btn-sm edit" title="view pdf" id="addBtn"><i class="fa fa-file-pdf-o"></i></button>
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
          <div class="table-responsive">
            <table id="acadprogram_table" class="table table-striped jambo_table bulk_action" style="width: 100%;">
              <thead>
              <tr class="headings">
                <th>School</th>
                <th>Program Code</th>
                <th>Program Description</th>
                <th>Action</th>
              </tr>
        </thead>   
    </table>
          </div>

    <div class="modal fade" id="editAcadProg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST" id='edit_acadprog_form'>
        <?php echo csrf_field(); ?>
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Academic Program</h5>
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

<!-- Add Modal -->
<div class="modal fade " id="add_acadProg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST" id='add_acadProg_form' runat="server">
        <?php echo csrf_field(); ?>
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Academic Program</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label><span class="text-danger"> * Required Fields</span></label><br>
            <label><span class="text-danger">*</span>Department:</label>
              <select id="mydropbox" class="form-control" onchange="copyValue()" required>
                <option disabled selected value> -- --  </option>
            <?php $__currentLoopData = $school; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($sc->id); ?>"><?php echo e($sc->school_name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

      <input type="textbox" id="school_id" name="school_id" hidden />
            <div class="row form-group">
              <div class="col-md-6 col-sm-6">
                <label><span class="text-danger">*</span>Program Code</label>
                <input type="text" class="form-control" name="acad_prog_code" required class="form-control">
              </div>
              <div class="col-md-6 col-sm-6">
                <label><span class="text-danger">*</span>Status</label>
                <select class="form-control" name="status" required>
                  <option disabled selected value> -- --  </option>
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                  <option value="Closed">Closed</option>
                  
                </select>
              </div>
              
            </div>

            <div class="row form-group">
              <label><span class="text-danger">*</span>Program Description</label>
            <input type="text" class="form-control" name="acad_prog" required class="form-control">
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" >Save</button>
          </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
  $('.alert').hide();
     //add
       $( "#add_acadProg_form" ).submit(function( event ) {
           event.preventDefault();
           $.ajax({
                    type: 'POST',
             url:"<?php echo e(route('addAcadProg')); ?>",
             data:$("#add_acadProg_form").serialize(),
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {
               $("#add_acadProg_form")[0].reset();
               $('#add_acadProg').modal('hide');
                            dataTable.ajax.reload();
                            swal.fire("Done!", results.message, "success");
                        } else {
                            swal.fire("Error!", results.message, "error");
                        }
                    }
                });
       }); 
 function copyValue(){
 
    var dropboxvalue = document.getElementById('mydropbox').value;
    document.getElementById('school_id').value = dropboxvalue;
 
 }
 
      $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
     });
     
     var token = $("input[name='_token']").val();
 
    var count = 0;
 
 
    // program table
 
         var dataTable= $('#acadprogram_table').DataTable( {
           "ajax": "<?php echo e(route('acadprogram_dtb')); ?>",
           responsive: true,
          		"ordering": false,
                dom: 'Blfrtip',
              lengthMenu: [
              [ 10, 25, 50, -1 ],
              [ '10', '25', '50', 'Show all' ]
            ],
            buttons: [
                    {
                      extend: 'excelHtml5',
                      title: 'List of Academic Programs'
                  },
                  ],
           "columns": [
               { "data": "school_code"},
               { "data": "acad_prog_code" },
               { "data": "acad_prog"},
               { "data": "actions"},
           ],
 
           initComplete: function () {var $buttons = $('.dt-buttons').hide();
              $('.dataTables_length').show();
              $('#exportLink').on('click', function() {
                $('.buttons-excel').click(); 
              })
               this.api().columns([0,2]).every( function () {
                   var column = this;
                   count++;
                   $('<div id="lalagyan'+count+'"></div>')
                       .appendTo( "#filters"+count );
 
                   var select = $('<select class="form-control" name="select'+count+'"><option value="">All</option></select>')
                       .appendTo( "#lalagyan"+count )
                       .on( 'change', function () {
                           var val = $.fn.dataTable.util.escapeRegex(
                               $(this).val()
                           );
    
                           column
                               .search( val ? '^'+val+'$' : '', true, false )
                               .draw();
                       } );
    
                   column.data().unique().sort().each( function ( d, j ) {
                       select.append( '<option value="'+d+'">'+d+'</option>' )
                   } );
               } );
           },
 
     
         });
       
       //delete
        $(document).on('click','.destroy',function(){
         var id = $(this).attr('programid');
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
           url:"<?php echo e(route('deleteAcadProg')); ?>",
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
           var id = $(this).attr('programid');
 
           $.ajax({
             url:"<?php echo e(route('editAcadProg')); ?>",
             method:"POST",
             data:{
               id:id,
               _token:token
             },
             success:function(data){
               $('#editAcadProg').modal('show');
               $('#editBody').html(data);
              
             }   
           });  
         });
 
         //Implement edit
       $( "#edit_acadprog_form" ).submit(function( event ) {
           event.preventDefault();
           $.ajax({
             url:"<?php echo e(route('updateAcadProg')); ?>",
          method:"POST",
             data:$("#edit_acadprog_form").serialize(),
          success: function (results) {
                        if (results.success === true) {
               $("#edit_acadprog_form")[0].reset();
               $('#editAcadProg').modal('hide');
                            swal.fire("Done!", results.message, "success");
                            dataTable.ajax.reload();
                        } else {
                            swal.fire("Error!", results.message, "error");
                        }
                    }
        }); 
       });
      
       
 
     </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Accreditation\Modules/Accreditation\Resources/views/acadprog-details.blade.php ENDPATH**/ ?>