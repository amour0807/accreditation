@extends('layouts.app')
@section('content')
@section('additional')
<style type="text/css">
	/* Shadow */
	table tr td {
	overflow-x: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;

	}
	table tr th {
		width: 9%;
	}
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
@endsection
@section('breadcrumb')
<li class="breadcrumb-item">
    <a class= 'link-blue' href="{{ url('home') }}">Dashboard</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Users</li>
<li class="nav-item dropdown ml-auto">
    <a class="nav-link" href="#" id="notificationDropdown" data-toggle="dropdown" aria-expanded="false"></a>  
</li>
@endsection
    <hr style="margin: 0 0 0 0;">
    <div class="block full"  style="margin-bottom: 10px;" >
    <div class="block-title" style="padding: 1px 3px 1px 3px;">
       <h2><strong>{{$school->school_name}} <br>
				Accredited Programs<span></strong></h2>
	<a class="btn btn-info float-right " href="{{route('userAdd_accred_form')}}">
   		Add an accreditation
   	</a>
    </div>
  <div class="alert"></div>

     @if (session('error'))
                        <div class="alert alert-dismissible alert-danger">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('error') }}
                        </div>
                    @endif
                        @if (session('success'))
                            <div class="alert alert-dismissible alert-success">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{ session('success') }}
                            </div>
                        @endif
@if(Session::has('message'))
<div class="alert alert-dismissible alert-danger">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <div>The program 
	@foreach($expiring as $exp)
		<strong>{{$exp->acad_prog}}'s</strong> from the <strong>{{$exp->school_name}}'s</strong><br> 
	@endforeach
	accreditation will expire in less than a year</div>
		  
		</div>
@endif
 <!-- Table showing PROGRAM details -->
    <table id="program_table"  class="table table-striped" style="width:100%">
		    <thead class="thead">
	            <tr>
	            	<th>Program</th>
	            	<th>Accreditation Status</th>
	            	<th>Visit Date</th>


	            	<th>Valid From</th>

	            	<th>PACUCUA Certificate</th>
	            	<th>FAAP Certificate</th>
	            	<th>PACUCUA Report</th>


	            	<th>Actions</th>

	            </tr>
		    </thead>   
		</table>
    
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
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-info">Add School</button>
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

$('.alertOld').hide();
   


   // school table

         var dataTable= $('#program_table').DataTable( {
        	"scrollX": true,
	        "ajax": "{{route('userProgram_dtb', $school->id)}}",
	        responsive: true,

	        "columns": [
	            { "data": "program" },
	            { "data": "accred_stat" },
	            { "data": "visit_date" },


	            { "data": "from" },

	            { "data": "cert1" },
	            { "data": "cert2" },
	            { "data": "cert3" },

	            { "data": "actions" },

	        ],
	        "columnDefs": [
			    { "width": '50pt', "targets": 7 }
			  ]
        	});

    //Adding
    $( "#addSchoolForm" ).submit(function( event ) {
        event.preventDefault();

        $.ajax({
          url:"{{route('userAddSchoolForm')}}",
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
