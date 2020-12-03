@extends('layouts.app')
@section('content')
<style type="text/css">
	/* Shadow */
	.hvr-shadow {

	  -webkit-transform: perspective(1px) translateZ(0);
	  transform: perspective(1px) translateZ(0);
	  box-shadow: 0 0 1px rgba(0, 0, 0, 0);
	  -webkit-transition-duration: 0.3s;
	  transition-duration: 0.3s;
	  -webkit-transition-property: box-shadow;
	  transition-property: box-shadow;

	}
	.hvr-shadow:hover, .hvr-shadow:focus, .hvr-shadow:active {
	  box-shadow: 0 12px 10px -10px rgba(0, 0, 0, 0.5);
	}
	.stretcged-link, a:hover{
		  color: white;
	}
}
</style>
    <hr style="margin: 0 0 0 0;">
          <div class="block full"  style="margin-bottom: 10px;" >
         <div class="block-title" style="padding: 1px 3px 1px 3px;">
         <h2><strong>User Accounts</strong></h2>
          	<a class="btn btn-info float-right "  data-toggle="modal" data-target="#add_user">
    Add users
    </a>
  </div>
  <div class="alert"></div>
  @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
    </div>
  @endif
   
 <form class="mb-4" action="{{route('awardfilterReport')}}" method="POST">
@csrf 

  <strong>Sort by:</strong>
  <div class="form-group row">
    <div class="col-md-4 ">
      <label >Department</label>
      <div id="filters1">
      </div>
    </div>

    <div class="col-md-3 ">
      <label>User Description</label>
      <div id="filters2">
        
      </div>
    </div>

    <div class="col-md-3 ">
      <label>Status</label>
      <div id="filters3">
        
      </div>
    </div>
   </div>
   
</form>
    
    <!-- Table showing school details -->
    <div class=" pt-5">
    	<table id="account_table" class="display compact cell-border" style="width:100%">
		    <thead class="thead">
	            <tr>
	            	<th>Employee Name</th>
	            	<th>Department</th>
	            	<th>User Description</th>
	            	<th>Status</th>
	            	<!-- <th>Activation Date</th> -->
	            	<th>Actions</th>
	            </tr>
		    </thead>   
		</table>
    </div>
    
	<!-- end table -->


	<!-- Modal -->
	<div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Add a user</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form  method="POST" id="addUserForm">
         	@csrf
		      <div class="modal-body">
		      	<label>Default User Account:<br> Username: DepartmentCode_LastnameFirst Letter of First name<br> Password: ID Number</label><hr>
		        <div class="form-group">
		        	<label>Department</label>
		        	 <select id="mydropbox" class="form-control" onchange="copyValue()">
		        	 	 <option disabled selected value> -- --  </option>
			            @foreach($school as $sc)
			            <option value="{{$sc->id}}">{{$sc->school_name}}</option>
			            @endforeach
			          </select>
		        </div>
		        <input type="textbox" id="school_id" name="school_id" hidden/>
		         <div class="form-group">
		        	<label>ID Number</label>
		        	<input type="text" class="form-control" name="id_num" required>
		        </div>
		        <div class="row form-group">
		        	<div class="col-md-4"> 
		        		<label>Last Name</label>
		        		<input type="text" class="form-control" name="last_name" required> 
		        	</div>
		        	<div class="col-md-4"> 
		        		<label>Middle Initial</label>
		        		<input type="text" class="form-control" name="middle_i" required> 
		        	</div>
		        	<div class="col-md-4"> 
		        		<label>First Name</label>
		        		<input type="text" class="form-control" name="first_name" required> 
		        	</div>
		        	
		        </div>
		        <div class="form-group">
		        	<label>User Description</label>
		        	<select class="form-control"  name="user_role" onchange='CheckRole(this.value);'>
					  <option disabled selected value> -- --  </option>
					  <option value="Admin">Admin</option>
					  <option value="others">Others</option>
					</select>
		        </div>
		        <div class="form-group">
		        	<input type="text" class="form-control" id="role" name="role"  style='display:none;'/>
		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Add User</button>
	      	  </div>
	      </form>
	    </div>
	  </div>
	</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Edit user</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form method="post" action="{{ route('editUser') }}"  enctype="multipart/form-data" autocomplete="off" class="form-horizontal form-bordered">
                                            {{ csrf_field() }}
          	  <div class="modal-body">
          	  	<div class="row form-group">
          	  		<div class="col-md-4">
          	  			<input class="form-control small" type="text" id="first_name">
          	  		</div>
          	  		<div class="col-md-4">
          	  			<input class="form-control small" type="text" id="middle_i">
          	  		</div>
          	  		<div class="col-md-4">
          	  			<input class="form-control small" type="text" id="last_name">
          	  		</div>
	          	  	<label id="department"></label>
          	  </div>
          	  	<div class="form-group">
		        	 <div class="form-group">
		        	<label>User Description</label>
		        	<select class="form-control small" id="user_role" name="user_role" onchange='CheckRole(this.value);'>
					  <option disabled selected value> -- --  </option>
					  <option value="Admin">Admin</option>
					  <option value="others1">Others</option>
					</select>
		        </div>
		        <div class="form-group">
		        	<input type="text" class="form-control" id="role1" name="role1"  style='display:none;'/>
		        </div>
		         <div class="form-group">
		        	<label>Status</label>
		        	<select class="form-control small" id="status" name="status">
					  <option disabled selected value> -- --  </option>
					  <option value="Active">Active</option>
					  <option value="Inactive">Inactive</option>
					</select>
		        </div>
		      </div>
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

