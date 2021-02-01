@extends('layouts.app')
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
  <h2><small>Number of University Employees </small></h2>
  @if(Auth::user()->hasPermission('create-employees'))
  <a class="btn btn-app float-right" data-toggle="modal"  data-target="#addStudentAwardModal">
    <i class="fa fa-plus-square-o"></i> Add Record
  </a>
    @endif
  <div class="clearfix"></div>
</div> <form class="mb-4" action="{{route('employeefilterReport')}}" target="_blank" method="POST">
	@csrf 
    <div class="row">
    	<div class="col-md-8">
    	</div>
     <div class="col-md-4">
     	<div class="float-right">
       <div class="actionPart" >
        <div class="actionSelect">
        </div>
    </div>
    <a id="exportLink" class="btn btn-outline-success btn-sm edit " target="_blank" title="view excel" ><i class="fa fa-file-excel-o"></i></a>
      <button type="submit" class="btn btn-outline-danger btn-sm edit " title="view pdf" id="addBtn"><i class="fa fa-file-pdf-o"></i></button>
  </div><br><br>
      </div>
    </div>

<div class="form-group row">
<div class="col-md-7 col-sm-12">
    <div class="col-md-6 ">
      <label>School / Department</label>
      <div id="filters1">
        
      </div>
    </div>

    <div class="col-md-6 ">
      <label>Semester</label>
      <div id="filters2">
        
      </div>
	</div>
</div>
<div class="col-md-4 col-sm-12">
	<div class="col-md-6 col-sm-6">
		<label>school Year: From </label>
		<select  class="form-control" name="from" id="from">
		   <option>All</option>
		 </select>
  </div>
  <div class="col-md-6 col-sm-6">
   <label>To</label>
   <select  class="form-control" name="to" id="to">
		   <option>All</option>
		 </select>
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
		<table id="employeetable" class="table table-striped jambo_table bulk_action" style="width: 100%;">
		  <thead>
		  <tr class="headings">
	            	<th colspan="3"></th>
	            	<th colspan="4">Teaching</th>
	            	<th colspan="2">Non-Teaching</th>
					<th></th>
	            </tr>
		  <tr class="headings">
	            	<th>School / Department</th>
	            	<th>Semester</th>
	            	<th>School Year</th>
					<th>Permanent</th>
	            	<th>Probationary</th>
	            	<th>Contractual</th>
	            	<th>Partime</th>
					<th>Permanent</th>
	            	<th>Probationary</th>
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
	        <h5 class="modal-title" id="exampleModalLabel">Add Employee Record</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>

	       <form id="form" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered" style="padding: 0px 8px 0px 16px;">
											{{ csrf_field() }}
			
											<span class="text-danger">* Required Fields</span><br>
          	  <div class="modal-body">
		      	 <div class="form-group">
		    	
				<div class="row form-group">
					
				<div class= "col-md-6"> 
                        <label><span class="text-danger">*</span>@if(!Auth::user()->hasRole('admin')){{$school->school_code}}@endif Schools:</label>
            
                    <select class="form-control small" name="department" required>
                       <option disabled selected value> -- --  </option>
                      @foreach($list as $sc)
                        <option value = '{{ $sc->school_code }}'> {{ $sc->school_name }}  </option>
                     @endforeach
                    </select>
                      </div>
					<div class= "col-md-3"> 
					<label><span class="text-danger">*</span>Semester:</label>
					<select class="form-control small" name="sem" required>
                       <option disabled selected value> -- --  </option>
                      
                        <option value = '1st Semester'> First Sem  </option>
                        <option value = '2nd Semester'> Second Sem  </option>
                    </select>
						</div>
						<div class="col-md-3 form-group">
							<label><span class="text-danger">*</span>School Year:</label>
							<select name="school_year" class="form-control">
							<option disabled selected value> -- --  </option>
								<?php $now = now()->year; ?>
								@for($year = $now; $year >= 2015 ; $year--)
								<option value='{{$year}} - {{$year+1}}'>{{$year}} - {{$year+1}}</option>
								@endfor
							</select>
					</div>
				</div>
				
				<label>Teaching:</label>
		        <div class="row form-group">
		        	<div class= "col-md-3"> 
		        <label><span class="text-danger">*</span>Permanent:</label>
					<input type="number" min="0" max="100" name="tpermanent" class="form-control" required>
					</div>
					<div class="col-md-3 form-group">
						<label><span class="text-danger">*</span>Probationary:</label>
						<input type="number" min="0" max="100" value="0" name="tprobationary" class="form-control" required>
				</div>

				<div class="col-md-3 form-group">
					<label><span class="text-danger">*</span>Contractual</label>

					<input type="number" min="0" max="100" value="0" name="tcontractual" class="form-control" required>
				</div>
				<div class="col-md-3 form-group">
						<label><span class="text-danger">*</span>Part Time:</label>
						<input type="number" min="0" max="100" value="0" name="tpartime" class="form-control" required>
				</div>
				</div>
				<label>Non Teaching:</label>
				<div class="row form-group">
					
				<div class="col-md-3 form-group">
						<label><span class="text-danger">*</span>Permanent:</label>
						<input type="number" min="0" max="100" value="0" name="ntpermanent" class="form-control" required>
				</div>
				<div class="col-md-3 form-group">
						<label><span class="text-danger">*</span>Probationary:</label>
						<input type="number" min="0" max="100" value="0" name="ntprobationary" class="form-control" required>
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
  text: "Add another record?",
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
  @endif
