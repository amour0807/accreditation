@extends('accreditation::layouts.master')

@section('content')
<h2>Reports here</h2>


<strong>Sort by: </strong><br>
      <div class="mb-3 p-3">
        <!-- <div class=" d-flex justify-content-center">
          <div class="col-md-8">
            <input type="text" id="searchbox" placeholder="search" class="form-control">
          </div>
        </div> -->
        <div class="row d-flex justify-content-center">
          <!-- <div class="col-md-2">
            <label>Date From</label>
          </div>
          <div class="col-md-2">
            <label>Date To</label>
          </div> -->
          <div class="col-md-4">
            <label>School</label>
          </div>
          <div class="col-md-4">
            <label>Accred Status</label>
          </div>
          
        </div>
        <div class="row d-flex justify-content-center" id="filters">
          
<!-- 
          <div class="col-md-4">
            <input type="date" name="min" id="min" class="form-control" required>
          </div>
          <div class="col-md-4">
            <input type="date" name="max" id="max" class="form-control" required>
          </div> -->
        </div>
        <div class="row d-flex justify-content-center mt-2">
          <div class="col-md-8">
             <button type="submit" class="btn btn-outline-danger col-md-12 " id="addBtn" data-target="#addModal" data-toggle="modal" >Export as PDF</button>
          </div>
        </div>
      </div>

<div class="mr-3">
    	<table id="program_report_table" class="display compact table-bordered" style="width:100%">
		    <thead class="thead">
	            <tr>
	            	<th>School</th>
	            	<th>Program</th>
	            	<th>Accreditation Status</th>
	            	<th>Visit Date</th>
	            	<th>From</th>
	            	<th>To</th>
	            	<th>Remarks</th>

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

   var count = 0;


   // program table

        var dataTable= $('#program_report_table').DataTable( {
	        "ajax": "{{route('program_report_dtb')}}",
	        "columns": [
	            { "data": "school" },
	            { "data": "program" },

	            { "data": "accred_stat" },
	            { "data": "visit_date_from" },
	            { "data": "from" },
	            { "data": "to" },
	            { "data": "remarks" },
	        ],

	        initComplete: function () {
	            this.api().columns([0,2]).every( function () {
	                var column = this;
	                count++;

	                $('<div class="col-md-4" id="lalagyan'+count+'"></div>')
	                    .appendTo( "#filters" );

	                var select = $('<select class="mb-2 form-control" name="select'+count+'"><option value> All </option></select>')
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
	        }
        });

    </script>
@endsection