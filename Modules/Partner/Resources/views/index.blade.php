@extends('layouts.app')
@section('content')
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

  <form class="mb-4" action="{{route('partnerfilterReport')}}" method="POST">
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
      <div class="col-md-7">
         <strong>Sort by:</strong>
      </div>
      <div class="col-md-5">
        <strong>Range of Award:</strong>
      </div>
    </div>
   <div class="form-group row">
     <div class="row col-md-7">
    <div class="col-md-3 ">
      <label >Name of Partner</label>
      <div id="filters1">   
      </div>
    </div>
    <div class="col-md-3 ">
      <label >Status</label>
      <div id="filters2">   
      </div>
    </div>
    <div class="col-md-3">
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
    </div>
    </div>
  <div class="row col-md-5">
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
    <table id="partner_table" class="display compact cell-border" style="table-layout: fixed">
		    <thead>
	            <tr>
                <th>Name of <br>Partner</th>
                <th>From</th>
	            	<th>To</th>
                <th>Status</th>
                <th>Supporting<br>Document</th>
                <th>Action</th>
	            	<th>Classification</th>
                <th>Nature</th>
	            </tr>
		    </thead>   
		</table>
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
  
           <form id="form" action="{{route('addPartner')}}" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered" style="padding: 0px 8px 0px 16px;">
                                              {{ csrf_field() }}
  
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
                    <option value="Regional">Regional</option>
                    <option value="National">National</option>
                    <option value="International">International</option>
                  </select>
              </div>
              <div class= "col-md-6"> 
                <label><span class="text-danger">*</span>Classification:</label>
                <select name="classification" class="form-control" onchange='CheckClas(this.value);' required>
                  <option disabled selected value> -- --  </option>
                  <option value="Institutional">Institutional</option>
                  <option value="School">School</option>
                  <option value="Program">Program</option>
                </select>
              </div>
            </div>
            <!-- For school and Program Classification -->
            <fieldset id="schoolcon" style='display:none;'>
            <div class="row col-md-12">
              <div class="col-md-6">
                    <label>Schools</label>
                    <select id="list1" multiple="multiple" rows=2 class="form-control">
                    @foreach($school as $sc)
                        <option value="{{$sc->id}}">{{$sc->school_code}}</option>
                    @endforeach
                    </select>
                    <br>
                    <input id="button1" type="button" value="Select" class="form-control"/>
                </div>
                <div class="col-md-6">
                    <label>Selected</label>
                    <select id="list2" name="schoolc[]" multiple="multiple" rows=2 class="form-control small">
                        
                    </select>
                    <br>
                    <input id="button2" type="button" value="Remove" class="form-control"/>
                </div>
            </div>
            </fieldset>
            <fieldset id="program" style='display:none;'>
            <div class="row col-md-12">
              <div class="col-md-6">
                  <label>Programs</label>
                  <select id="lbprogram" multiple="multiple" rows=2 class="form-control">
                  @foreach($program as $pr)
                      <option value="{{$pr->id}}">{{$pr->acad_prog_code}}</option>
                  @endforeach
                  </select>
                  <br>
                  <input id="btnprogram" type="button" value="Select" class="form-control"/>
              </div>
              <div class="col-md-6">
                  <label>Selected</label>
                  <select id="lbpselect" name="programc[]" multiple="multiple" rows=2 class="form-control small">
                      
                  </select>
                  <br>
                  <input id="btnpselect" type="button" value="Remove" class="form-control"/>
              </div>
            </div>
            </fieldset>
            
              <!--  -->
            <div class="row form-group">
              <div class="col-md-6">
                  <label><span class="text-danger">*</span>From</label>
                  <input type="date" class="form-control" name="from" placeholder="" >
              </div>
              <div class="col-md-6">
                  <label><span class="text-danger"></span>To</label>
                  <input type="date" class="form-control" name="to" placeholder="" >
              </div>
            </div>
            <div class="row form-group">
              <legend>Nature of Partnership</legend>
                  <div class="col-md-2">
                  <input type="checkbox"  name="nature[]" value="Faculty Dev't">
                      <label >Faculty Dev't</label>
                </div>
                <div class="col-md-2">
                  <input type="checkbox"  name="nature[]" value="Staff Dev't">
                      <label >Staff Dev't</label>
                </div>
                <div class="col-md-2">
                  <input type="checkbox"  name="nature[]" value="Student Dev't">
                      <label >Student Dev't</label>
                </div>
                <div class="col-md-2">
                  <input type="checkbox"  name="nature[]" value="Research">
                      <label >Research</label>
                </div>
                <div class="col-md-2">
                  <input type="checkbox"  name="nature[]" value="ECOS">
                      <label >ECOS</label>
                </div>
                <div class="col-md-2">
                  <input type="checkbox" id="others" onclick="otherNature()"  name="nature[]" value="Others">
                      <label >Others</label>
                </div>
            </div>
            <div class="row form-group" id="naturegrp" style="display: none;">
              <div class="row col-md-12">
                <div class="col-md-8">
                  <label><span class="text-danger"></span>Others</label>
                  <input type="hidden" class="form-control" value="1" id="total_nature">
                  <input type="text" class="form-control" name="nature[]">
                  <div id="new_nature"></div>
                </div>
                <div class="col-md-4"><br>
                  <a onclick="add()" class=" mdi mdi-plus-circle" style="font-size: 20px; color:red;"></a>
                  <a onclick="remove()" class=" mdi mdi-minus-circle" style="font-size: 20px; color:gray;"></a>
                </div>
              </div>
            </div>
            </div>
            <div class="row form-group">
                <i class="fas fa-upload">Supporting Document</i>
                <input type="file" name="supporting_doc" class="form-control" required>
              </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-info">Add Partner</button>
              
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

