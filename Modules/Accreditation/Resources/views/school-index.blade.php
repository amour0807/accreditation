@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
  <h2>School Departments</h2>
  @if(Auth::user()->hasPermission('create-school'))
  <a class="btn btn-app float-right" data-toggle="modal" data-target="#add_department">
    <i class="fa fa-plus-square-o"></i> Add department
  </a>
    @endif
  <div class="clearfix"></div>
</div>
	  <div class="x_content">
		  <div class="row">
			  <div class="col-sm-12">
            <div class="table-responsive">
   <table id="schooldept_table" class="table table-striped jambo_table bulk_action" style="width: 100%;">
        <thead>
          <tr class="headings">
      <th>Code</th>
      <th>School Name</th>
      <th>Actions</th>
    </tr>
  </thead>   
</table>
</div>

<!-- Add Modal -->
<div class="modal fade" id="add_department" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form method="POST" id='add_schooldept_form'>
    		@csrf
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Add Department</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
            <label><span class="text-danger"> * Required Fields</span></label>
            <div class="form-group">
              <label><span class="text-danger">*</span></label>School Code</label>
            <input type="text" class="form-control" name="school_code" required class="form-control">
            </div>
            <div class="form-group">
              <label><span class="text-danger">*</span>School Name</label>
            <input type="text" class="form-control" name="school_name" required class="form-control">
            </div>
		        
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-success" >Save</button>
		      </div>
  		</form>
    </div>
  </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="editDepartment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form method="POST" id='edit_schooldept_form'>
    		@csrf
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Edit School Department</h5>
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

@endsection
@section('scripts')
<script type="text/javascript">

  $.ajaxSetup({
    headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  


 // program table

      var dataTable= $('#schooldept_table').DataTable( {
        "ordering": false,
        "ajax": "{{route('school_dept_dtb')}}",

        "columns": [
            { "data": "school_code" },
            { "data": "school_name" },
            { "data": "actions" },
        ],
      
      
        });
$('.alert').hide();
  //add
    $( "#add_schooldept_form" ).submit(function( event ) {
        event.preventDefault();
        $.ajax({
                    type: 'POST',
                    url: "{{route('addSchoolForm')}}",
                    data:$("#add_schooldept_form").serialize(),
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {
                          $("#add_schooldept_form")[0].reset();
                          $('#add_department').modal('hide');
                          dataTable.ajax.reload();
                            swal.fire("Done!", results.message, "success");
                        } else {
                            swal.fire("Error!", results.message, "error");
                        }
                    }
                });

    }); 
    
  var token = $("input[name='_token']").val();
    //delete
     $(document).on('click','.destroy',function(){
      var id = $(this).attr('schoolid');
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
          url:"{{route('deleteSchoolDept')}}",
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
      })
  });

     //show edit form
    $(document).on('click','.edit',function(){
        var id = $(this).attr('schoolid');

        $.ajax({
          url:"{{route('editSchoolDept')}}",
          method:"POST",
          data:{
            id:id,
            _token:token
          },
          success:function(data){
            $('#editDepartment').modal('show');
            $('#editBody').html(data);
           
          }   
        });  
      });

      //Implement edit

    $( "#edit_schooldept_form" ).submit(function( event ) {
        event.preventDefault();
        $.ajax({
          url:"{{route('updateSchoolDept')}}",
          method:"POST",
          data:$("#edit_schooldept_form").serialize(),
          success: function (results) {
                        if (results.success === true) {
                          $("#edit_schooldept_form")[0].reset();
                          $('#editDepartment').modal('hide');
                            swal.fire("Done!", results.message, "success");
                            dataTable.ajax.reload();
                        } else {
                            swal.fire("Error!", results.message, "error");
                        }
                    }
        }); 
    }); 

  </script>
@endsection