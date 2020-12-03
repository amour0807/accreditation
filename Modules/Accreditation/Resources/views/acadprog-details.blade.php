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
       <h2><strong>Academic Programs<span></strong></h2>
         <a class="btn btn btn-info float-right " data-toggle="modal" data-target="#add_acadProg">
       Add Academic Program
    </a>
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

<form class="mb-4" action="{{route('filterReport')}}" method="POST">
@csrf 
<!-- checking for the controller if to include current->yes -->
<input type="hidden" name="reportType" value="notHistory">

  <div class="form-group row">
    <div class="col-md-1"> <strong>Sort by:</strong>
      <label >School</label></div>
    <div class="col-md-3 ">
      <div id="filters1">
      </div>
    </div>
  </div>
</form>
<hr>

      <table id="acadprogram_table"  class="display compact cell-border" style="width:100%">
        <thead class="thead">
              <tr>
                <th>School</th>
                <th>Program Code</th>
                <th>Program Description</th>
                <th>Action</th>
              </tr>
        </thead>   
    </table>

    <div class="modal fade" id="editAcadProg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST" id='edit_acadprog_form'>
        @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Academic Program</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="editBody">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" >Save changes</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade " id="add_acadProg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST" id='add_acadProg_form' runat="server">
        @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Academic Program</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
            <label><span class="text-danger">*</span>Department:</label>
              <select id="mydropbox" class="form-control" onchange="copyValue()">
                <option disabled selected value> -- --  </option>
            @foreach($school as $sc)
            <option value="{{$sc->id}}">{{$sc->school_name}}</option>
            @endforeach
          </select>
        </div>

      <input type="textbox" id="school_id" name="school_id" hidden />
            <div class="form-group">
              <label>Program Code</label>
            <input type="text" class="form-control" name="acad_prog_code" required class="form-control">
            </div>

            <div class="form-group">
              <label>Program Description</label>
            <input type="text" class="form-control" name="acad_prog" required class="form-control">
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" >Save</button>
          </div>
      </form>
    </div>
  </div>
</div>

  <script type="text/javascript">
 $('.alert').hide();
    //add
      $( "#add_acadProg_form" ).submit(function( event ) {
          event.preventDefault();
        
          $.ajax({
            url:"{{route('addAcadProg')}}",
            method:"POST",
            data:$("#add_acadProg_form").serialize(),
            success:function(data){
              $("#add_acadProg_form")[0].reset();
              $('#add_acadProg').modal('hide');
              dataTable.ajax.reload();
              $('.alert').append('<div class="alert alert-success alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><span id="alertMessage">Record added!</span> </div>');
              $('.alert').show();
              $(".alert").delay(4000).fadeOut(500);
              setTimeout(function(){
                $('#alertMessage').remove();
              }, 5000);
            }
                
          }); 
      }); 
function copyValue(){

   var dropboxvalue = document.getElementById('mydropbox').value;
   document.getElementById('school_id').value = dropboxvalue;

}

     $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    var token = $("input[name='_token']").val();

   var count = 0;


   // program table

        var dataTable= $('#acadprogram_table').DataTable( {
          "scrollX": true,
          "ajax": "{{route('acadprogram_dtb')}}",
          responsive: true,

          "columns": [
              { "data": "school_code"},
              { "data": "acad_prog_code" },
              { "data": "acad_prog"},
              { "data": "actions"},
          ],

          initComplete: function () {
              this.api().columns([0,2]).every( function () {
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
      
      //delete
       $(document).on('click','.destroy',function(){
        var conf = confirm('This record will be deleted. Continue?');
        var id = $(this).attr('programid');

      if(conf){
        $.ajax({
          url:"{{route('deleteAcadProg')}}",
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

       //show edit form
      $(document).on('click','.edit',function(){
          var id = $(this).attr('programid');

          $.ajax({
            url:"{{route('editAcadProg')}}",
            method:"POST",
            data:{
              id:id,
              _token:token
            },
            success:function(data){
              $('#editAcadProg').modal('show');
              $('#editBody').html(data);
             
            }   
          });  
        });

        //Implement edit
      $( "#edit_acadprog_form" ).submit(function( event ) {
          event.preventDefault();
        
          $.ajax({
            url:"{{route('updateAcadProg')}}",
            method:"POST",
            data:$("#edit_acadprog_form").serialize(),
            success:function(data){
              $("#edit_acadprog_form")[0].reset();
              $('#editAcadProg').modal('hide');
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
     
      

    </script>

@endsection