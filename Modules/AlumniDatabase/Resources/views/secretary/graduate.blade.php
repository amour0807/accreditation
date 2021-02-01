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
    <div class="x_title">
  <h2><small>List of Graduates </small></h2>
  @if(Auth::guard('alumni')->user()->user_role != 'admin')<a class="btn btn-app float-right" data-toggle="modal"  data-target="#addStudentAwardModal">
    <i class="fa fa-plus-square-o"></i> Add Graduate</a>@endif
  <div class="clearfix"></div>
</div> <form class="mb-4" action="{{route('alumniGradfilterReport')}}" method="POST">
	@csrf 

 <div class="row">
      <div class="col-md-12">
         <strong>Sort by:</strong>
      </div>
    </div>
   <div class="form-group row">
     <div class="row col">
    <div class="col-md-3 col-sm-4">
      <label>School / Department</label>
      <div id="filters1">
        
      </div>
	</div>
	<div class="col-md-3 col-sm-4">
		<label>Program</label>
		<div id="filters2">
		  
		</div>
	  </div>

    <div class="col-md-2 col-sm-4">
      <label>Semester</label>
      <div id="filters3">
        
      </div>
	</div>
	<div class="col-md-2 col-sm-4">
      <label>School Year</label>
      <div id="filters4">
        
      </div>
    </div>
	
	<div class="col-md-2 col-sm-4">
	<label>&nbsp;&nbsp;</label><br>
    <a id="exportLink" class="btn btn-outline-success btn-sm edit " target="_blank" title="view excel" ><i class="fa fa-file-excel-o"></i></a>
      <button type="submit" class="btn btn-outline-danger btn-sm edit " target="_blank" title="view pdf" id="addBtn"><i class="fa fa-file-pdf-o"></i></button><br><br>
      </div>
     </div>
  </div>
      
</form>
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
		<table id="graduatetable" class="table table-striped jambo_table bulk_action" style="width: 100%;">
		  <thead>
		  <tr class="headings">
	            	<th>School / Department</th>
	            	<th>Program</th>
	            	<th>Semester</th>
					<th>School Year</th>
	            	<th>ID Number</th>
	            	<th>Name</th>
	            	<th>Remarks</th>
	            	<th nowrap>Actions</th>
	            </tr>
		    </thead>   
		</table>
	</div>
    
	<!-- end table -->

	<!-- Modal -->
	<div class="modal fade" id="addStudentAwardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Add Graduates</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>

	       <form id="form" action="{{ route('addAlumniGraduate') }}" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered" style="padding: 0px 8px 0px 16px;">
                                            {{ csrf_field() }}
          	  <div class="modal-body">
		      	 <div class="form-group">
		    	
				<div class="row form-group">
						<div class="col-md-4" style="display: none">
							<label><span class="text-danger">*</span>School:</label>
							  <select class="form-control form-control-sm" name="school" required >
								@foreach ($list as $school)
								  <option selected value="{{$school->id}}">{{ $school->school_name }}</option>
								@endforeach
							</select>
						</div> 
						<div class="col-md-8">
							<label><span class="text-danger">*</span>Program:</label>
							  <div id='program_choice'>
								 <select class="form-control form-control-sm " name="program" required> 
									 <option disabled selected>--- --</option>
									 @foreach ($acad_prog as $ap)
									 <option value="{{$ap->id}}">{{ $ap->acad_prog }}</option>
								   @endforeach
								 </select>
							 </div>
						</div>
						<div class="col-md-4">
							<label><span class="text-danger"></span>Major:</label>
							<input type="text" name="major" class="form-control form-control-sm ">
						</div>
				</div>
				<div class="row form-group">
					<div class= "col-md-6"> 
						<label><span class="text-danger">*</span>Semester:</label>
						<select class="form-control small" name="semester" required disabled>
							<option value = '1st Sem'> First Semester  </option>
							<option value = '2nd Sem'   selected> Second Semester  </option>
						</select>
							</div>
							<div class="col-md-6 form-group">
								<label><span class="text-danger">*</span>School Year:</label>
								<select name="schoolyear" class="form-control" disabled>
								<option selected value = "2020 - 2021"> 2020 - 2021 </option>
									{{-- <?php $now = now()->year; ?>
									@for($year = $now; $year >= 2015 ; $year--)
									<option value='{{$year}}'>{{$year}}</option>
									@endfor --}}
								</select>
						</div>
				</div>
				
				
		        <div class="row form-group">
		        	<div class= "col-md-3"> 
		        <label><span class="text-danger">*</span>ID Number:</label>
					<input type="number" min="0" name="idnumber" class="form-control" required>
					</div>
					<div class="col-md-3 form-group">
						<label><span class="text-danger">*</span>First Name:</label>
						<input type="text" name="firstname" class="form-control" required>
				</div>

				<div class="col-md-3 form-group">
					<label><span class="text-danger"></span>Middle Name</label>
					<input type="text" name="middlename" class="form-control">
                </div>
                <div class="col-md-3 form-group">
					<label><span class="text-danger">*</span>Last Name</label>
					<input type="text" name="lastname" class="form-control" required>
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
			  </div>
		  </div>
	  </div>
	</div>
</div>
@endsection
@section('scripts')
@if(\Session::has('success'))
<script>
Swal.fire({
  title: 'Successfully saved!',
  text: "Add another graduate?",
  icon: 'success',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes',
  cancelButtonText: 'Back to List'
}).then((result) => {
  if (result.isConfirmed) {
	$('#addStudentAwardModal').modal('show');
  }
})
</script>
@elseif(\Session::has('successPassword'))
<script>
Swal.fire({
  icon: 'success',
  title: 'Your password has been updated!',
  showConfirmButton: false,
  timer: 1500
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
		
		var token = $("input[name='_token']").val();

    $('#schoolchange').on('change',function(){
            var id = $(this).val();
            $.ajax({
            url:"{{route('alumniGraduate_select')}}",
            method:"POST",
            data:{
            id:id,
            _token:token
            },
            success:function(data){
            $('#program_choice').html(data);
            }   
        }); 
    });
	  var count = 0;
	
		  var dataTable= $('#graduatetable').DataTable( {
				"ajax": "{{route('alumniGraduate_dtb')}}", //view
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
					{ "data": "school_code" ,
                "visible": false,},
					{ "data": "acad_prog_code" ,
                "visible": false,},
					{ "data": "semester" ,
                "visible": false,},
					{ "data": "school_year" ,
                "visible": false,},
					{ "data": "id_number" },
					{ "data": null , 
					 "render" : function ( data, type, full ) { 
						 if(full['middle_name'] != null)
						return full['first_name']+' '+full['middle_name']+'. '+full['last_name'];
						 else
						return full['first_name']+' '+full['last_name'];
                        
					 }
                    },
					{ "data": "remarks" },
					{ "data": "actions" },
				],
				initComplete: function () {
	
				var $buttons = $('.dt-buttons').hide();
				$('.dataTables_length').show();
				 $('#exportLink').on('click', function() {
					$('.buttons-excel').click(); 
				 })
	
				  this.api().columns([0,1,2,3]).every( function () {
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
	
	
			$('#from, #to').change(function () {
					dataTable.draw();
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