<script type="text/javascript">

	function CheckAward(val){
	 var element=document.getElementById('others2');
	 if(val=='others2')
	   element.style.display='block';
	 else
	   element.style.display='none';
	}
	
		$.ajaxSetup({
			headers: {
			   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		
		var token = $("input[name='_token']").val();
		 
	  var count = 0;
	  $('#from').each(function() {
		var year = (new Date()).getFullYear();
		year -= 30;
		for (var i = 30; i > 0; i--) {
		
			$(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
		}

		})
	$('#to').each(function() {

		var year = (new Date()).getFullYear();
		year -= 30;
		for (var i = 30; i > 0; i--) {
		
			$(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
		}

		})
	  $( "#form" ).submit(function( event ) {
        event.preventDefault();
        $.ajax({
                    type: 'POST',
                    url: "{{route('addEmployee')}}",
                    data:$("#form").serialize(),
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {
                            $("#form")[0].reset();
                            $('#addStudentAwardModal').modal('hide');
                            dataTable.ajax.reload();
                            swal.fire("Done!", results.message, "success");
                          
                        } else {
                            swal.fire("Error!", results.message, "error");
                        }
                    }
                });
    }); 
	$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = $('#from').val()
			max = $('#to').val()
			from = data[2].split(' ');
        if ( ( isNaN( min ) && isNaN( max ) ) ||
             ( isNaN( min ) && from[2] <= max ) ||
             ( min <= from[2] && isNaN( max ) ) ||
             ( min <= from[2] && from[2] <= max ) )
        {
            return true;
        }else{
        	return false;
        }
        
    }
);
		  var dataTable= $('#employeetable').DataTable( {
				"ajax": "{{route('employee_dtb')}}", //view
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
                title: 'Employee'
            },
            ],
				"columns": [
					{ "data": "department" },
					{ "data": "semester" },
					{ "data": "school_year" },
					{ "data": "no_Tpermanent" },
					{ "data": "no_Tprobationary" },
					{ "data": "no_Tcontractual" },
					{ "data": "no_Tpartime" },
					{ "data": "no_NTpermanent" },
					{ "data": "no_NTprobationary" },
					{ "data": "actions" },
				],
				initComplete: function () {
	
				var $buttons = $('.dt-buttons').hide();
				$('.dataTables_length').show();
				 $('#exportLink').on('click', function() {
					$('.buttons-excel').click(); 
				 })
	
				  this.api().columns([0,1,2]).every( function () {
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
	var id = $(this).attr('empid');
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
			  url:"{{route('deleteEmployee')}}",
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