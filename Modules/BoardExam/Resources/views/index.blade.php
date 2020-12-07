@extends('layouts.app')
@section('content')
    <hr style="margin: 0 0 0 0;">
    <div class="block full"  style="margin-bottom: 10px;" >
    <div class="block-title" style="padding: 1px 3px 1px 3px;" id="datatable_wrapper">
       <h2><strong>Licensure Examination<span></strong></h2>
       <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#addAwardModal">New Record</button>
        
    </div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
    </div>
  @endif
@if(!empty(Session::get('success_modal')) && Session::get('success_modal') == 5)
<script>
      $('#success-modal').modal('show');

</script>
@endif
  <form class="mb-4" action="{{route('boardfilterReport')}}" method="POST">
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
     <div class="row col">
    <div class="col-md-4 ">
      <label >Type:</label>
      <div id="filters1">   
      </div>
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
    <!-- Table showing awards -->
    <table id="boardexam_table" class="display compact cell-border" style="table-layout: fixed">
        <thead>
              <tr>
                <th>Licensure Examination</th>
                <th>Date</th>
                <th>Type</th>
                <th>Supporting <br>Document</th>
                <th>Topnotcher/s</th>
                <th>Action</th>
              </tr>
        </thead>   
    </table>
    <!-- Modal -->
  <div class="modal fade" id="addAwardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Record</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

         <form id="form" action="{{route('addBoardExam')}}" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered" style="padding: 0px 8px 0px 16px;">
                                            {{ csrf_field() }}

        <div class="modal-body">
          <div class="row form-group">
              <label><span class="text-danger">*</span>Licensure Examination</label>
              <input type="text" class="form-control" name="exam" placeholder="" required>
          </div>
          <div class="row form-group">
             <div class="col-md-4">
                <label><span class="text-danger"></span>Examination Type:</label>
                <select name="exam_type" class="form-control small" required>
                  <option disabled selected value> -- --  </option>
                  <option value="Local">Local</option>
                  <option value="Regional">Regional</option>
                  <option value="National">National</option>
                  <option value="International">International</option>
                </select>
            </div>
              <div class="col-md-4">
                <label><span class="text-danger">*</span>Date</label>
                <input type="date" class="form-control" name="exam_date" required>
            </div>
            <div class="col-md-4">
                <label><span class="text-danger"></span>School Rank</label>
                <input type="number" class="form-control" name="school_rank"  min="0" max="100"placeholder="ex. 1" value="0">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-8">
              <label><span class="text-danger"></span>Topnotcher/s</label>
              
              <input type="hidden" class="form-control" value="1" id="total_top">
              <input type="text" class="form-control" name="top[]">
              <div id="new_top"></div>
            </div>
            <div class="col-md-2">
              <label><span class="text-danger"></span>Rank</label>
              
              <input type="hidden" class="form-control" value="1" id="total_rank">
              <input type="number" min="0" max="100" class="form-control" name="rank[]" placeholder="ex. 1">
              <div id="new_rank"></div>
            </div>
            <div class="col-md-2">
              <a class="btn btn-info" onclick="add()">Add</a>
              <a class="btn" onclick="remove()">remove</a>
            </div>
          </div>
          <div class="row col-md-12">
            <fieldset class="row col-md-12">
               <legend>First Takers :</legend>
              <div class="col-md-2">
                <label><span class="text-danger">*</span>Passed</label>
                <input type="number" class="ftaker form-control" id="fpassed" name="fpassed" min="0" max="100"oninput="calculateSum()" value="0" required>
             </div>
              <div class="col-md-2">
                <label><span class="text-danger">*</span>Failed</label>
                <input type="number" class="ftaker form-control" name="ffailed" min="0" max="100" oninput="calculateSum()" value="0" required>
              </div>
              <div class="col-md-2">
                <label><span class="text-danger">*</span>Con</label>
                <input type="number" class="ftaker form-control" name="fcon" min="0" max="100"oninput="calculateSum()" value="0" required>
              </div>
              <div class="col-md-3">
                <label><span class="text-danger"></span>Total</label><br>
                <span id="ftotal">0</span>
              </div>
              <div class="col-md-3">
                <label><span class="text-danger"></span>Percentage</label><br>
                <span id="fpercent">0 %</span>
              </div>
              </fieldset>
          </div>
          <div class="row col-md-12">
            <fieldset class="row col-md-12">
               <legend>Total No. of Takers :</legend>
              <div class="col-md-2">
                <label><span class="text-danger">*</span>Passed</label>
                <input type="number" class="ttaker form-control" id="tpassed" name="tpassed" min="0" max="100" oninput="calculateSum()" value="0" required>
             </div>
              <div class="col-md-2">
                <label><span class="text-danger">*</span>Failed</label>
                <input type="number" class="ttaker form-control" name="tfailed" min="0" max="100" oninput="calculateSum()" value="0" required>
              </div>
              <div class="col-md-2">
                <label><span class="text-danger">*</span>Con</label>
                <input type="number" class="ttaker form-control" name="tcon" min="0" max="100" oninput="calculateSum()" value="0" required>
              </div>
              <div class="col-md-3">
                <label><span class="text-danger"></span>Total</label><br>
                <span id="ttotal">0</span>
              </div>
              <div class="col-md-3">
                <label><span class="text-danger"></span>Percentage</label><br>
                <span id="tpercent">0</span>
              </div>
              </fieldset>
          </div>
          <div class="row form-group">
            <div class="col-md-9">
              <i class="fas fa-upload">Supporting Document</i>
              <input type="file" name="supporting_doc" class="form-control">
            </div>
            <div class="col-md-3">
              <span id="npercent">0</span>
            </div>
              
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-info">Add Licensure Examination</button>
            
          <div>
          </div>
             </form>
      </div>
    </div>
  </div>

