@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
  <div class="x_panel">
    <div class="x_title">
      <h2><small>User Accounts </small></h2>
      <a class="btn btn-app float-right" href="{{route('addUser')}}">
        <i class="fa fa-plus-square-o"></i> Add User
      </a>
      <div class="clearfix"></div>
</div>

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
</div>
</div>
   
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_content">
            <div class="row">
              <div class="col-sm-12"> 
    <!-- Table showing school details -->
    
    <div class="table-responsive">
      <table id="account_table" class="table table-striped jambo_table" style="table-layout: fixed; width: 100%;">
           <thead>
             <tr class="headings">
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
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
	<!-- end table -->
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
          "bSort": false,

	        "columns": [
            { "data": null , 
            "render" : function ( data, type, full ) { 
              if(full['middle_initial'] != "")
              return full['first_name']+' '+full['middle_initial']+'. '+full['last_name'];
              else
              return full['first_name']+' '+full['last_name'];
              }
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
