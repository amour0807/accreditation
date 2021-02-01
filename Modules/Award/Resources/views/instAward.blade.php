@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
      <h2><small>Institutional Awards And Recognition </small></h2>
      @if(Auth::user()->hasPermission('create-instaward'))
      <a class="btn btn-app float-right" data-toggle="modal"  data-target="#addAwardModal">
        <i class="fa fa-plus-square-o"></i> Add Award
      </a>
        @endif
      <div class="clearfix"></div>
    </div>
    <form class="mb-4" action="{{route('instawardfilterReport')}}" target="_blank"method="POST">
      @csrf 
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
      <div class="col-md-6">
        <label >Award</label>
        <select name="award1" id="award" class="form-control" required>
            <option> All  </option>
          @foreach($award as $a)
            <option>{{$a->award}} </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label >Scope</label>
					<select name="scope1" id="scopes" class="form-control small" required>
					  <option> All </option>
					  <option>School</option>
					  <option>Institutional</option>
					  <option> Local</option>
					  <option>National</option>
					  <option>International</option>
					</select>
      </div>
      </div>
    <div class="row col">
      <div class="col-6 col-md-6">
        <label>From </label>
        <select  class="form-control" name="min" id="min">
          <option>All</option>
        </select>
      </div>
      <div class="col-6 col-md-6">
      <label>To</label>
      <select  class="form-control" name="max" id="max">
          <option>All</option>
        </select>
    </div>
    </div>
    </div>
    
    <div class="row">
      <div class="col-md-8">
      </div>
     <div class="col-md-4">
      <div class="float-right">
        <a id="exportLink" class="btn btn-outline-success btn-sm edit " target="_blank" title="view excel" ><i class="fa fa-file-excel-o"></i></a>
          <button type="submit" class="btn btn-outline-danger btn-sm edit " title="view pdf" id="addBtn"><i class="fa fa-file-pdf-o"></i></button>
      </div><br><br>
      </div>
    </div>
  </form>
  </div>
</div>
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">

	  <div class="x_content">
		  <div class="row">
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

			  <div class="col-sm-12">

    <!-- Table showing awards -->
    <div class="table-responsive">
      <table id="instawardtable" class="table table-striped jambo_table bulk_action" style="width: 100%;">
        <thead>
        <tr class="headings">
                <th style="width:20%">Award Title</th>
                <th>Scope</th>
                <th>Date Issued</th>
	            	<th>Valid From</th>
                <th>Valid To</th>
                <th>Award <br>Giving Body</th>
                <th>Supporting <br>Document</th>
                    <th>Action</th>
	            </tr>
		    </thead>   
    </table>
    </div>
<!-- Modal -->
<div class="modal fade " data-backdrop="static" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
      </div>
      <div class="modal-body">
        Record saved. Add another record?
      </div>
      <div class="modal-footer">
        <a class="btn btn-danger" href="{{route('instAward')}}">Cancel</a>
        <button type="button" class="btn btn-info"   data-toggle="modal" 
			data-target="#addAwardModal" data-dismiss="modal">Add Another Record</button>
      </div>
    </div>
  </div>
</div>
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

	       <form id="studentForm" class="form-horizontal form-bordered" style="padding: 0px 8px 0px 16px;">
                                            {{ csrf_field() }}
       <span class="text-danger">* Required Fields</span><br>

        <div class="modal-body">
          <div class="row form-group">
              <label><span class="text-danger">*</span>Title of Award</label>
		        	<input type="text" class="form-control" name="award" placeholder="" required>
          </div>
          <div class= "row form-group"> 
		        <label><span class="text-danger">*</span>Scope:</label>
					<select name="scope" class="form-control small" required>
					  <option disabled selected value> -- --  </option>
					  <option >School</option>
					  <option >Institutional</option>
					  <option> Local</option>
					  <option >National</option>
					  <option>International</option>
					</select>
          </div>
          <div class="row form-group">
            <div class="col-md-12">
                <label><span class="text-danger">*</span>Date Issued</label>
                <input type="date" class="form-control" name="date_issued" placeholder="" required>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-6">
                <label><span class="text-danger"></span>From</label>
                <input type="date" class="form-control" name="from" id="fromVal" placeholder="" >
            </div>
            <div class="col-md-6">
                <label><span class="text-danger"></span>To</label>
                <input type="date" class="form-control" name="to" id="toVal" placeholder="" >
                <span id="spnErrorDate" class="error text-danger" style="display: none;">*Must be greater than the starting Date.</span>
            </div>
          </div>
          {{-- <div class="row form-group">
              <label><span class="text-danger"></span>Venue</label>
		        	<input type="text" class="form-control" name="venue" placeholder="" >
          </div> --}}
          <div class="row form-group">
              <label><span class="text-danger">*</span>Award Giving Body</label>
		        	<input type="text" class="form-control" name="award_gb" placeholder="" required>
          </div>
          <div class="row form-group">
		        	<i class="fa fa-upload">Supporting Document</i><br>
		        	<input type="file" name="supporting_doc" class="form-control">
		        </div>
		      <div class="modal-footer" id="clasValidate"> 
		       
            <a type="button" class="btn btn-danger" data-dismiss="modal">Close</a>
            <button type="submit" class="btn btn-info">Add Award</button>
	      	<div>
	      	</div>
             </form>
	    </div>
	  </div>
  </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
