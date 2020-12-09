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
       <h2><strong>Topnotchers<span></strong></h2>
    </div>
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

  <form class="mb-4" action="{{route('topfilterReport')}}" method="POST">
    @csrf 
     <div class="row">
      <div class="col-md-8">
      </div>
     <div class="col-md-4">
      <div class="float-right">
        <a id="exportLink" class="btn btn-outline-success btn-sm edit " target="_blank" title="view excel" ><i class="fas fa-file-excel"></i></a>
          <button type="submit" class="btn btn-outline-danger btn-sm edit " target="_blank" title="view pdf" id="addBtn"><i class="fas fa-file-pdf"></i></button>
      </div><br><br>
      </div>
    </div>
 <div class="row">
      <div class="col-md-6">
         <strong>Sort by:</strong>
      </div>
      <div class="col-md-6">
        <strong>Examination:</strong>
      </div>
    </div>
   <div class="form-group row">
    <div class="col-md-3 ">
      <label >Licensure Exam</label>
      <div id="filters1">
      </div>
    </div>
    <div class="col-md-3 ">
      <label >Rank</label>
      <div id="filters2">
      </div>
    </div>
    <div class="row col">
      <div class="col-md-6 ">
            <label>From </label>
            <input type="date" name="mindate" class="form-control" id="mindate">
      </div>
      <div class="col-md-6">
       <label>To</label>
            <input type="date" name="maxdate" class="form-control" id="maxdate">
     </div>
    </div>
  </div>
</form>
<hr>

      <table id="topnotcher_table"  class="display compact cell-border" style="width:100%">
        <thead class="thead">
              <tr>
                <th>Examination Date</th>
                <th>Licensure Exam</th>
                <th>Name</th>
                <th>Rank</th>
              </tr>
        </thead>   
    </table>


  <script type="text/javascript">
 $('.alert').hide();
   
     $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    var token = $("input[name='_token']").val();

   var count = 0;
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

   // program table
        var dataTable= $('#topnotcher_table').DataTable( {
          "scrollX": true,
          "ajax": "{{route('topnotcher_dtb')}}",
          
           dom: 'Blfrtip',
          lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'excelHtml5',
            ],
          "columns": [
              { "data": "exam_date"},
              { "data": "licensure_exam" },
              { "data": "name"},
              { "data": "rank"},
          ],
          responsive: true,
          initComplete: function () {
            var $buttons = $('.dt-buttons').hide();
            $('.dataTables_length').show();
             $('#exportLink').on('click', function() {
                $('.buttons-excel').click(); 
             })

              this.api().columns([1,3]).every( function () {
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
      
  $('#mindate, #maxdate').change(function () {
                dataTable.draw();
        
            });
      

    </script>

@endsection