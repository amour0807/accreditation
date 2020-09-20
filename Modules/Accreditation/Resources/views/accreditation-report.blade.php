@extends('accreditation::layouts.master')

@section('content')
<h2 class="mb-4">Accreditation Reports</h2>

<form method="post" class="mb-4">
@csrf 
	<strong>Sort by:</strong>
	<div class="form-group row">
		<div class="col-md-3 ">
			<label>School</label>
			<select class="form-control">
				<option>asdasd</option>
			</select>
		</div>
		<div class="col-md-3 ">
			<label>Accreditation Level</label>
			<select class="form-control">
				<option>asdasd</option>
			</select>
		</div>
		<div class="col-md-3 ">
			<label>Accreditation Status</label>
			<select class="form-control">
				<option>asdasd</option>
			</select>
		</div>
		<div class="col-md-3 ">
			<label>School</label>
			<select class="form-control">
				<option>asdasd</option>
			</select>
		</div>
	</div>


	<div class="form-group row">
		
				
				<label class="col-3">Range of Visitation: </label>
				<div class="col-3">
					<input type="date" name="" class="form-control">
				</div>
				<div class="col-3 ">
					<input type="date" name="" class="form-control">
				</div>


			
		
	</div>

	<div class="form-group row">
				<label class="col-3">Range of Validity: </label>
				<div class="col-3">
					<input type="date" name="" class="form-control">
				</div>
				<div class="col-3 ">
					<input type="date" name="" class="form-control">
				</div>
	</div>



	<div class="form-group row">
		<div class="col-md-12">
			<button class="btn bg-ub-grey float-right btn-sm ">Apply filters</button>
		</div>
	</div>
</form>
	


<div class="mr-3">
    	<table id="program_report_table" class="display compact table-bordered" style="width:100%">
		    <thead class="thead">
	            <tr>
	            	<th>School</th>
	            	<th>Program</th>
	            	<th>Accreditation Status</th>
	            	<th>Visit Date</th>
	            	<th>Validity</th>

	            	<th>Remarks</th>

	            </tr>
		    </thead>   
		</table>
    </div>




	<script type="text/javascript">

    $.ajaxSetup({
	    headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
    });
    
    var token = $("input[name='_token']").val();

   var count = 0;


   // program table

        var dataTable= $('#program_report_table').DataTable( {
	        "ajax": "{{route('program_report_dtb')}}",
	        "columns": [
	            { "data": "school" },
	            { "data": "program" },

	            { "data": "accred_stat" },
	            { "data": "visit_date" },
	            { "data": "validity" },
	            
	            { "data": "remarks" },
	        ],

	      
        });

    </script>
@endsection