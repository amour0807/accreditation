@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
      <h2><small>Add User Accounts </small></h2>
     
      <div class="clearfix"></div>
  </div>
  @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
    </div>
  @endif
  <form  action="{{route('createUser')}}" method="POST" id="formValidate" enctype="multipart/form-data"  >
  {{ csrf_field() }}
		      <div class="modal-body">
		      	<label>Default User Account:<br> Username: DepartmentCode_LastnameFirst Letter of First name<br> Password: ID Number</label><hr>
		        <div class="row form-group">
            <div class="col-md-4">
		        	<label><span class="text-danger">*</span>Department</label>
		        	 <select id="mydropbox" class="form-control" onchange="copyValue()" required>
		        	 	 <option disabled selected value> -- --  </option>
			            @foreach($school as $sc)
			            <option value="{{$sc->id}}">{{$sc->school_name}}</option>
			            @endforeach
                </select>
            </div>
		        <input type="textbox" id="school_id" name="school_id" hidden/>
            <div class="col-md-4">
                <label><span class="text-danger">*</span>ID Number</label>
                <input type="number" class="form-control" name="id_num" required>
            </div>
		        </div>
		        <div class="row form-group">
		        	<div class="col-md-4">
		        		<label><span class="text-danger">*</span>Last Name</label>
		        		<input type="text" class="form-control" name="last_name" required>
		        	</div>
		        	<div class="col-md-4">
		        		<label>Middle Initial</label>
		        		<input type="text" class="form-control" name="middle_i">
		        	</div>
		        	<div class="col-md-4">
		        		<label><span class="text-danger">*</span>First Name</label>
		        		<input type="text" class="form-control" name="first_name" required>
		        	</div>

            </div>
            <div class="form-group">
              <label><span class="text-danger">*</span><strong>Roles</strong></label>
              @foreach($roles as $role)
              <div><input type="radio"  value="{{$role->id}}" name="role" required>&nbsp;&nbsp;{{$role->role_name}}
              @endforeach
            </div>
		        <div class="row form-group">
          
            <div class="col-md-4">
            <table class="table table-bordered">
                <tr>
                  <th><span class="text-danger">*</span>Permissions</th>
                </tr>
                @foreach($listPermission as $list)
                    <?php
                      $numOfCols = 4;
                      $rowCount = 0;
                      $bootstrapColWidth = 12 / $numOfCols;
                    ?>
                    <tr>
                      <td>{{$list}}</td>
                    </tr>
              @endforeach
            </table>
              </div>
              <div class="col-md-8">
              <table class="table table-bordered" style="text-align:center;">
                  <tr>
                    <th>View</th>
                    <th>Create</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                    <tr>
                    @foreach($permissions as $p)
                      <td><input type="checkbox"  value="{{$p->id}}" name="permission[]" class="flat"></td>
                      <?php $rowCount++; ?>
                    @if($rowCount % $numOfCols == 0) 
                    </tr>
                    @endif
                    @endforeach
                    
              </table>
              </div>
              <span id="spnError" class="error text-danger" style="display: none;">*Please select at-least one Permission.</span>
		        </div>
		      </div>
		      <div class="modal-footer">
            <a href="{{route('userlist')}}"class="btn btn-warning" class="btn btn-secondary">Back</a>
            <div id="perValidate">
            <button type="submit" class="btn btn-primary">Add User</button>
            </div>
	      	</div>
        </form>
  </div>
</div>
<script type="text/javascript">
//VALIDATE NATURE
$("#perValidate button").click(function(event){
var checked = $("#formValidate input[type=checkbox]:checked").length;
            var isValid = checked > 0;
            if(isValid == false){
              event.preventDefault(); 
            } $("#spnError")[0].style.display = isValid ? "none" : "block";
});

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
