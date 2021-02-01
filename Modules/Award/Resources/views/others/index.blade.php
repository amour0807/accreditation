@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
  <h2>Student's Award</h2>
  @if(Auth::user()->hasPermission('create-student'))
  <a class="btn btn-app float-right" data-toggle="modal"  data-target="#addStudentAwardModal">
    <i class="fa fa-plus-square-o"></i> Add Award
  </a>
    @endif
  <div class="clearfix"></div>
</div> <form class="mb-4" action="{{route('userawardfilterReport')}}" target='_blank' method="POST">
	@csrf 

 <div class="row">
      <div class="col-md-6">
         <strong>Sort by:</strong>
      </div>
      <div class="col-md-6">
        <strong>Range of Award:</strong>
      </div>
    </div>
   <div class="form-group row">
     <div class="row col">
    <div class="col-md-6 ">
      <label>Scope</label>
      <div id="filters1">
        
      </div>
    </div>

    <div class="col-md-6 ">
      <label>Categoty</label>
      <div id="filters2">
        
      </div>
    </div>
     </div>
  <div class="row col">
		<div class="col-6 col-md-6">
			<label>From </label>
			<select  class="form-control" name="min" id="min">
				<option>All</option>
			</select>
		</div>
		<div class="col-6 col-md-6">
		<label>To</label>
		<select  class="form-control" name="max" id="max">
				<option>All</option>
			</select>
	</div>
  </div>
  </div>
      
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
      <button type="submit" class="btn btn-outline-danger btn-sm edit " target="_blank" title="view pdf" id="addBtn"><i class="fa fa-file-pdf-o"></i></button>
  </div><br><br>
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
		<table id="awardtable"  class="table table-striped jambo_table bulk_action" style="width: 100%;">
			 <thead>
			   <tr class="headings">
				   
	            	<th>Name</th>
	            	<th>Program</th>
	            	<th>Scope</th>
	            	<th>Category</th>
	            	<th>Award</th>
	            	<th>Classification</th>
	            	<th>Competition</th>
	            	<th>Award <br>Giving Body</th>
	            	<th>Date Awarded</th>
	            	<th>Venue</th>

	            	<th>Actions</th>
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
	        <h5 class="modal-title" id="exampleModalLabel">Add Student Award</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>

	       <form id="form" action="{{ route('addStudentAward') }}" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered" style="padding: 0px 8px 0px 16px;">
											{{ csrf_field() }}
			
			<span class="text-danger">* Required Fields</span><br>
          	  <div class="modal-body">
		      	 <div class="form-group">
		    	<div class="row form-group">

		        <div class="col-md-4">
		        	<label><span class="text-danger">*</span>First Name</label>
		        	<input type="text" class="form-control" name="first_name" placeholder="" required>
		        </div>
		        <div class="col-md-4">
		        	<label><span class="text-danger"></span>Middle Initial</label>
		        	<input type="text" class="form-control" maxlength="1" name="middle_i" placeholder="">
		        </div>
		         <div class="col-md-4">
		        	<label><span class="text-danger">*</span>Last Name</label>
		        	<input type="text" class="form-control" name="last_name" placeholder="" required>
		        </div>
		    </div>
		    	<div class="form-group">
		        	<label><span class="text-danger">*</span>@if(!Auth::user()->hasRole('admin')){{$school->school_code}}@endif Program:</label>

					<select class="form-control small" name="acad_prgram_id" required>
						 <option disabled selected value> -- --  </option>
						@foreach($acad_prog as $aw)
					 	 <option value = '{{ $aw->a_id }}'> {{ $aw->acad_prog }}  </option>
					 @endforeach
					</select>
		        </div>
		        
		        <div class="row form-group">
		        	<div class= "col-md-4"> 
		        <label><span class="text-danger">*</span>Scope:</label>

					<select name="scope" class="form-control small" required>
					  <option disabled selected value> -- --  </option>
					  <option value="School">School</option>
					  <option value="Institutional">Institutional</option>
					  <option value="Local">Local</option>
					  <option value="National">National</option>
					  <option value="International">International</option>
					</select>
					</div>
					<div class="col-md-4 form-group">
						<label><span class="text-danger">*</span>Category:</label>

					<select name="category" class="form-control small" required>
						<option disabled selected value> -- -- </option>
					  <option value="Academics">Academics</option>
					  <option value="Non-Academics">Non-Academic</option>
					</select>
					
				</div>

				<div class="col-md-4 form-group">
					<label><span class="text-danger">*</span>Participant's Classification:</label>

					<select name="classification" class="form-control small" required>
					  <option disabled selected value> -- --  </option>
					  <option value="Individual">Individual</option>
					  <option value="Group">Group</option>
					</select>
					
		        	
				</div>
                </div>

				<div class="row form-group">
					<div class="col-md-4">
		        	<label><span class="text-danger">*</span>Title of Competition</label>
		        	<input type="text" class="form-control" name="title_competitions" placeholder="" required>
					</div>
					<div class="col-md-4">
		        	<label><span class="text-danger">*</span>Award / Recognition /Achivement:</label>

					<select class="form-control small" name="award" onchange='CheckAward(this.value);' required>
					  <option disabled selected value> -- --  </option>
					  <option value="First Place">First Place</option>
					  <option value="Second Place">Second Place</option>
					  <option value="First Place">Third Place</option>
					  <option value="Second Place">Fourth Place</option>
					  <option value="Champion">Champion</option>
					  <option value="1st Runner Up">1st Runner Up</option>
					  <option value="2nd Runner Up">2nd Runner Up</option>
					  <option value="3rd Runner Up">3rd Runner Up</option>
					  <option value="Gold">Gold</option>
					  <option value="Silver">Silver</option>
					  <option value="Bronze">Bronze</option>
					  <option value="Finalist">Finalist</option>
					  <option value="others2">Others</option>
					</select>
		        	
		        	<input type="text" class="form-control" id="others2" name="others2"  style='display:none;'/>
		        	</div>
		        	<div class="col-md-4">
		        	<label><span class="text-danger">*</span>Award Giving Body</label>
		        	<input type="text" class="form-control" name="award_giving_body" placeholder="" required>
		        </div>	
		        </div>
		        <div class="row form-group">
		        <div class="col-md-4 form-group">
		           <label><span class="text-danger">*</span>Venue</label>
		           <input type="text" class="form-control" name="venue" placeholder="" required>
		        </div>
		        <div class="col-md-4 form-group">
		        	<label><span class="text-danger">*</span>Date Awarded</label>
		        	<input type="date" class="form-control small" name="date" placeholder="" required>
		        </div>
		        <div class="col-md-4 form-group">
		        	<i class="fa fa-upload">Certificate</i>
		        	<input type="file" name="award_cert" class="form-control">
		        </div>
		      </div>
		      
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-info">Add Award</button>
	      	  </div>
	      	</div>
            </div>
             </form>
	    </div>
	  </div>
	</div>

