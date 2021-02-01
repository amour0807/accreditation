@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
      <h2> Accreditation Status </h2>
      <a class="btn btn-app float-right" data-toggle="modal" data-target="#add_status">
        <i class="fa fa-plus-square-o"></i> Add an accreditation status
      </a>
      <div class="clearfix"></div>
    </div>
	  <div class="x_content">
		  <div class="row">
			  <div class="col-sm-12">
          <div class="table-responsive">
            <table id="history_table" class="table table-striped jambo_table bulk_action" style="width: 100%;">
              <thead>
                <tr class="headings">
      <th>Accreditation Status</th>
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
      <form method="POST" id='add_status_form'>
        @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Accreditation Status</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label><span class="text-danger">*</span></label>Status Name</label>
            <input type="text" name="accredStatus" required class="form-control">
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
  
  var token = $("input[name='_token']").val();


 // program table

      var dataTable= $('#history_table').DataTable( {
        "ordering": false,
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
                    type: 'POST',
                    url: "{{route('addStatus')}}",
                    data:$("#add_status_form").serialize(),
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {
                            $("#add_status_form")[0].reset();
                            $('#add_status').modal('hide');
                            dataTable.ajax.reload();
                            swal.fire("Done!", results.message, "success");
                          
                        } else {
                            swal.fire("Error!", results.message, "error");
                        }
                    }
                });
    }); 
    
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
          url:"{{route('deleteStatus')}}",
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
  @endsection