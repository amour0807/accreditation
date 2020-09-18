@extends('accreditation::layouts.master')

@section('content')


	<h4 class="mb-5">{{$school->school_name}}</h4>


    	<table id="program_table"  class="display compact table-bordered" style="width:100%">
		    <thead class="thead">
	            <tr>
	            	<th>Program</th>
	            	<th>Accreditation Status</th>
	            	<th>Visit Date</th>
	            	<th>Valid From</th>
	            	<th>Valid To</th>

	            	<th>PACUCUA Certificate</th>
	            	<th>FAAP Certificate</th>
	            	<th>PACUCUA Report</th>


	            	<th>Actions</th>

	            </tr>
		    </thead>   
		</table>



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
	        responsive: true,

	        "columns": [
	            { "data": "program" },
	            { "data": "accred_stat" },
	            { "data": "visit_date" },
	            { "data": "from" },
	            { "data": "to" },
	            { "data": "cert1" },
	            { "data": "cert2" },
	            { "data": "cert3" },

	            { "data": "actions" },

	        ],
	        "columnDefs": [
			    { "width": '50pt', "targets": 8 }
			  ]
        	});

    </script>
@endsection