@extends('accreditation::layouts.master')

@section('content')
<div class="alert"></div>
@if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
        </div>
     
        @endif

<div class="mb-5">
	<h2 class="float-left">Accreditation Status</h2>
	<a class="btn bg-ub-red float-right " data-toggle="modal" data-target="#add_status">
   		<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
		  <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
		</svg>
   		Add an accreditation
   	</a>
   	<br>
</div>


<table id="history_table" class="display table-bordered" style="width:100%">
          <thead class="thead">
            <tr>

                  <th>Accreditation Status</th>
                  <th>Actions</th>

            </tr>
          </thead>   
</table>






<!-- Add Modal -->
<div class="modal fade" id="add_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form method="POST" id='add_status_form'>
    		@csrf
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Add Accreditation Status</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <label>Status Name</label>
		        <input type="text" name="accredStatus" required class="form-control">
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary" >Save changes</button>
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
    		@csrf
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Edit Accreditation status</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body" id="editBody">
		        
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary" >Save changes</button>
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

        var dataTable= $('#history_table').DataTable( {
          "ajax": "{{route('accred_stat_dtb')}}",
         

          "columns": [
              { "data": "accred_status" },
              { "data": "actions" },
          ],
        
        
          });
$('.alert').hide();
    //add
	    $( "#add_status_form" ).submit(function( event ) {
	        event.preventDefault();
	      
	        $.ajax({
	          url:"{{route('addStatus')}}",
	          method:"POST",
	          data:$("#add_status_form").serialize(),
	          success:function(data){
	            $("#add_status_form")[0].reset();
	            $('#add_status').modal('hide');
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
	    
	    //delete
       $(document).on('click','.destroy',function(){
	      var conf = confirm('This record will be deleted. Continue?');
	      var id = $(this).attr('statusid');

      if(conf){
        $.ajax({
          url:"{{route('deleteStatus')}}",
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
          var id = $(this).attr('statusid');

          $.ajax({
            url:"{{route('editStatus')}}",
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
	          url:"{{route('updateStatus')}}",
	          method:"POST",
	          data:$("#edit_status_form").serialize(),
	          success:function(data){
	            $("#edit_status_form")[0].reset();
	            $('#editModal').modal('hide');
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