$('.alertOld').hide();
   
function copyValue(){
   var dropboxvalue = document.getElementById('mydropbox').value;
   document.getElementById('school_id').value = dropboxvalue;
}

function CheckRole(val){
 var roleAdd=document.getElementById('role');
 var roleEdit=document.getElementById('role1');
 if(val=='others')
   roleAdd.style.display='block';
 else  
   roleAdd.style.display='none';

 if(val=='others1')
   roleEdit.style.display='block';
 else  
   roleEdit.style.display='none';
}

   // account table
 var count = 0;
        
	   var dataTable= $('#account_table').DataTable( {
	        "ajax": "{{route('account_dtb', 1)}}", //view
	        responsive: true,
        	"scrollX": true,   

	        "columns": [
	            { "data": null , 
			     "render" : function ( data, type, full ) { 
			        return full['first_name']+', '+full['middle_initial']+'. '+full['last_name'];}
			      },
	            { "data": "school_name" },
	            { "data": "user_role" },
	            { "data": "status" },
	            { "data": "actions" },

	        ],
	          initComplete: function () {
              this.api().columns([1,2,3]).every( function () {
                  var column = this;
                  count++;
                  $('<div id="lalagyan'+count+'"></div>')
                      .appendTo( "#filters"+count );

                  var select = $('<select class="form-control small" name="select'+count+'"><option value="">All</option></select>')
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

    //add
	    $( "#addUserForm" ).submit(function( event ) {
	        event.preventDefault();
	      
	        $.ajax({
	          url:"{{route('addUser')}}",
	          method:"POST",
	          data:$("#addUserForm").serialize(),
	          success:function(data){
	            $("#addUserForm")[0].reset();
	            $('#add_user').modal('hide');
	            dataTable.ajax.reload();
	            $('.alert').append('<div class="alert alert-success alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><span id="alertMessage">Record added!</span> </div>');
	            $('.alert').show();
	            $(".alert").delay(4000).fadeOut(500);
	            setTimeout(function(){
	              $('#alertMessage').remove();
	            }, 5000);
	          }
	              
	        }); 
	    }); 
	    
	     //show edit form
  //show edit form
      $(document).on('click','.edit',function(){
          var id = $(this).attr('userid');
          var user_role = $(this).attr('user_role');
          var status = $(this).attr('status');
          var lastname = $(this).attr('lastname');
          var firstname = $(this).attr('firstname');
          var middlei = $(this).attr('middlei');

          $.ajax({
            url:"{{route('editUser')}}",
            method:"POST",
            data:{
              id:id,
              _token:token
            },
            success:function(data){
              $('#user_role').val( user_role );
              $('#status').val( status );
              $('#last_name').val( lastname );
              $('#middle_i').val( middlei );
              $('#first_name').val( firstname );
              $('#editUser').modal('show');
              $('#editBody').html(data);
            }   
          });  
        });

  	// delete
  	      $(document).on('click','.destroy',function(){
	      var conf = confirm('This record will be deleted. Continue?');
	      var id = $(this).attr('userid');

      if(conf){
        $.ajax({
          url:"{{route('deleteUser')}}",
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
             alert('Record not deleted. There are records associated with this User');
         }

        });  
      }
    });
    </script>
@endsection
