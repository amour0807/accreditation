@extends('layouts.app')
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
</div> <form class="mb-4" action="{{route('reportfilterReport')}}" method="POST">
	@csrf 

 <div class="row">
      <div class="col-md-12">
         <strong>Sort by:</strong>
      </div>
    </div>
   <div class="form-group row">
     <div class="row col">
    <div class="col-md-2 col-sm-3">
      <label>School / Department</label>
      <div id="filters1">
        
      </div>
	</div>
	<div class="col-md-2 col-sm-3">
		<label>Program</label>
		<div id="filters2">
		  
		</div>
	  </div>
	  <div class="col-md-2 col-sm-3">
      <label>Semester</label>
      <div id="filters3">
        
      </div>
	</div>
	<div class="col-md-2 col-sm-3">
      <label>School Year</label>
      <div id="filters4">
        
      </div>
    </div>
    <div class="col-md-3 col-sm-3">
      <label>Questions</label>
      <div id="filters5">
        
      </div>
    </div>
	<div class="col-md-1 col-sm-3">
    	<a id="exportLink" class="btn btn-outline-success btn-sm edit " target="_blank" title="view excel" ><i class="fa fa-file-excel-o"></i></a>
      <button type="submit" class="btn btn-outline-danger btn-sm edit " target="_blank" title="view pdf" id="addBtn"><i class="fa fa-file-pdf-o"></i></button>
      </div>
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

	<div class="table-responsive">
		<table id="graduatetable" class="table table-striped jambo_table bulk_action" style="width: 100%;">
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

	  var count = 0;
	
		  var dataTable= $('#graduatetable').DataTable( {
				"ajax": "{{route('report_dtb')}}", //view
				responsive: false,
				"scrollX": false,
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