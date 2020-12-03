@extends('layouts.app')
@section('content')
@section('breadcrumb')
<li class="breadcrumb-item">
    <a class= 'link-blue' href="{{ url('home') }}">Dashboard</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Users</li>
<li class="nav-item dropdown ml-auto">
    <a class="nav-link" href="#" id="notificationDropdown" data-toggle="dropdown" aria-expanded="false"></a>  
</li>
@endsection
    <hr style="margin: 0 0 0 0;">
    <div class="block full"  style="margin-bottom: 10px;" >
    <div class="block-title" style="padding: 1px 3px 1px 3px;">
       <h2><strong>School Departments<span></strong></h2>
         <a class="btn btn-info float-right " data-toggle="modal" data-target="#add_department">
           Add department
         </a>
    </div>
  <div class="alert"></div>
  @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
    </div>
  @endif
  @if ($message = Session::get('error'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
    </div>
  @endif
    <br>

<table id="schooldept_table" class="display compact cell-border" style="width:100%">
  <thead>
    <tr>
      <th>Code</th>
      <th>School Name</th>
      <th>Actions</th>
    </tr>
  </thead>   
</table>

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
            <div class="form-group">
              <label>School Code</label>
            <input type="text" class="form-control" name="school_code" required class="form-control">
            </div>
            <div class="form-group">
              <label>School Name</label>
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

<script type="text/javascript">

    $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    var token = $("input[name='_token']").val();


   // program table

        var dataTable= $('#schooldept_table').DataTable( {
          "scrollX": true,
          
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
	          url:"{{route('addSchoolForm')}}",
	          method:"POST",
	          data:$("#add_schooldept_form").serialize(),
	          success:function(data){
	            $("#add_schooldept_form")[0].reset();
	            $('#add_department').modal('hide');
	            dataTable.ajax.reload();
	           
	          }, error: function(jqxhr, status, exception) {
             alert('Duplicate School Code');
         }
	              
	        }); 
	    }); 
	    //delete
       $(document).on('click','.destroy',function(){
	      var conf = confirm('This record will be deleted. Continue?');
	      var id = $(this).attr('schoolid');

      if(conf){
        $.ajax({
          url:"{{route('deleteSchoolDept')}}",
          method:"POST",
          data:{
            id:id,
            _token:token
          },
          success:function(data){
            dataTable.ajax.reload();
            $('.alert').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><span id="alertMessage">Record deleted!</span> </div>');
            $('.alert').show();
            $(".alert").delay(4000).fadeOut(500);
            setTimeout(function(){
              $('#alertMessage').remove();
            }, 5000);
          },
          error: function(jqxhr, status, exception) {
             alert('Record not deleted. There are records associated with this Accreditation Status');
         }

        });  
      }
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
	          success:function(data){
	            $("#edit_schooldept_form")[0].reset();
	            $('#editDepartment').modal('hide');
	            dataTable.ajax.reload();
	            $('.alert').append('<div class="alert alert-info alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><span id="alertMessage">Record updated!</span> </div>');
	            $('.alert').show();
	            $(".alert").delay(4000).fadeOut(500);
	            setTimeout(function(){
	              $('#alertMessage').remove();
	            }, 5000);
	          }
	              
	        }); 
	    }); 

    </script>
@endsection