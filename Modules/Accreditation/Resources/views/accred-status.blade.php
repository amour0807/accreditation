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
       <h2><strong>Accreditation Status<span></strong></h2>
         <a class="btn btn-info float-right " data-toggle="modal" data-target="#add_status">
         Add an accreditation status
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
<div style="width: 80%; margin-left: 10%;">
  <table id="history_table"  class="display compact cell-border" style="table-layout: fixed; width: 100%;">
    <thead>
        <tr>
      <th>Accreditation Status</th>
      <th >Actions</th>
    </tr>
  </thead>
      <tbody>
      </tbody>
    </table> 
</div>
   
<!-- Add Modal -->
<div class="modal fade" id="add_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST" id='add_status_form'>
        @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Accreditation Status</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>Status Name</label>
            <input type="text" name="accredStatus" required class="form-control">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" >Save changes</button>
          </div>
      </form>
    </div>
  </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST" id='edit_status_form'>
        @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Accreditation status</h5>
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

<script type="text/javascript">

    $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    var token = $("input[name='_token']").val();


   // program table

        var dataTable= $('#history_table').DataTable( {
          "scrollX": true,
          
          "ajax": "{{route('accred_stat_dtb')}}",
         

          "columns": [
              { "data": "accred_status" },
              { "data": "actions" },
          ],
        
        
          });
$('.alert').hide();
    //add
      $( "#add_status_form" ).submit(function( event ) {
          event.preventDefault();
        
          $.ajax({
            url:"{{route('addStatus')}}",
            method:"POST",
            data:$("#add_status_form").serialize(),
            success:function(data){
              $("#add_status_form")[0].reset();
              $('#add_status').modal('hide');
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
      
      //delete
       $(document).on('click','.destroy',function(){
        var conf = confirm('This record will be deleted. Continue?');
        var id = $(this).attr('statusid');

      if(conf){
        $.ajax({
          url:"{{route('deleteStatus')}}",
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
          var id = $(this).attr('statusid');

          $.ajax({
            url:"{{route('editStatus')}}",
            method:"POST",
            data:{
              id:id,
              _token:token
            },
            success:function(data){
              $('#editModal').modal('show');
              $('#editBody').html(data);
             
            }   
          });  
        });

        //Implement edit

      $( "#edit_status_form" ).submit(function( event ) {
          event.preventDefault();
        
          $.ajax({
            url:"{{route('updateStatus')}}",
            method:"POST",
            data:$("#edit_status_form").serialize(),
            success:function(data){
              $("#edit_status_form")[0].reset();
              $('#editModal').modal('hide');
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