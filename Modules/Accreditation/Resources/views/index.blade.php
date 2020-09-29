@extends('accreditation::layouts.master')

@section('content')
<style type="text/css">
	/* Shadow */
	.hvr-shadow {

	  -webkit-transform: perspective(1px) translateZ(0);
	  transform: perspective(1px) translateZ(0);
	  box-shadow: 0 0 1px rgba(0, 0, 0, 0);
	  -webkit-transition-duration: 0.3s;
	  transition-duration: 0.3s;
	  -webkit-transition-property: box-shadow;
	  transition-property: box-shadow;

	}
	.hvr-shadow:hover, .hvr-shadow:focus, .hvr-shadow:active {
	  box-shadow: 0 12px 10px -10px rgba(0, 0, 0, 0.5);
	}
	.stretcged-link, a:hover{
		  color: white;
	}
}
</style>

    <h2 class="float-left">Accredited Programs</h2>
   	<a class="btn bg-ub-red float-right " href="{{route('add_accred_form')}}">
   		<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
		  <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
		</svg>
   		Add an accreditation
   	</a>
	
	<br>

    <div class="row text-center mt-4 py-3" >
    	
    	<div class="col-md-2 ">
    		<div class="card hvr-shadow">
			    <h1 class="card-title">{{$count4}}</h1>
			    <a href="#" class="bg-ub-grey stretched-link ">Level IV</a>
			</div>
    	</div>
    	<div class="col-md-2 ">
    		<div class="card hvr-shadow">

			    <h1 class="card-title">{{$count3}}</h1>
			    <a href="#" class="bg-ub-grey stretched-link">Level III</a>

			</div>
    	</div>
    	<div class="col-md-2 ">
    		<div class="card hvr-shadow">

			    <h1 class="card-title">{{$count2}}</h1>
			    <a href="#" class="bg-ub-grey stretched-link">Level II</a>

			</div>
    	</div>
    	<div class="col-md-2">
    		<div class="card hvr-shadow">

			    <h1 class="card-title">{{$count1}}</h1>
			    <a href="#" class="bg-ub-grey stretched-link">Level I</a>

			</div>
    	</div>

    	<div class="col-md-2 ">
    		<div class="card hvr-shadow">

			    <h1 class="card-title">{{$count6}}</h1>
			    <a href="#" class="bg-ub-grey stretched-link">Candidate Status</a>

			</div>
    	</div>

    	<div class="col-md-2  ">
    		<div class="card hvr-shadow">

			    <h1 class="card-title">{{$count5}}</h1>
			    <a href="#" class="bg-ub-grey stretched-link">Orientation</a>

			</div>
    	</div>
 
    </div>
    <br>
<hr>
    <div class="mt-3 mb-3" >
    	<h2 class="float-left ">Schools</h2>
	   	<!-- <a class="btn btn-success  float-right mr-4" href="#" data-toggle="modal" data-target="#addSchoolModal">
	   		<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
			  <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
			</svg>
	   		Add School
	   	</a> -->		
    </div>
    <br>
    
    <!-- Table showing school details -->
    <div class=" pt-5">
    	<table id="school_table" class="display compact table-bordered" style="width:100%">
		    <thead class="thead">
	            <tr>
	            	<th>School code</th>
	            	<th>Accredited Programs</th>
	            	<th>Level IV</th>
	            	<th>Level III</th>
	            	<th>Level II</th>
	            	<th>Level I</th>
	            	<th>Candidate Status</th>
	            	<th>Orientation</th>
	            	<th>Actions</th>
	            </tr>
		    </thead>   
		</table>
    </div>
    
	<!-- end table -->




<!-- Modal for adding schools -->

	

	<!-- Modal -->
	<div class="modal fade" id="addSchoolModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Add a School</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form id="addSchoolForm" method="POST">
         	@csrf
		      <div class="modal-body">
		        <div class="form-group">
		        	<label>School Name</label>
		        	<input type="text" class="form-control" name="school_name" placeholder="ex: School of Information Technology" required>
		        </div>
		        <div class="form-group">
		        	<label>School Code</label>
		        	<input type="text" class="form-control" name="school_code" placeholder="ex: SIT" required>
		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Add School</button>
	      	  </div>
	      </form>
	    </div>
	  </div>
	</div>


	<script type="text/javascript">

    $.ajaxSetup({
	    headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
    });
    
    var token = $("input[name='_token']").val();

   


   // school table

        var dataTable= $('#school_table').DataTable( {
        	responsive: true,
	        "ajax": "{{route('school_dtb')}}",
	        "columns": [
	            { "data": "school" },
	            { "data": "accred_prgrms" },
	            { "data": "lvl4" },
	            { "data": "lvl3" },
	            { "data": "lvl2" },
	            { "data": "lvl1" },
	            { "data": "candidate_stat" },
	            { "data": "orientation" },
	            { "data": "actions" },

	        ],

        	});

    //Adding
    $( "#addSchoolForm" ).submit(function( event ) {
        event.preventDefault();

        $.ajax({
          url:"{{route('addSchoolForm')}}",
          method:"POST",
          data: $("#addSchoolForm").serialize(),
          success:function(data){
            $('#addSchoolModal').modal('hide');
            dataTable.ajax.reload();
           
          }
              
        }); 
    });   
    </script>
@endsection