$(function(){
    $("#button1").click(function(){
        $("#list1 > option:selected").each(function(){
            $(this).remove().appendTo("#list2");
        });
    });
    
    $("#button2").click(function(){
        $("#list2 > option:selected").each(function(){
            $(this).remove().appendTo("#list1");
        });
    });
    $("#btnprogram").click(function(){
        $("#lbprogram > option:selected").each(function(){
            $(this).remove().appendTo("#lbpselect");
        });
    });
    
    $("#btnpselect").click(function(){
        $("#lbpselect > option:selected").each(function(){
            $(this).remove().appendTo("#lbprogram");
        });
    });
});
 var dataTable = $('#partner_table').DataTable( {
          "processing" : true,
          "ajax": "{{route('partner_dtb')}}",
          "bSort": false,
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
              { "data": "company_name" },
              { "data": "from" },
              { "data": "to" },
              { "data": "status" },
              { "data": "supporting_doc" },
              { "data": "actions" },
              { "data": "classification"
              },
              { "data": "nature"
              },
          ],

          initComplete: function () {
            var $buttons = $('.dt-buttons').hide();
            $('.dataTables_length').show();
             $('#exportLink').on('click', function() {
                $('.buttons-excel').click(); 
             })

              this.api().columns([0,3]).every( function () {
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

     $('#from, #to, #clarify').change(function () {
                dataTable.draw();
                    });

  function CheckClas(val){
     var school=document.getElementById('schoolcon');
     var program=document.getElementById('program');
     if(val=='School'){
       school.style.display='block';
       program.style.display='none';
     }else if (val=='Program'){
       program.style.display='block';
       school.style.display='none';
      }else{
        school.style.display='none';
        program.style.display='none';
      }
    }
    function otherNature() {
      var checkBox = document.getElementById("others");
      // Get the output text
      var grp = document.getElementById("naturegrp");

      // If the checkbox is checked, display the output text
      if (checkBox.checked == true){
        grp.style.display = "block";
      } else {
        grp.style.display = "none";
      }
    }
    function add(){
          var new_nature_no = parseInt($('#total_nature').val())+1;
          var new_nature="<input type='text' class='form-control' name='nature[]' id='nature_"+new_nature_no+"'>";
          
          $('#new_nature').append(new_nature);
          $('#total_nature').val(new_nature_no);
        }
    function remove(){
          var last_nature_no = $('#total_nature').val();
          if(last_nature_no>1){
            $('#nature_'+last_nature_no).remove();
            $('#total_nature').val(last_nature_no-1);
          }
    }
    $(document).on('click','.destroy',function(){
	      var conf = confirm('This record will be deleted. Continue?');
	      var id = $(this).attr('partnerid');

      if(conf){
        $.ajax({
          url:"{{route('deletePartner')}}",
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
