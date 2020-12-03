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
    <div class="block-title" style="padding: 1px 3px 1px 3px;" id="datatable_wrapper">
       <h2><strong>Student Awards<span></strong></h2>
    </div>
<form class="mb-4" action="{{route('awardfilterReport')}}" method="POST">
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
      <button class="btn btn-outline-danger btn-sm edit " type="submit"  target="_blank" title="view pdf" id="addBtn"><i class="fas fa-file-pdf"></i></button>
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
      <label >School</label>
      <div id="filters1">   
      </div>
    </div>

    <div class="col-md-4 ">
      <label>Scope</label>
      <div id="filters2">
        
      </div>
    </div>

    <div class="col-md-4 ">
      <label>Categoty</label>
      <div id="filters3">
        
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

    <table id="awardtable" class="display compact cell-border" style="table-layout: fixed; cursor: pointer;">
		    <thead>
	            <tr>
	            	<th>School</th>
	            	<th>Student's <br> Name</th>
	            	<th>Scope</th>
	            	<th>Category</th>
	            	<th>Award</th>
	            	<th>Classification</th>
	            	<th>Competition</th>
	            	<th>Award <br>Giving Body</th>
	            	<th>Date Awarded</th>
	            	<th>Venue</th>
	            </tr>
		    </thead>   
		</table>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-warning modal-lg" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header text-center">
        <h5 class="modal-title white-text w-100 font-weight-bold py-2">Student's Award</h5>
         <h6 class="modal-title white-text w-100 font-weight-bold py-2">
           <label id="name"></label><br>
           <label id="award"></label><br>
           <label id="school"></label>
         </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <div class="modal-body">
    <div class="row">
     <div class="col-md-5" style="border:thin;">
      <center>
        <img src="{{asset('certificates/blank_cert.png')}}" style="height:200;width:300px;">
      </center>
    </div>
    <div class="col-md-7">
    <div class=" row">
        <label  class="col-sm-5 col-form-label" ><b>Scope:</b></label>
        <label  class="col-sm-7 col-form-label" id="scope"></label>
    </div>
  <div class=" row">
    <label class="col-sm-5 col-form-label"><b>Category:</b></label>
    <label class="col-sm-7 col-form-label" id="category"></label>
  </div>
  <div class=" row">
    <label class="col-sm-5 col-form-label"><b>Participant's Classification:</b></label>
    <label class="col-sm-7 col-form-label" id="pc"></label>
  </div>
  <div class=" row">
    <label class="col-sm-5 col-form-label"><b>Competition:</b></label>
    <label class="col-sm-7 col-form-label" id="competition"></label>
  </div>
  <div class=" row">
    <label class="col-sm-5 col-form-label"><b>Venue:</b></label>
    <label class="col-sm-7 col-form-label" id="venue"></label>
  </div>
  <div class=" row">
    <label class="col-sm-5 col-form-label"><b>Award Giving Body:</b></label>
    <label class="col-sm-7 col-form-label" id="awardb"></label>
  </div>
  <div class=" row">
    <label class="col-sm-5 col-form-label"><b>Date:</b></label>
    <label class="col-sm-7 col-form-label" id="date"></label>
  </div>
  </div>
    </div>
  </div>
    

    </div>
    <!--/.Content-->
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
          "ajax": "{{route('award_dtb', 1)}}",
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
              { "data": "school_code" },
              { "data": null , 
           "render" : function ( data, type, full ) { 
              return full['first_name']+' '+full['middle_initial']+'. '+full['last_name'];}
            },
              { "data": "scope" },
              { "data": "category" },
              { "data": "award" },
              { "data": "classification" },
              { "data": "title_competitions" },
              { "data": "award_giving_body" },
              { "data": "date_awarded" },
              { "data": "venue" },
          ],

          initComplete: function () {
            var $buttons = $('.dt-buttons').hide();
            $('.dataTables_length').show();
             $('#exportLink').on('click', function() {
                $('.buttons-excel').click(); 
             })

              this.api().columns([0,2,3]).every( function () {
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
    
    $('#awardtable tbody').on( 'click', 'tr', function () {
        var trElem = $(this).closest("tr");// grabs the button's parent tr element
      
        var school = $(trElem).children("td")[0];
        var name = $(trElem).children("td")[1];
        var scope = $(trElem).children("td")[2];
        var category = $(trElem).children("td")[3];
        var award = $(trElem).children("td")[4];
        var classification = $(trElem).children("td")[5];
        var competition = $(trElem).children("td")[6];
        var awardb = $(trElem).children("td")[7];
        var date = $(trElem).children("td")[8];
        var venue = $(trElem).children("td")[9];

        var nm = document.getElementById('name');
        nm.innerHTML = $(name).text();
        var sc = document.getElementById('school');
        sc.innerHTML = $(school).text();
        var scp = document.getElementById('scope');
        scp.innerHTML = $(scope).text();
        var cat = document.getElementById('category');
        cat.innerHTML = $(category).text();
        var aw = document.getElementById('award');
        aw.innerHTML = $(award).text();
        var cls = document.getElementById('pc');
        cls.innerHTML = $(classification).text();
        var cmp = document.getElementById('competition');
        cmp.innerHTML = $(competition).text();
        var ab = document.getElementById('awardb');
        ab.innerHTML = $(awardb).text();
        var vn = document.getElementById('venue');
        vn.innerHTML = $(venue).text();
        var dt = document.getElementById('date');
        dt.innerHTML = $(date).text();
        $("#myModal").modal("show");

    } );

      

		$(document).on('click','.edit',function(){
          var id = $(this).attr('awardid');

          $.ajax({
            data:{
              id:id,
              _token:token
            },
            success:function(data){
              $('#awardID').val( id );
              $('#editStudentAwardModal').modal('show');
     
            }   
          });  
        });

        //Implement edit

	    $( "#edit_schooldept_form" ).submit(function( event ) {
	        event.preventDefault();
	      
	        $.ajax({
	          url:"{{route('updateSchoolDept')}}",
	          method:"POST",
	          data:$("#edit_schooldept_form").serialize(),
	          success:function(data){
	            $("#edit_schooldept_form")[0].reset();
	            $('#editDepartment').modal('hide');
	            dataTable.ajax.reload();
	            $('.alert').append('<div class="alert alert-info alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><span id="alertMessage">Record updated!</span> </div>');
	            $('.alert').show();
	            $(".alert").delay(4000).fadeOut(500);
	            setTimeout(function(){
	              $('#alertMessage').remove();
	            }, 5000);
	          }
	              
	        }); 
	    }); 
	     //delete
       $(document).on('click','.destroy',function(){
	      var conf = confirm('This record will be deleted. Continue?');
	      var id = $(this).attr('awardid');

      if(conf){
        $.ajax({
          url:"{{route('deleteSchoolDept')}}",
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
