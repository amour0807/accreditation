@extends('layouts.app')
@section('content')
<<<<<<< HEAD
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
      <h2><small>Company Partners </small></h2>
      @if(Auth::user()->hasPermission('create-partner'))
      <a class="btn btn-app float-right"data-toggle="modal" data-target="#addAwardModal">
        <i class="fa fa-plus-square-o"></i> Add Partnership
      </a>
        @endif
      <div class="clearfix"></div>
=======
    <hr style="margin: 0 0 0 0;">
    <div class="block full"  style="margin-bottom: 10px;" >
    <div class="block-title" style="padding: 1px 3px 1px 3px;" id="datatable_wrapper">
       <h2><strong>Company Partners<span></strong></h2>
       <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#addAwardModal">Add Partnership</button>
        
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
<<<<<<< HEAD
  <form class="mb-4" action="#" method="POST">
=======
  <form class="mb-4" action="" method="POST">
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
    @csrf 
     <div class="row">
      <div class="col-md-8">
      </div>
     <div class="col-md-4">
      <div class="float-right">
<<<<<<< HEAD
        <button id="exportLink" class="btn btn-outline-success btn-sm edit " target="_blank" title="view excel" ><i class="fas fa-file-excel"></i></button>
=======
        <a id="exportLink" class="btn btn-outline-success btn-sm edit " target="_blank" title="view excel" ><i class="fas fa-file-excel"></i></a>
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
          <button type="submit" class="btn btn-outline-danger btn-sm edit " target="_blank" title="view pdf" id="addBtn"><i class="fas fa-file-pdf"></i></button>
      </div><br><br>
      </div>
    </div>
 <div class="row">
      <div class="col-md-6">
         <strong>Sort by:</strong>
      </div>
      <div class="col-md-6">
        <strong>Range of Validity:</strong>
      </div>
    </div>
   <div class="form-group row">
     <div class="row col">
    <div class="col-md-6 ">
<<<<<<< HEAD
      <label >Name of Partners</label>
=======
      <label >Scope</label>
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
      <div id="filters1">   
      </div>
    </div>
    <div class="col-md-6 ">
<<<<<<< HEAD
      <label >Scope</label>
=======
      <label >Classification</label>
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
      <div id="filters2">   
      </div>
>>>>>>> d471564580cde705a1746260414ac2aa14452cf2
    </div>
       
<form class="mb-4" action="{{route('partnerfilterReport')}}" target="_blank" method="POST">
  @csrf 
<div class="row">
    <div class="col-md-7">
       <strong>Sort by:</strong>
    </div>
    <div class="col-md-4">
      <strong>Range of Partnership</strong>
   </div>
  </div>
 <div class="form-group row">
   <div class="row col-md-7">
  <div class="col-md-6 ">
    <label >Name of Partner</label>
    <select name="partner1" id="partner" class="form-control" required>
      <option> All  </option>
    @foreach($partner as $a)
      <option>{{$a->company_name}} </option>
    @endforeach
  </select>
  </div>
  <div class="col-md-6 ">
    <label >Status</label>
    <select name="status1" id="status" class="form-control" required>
      <option> All  </option>
      <option>Active</option>
      <option>Inactive </option>
  </select>
  </div>
  {{-- <div class="col-md-3">
    <label >School</label>
    <select name="school" id="clarify" class="form-control" >
    <option  selected value> -- --  </option>
      @foreach($school as $sc)
      <option value="{{$sc->school_code}}"> {{$sc->school_code}} </option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3 ">
    <label >Program</label>
    <select name="school" class="form-control" >
    <option  selected value> -- --  </option>
    @foreach($program as $p)
      <option value="{{$p->acad_prog_code}}"> {{$p->acad_prog_code}} </option>
      @endforeach
    </select>
  </div> --}}
   </div>
  <div class="col-md-4 col-12">
    <div class="col-6 col-md-6">
          <label>From </label>
          <select  class="form-control" name="from" id="from">
             <option>All</option>
           </select>
    </div>
    <div class="col-6 col-md-6">
      <strong>&nbsp;</strong>
     <label>To</label>
     <select  class="form-control" name="to" id="to">
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
     <button type="submit" class="btn btn-outline-danger btn-sm edit " target="_blank" title="view pdf" id="addBtn"><i class="fa fa-file-pdf-o"></i></button>
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
			  <div class="col-sm-12">
    <!-- Table showing awards -->
    
    <div class="table-responsive">
      <table id="partner_table" class="table table-striped jambo_table action_bulk" style="width: 100%;">
           <thead>
             <tr class="headings">
                <th>Name of <br>Partner</th>
                <th>From</th>
	            	<th>To</th>
                <th>Status</th>