<!-- Add Another Modal -->
<div class="modal fade " data-backdrop="static" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
      </div>
      <div class="modal-body">
        Record saved. Add another record?
      </div>
      <div class="modal-footer">
        <a class="btn btn-danger" href="#">Proceed to Dashboard</a>
        <button type="button" class="btn btn-info"   data-toggle="modal" 
      data-target="#addAwardModal" data-dismiss="modal">Add Another Record</button>
      </div>
    </div>
  </div>
</div>

  <script type="text/javascript">

  function calculateSum() {

    var sum = 0;
    var fpassed = document.getElementById("fpassed").value;

    $(".ftaker").each(function() {

      if(!isNaN(this.value)) {
        sum += parseFloat(this.value);
      }

    });
    var fpercent = (fpassed/sum)*100;
    //.toFixed() method will roundoff the final sum to 2 decimal places
    $("#ftotal").html(sum);
    $("#fpercent").html(fpercent.toFixed(2)+"%");


    var total = 0;
    var tpassed = document.getElementById("tpassed").value;
    $(".ttaker").each(function() {

      if(!isNaN(this.value)) {
        total += parseFloat(this.value);
      }

    });
    var tpercent = (tpassed/total)*100;
    var npercent = fpercent+tpercent;
    //.toFixed() method will roundoff the final sum to 2 decimal places
    $("#ttotal").html(total);
    $("#tpercent").html(tpercent.toFixed(2)+"%");
    $("#npercent").html(npercent.toFixed(2)+"%s");
  }

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
        var age = Date.parse( data[1] ) || 0; // use data for the age column
 
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


 var dataTable = $('#boardexam_table').DataTable( {
          "processing" : true,
          "ajax": "{{route('boardexam_dtb')}}",

           dom: 'Blfrtip',
          lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'excelHtml5',
            ],

          responsive: false,
          "scrollX": false,
          
          "columns": [
              { "data": "licensure_exam" },
              { "data": "exam_date" },
              { "data": "type" },
              { "data": "supporting_doc" },
              { "data": "topnotcher" },
              { "data": "actions" },
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

 $('#mindate, #maxdate').change(function () {
                dataTable.draw();
        
            });

     function add(){
          var new_top_no = parseInt($('#total_top').val())+1;
          var new_rank_no = parseInt($('#total_rank').val())+1;
          var new_top="<input type='text' class='form-control' name='top[]' id='top_"+new_top_no+"'>";
          var new_rank="<input type='text' class='form-control' name='rank[]' id='rank_"+new_rank_no+"'>";
          $('#new_top').append(new_top);
          $('#new_rank').append(new_rank);

          $('#total_top').val(new_top_no);
          $('#total_rank').val(new_rank_no)
        }
        function remove(){
          var last_top_no = $('#total_top').val();
          var last_rank_no = $('#total_rank').val();
          if(last_top_no>1){
            $('#top_'+last_top_no).remove();
            $('#total_top').val(last_top_no-1);
            $('#rank_'+last_rank_no).remove();
            $('#total_rank').val(last_rank_no-1);
          }
        }

       //delete
       $(document).on('click','.destroy',function(){
        var conf = confirm('This record will be deleted. Continue?');
        var id = $(this).attr('instAwardID');

      if(conf){
        $.ajax({
          url:"{{route('deleteInstAward')}}",
          method:"POST",
          data:{
            id:id,
            _token:token
          },
          success:function(data){
            dataTable.ajax.reload();
            $('.alert').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><span id="alertMessage">Record deleted!</span> </div>');
            $('.alert').show();
            $(".alert").delay(4000).fadeOut(500);
            setTimeout(function(){
              $('#alertMessage').remove();
            }, 5000);
          },
          error: function(jqxhr, status, exception) {
             alert('Record not deleted. There are records associated with this Accreditation Status');
         }

        });  
      }
    });


       
    </script>
@endsection
