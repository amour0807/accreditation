@extends('layouts.app')
@section('content')
    <hr style="margin: 0 0 0 0;">
    <div class="block full"  style="margin-bottom: 10px;" >
    <div class="block-title" style="padding: 1px 3px 1px 3px;" id="datatable_wrapper">
       <h2><strong>Institutional Awards And Recognition<span></strong></h2>
       <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#addAwardModal">Add Award</button>
        
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
  <form class="mb-4" action="{{route('instawardfilterReport')}}" method="POST">
    @csrf 
     <div class="row">
      <div class="col-md-8">
      </div>
     <div class="col-md-4">
      <div class="float-right">
        <button id="exportLink" class="btn btn-outline-success btn-sm edit " target="_blank" title="view excel" ><i class="fas fa-file-excel"></i></button>
          <button type="submit" class="btn btn-outline-danger btn-sm edit " target="_blank" title="view pdf" id="addBtn"><i class="fas fa-file-pdf"></i></button>
      </div><br><br>
      </div>
    </div>
 <div class="row">
      <div class="col-md-6">
         <strong>Sort by:</strong>
      </div>
      <div class="col-md-6">
        <strong>Range of Award:</strong>
      </div>
    </div>
   <div class="form-group row">
     <div class="row col">
    <div class="col-md-4 ">
      <label >Award</label>
      <div id="filters1">   
      </div>
    </div>
    </div>
  <div class="row col">
    <div class="col-md-6 ">
          <label>From </label>
          <input type="date" name="from" class="form-control" id="from">
  </div>
  <div class="col-md-6">
     <label>To</label>
          <input type="date" name="to" class="form-control" id="to">
   </div>
  </div>
  </div>
</form>
<hr>
    <!-- Table showing awards -->
    <table id="instawardtable" class="display compact cell-border" style="table-layout: fixed">
		    <thead>
	            <tr>
	            	<th>Award Title</th>
	            	<th>Valid From</th>
                <th>Valid To</th>
	            	<th>Venue</th>
                <th>Award <br>Giving Body</th>
	            	<th>Supporting <br>Document</th>
                    <th>Action</th>
	            </tr>
		    </thead>   
		</table>
    <!-- Modal -->
	<div class="modal fade" id="addAwardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Add Institutional Awards And Recognitions</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>

	       <form id="form" action="{{route('addInstAward')}}" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered" style="padding: 0px 8px 0px 16px;">
                                            {{ csrf_field() }}

        <div class="modal-body">
          <div class="row form-group">
              <label><span class="text-danger">*</span>Title of Award</label>
		        	<input type="text" class="form-control" name="award" placeholder="" required>
          </div>
          <div class="row form-group">
            <div class="col-md-6">
                <label><span class="text-danger"></span>From</label>
                <input type="date" class="form-control" name="from" placeholder="" >
            </div>
            <div class="col-md-6">
                <label><span class="text-danger"></span>To</label>
                <input type="date" class="form-control" name="to" placeholder="" >
            </div>
          </div>
          <div class="row form-group">
              <label><span class="text-danger"></span>Venue</label>
		        	<input type="text" class="form-control" name="venue" placeholder="" >
          </div>
          <div class="row form-group">
              <label><span class="text-danger">*</span>Award Giving Body</label>
		        	<input type="text" class="form-control" name="award_gb" placeholder="" required>
          </div>
          <div class="row form-group">
		        	<i class="fas fa-upload">Supporting Document</i>
		        	<input type="file" name="supporting_doc" class="form-control">
		        </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-info">Add Award</button>
            
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

    $.ajaxSetup({
	    headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
    });

     
    var token = $("input[name='_token']").val();

    var count = 0;

       $.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var from = Date.parse($('#from').val());
        var to = Date.parse($('#to').val());
        var age = Date.parse( data[2] ) || 0; 
        if ( ( isNaN( from ) && isNaN( to ) ) ||
             ( isNaN( from ) && age <= to ) ||
             ( from <= age   && isNaN( to ) ) ||
             ( from <= age   && age <= to ) )
        {
            return true;
        }else{
          return false;
        }
        
    }
);

 var dataTable = $('#instawardtable').DataTable( {
          "processing" : true,
          "ajax": "{{route('instaward_dtb',1)}}",

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
              { "data": "award" },
              { "data": "from" },
              { "data": "to" },
              { "data": "venue" },
              { "data": "award_giving_body" },
              { "data": "dsupporting_doc" },
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


     $('#from, #to').change(function () {
                dataTable.draw();
                    });

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