<<<<<<< HEAD
=======
                <th>Supporting<br>Document</th>
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
                <th>Action</th>
	            	<th>Classification</th>
                <th>Nature</th>
	            </tr>
		    </thead>   
    </table>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addAwardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Partnership</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
  
           <form id="formValidate" enctype="multipart/form-data" autocomplete="off"  class="form-horizontal form-bordered" style="padding: 0px 8px 0px 16px;">
                                              {{ csrf_field() }}
  
                                              <span class="text-danger">* Required Fields</span><br>
          <div class="modal-body">
            <div class="row form-group">
                <label><span class="text-danger">*</span>Name of Partner</label>
                <input type="text" class="form-control" name="partner" placeholder="" required>
            </div>
            <div class= "row form-group"> 
              <div class="col-md-6">
                  <label><span class="text-danger">*</span>Scope:</label>
                  <select name="scope" class="form-control" required>
                    <option disabled selected value> -- --  </option>
                    <option value="Local">Local</option>
                    <option value="National">National</option>
                    <option value="International">International</option>
                    <option value="Regional">Regional</option>
                    <option value="Institutional">Institutional</option>
                  </select>
              </div>
              <div class= "col-md-6"> 
                <label><span class="text-danger">*</span>Classification:</label>
                <select id="classification" name="classification" class="form-control" onchange='CheckClas(this.value);' required>
                  <option disabled selected value> -- --  </option>
                  <option value="Institutional">Institutional</option>
                  <option value="School">School</option>
                  <option value="Program">Program</option>
                </select>
              </div>
            </div>
<<<<<<< HEAD
            <!-- For school and Program Classification -->
            <fieldset id="schoolcon" style='display:none;'>
            <div class="row col-md-12">
              <div class="col-md-6">
                    <label>Schools</label>
                    <select id="list1" multiple="multiple" class="form-control" style="height: 150px;">
                    @foreach($school as $sc)
                        <option value="{{$sc->id}}">{{$sc->school_code}}</option>
                    @endforeach
                    </select>
                    <br>
                    <input id="button1" type="button" value="Select" class="form-control"/>
                </div>
                <div class="col-md-6">
                    <label>Selected</label>
                    <select id="list2" name="schoolc[]" multiple="multiple" style="height: 150px;"class="form-control small">
                        
                    </select>
                    <br>
                    <input id="button2" type="button" value="Remove" class="form-control"/>
=======
            <div class= "col-md-6"> 
              <label><span class="text-danger">*</span>Classification:</label>
              <select name="classification" class="form-control small" onchange='CheckClas(this.value);' required>
                <option disabled selected value> -- --  </option>
                <option value="Institutional">Institutional</option>
                <option value="School">School</option>
                <option value="Program">Program</option>
              </select>
            </div>
          </div>
          <!-- For school and Program Classification -->
          <?php
            $numOfCols = 4;
            $rowCount = 0;
            $bootstrapColWidth = 12 / $numOfCols;
          ?>
         
          <fieldset id="schoolc" style='display:none;'>
            <legend>Schools</legend>
                <div class="row">
                @foreach($school as $sc)
                <div class="col-md-<?php echo $bootstrapColWidth; ?>">
<<<<<<< HEAD
                      <input type="checkbox" id="{{$sc->id}}" name="schoolc[]" value="{{$sc->id}}">
                <label for="{{$sc->id}}"> {{$sc->school_code}}</label>
=======
                      <input type="checkbox"  name="schoolc[]" value="{{$sc->id}}">
                <label>{{$sc->school_code}}</label>
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
                </div>
                  <?php $rowCount++; ?>
                @if($rowCount % $numOfCols == 0) 
                  </div><div class="row">
                @endif
                @endforeach
              </div>
          </fieldset>
          <fieldset id="program" style='display:none;'>
            <legend>Programs</legend>
                <div class="row">
                @foreach($program as $pr)
                <div class="col-md-<?php echo $bootstrapColWidth; ?>">
