@extends('layouts.app')
@section('content')
    <hr style="margin: 0 0 0 0; ">
    <div class="block full"  style="margin-bottom: 10px;" >
    <div class="block-title" style="padding: 1px 3px 1px 3px;">
       <h2><strong>Licensure Exam Details</strong>
       </h2>
    </div>
  <div class="alert"></div>
  @if(Session::has('message'))
    <div class="alert alertOld alert-info alert-dismissible fade show alertOld" role="alert">
      {{ Session::get('message') }}
                <button type="button" class="close" data-dismiss="alert">×</button>
    </div> 
    @endif
    @if(Session::has('red'))
      
    <div class="alert alertOld alert-danger alert-dismissible fade show alertOld" role="alert">
      {{ Session::get('red') }}
                <button type="button" class="close" data-dismiss="alert">×</button>
    </div> 
  @endif
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

@if (session('success'))
     <div class="alert alert-info alert-block">
            <strong>{{ session('success') }}</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
     
@endif
  <form class="mb-4" action="{{route('bHistoryfilterReport')}}" method="POST">
    @csrf 
    
<input type="text" name="licensure" value="{{$exam}}" hidden>
 <div class="row">
        <strong>Examination:</strong>
    </div>
   <div class="form-group row" >
     <div class="row col-md-8">
      <div class="col-md-6 ">
          <label>From </label>
          <input type="date" name="mindate" class="form-control" id="mindate">
      </div>
      <div class="col-md-6">
         <label>To</label>
              <input type="date" name="maxdate" class="form-control" id="maxdate">
       </div>
    </div>
      <div class="row col-md-4">
        <div class="float-right">
            <a id="exportLink" class="btn btn-outline-success btn-sm edit " target="_blank" title="view excel" ><i class="fas fa-file-excel"></i></a>
              <button type="submit" class="btn btn-outline-danger btn-sm edit " target="_blank" title="view pdf" id="addBtn"><i class="fas fa-file-pdf"></i></button>
          </div>
      </div>
  </div>
</form>
    <hr>
      <table id="history_table"  class="display compact cell-border" style="text-align: center;">
        <thead>
          <tr>
            <th>Date Taken</th>
            <th colspan="4"><center>First Takers</center></th>
            <th>UB Passsing<br>Percentage<br>(First Takers)</th>
            <th colspan="4"><center>Total No. of Takers</center></th>
            <th>UB Overall<br>Passsing<br>Percentage</th>
            <th>National<br>Passsing<br>Percentage</th>
            <th>Topnotchers</th>
          </tr>
          <tr>
            <th></th>
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

   var dataTable = $('#history_table').DataTable( {
          "scrollX" : true,
          "processing" : true,
          "ajax": "{{route('boardHistory_dtb')}}",

           dom: 'Blfrtip',
          lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'excelHtml5',
            ],

          "columns": [
              { "data": "exam_date" },
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
              { "data": "national_percent" },
              { "data": "topnotcher" },
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