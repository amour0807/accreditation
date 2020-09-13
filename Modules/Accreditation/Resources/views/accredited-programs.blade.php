@extends('accreditation::layouts.master')

@section('content')
	<h4 class="my-3 mb-5">{{$school->school_name}}</h4>

	<div class="mr-3">
    	<table id="program_table" class="table table-bordered">
		    <thead class="thead">
	            <tr>
	            	<th>Program</th>
	            	<th>Accreditation Status</th>
	            	<th>Visit Date</th>
	            	<th>From</th>
	            	<th>To</th>

	            	<th>Remarks</th>
	            	<th>Actions</th>

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

   


   // program table

        var dataTable= $('#program_table').DataTable( {
	        "ajax": "{{route('program_dtb', $school->id)}}",
	        "columns": [
	            { "data": "program" },
	            { "data": "accred_stat" },
	            { "data": "visit_date" },
	            { "data": "from" },
	            { "data": "to" },
	            { "data": "remarks" },
	            { "data": "actions" },

	        ],
        	});

    </script>
@endsection