<<<<<<< HEAD
                     <input type="checkbox" id="{{$pr->id}}" name="programc[]" value="{{$pr->id}}">
                    <label for="{{$pr->id}}"> {{$pr->acad_prog_code}}</label>
=======
                     <input type="checkbox"  name="programc[]" value="{{$pr->id}}">
                    <label > {{$pr->acad_prog_code}}</label>
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
>>>>>>> d471564580cde705a1746260414ac2aa14452cf2
                </div>
            </div>
            <span id="spnErrorSchool" class="error text-danger" style="display: none;">*Please select at-least one School.</span>
            </fieldset>
            <fieldset id="program" style='display:none;'>
            <div class="row col-md-12">
              <div class="col-md-6">
                  <label>Programs</label>
                  <select id="lbprogram" multiple="multiple" class="form-control" style="height: 150px;">
                  @foreach($program as $pr)
                      <option value="{{$pr->id}}">{{$pr->acad_prog_code}}</option>
                  @endforeach
                  </select>
                  <br>
                  <input id="btnprogram" type="button" value="Select" class="form-control"/>
              </div>
              <div class="col-md-6">
                  <label>Selected</label>
                  <select id="lbpselect" name="programc[]" multiple="multiple" style="height: 150px;" class="form-control small">
                      
                  </select>
                  <br>
                  <input id="btnpselect" type="button" value="Remove" class="form-control"/>
              </div>
            </div>
            <span id="spnErrorProgram" class="error text-danger" style="display: none;">*Please select at-least one Program.</span>
            </fieldset>
            
              <!--  -->
              <fieldset>
            <div class="row form-group">
              <div class="col-md-6">
                  <label><span class="text-danger">*</span>From</label>
                  <input type="date" class="form-control" id="fromVal" name="from" required>
              </div>
              <div class="col-md-6">
                  <label><span class="text-danger"></span>To</label>
                  <input type="date" class="form-control" name="to" id="toVal" placeholder="" >
                  <span id="spnErrorDate" class="error text-danger" style="display: none;">*Must be greater than the starting Date.</span>
              </div>
            </div>
          </fieldset>
            <fieldset>
              <label><span class="text-danger">*</span>Nature of Partnership</label>
            <div class="row form-group">
              <div class="col-md-6">
                  <input type="checkbox"  name="nature[]" value="Faculty Dev't" />
                     Faculty Dev't<br />
                  <input type="checkbox"  name="nature[]" value="Staff Dev't" />
                    Staff Dev't <br />
                  <input type="checkbox"  name="nature[]" value="Student Dev't" />
                      Student Dev't <br />
              </div>
              <div class="col-md-6">
                  <input type="checkbox"  name="nature[]" value="Research" />
                      Research <br />
                  <input type="checkbox"  name="nature[]" value="ECOS" />
                      ECOS <br />
                  <input type="checkbox" id="others" onclick="otherNature()"  name="nature[]" value="Others" />
                      Others <br />
              </div>
            </div>
            <div class="row form-group" id="naturegrp" style="display: none;">
              <div class="row col-md-12">
                <div class="col-md-8">
                  <label><span class="text-danger"></span>Others</label>
                  <input type="hidden" class="form-control" value="1" id="total_nature">
                  <input type="text" class="form-control removeVal" name="nature[]">
                  <span id="spnErrorOthers" class="error text-danger" style="display: none;">*Required Input.</span>
                  <div id="new_nature"></div>
                </div>
                <div class="col-md-4"><br>
                  <a onclick="add()" class=" fa fa-plus-circle" style="font-size: 20px; color:red;"></a>
                  <a onclick="remove()" class=" fa fa-minus-circle" style="font-size: 20px; color:gray;"></a>
                </div>
              </div>
            </div>
            <span id="spnError" class="error text-danger" style="display: none;">*Please select at-least one Nature of Partnership.</span>
            <br />
          </fieldset>
            <div class="row form-group">
                <label><span class="text-danger">*</span><i class="fa fa-upload"></i> Supporting Document</label>
                <input type="file" name="supporting_doc" class="form-control" required>
              </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <div id="clasValidate">
              <button type="submit" class="btn btn-info">Add Partner</button>
              </div>
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
        confirmButtonText: 'add another partner'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#addAwardModal').modal('show');
        }
      })
  </script>
  @endif
