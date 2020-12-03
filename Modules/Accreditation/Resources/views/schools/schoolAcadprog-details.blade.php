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
       <h2><strong>{{$school->school_name}} <br> Academic Programs<span></strong></h2>
        <a class="btn btn-info float-right " data-toggle="modal" data-target="#add_acadProg">
      Add Academic Program
    </a>
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

<table id="schoolAcadprog_table" class="table table-striped" style="width:100%"> 
  <thead>
    <tr>
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
              <input type="text" class="form-control" name="school_id" required class="form-control" value="{{$school->school_name}}"disabled>
        </div>

      <input type="textbox" id="school_id" name="school_id" value="{{$school->id}}" hidden />
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
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" >Save</button>
          </div>
      </form>
    </div>
  </div>
</div>
  <script type="text/javascript">
 $('.alert').hide();
    $( "#add_acadProg_form" ).submit(function( event ) {
          event.preventDefault();
        
          $.ajax({
            url:"{{route('useraddAcadProg')}}",
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

 $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    var token = $("input[name='_token']").val();

   // program table
  var dataTable= $('#schoolAcadprog_table').DataTable( {
          "ajax": "{{route('userAcadprog_dtb', $school->id)}}", //view
          responsive: true,
          "scrollX": true,
          

          "columns": [
              { "data": "acad_prog_code" },
              { "data": "acad_prog" },

              { "data": "actions" },

          ],

    
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