<!-- Add Another Modal -->
<div class="modal fade " data-backdrop="static" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
      </div>
      <div class="modal-body">
        Record saved. Add another record?
      </div>
      <div class="modal-footer">
        <a class="btn btn-danger" href="{{route('userStudentAward')}}">Proceed to Dashboard</a>
        <button type="button" class="btn btn-info"   data-toggle="modal" 
			data-target="#addStudentAwardModal" data-dismiss="modal">Add Another Record</button>
      </div>
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
		  
	$('#min').each(function() {

		var year = (new Date()).getFullYear();
		year -= 30;
		for (var i = 30; i > 0; i--) {

			$(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
		}
	})
	$('#max').each(function() {

		var year = (new Date()).getFullYear();
		year += 4;
		year -= 30;
		for (var i = 30; i > 0; i--) {

			$(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
		}
	})
		   $.fn.dataTable.ext.search.push(
		function( settings, data, dataIndex ) { 
			var from = $('#min').val()
			    to = $('#max').val()
			    dates = data[8].split(' '); 
			if ( ( isNaN( from ) && isNaN( to ) ) ||
				 ( isNaN( from ) && dates[2] <= to ) ||
				 ( from <= dates[2]   && isNaN( to ) ) ||
				 ( from <= dates[2]   && dates[2] <= to ) )
			{
				return true;
			}else{
			  return false;
			}
			
		}
	);
		  var dataTable= $('#awardtable').DataTable( {
				"ajax": "{{route('userAward_dtb')}}", //view
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
                title: 'Student Awards'
            },
            ],
	
				"columns": [
					{ "data": null , 
					 "render" : function ( data, type, full ) { 
						 if(full['middle_initial'] != "")
						return full['first_name']+' '+full['middle_initial']+'. '+full['last_name'];
						else
						return full['first_name']+' '+full['last_name'];
						}
					  },
					{ "data": "acad_prog_code" ,
					"visible": false,},
					{ "data": "scope" ,
					"visible": false,},
					{ "data": "category",
					"visible": false, },
					{ "data": "award"},
					{ "data": "classification" ,
					"visible": false,},
					{ "data": "title_competitions" },
					{ "data": "award_giving_body" },
					{ "data": "date_awarded" },
					{ "data": "venue" ,
					"visible": false,},
					{ "data": "actions" },
	
				],
				initComplete: function () {
	
				var $buttons = $('.dt-buttons').hide();
				$('.dataTables_length').show();
				 $('#exportLink').on('click', function() {
					$('.buttons-excel').click(); 
				 })
	
				  this.api().columns([2,3]).every( function () {
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
	
	
			$('#min, #max').change(function () {
					dataTable.draw();
						});
			
		//delete
$(document).on('click','.destroy',function(){
	var id = $(this).attr('awardid');
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
			  url:"{{route('deleteAward')}}",
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