@include('common.inputVal');
<script type="text/javascript">
    var token = $("input[name='_token']").val();
    var count = 0;
    $( "#formValidate" ).submit(function( event ) {
        event.preventDefault();
        $.ajax({
                    type: 'POST',
                    url: "{{route('addPartner')}}",
                    data:$("#formValidate").serialize(),
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {
                            $("#formValidate")[0].reset();
                            $('#addAwardModal').modal('hide');
                            dataTable.ajax.reload();
                            swal.fire("Done!", results.message, "success");
                          
                        } else {
                            swal.fire("Error!", results.message, "error");
                        }
                    }
                });
    });
    $('#from').each(function() {
        var year = (new Date()).getFullYear();
        year -= 30;
        for (var i = 30; i > 0; i--) {
          
            $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
        }
        })
        $('#to').each(function() {

        var year = (new Date()).getFullYear();
        year += 4;
        year -= 30;
        for (var i = 30; i > 0; i--) {
          
            $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
        }
      }) 

      $.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
<<<<<<< HEAD
        var min = $('#from').val()
			max = $('#to').val()
			dfrom = data[1].split(' ')
			dto = data[2].split(' ');

        if ( ( isNaN( min ) && isNaN( max ) ) ||
             ( isNaN( min ) && dfrom[1] <= max ) ||
             ( min <= dfrom[2] && isNaN( max ) ) ||
             ( min <= dfrom[2] && dto[2] <= max ) )
=======
        var from = Date.parse($('#from').val());
        var to = Date.parse($('#to').val());
<<<<<<< HEAD
        var age = Date.parse( data[2] ) || 0; 
=======
        var age = Date.parse( data[5] ) || 0; 
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
        if ( ( isNaN( from ) && isNaN( to ) ) ||
             ( isNaN( from ) && age <= to ) ||
             ( from <= age   && isNaN( to ) ) ||
             ( from <= age   && age <= to ) )
>>>>>>> d471564580cde705a1746260414ac2aa14452cf2
        {
            return true;
        }else{
        	return false;
        }
        
    }
);

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var partner = $('#partner').val()
            dbtype =  data[0]
        if (partner == dbtype || partner == 'All' )
          return true;
        else
        	return false;
    }
);
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var status = $('#status').val()
            dbtype =  data[0]
        if (status == dbtype || status == 'All' )
          return true;
        else
        	return false;
    }
);
 var dataTable = $('#partner_table').DataTable( {
          "processing" : true,
<<<<<<< HEAD
=======
<<<<<<< HEAD
          "serverSide" : true,
=======
          "bSort" : false,
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
>>>>>>> d471564580cde705a1746260414ac2aa14452cf2
          "ajax": "{{route('partner_dtb')}}",
          "bSort": false,
           dom: 'Blfrtip',
          lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10', '25', '50', 'Show all' ]
        ],
          buttons: [
               {
                extend: 'excelHtml5',
                title: 'UniversityPartner'
            },
         ],

          responsive: true,
          
          "columns": [
              { "data": "company_name" },
              { "data": "from" },
              { "data": "to" },
<<<<<<< HEAD
=======
              { "data": "status" },
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
              { "data": "supporting_doc" },
              { "data": "actions" },
              { "data": "classification",
                "visible": false,
              },
              { "data": "nature",
              "visible": false,
              },
          ],
<<<<<<< HEAD
=======

          initComplete: function () {
            var $buttons = $('.dt-buttons').hide();
            $('.dataTables_length').show();
             $('#exportLink').on('click', function() {
                $('.buttons-excel').click(); 
             })

<<<<<<< HEAD
              this.api().columns([0]).every( function () {
=======
              this.api().columns([1,2]).every( function () {
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
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

>>>>>>> d471564580cde705a1746260414ac2aa14452cf2
        });

     $('#from, #to, #clarify, #status, #partner').change(function () {
                dataTable.draw();
                    });


    $(document).on('click','.destroy',function(){
	      var id = $(this).attr('partnerid');
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
          url:"{{route('deletePartner')}}",
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
