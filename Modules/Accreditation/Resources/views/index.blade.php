@extends('accreditation::layouts.master')

@section('content')
	
    <h2>Accredited Programs</h2>

    <div class="row text-center">
    	
    	<div class="col-md-3 p-2">
    		<div class="card">
			  <div class="card-body">
			    <h1 class="card-title">35</h1>
			    <a href="#" class="stretched-link">Lvl IV</a>
			  </div>
			</div>
    	</div>
    	<div class="col-md-3 p-2">
    		<div class="card">
			  <div class="card-body">
			    <h1 class="card-title">35</h1>
			    <a href="#" class="stretched-link">Lvl III</a>
			  </div>
			</div>
    	</div>
    	<div class="col-md-3 p-2">
    		<div class="card">
			  <div class="card-body">
			    <h1 class="card-title">35</h1>
			    <a href="#" class="stretched-link">Lvl II</a>
			  </div>
			</div>
    	</div>
    	<div class="col-md-3 p-2">
    		<div class="card">
			  <div class="card-body">
			    <h1 class="card-title">35</h1>
			    <a href="#" class="stretched-link">Lvl I</a>
			  </div>
			</div>
    	</div>
 
    </div>
    
    <h3 class="mt-3">Schools</h3>

    <!-- Table showing school details -->
    <table id="school_table" class="table table-bordered">
	    <thead class="thead">
            <tr>
            	<th>School code</th>
            	<th>Accredited Programs</th>
            	<th>Lvl IV</th>
            	<th>Lvl III</th>
            	<th>Lvl II</th>
            	<th>Lvl I</th>
            	<th>Orientation</th>
            	<th>Candidate Status</th>
            </tr>
	    </thead>   
	</table>
	<!-- end table -->

	<script type="text/javascript">

    $.ajaxSetup({
	    headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
    });
    
    var token = $("input[name='_token']").val();

   


   // school table

        var dataTable= $('#school_table').DataTable( {
	        "ajax": "{{route('school_dtb')}}",
	        "columns": [
	            { "data": "school" },
	            { "data": "accred_prgrms" },
	            { "data": "lvl4" },
	            { "data": "lvl3" },
	            { "data": "lvl2" },
	            { "data": "lvl1" },
	            { "data": "orientation" },
	            { "data": "candidate_stat" },
	        ],
        	});

    </script>
@endsection
