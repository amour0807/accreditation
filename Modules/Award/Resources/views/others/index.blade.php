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

<script type="text/javascript">
    var token = $("input[name='_token']").val();

function CheckAward(val){
 var element=document.getElementById('others2');
 if(val=='others2')
   element.style.display='block';
 else
   element.style.display='none';
}
</script>	
@endsection
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
       <h2><strong>Student's Award<span>{{$school->school_name}}</strong></h2>
       	 <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#addStudentAwardModal">Add Award</button>
    </div>
  @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
    </div>
  @endif
@if(!empty(Session::get('success_modal')) && Session::get('success_modal') == 5)
	<script>
	$(function() {
		$('#success-modal').modal({backdrop: 'static', keyboard: false})  
	    $('#success-modal').modal('show');

	});
	</script>
@endif
 <form class="mb-4" action="{{route('userawardfilterReport')}}" method="POST">
    @csrf 
    <div class="row">
    	<div class="col-md-8">
    	</div>
     <div class="col-md-4">
     	<div class="float-right">
       <div class="actionPart" >
        <div class="actionSelect">
            
        </div>
    </div>
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
    <div class="col-md-6 ">
      <label>Scope</label>
      <div id="filters1">
        
      </div>
    </div>

    <div class="col-md-6 ">
      <label>Categoty</label>
      <div id="filters2">
        
      </div>
    </div>
     </div>
  <div class="row col">
    <div class="col-md-6 ">
          <label>From </label>
          <input type="date" name="from" class="form-control small" id="from">
  </div>
  <div class="col-md-6">
     <label>To</label>
          <input type="date" name="to" class="form-control small" id="to">
   </div>
  </div>
  </div>
      
