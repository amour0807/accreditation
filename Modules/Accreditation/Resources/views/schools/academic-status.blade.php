@extends('layouts.app')
@section('content')
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
       <h2><strong>{{$accredStatus->accred_status}}<span></strong></h2>
         <a class="btn btn-info float-right " data-toggle="modal" data-target="#add_status">
         Add an accreditation status
        </a>
    </div>
  <div class="alert"></div>
  @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
    </div>
  @endif
  @if ($message = Session::get('error'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
    </div>
  @endif
    <br>
    
<table id="program_table"  class="table table-striped" style="width:100%">
		    <thead >
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
		
	<script type="text/javascript">

    $.ajaxSetup({
	    headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
    });
    
    var token = $("input[name='_token']").val();

   


   // program table

        var dataTable= $('#program_table').DataTable( {
	        "ajax": "{{route('userProgram_dtb', $school->id)}}",
	        responsive: true,
        	"scrollX": true,
	        

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

    </script>
@endsection