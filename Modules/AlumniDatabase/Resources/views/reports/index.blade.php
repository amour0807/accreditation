@extends('layouts.appAlumni')
@section('content')
@section('additional')
<style type="text/css">
	table tr td {
	overflow-x: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;

	}
	table tr th {
		width: 9%;
	}

</style>
@endsection
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
  <h2><small>Surveys </small></h2>
 
  <div class="clearfix"></div>
</div> <form class="mb-4" target="_blank" action="{{route('reportfilterReport')}}" method="POST">
	@csrf 

 <div class="row">
      <div class="col-md-12">
         <strong>Sort by:</strong>
      </div>
	</div>
   <div class="form-group row">
     <div class="row col">
@if(Auth::guard('alumni')->user()->user_role == 'admin')
    <div class="col-md-3 col-sm-5">
      <label>School / Department</label>
      <select class="form-control form-control-sm" id="schoolchange" name="school" required>
		<option selected value='ALL'>ALL</option>
		@foreach ($schools as $name => $id)
		  <option value="{{$id}}">{{ $name }}</option>
		@endforeach
	</select>
	</div>
	<div class="col-md-3 col-sm-5">
		<label>Program</label>
		<div id='program_choice'>
			<select class="form-control form-control-sm " disabled name="program" required> 
				<option value="ALL">ALL</option>
			</select>
		</div>
	  </div>
@else
<div class="col-md-3 col-sm-5">
	<label>Program</label>
	<div id='program_choice'>
		<select class="form-control form-control-sm " name="secprogram" required> 
			<option value="ALL">ALL</option>
			@foreach ($programs as $p)
			<option value="{{$p->id}}">{{ $p->acad_prog }}</option>
		  @endforeach
		</select>
	</div>
  </div>
@endif
<div class="col-md-2 col-sm-5">
	<label>Semester</label>
		<select class="form-control form-control-sm " name="sem" required> 
			<option disabled selected value> -- --  </option>
			<option value="1st Semester"> First Semester</option>
			<option value="2nd Semester"> Second Semester</option>
		</select>
  </div>
  <div class="col-md-2 col-sm-5">
	<label>School Year:</label>
		<select class="form-control form-control-sm " name="schoolyear" required> 
			<option disabled selected value> -- --  </option>
				<?php $now = now()->year; ?>
				@for($year = $now; $year >= 2019 ; $year--)
				<option value='{{$year}} - {{$year+1}}'>{{$year}} - {{$year+1}}</option>
				@endfor
		</select>
  </div>
	<div class="col-md-2 col-sm-3">
		<label></label><br>
    	<a id="exportLink" class="btn btn-outline-success btn-sm edit " target="_blank" title="view excel" ><i class="fa fa-file-excel-o"></i></a>
      <button type="submit" class="btn btn-outline-danger btn-sm edit " title="view pdf" id="addBtn"><i class="fa fa-file-pdf-o"></i></button>
      </div>
     </div>
  </div>
  <div class="row">
	<div class="col-md-12">
	   <strong>Questions:</strong><br>
	   <ul class="to_do">
	@foreach($question as $q)
		<li>
		  <p><input type="checkbox" value="{{$q->id}}" name="question[]">&nbsp;&nbsp;{{$q->question}}</p>
		</li>
	@endforeach
	   </ul>
	  
	</div>
  </div>
      
</form>
	</div>
</div>
<div class="col-md-12 col-sm-12">
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

	{{-- <div class="table-responsive">
		<table id="graduatetable" class="table table-striped jambo_table bulk_action" style="table-layout: fixed; width: 100%;">
		  <thead>
		  <tr class="headings">
	            	<th>School / Department</th>
	            	<th>Program</th>
					<th>Semester</th>
					<th>School Year</th>
	            	<th>Question</th>
	            	<th>Answer</th>
	            </tr>
		    </thead>   
		</table>
	</div> --}}
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
	$(document).ready(function(){

	   $('#schoolchange').on('change',function(){
			   var id = $(this).val();
			   $.ajax({
				url:"{{route('reportschool_select')}}",
				method:"POST",
				data:{
				  id:id,
				  _token:token
				},
				success:function(data){
				  $('#program_choice').html(data);
				}   
			 }); 
		});

	});
	  var count = 0;
	
		  var dataTable= $('#graduatetable').DataTable( {
				"ajax": "{{route('report_dtb')}}", //view
				responsive: false,
				"scrollX": true,
				"ordering": false,
			    dom: 'Blfrtip',
			  lengthMenu: [
				[ 10, 25, 50, -1 ],
				[ '10', '25', '50', 'Show all' ]
			],
			buttons: [
               {
                extend: 'excelHtml5',
                title: 'Graduate Survey'
            },
            ],

				"columns": [
					{ "data": "school_code" ,
                "visible": false,},
					{ "data": "acad_prog_code" ,
                "visible": false,},
					{ "data": "semester",
                "visible": false,},
					{ "data": "school_year",
                "visible": false,},
					{ "data": "question" },
					{ "data": "answer" },
				],
				initComplete: function () {
	
				var $buttons = $('.dt-buttons').hide();
				$('.dataTables_length').show();
				 $('#exportLink').on('click', function() {
					$('.buttons-excel').click(); 
				 })
	
				  this.api().columns([0,1,2,3,4]).every( function () {
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
	</script>
@endsection