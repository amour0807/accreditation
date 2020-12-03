@extends('layouts.app')
@section('content')
		  <hr style="margin: 0 0 0 0;">
          <div class="block full"  style="margin-bottom: 10px;" >
         <div class="block-title" style="padding: 1px 3px 1px 3px;">
         <h2><strong>Accredited Programs</strong></h2>
          	<a class="btn btn-info float-right "  href="{{route('add_accred_form')}}">
    Add Accreditation 
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
   <table id="school_table" class="display compact cell-border" style="width:100%">
        <thead>
              <tr>
                <th>School</th>
                <th>Program</th>
                <th>Accreditation<br> Status</th>
                <th>Visit Date</th>


                <th>Valid From</th>

                <th>PACUCUA<br> Certificate</th>
                <th>FAAP<br> Certificate</th>
                <th>Chaiman's<br> Report</th>


                <th>Actions</th>

              </tr>
        </thead>  
        <tbody>
      </tbody> 
    </table>
       
<script type="text/javascript">

    $.ajaxSetup({
	    headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
    });
    
    var token = $("input[name='_token']").val();

$('.alertOld').hide();
   // school table

        var dataTable= $('#school_table').DataTable( {
        	"scrollX": true,
        	responsive: true,
	        "ajax": "{{route('school_dtb')}}",
	        "columns": [
	        	{ "data": "school_code"},
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
