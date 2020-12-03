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
       <h2><strong>Accreditation History Reports<span></strong></h2>
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
    
<form class="mb-4" action="{{route('userFilterReport')}}" method="POST">
@csrf 
<!-- checking for the controller if to include current->yes -->


<input type="hidden" name="reportType" value="history">
  <strong>Sort by:</strong>
  <div class="form-group row">
    <div class="col-md-3 ">
      <label>Program</label>
      <div id="filters1">
        
      </div>
    </div>
    
    <div class="col-md-3 ">
      <label>Accreditation Level</label>
      <div id="filters2">
        
      </div>
    </div>
    <div class="col-md-3 ">
      <label>Accreditation Status</label>
      <select class="form-control" id="accredStat" name="accredStat">
        <option value="">All</option>
        <option value="Active">Active</option>
        <option value="Expired">Expired</option>
      </select>
    </div>
    <div class="col-md-3 ">
      <label>Visitation year</label>
      <select  class="form-control" id="dropdownYear" name="visitYear">
        <option value="">All</option>
      </select>
    </div>
  </div>



  <div class="form-group row">
        <label class="col-3">Range of Validity: </label>
        <div class="col-3">
          <input type="date" name="min" class="form-control" id="min">
        </div>
        <div class="col-3 ">
          <input type="date" name="max" class="form-control" id="max">
        </div>
  </div>



  <div class="row d-flex justify-content-center mt-2">
      <div class="col-md-8">
         <button type="submit" class="btn btn-outline-danger col-md-12 " id="addBtn"  >Export as PDF</button>
      </div>
    </div>
</form>


                      
                            
                        

<!-- end test -->




<div class="mr-3">
      <table id="program_report_table" class="table table-striped" style="width:100%">
        <thead class="thead">
              <tr>
                <th>School</th>
                <th>Program</th>
                <th>Accreditation Status</th>
                <th>Visit From</th>
                <th>Visit to</th>

                <th>Validity From</th>
                <th>Validity To</th>


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

   //Date
        var date = new Date();

          var newd      = date.toLocaleDateString();
          var month     = date.getMonth()+1;
          var date1     = date.getDate();
          var year      = date.getFullYear();
          
          if(month <10){
            month = '0'+month;

          }if(date1 <10){
            date1 = '0'+date1;
          }
  
        var newDate = year+'-'+month+'-'+date1;
                var count = 0;


//Datatable
$('#dropdownYear').each(function() {

  var year = (new Date()).getFullYear();
  var current = year;
  year -= 30;
  for (var i = 30; i > 0; i--) {
    
      $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
  }

})




/* Custom filtering function which will search data in column four between two values */
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
      //get selected status from the dropdown
        var status = $('#accredStat').val();
        //parse current date from above
        var ahem = Date.parse( newDate );
        //parse data from the to column
        var due = Date.parse( data[6] ) || 0; 

        if ( status == 'Active' )
        {
          if(due > ahem){
              return true;
          }
          else{
            return false;
          }
        }else if( status =='Expired'){
          if(due <= ahem){
              return true;
          }
          else{
            return false;
          }
        }
        else{
            return true;

        }
        
    }
);

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = Date.parse($('#min').val());
        var max = Date.parse($('#max').val());
        var age = Date.parse( data[6] ) || 0; // use data for the age column
 
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

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var yearSelect = $('#dropdownYear').val();

        var years = data[3] || 0; // use data for the age column
        var d = new Date( years );

        var yearVisit = d.getFullYear();


        if ( yearSelect == yearVisit )
        {
         // alert('equal year')

            return true;

        }else if(yearSelect && yearSelect != yearVisit){
           // alert('no year')
            return false;
        }else if(!yearSelect ){
          // alert('no year')
            return true;
        }

        else{
          // alert('yes year')

          return false;

        }
        
    }
);


   // program table

        var dataTable= $('#program_report_table').DataTable( {
          "scrollX": true,
          "ajax": "{{route('userProgram_history_report_dtb')}}",
          "columns": [
              { "data": "school" },
              { "data": "program" },
              { "data": "accred_stat" },
              { "data": "visit_date_from" },
              { "data": "visit_date_to" },

              { "data": "from" },
              { "data": "to" },

              
              { "data": "remarks" },
          ],


       


          initComplete: function () {
              this.api().columns([1,2]).every( function () {
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

  // Event listener to the two range filtering inputs AND THE status to redraw on input
            $('#min, #max, #accredStat, #dropdownYear').change(function () {
                dataTable.draw();
        
            });

 
        //Adding
    $( "#addSchoolForm" ).submit(function( event ) {
        event.preventDefault();

        $.ajax({
          url:"{{ route('userFilterReport') }}",
          method:"POST",
          data: $("#addSchoolForm").serialize(),
          success:function(data){
            dataTable.ajax.reload();
          }
              
        }); 
    });   

    

    </script>
@endsection