@if(\Session::has('success'))
<script>
Swal.fire({
  icon: 'success',
  title: 'Done!',
  text: 'Successfully Saved!',
  timer: 1500
})
</script>
  @elseif(\Session::has('error'))
  <script>
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Something went wrong!',
    footer: "<a>Back</a>"
  }) 
  </script>
  @elseif(\Session::has('success_add'))
  <script>
    Swal.fire({
        title: 'Done',
        text: "Successfully Saved!",
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'add another award'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#addAwardModal').modal('show');
        }
      })
  </script>
  @endif
@include('common.inputVal');
	<script type="text/javascript">

    $.ajaxSetup({
	    headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
    });

     
    var token = $("input[name='_token']").val();

    var count = 0;

    $('#min').each(function() {

    var year = (new Date()).getFullYear();
    year -= 30;
    for (var i = 30; i > 0; i--) {

      $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
    }
    })
    $('#max').each(function() {

    var year = (new Date()).getFullYear();
    year += 4;
    year -= 30;
    for (var i = 30; i > 0; i--) {

      $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
    }
    })
    $( "#studentForm" ).submit(function( event ) {
        event.preventDefault();
        $.ajax({
                    type: 'POST',
                    url: "{{route('addInstAward')}}",
                    data:$("#studentForm").serialize(),
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {
                            $("#studentForm")[0].reset();
                            $('#addAwardModal').modal('hide');
                            dataTable.ajax.reload();
                            swal.fire("Done!", results.message, "success");
                          
                        } else {
                            swal.fire("Error!", results.message, "error");
                        }
                    }
                });
    }); 
       $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
      var from = $('#min').val()
			    to = $('#max').val()
			    dfrom = data[3].split(' '); 
			    dto = data[4].split(' '); 
			if ( ( isNaN( from ) && isNaN( to ) ) ||
				 ( isNaN( from ) && dfrom[2] <= to ) ||
				 ( from <= dfrom[2]   && isNaN( to ) ) ||
				 ( from <= dfrom[2]   && dto[2] <= to ) )
			{
				return true;
			}else{
			  return false;
			}
			
		}
);
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var award = $('#award').val()
            dbtype =  data[0]
        if (award == dbtype || award == 'All' )
          return true;
        else
        	return false;
    }
);
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var scope = $('#scopes').val()
            dbtype =  data[1]
        if (scope == dbtype || scope == 'All' )
          return true;
        else
        	return false;
    }
);
 var dataTable = $('#instawardtable').DataTable( {
            "ajax": "{{route('instaward_dtb',1)}}",

           dom: 'Blfrtip',
          lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10', '25', '50', 'Show all' ]
          ],
                  buttons: [
                      'excelHtml5',
            ],

          responsive: true,
          "ordering": false,
          "columns": [
              { "data": "award" },
              { "data": "scope" },
              { "data": "date_issued" },
              { "data": "from" },
              { "data": "to" },
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
          },

        });


     $('#min, #max, #award, #scopes').change(function () {
                dataTable.draw();
                    });

	     //delete
       $(document).on('click','.destroy',function(){
	      var id = $(this).attr('instAwardID');
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
          url:"{{route('deleteInstAward')}}",
          method:"POST",
          data:{
            id:id,
            _token:token
          },
          success:function(data){
            Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          ) 
          dataTable.ajax.reload();
          },
          error: function(jqxhr, status, exception) {
            Swal.fire(
            'Cannot be Deleted!',
            'this record still has a task. Please delete it all then delete this project.',
            'error'
          )
         }

        }); 
         
        }
      })
    });


       
    </script>
    @endsection