</form><hr>

    <!-- Table showing awards -->

    <table id="awardtable" class="display compact cell-border" style="width:100%; table-layout: fixed;">
		    <thead class="thead">
	            <tr>
	            	<th>Name</th>
	            	<th>Program</th>
	            	<th>Scope</th>
	            	<th>Category</th>
	            	<th>Award</th>
	            	<th>Classification</th>
	            	<th>Competition</th>
	            	<th>Award <br>Giving Body</th>
	            	<th>Date Awarded</th>
	            	<th>Venue</th>

	            	<th>Actions</th>
	            </tr>
		    </thead>   
		</table>
    
	<!-- end table -->

	<!-- Modal -->
	<div class="modal fade" id="addStudentAwardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Add Student Award</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>

	       <form id="form" action="{{ route('addStudentAward') }}" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered" style="padding: 0px 8px 0px 16px;">
                                            {{ csrf_field() }}
          	  <div class="modal-body">
		      	 <div class="form-group">
		    	<div class="row form-group">

		        <div class="col-md-4">
		        	<label><span class="text-danger">*</span>First Name</label>
		        	<input type="text" class="form-control" name="first_name" placeholder="" required>
		        </div>
		        <div class="col-md-4">
		        	<label><span class="text-danger"></span>Middle Initial</label>
		        	<input type="text" class="form-control" maxlength="1" name="middle_i" placeholder="">
		        </div>
		         <div class="col-md-4">
		        	<label><span class="text-danger">*</span>Last Name</label>
		        	<input type="text" class="form-control" name="last_name" placeholder="" required>
		        </div>
		    </div>
		    	<div class="form-group">
		        	<label><span class="text-danger">*</span>{{$school->school_code}} Program:</label>

					<select class="form-control small" name="acad_prgram_id" >
						 <option disabled selected value> -- --  </option>
						@foreach($acad_prog as $aw)
					 	 <option value = '{{ $aw->a_id }}'> {{ $aw->acad_prog }}  </option>
					 @endforeach
					</select>
		        </div>
		        
		        <div class="row form-group">
		        	<div class= "col-md-4"> 
		        <label><span class="text-danger">*</span>Scope:</label>

					<select name="scope" class="form-control small" required>
					  <option disabled selected value> -- --  </option>
					  <option value="School">School</option>
					  <option value="Institutional">Institutional</option>
					  <option value="Local">Local</option>
					  <option value="Regional">Regional</option>
					  <option value="National">National</option>
					  <option value="International">International</option>
					</select>
					</div>
					<div class="col-md-4 form-group">
						<label><span class="text-danger">*</span>Category:</label>

					<select name="category" class="form-control small" required>
						<option disabled selected value> -- -- </option>
					  <option value="Academics">Academics</option>
					  <option value="Non-Academics">Non-Academic</option>
					</select>
					
				</div>

				<div class="col-md-4 form-group">
					<label><span class="text-danger">*</span>Participant's Classification:</label>

					<select name="classification" class="form-control small" required>
					  <option disabled selected value> -- --  </option>
					  <option value="Individual">Individual</option>
					  <option value="Group">Group</option>
					</select>
					
		        	
				</div>
                </div>

				<div class="row form-group">
					<div class="col-md-4">
		        	<label><span class="text-danger">*</span>Title of Competition</label>
		        	<input type="text" class="form-control" name="title_competitions" placeholder="" required>
					</div>
					<div class="col-md-4">
		        	<label><span class="text-danger">*</span>Award / Recognition /Achivement:</label>

					<select class="form-control small" name="award" onchange='CheckAward(this.value);'>
					  <option disabled selected value> -- --  </option>
					  <option value="First Place">First Place</option>
					  <option value="Second Place">Second Place</option>
					  <option value="First Place">Third Place</option>
					  <option value="Second Place">Fourth Place</option>
					  <option value="Champion">Champion</option>
					  <option value="1st Runner Up">1st Runner Up</option>
					  <option value="2nd Runner Up">2nd Runner Up</option>
					  <option value="3rd Runner Up">3rd Runner Up</option>
					  <option value="Gold">Gold</option>
					  <option value="Silver">Silver</option>
					  <option value="Bronze">Bronze</option>
					  <option value="Finalist">Finalist</option>
					  <option value="others2">Others</option>
					</select>
		        	
		        	<input type="text" class="form-control" id="others2" name="others2"  style='display:none;'/>
		        	</div>
		        	<div class="col-md-4">
		        	<label><span class="text-danger">*</span>Award Giving Body</label>
		        	<input type="text" class="form-control" name="award_giving_body" placeholder="" required>
		        </div>	
		        </div>
		        <div class="row form-group">
		        <div class="col-md-4 form-group">
		           <label><span class="text-danger">*</span>Venue</label>
		           <input type="text" class="form-control" name="venue" placeholder="" required>
		        </div>
		        <div class="col-md-4 form-group">
		        	<label><span class="text-danger">*</span>Date Awarded</label>
		        	<input type="date" class="form-control small" name="date" placeholder="" required>
		        </div>
		        <div class="col-md-4 form-group">
		        	<i class="fas fa-upload">Certificate</i>
		        	<input type="file" name="award_cert" class="form-control">
		        </div>
		      </div>
		      
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-info">Add Award</button>
	      	  </div>
	      	</div>
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
        <a class="btn btn-danger" href="{{route('userStudentAward')}}">Proceed to Dashboard</a>
        <button type="button" class="btn btn-info"   data-toggle="modal" 
			data-target="#addStudentAwardModal" data-dismiss="modal">Add Another Record</button>
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
        var age = Date.parse( data[8] ) || 0; 
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
      var dataTable= $('#awardtable').DataTable( {
	        "ajax": "{{route('userAward_dtb', $school->id)}}", //view
	        responsive: false,
        	"scrollX": false,
            dom: 'Blfrtip',
          lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'excelHtml5',
            ],

	        "columns": [
	            { "data": null , 
			     "render" : function ( data, type, full ) { 
			        return full['first_name']+', '+full['middle_initial']+'. '+full['last_name'];}
			      },
	            { "data": "acad_prog_code" },
	            { "data": "scope" },
	            { "data": "category" },
	            { "data": "award" },
	            { "data": "classification" },
	            { "data": "title_competitions" },
	            { "data": "award_giving_body" },
	            { "data": "date_awarded" },
	            { "data": "venue" },

	            { "data": "actions" },

	        ],
	        initComplete: function () {

            var $buttons = $('.dt-buttons').hide();
            $('.dataTables_length').show();
             $('#exportLink').on('click', function() {
                $('.buttons-excel').click(); 
             })

              this.api().columns([2,3]).every( function () {
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


		$('#from, #to').change(function () {
                dataTable.draw();
                    });
		
	
	     //delete
             $(document).on('click','.destroy',function(){
	      var conf = confirm('This record will be deleted. Continue?');
	      var id = $(this).attr('awardid');

      if(conf){
        $.ajax({
          url:"{{route('deleteAward')}}",
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
             alert('Record not deleted.');
         }

        });  
      }
    });

</script>
@endsection
