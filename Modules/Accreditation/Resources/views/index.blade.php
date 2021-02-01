@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
  <h2>Accredited Programs</h2>
  @if(Auth::user()->hasRole('admin') || Auth::user()->hasPermission('create-accred'))
  <a class="btn btn-app float-right" href="{{route('add_accred_form')}}">
    <i class="fa fa-plus-square-o"></i> Add Accreditation 
  </a>
    @endif
  <div class="clearfix"></div>
</div>
	  <div class="x_content">
		  <div class="row">
			  <div class="col-sm-12">
  <div class="table-responsive">
   <table id="school_table"  class="table table-striped jambo_table bulk_action" style="width: 100%;">
        <thead>
          <tr class="headings">
                <th>School</th>
                <th style="width: 15%">Program</th>
                <th style="width: 25%">Accreditation Status</th>
                <th >Visit Date</th>
                <th style="width: 20%">Valid From</th>
                <th >FAAP <small>Certificate</small></th>
                <th>PACUCOA <small>Certificate</small></th>
                <th>Chaiman's Report</th>
                <th style="width: 13%">Actions</th>
              </tr>
        </thead> 
        <tbody>
        </tbody>
      </table> 
            </div>
  </div>
</div>
</div>
</div>
</div>
@endsection
@section('scripts')
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
          "ordering": false,
	        "ajax": "{{route('school_dtb')}}",
	        "columns": [
	        	  { "data": "school_code",
              "visible": false,},
				      { "data": "program" },
	            { "data": "accred_stat" },
	            { "data": "visit_date", 
              "visible": false,},
	            { "data": "from"},
	            { "data": "cert1" },
	            { "data": "cert2" },
	            { "data": "cert3" },
	            { "data": "actions" },
	        ],
	        "columnDefs": [
			    { "height": '10pt' }
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
