@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
      <h2><a href="{{ route('boardExam') }}" class="fa fa-angle-double-left" >&nbsp;&nbsp;Licensure Exam Details</a></h2>
     
      <div class="clearfix"></div>
    </div>
    <form class="mb-4" action="{{route('bHistoryfilterReport')}}" method="POST">
      @csrf 
      
      <input type="text" value="{{$exam}}" name="licensure" hidden>
          <div class="float-right">
              <a id="exportLink" class="btn btn-outline-success btn-sm edit " target="_blank" title="view excel" ><i class="fa fa-file-excel-o"></i></a>
                <button type="submit" class="btn btn-outline-danger btn-sm edit " target="_blank" title="view pdf" id="addBtn"><i class="fa fa-file-pdf-o"></i></button>
            </div>
  </form>
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

        <h6><center>{{$exam}}</center></h6>
<div class="table-responsive">
  <table id="history_table" class="table table-striped jambo_table bulk_action" style="width: 100%;">
       <thead>
         <tr class="headings" style="font-size: 11px">
            <th colspan="2">Date Taken</th>
            <th colspan="4"><center>First Takers</center></th>
            <th>UB Passsing<br>Percentage<br>(First Takers)</th>
            <th colspan="4"><center>Total No. of Takers</center></th>
            <th >UB Overall<br>Passsing<br>Percentage</th>
            <th>National<br>Passsing<br>Percentage</th>
            <th>Top<br>notchers</th>
            <th>School Rank</th>
          </tr>
          <tr>
            <th>Month</th>
            <th>Year</th>
            <th>Passed</th>
            <th>Failed</th>
            <th>Con</th>
            <th>Total</th>
            <th></th>
            <th>Passed</th>
            <th>Failed</th>
            <th>Con</th>
            <th>Total</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
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

   var dataTable = $('#history_table').DataTable( {
          "processing" : true,
          "bSort" : false,
          "ajax": "{{route('boardHistory_dtb', $exam)}}",

           dom: 'Blfrtip',
          lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10', '25', '50', 'Show all' ]
        ],
        buttons: [
              {
                extend: 'excelHtml5',
                title: 'Licensure_history'
            },
            {
                extend: 'pdfHtml5',
                title: 'Licensure_history'
            }
            ],

          "columns": [
              { "data": "exam_month" },
              { "data": "exam_year" },
              { "data": "ftaker_passed" },
              { "data": "ftaker_failed" },
              { "data": "ftaker_cond" },
              { "data": "ftaker_total" },
              { "data": "ftaker_percentage" },
              { "data": "total_passed" },
              { "data": "total_failed" },
              { "data": "total_cond" },
              { "data": "total_total" },
              { "data": "overall_percentage" },
              { "data":  null , 
           "render" : function ( data, type, full ) { 
              return full['national_percent']+'%';}
              
              },
              { "data": "topnotcher" },
              { "data": "school_rank" },
          ],

          initComplete: function () {
            var $buttons = $('.dt-buttons').hide();
            $('.dataTables_length').show();
             $('#exportLink').on('click', function() {
                $('.buttons-excel').click(); 
             })

              this.api().columns([0]).every( function () {
                  var column = this;
                  count++;
                  $('<div id="lalagyan'+count+'"></div>')
                      .appendTo( "#filters"+count );

                  var select = $('<select class="form-control" name="select'+count+'"><option value="">All</option></select>')
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
   $.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = Date.parse($('#mindate').val());
        var max = Date.parse($('#maxdate').val());
        var age = Date.parse( data[0] ) || 0; // use data for the age column
 
        if ( ( isNaN( min ) && isNaN( max ) ) ||
             ( isNaN( min ) && age <= max ) ||
             ( min <= age   && isNaN( max ) ) ||
             ( min <= age   && age <= max ) )
        {
            return true;
        }else{
          return false;
        }
        
    }
);
    $('#mindate, #maxdate').change(function () {
                dataTable.draw();
        
            });
</script>
@endsection