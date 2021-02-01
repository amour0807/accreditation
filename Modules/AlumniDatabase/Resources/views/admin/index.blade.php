@extends('layouts.appAlumni')
@section('content')
@section('additional')
<style type="text/css">
	table tr td {
	overflow-x: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;

	}
	table tr th {
		width: 9%;
	}

</style>
@endsection
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title"><a class="btn btn-app float-right" data-toggle="modal"  data-target="#addUserModal">
    <i class="fa fa-plus-square-o"></i> Add Account
  </a>
  <div class="clearfix"></div>
</div>
	</div>
</div>
<div class="col-md-12 col-sm-12">
	<div class="x_panel">
	  <div class="x_content">
		  <div class="row">
			  <div class="col-sm-12">

@if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        @endif

    <!-- Table showing awards -->
	<div class="table-responsive">
		<table id="usertable" class="table table-striped jambo_table bulk_action" style="width: 100%;">
		  <thead>
		  <tr class="headings">
	            	<th>School / Department</th>
	            	<th>Email</th>
	            	<th>Remarks</th>
	            	<th nowrap>Actions</th>
	            </tr>
		    </thead>   
		</table>
	</div>
    
	<!-- end table -->

	<!-- Modal -->
	<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="exampleModalLabel">Add Account</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
  
			 <form id="form" action="{{ route('addAlumniAccount') }}" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered" style="padding: 0px 8px 0px 16px;">
											  {{ csrf_field() }}
				  <div class="modal-body">
					 <div class="form-group">
				  <div class="row form-group">
						  <div class="col-md-12">
							  <label><span class="text-danger">*</span>School:</label>
								<select class="form-control form-control" id="schoolchange" name="school" required>
								  <option disabled selected value> -- -- --</option>
								  @foreach ($list as $school)
									<option value="{{$school->id}}">{{ $school->school_name }}</option>
								  @endforeach
							  </select>
						  </div>
				  </div>
				  <div class="row form-group">
					  <div class="col-md-12 form-group">
						  <label><span class="text-danger">*</span>Email</label>
						  <input type="email" name="email" class="form-control" required>
						  
						<label><span class="text-danger">Default password is their school code ex. qao</span></label>
					  </div>
				  </div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				  <button type="submit" class="btn btn-info">Add Record</button>
				  </div>
				</div>
			  </div>
			   </form>
		  </div>
		</div>
      </div>
      <!--End add Modal -->
      <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" id='edit_account_form'>
                @csrf
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Account</h5>
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

			  </div>
		  </div>
	  </div>
	</div>
</div>
@endsection
@section('scripts')
@if(\Session::has('successAcount'))
<script>
Swal.fire({
  title: 'Successfully saved!',
  text: "Add another account?",
  icon: 'success',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes',
  cancelButtonText: 'Back to List'
}).then((result) => {
  if (result.isConfirmed) {
	$('#addUserModal').modal('show');
  }
})
</script>
  @elseif(\Session::has('error'))
  <script>
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Something went wrong!',
    footer: "<a>Back</a>"
  }) 
  </script>
  @elseif(\Session::has('update'))
  <script>
  Swal.fire({
    icon: 'success',
    title: 'Done',
    text: 'Successfully Updated'
  }) 
  </script>
  @elseif(\Session::has('resend'))
  <script>
  Swal.fire({
    icon: 'success',
    title: 'Done',
    text: 'Successfully Send'
  }) 
  </script>
  @endif
<script type="text/javascript">
	
	$.ajaxSetup({
			headers: {
			   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	     //show edit form
   $(document).on('click','.edit',function(){
        var id = $(this).attr('accountid');

        $.ajax({
          url:"{{route('alumniAccountEdit')}}",
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
	var token = $("input[name='_token']").val();
		  var dataTable= $('#usertable').DataTable( {
				"ajax": "{{route('useraccount_dtb')}}", //view
				responsive: false,
				"scrollX": false,
				"ordering": false,
			    dom: 'Blfrtip',
			  lengthMenu: [
				[ 10, 25, 50, -1 ],
				[ '10', '25', '50', 'Show all' ]
			],
			buttons: [
               {
                extend: 'excelHtml5',
                title: 'Graduates'
            },
            ],

				"columns": [
					{ "data": "school_code" },
					{ "data": "email" },
					{ "data": "remarks" },
					{ "data": "actions" },
				],
				initComplete: function () {
	
				var $buttons = $('.dt-buttons').hide();
				$('.dataTables_length').show();
				 $('#exportLink').on('click', function() {
					$('.buttons-excel').click(); 
				 })
			  },
				});
	
	
			$('#from, #to').change(function () {
					dataTable.draw();
						});

    $( "#edit_account_form" ).submit(function( event ) {
        event.preventDefault();
      
        $.ajax({
          url:"{{route('updateAccount')}}",
          method:"POST",
          data:$("#edit_account_form").serialize(),
          success: function (results) {
                        if (results.success === true) {
                          $("#edit_account_form")[0].reset();
                          $('#editModal').modal('hide');
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
	var id = $(this).attr('enid');
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
			  url:"{{route('deleteAlumniGraduate')}}",
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
@endsection