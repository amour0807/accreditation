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
  <h2>Scholarships & Grants</h2>
  @if(Auth::user()->hasPermission('create-scholar'))
  <a class="btn btn-app float-right" data-toggle="modal"  data-target="#addStudentAwardModal">
    <i class="fa fa-plus-square-o"></i> Add Record
  </a>
    @endif
  <div class="clearfix"></div>
</div> <form class="mb-4" action="{{route('scholarfilterReport')}}" target="_blank" method="POST">
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

 <div class="row">
      <div class="col-md-12">
         <strong>Sort by:</strong>
      </div>
    </div>
   <div class="form-group row">
     <div class="row col">
    <div class="col-md-4 ">
      <label>Scholarship / Grant</label>
      <div id="filters1">
        
      </div>
    </div>
	
	<div class="col-md-4 col-sm-6">
		<label>School Year: From </label>
		<select  class="form-control" name="from" id="from">
		   <option>All</option>
		 </select>
  </div>
  <div class="col-md-4 col-sm-6">
   <label>To</label>
   <select  class="form-control" name="to" id="to">
		   <option>All</option>
		 </select>
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
	            	<th>School / Department</th>
					<th>School Year</th>
					<th>#</th>
					<th>PhP</th>
					<th>#</th>
					<th>PhP</th>
					<th>#</th>
					<th>PhP</th>
	            	<th>Total Number</th>
	            	<th>Total Amount</th>
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
	        <h5 class="modal-title" id="exampleModalLabel">Add Scholarship / Grants Record</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>

	       <form id="form" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered" style="padding: 0px 8px 0px 16px;">
                                            {{ csrf_field() }}
			<label><span class="text-danger">* Required Fields</span></label>
          	  <div class="modal-body">
		      	 <div class="form-group">
		    	
				<div class="row form-group">
					
				<div class= "col-md-6"> 
                        <label><span class="text-danger">*</span> Scholarships / Grants:</label>
            
                    <select class="form-control small" name="scholarshipID" required>
                       <option disabled selected value> -- --  </option>
                      @foreach($list as $sc)
                        <option value = '{{ $sc->id }}'> {{ $sc->scholar_title}}  </option>
                     @endforeach
					</select>

				</div>
				<div class="col-md-6 form-group">
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
			<div class="row form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-3" style="text-align:right;">First Semester:</label>
		        	<div class= "col-md-4"> 
		        <label><span class="text-danger">*</span>Total:</label>
					<input type="number" min="0"name="fno" class="form-control" required>
					</div>
					<div class="col-md-4 form-group">
						<label><span class="text-danger">*</span>Amount:</label>
						<input type="number" min="0" name="fphp" step=".01"class="form-control" required>
				</div>
			</div>
			<div class="row form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-3" style="text-align:right;">Second Semester:</label>
				<div class= "col-md-4"> 
					<label><span class="text-danger">*</span>Total:</label>
					<input type="number" min="0" name="sno" class="form-control" required>
				</div>
				<div class="col-md-4 form-group">
					<label><span class="text-danger">*</span>Amount:</label>
						<input type="number" min="0" step=".01" name="sphp" class="form-control" required>
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-3" style="text-align:right;">Short Term:</label>
			
			<div class= "col-md-4"> 
				<label><span class="text-danger">*</span>Total:</label>
				<input type="number" min="0" name="stno" class="form-control" required>
			</div>
			<div class="col-md-4 form-group">
				<label><span class="text-danger">*</span>Amount:</label>
						<input type="number" min="0" step=".01" name="stphp" class="form-control" required>
		</div>
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
	 if(val=='External')
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
                    url: "{{route('addScholar')}}",
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
			dfrom = data[1].split(' ');

        if ( ( isNaN( min ) && isNaN( max ) ) ||
             ( isNaN( min ) && dfrom[2] <= max ) ||
             ( min <= dfrom[2] && isNaN( max ) ) ||
             ( min <= dfrom[2] && dfrom[2] <= max ) )
        {
            return true;
        }else{
        	return false;
        }
    }
);		
			var count = 0;
		  var dataTable= $('#employeetable').DataTable( {
				"ajax": "{{route('scholar_dtb')}}", //view
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
					{ "data": "scholar_title" },
					{ "data": "school_year" },
					{ "data": "fno" ,
					"visible": false,},
					{ "data": "fphp" ,
					"visible": false,},
					{ "data": "sno" ,
					"visible": false,},
					{ "data": "sphp" ,
					"visible": false,},
					{ "data": "stno" ,
					"visible": false,},
					{ "data": "stphp" ,
					"visible": false,},
					{ "data": "totalno"},
					{ "data": "totalphp"},
					{ "data": "actions" },
				],
				initComplete: function () {
	
				var $buttons = $('.dt-buttons').hide();
				$('.dataTables_length').show();
				 $('#exportLink').on('click', function() {
					$('.buttons-excel').click(); 
				 })
	
				  this.api().columns([0,1]).every( function () {
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
			  url:"{{route('deleteScholar')}}",
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