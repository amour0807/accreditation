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
       <h2><strong>{{ $program->AcadPrgrm->acad_prog }}<br>Accreditation History<span></strong></h2>
         <a class="btn btn-info float-right " data-toggle="modal" data-target="#add_status">
         Add an accreditation status
        </a>
    </div>
<div class="alert alertOld alert-danger alert-dismissible fade show alertOld" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
  
</div>
      <table id="history_table" class="table table-striped" style="width:100%">
          <thead>
            <tr>

                  <th>Accreditation Status</th>
                  <th>Visit Date</th>
                  <th>Validity</th>


                  <th>PACUCUA Certificate</th>
                  <th>FAAP Certificate</th>
                  <th>PACUCUA Report</th>

                  <th>Remarks</th>

            </tr>
          </thead>   
      </table>
<script type="text/javascript">

    $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    var token = $("input[name='_token']").val();
   
$('.alertOld').hide();


   // program table

        var dataTable= $('#history_table').DataTable( {
          "ajax": "{{route('userHistory_dtb', $program->AcadPrgrm->id)}}",
          responsive: true,
          "scrollX": true,
          "columns": [
              { "data": "accred_stat" },
              
              { "data": "visit_date" },
              { "data": "validity" },
              { "data": "cert1" },
              { "data": "cert2" },
              { "data": "cert3" },
              { "data": "remarks" },
        
          ],
          
          });


        
    $(document).on('click','.delete',function(){
      var conf = confirm('Are you sure you want to delete this record?');
      var id = $(this).attr('progid');

      if(conf){
        $.ajax({
          url:"{{route('deleteProg')}}",
          method:"POST",
          data:{
            id:id,
            _token:token
          },
          success:function(data){
            dataTable.ajax.reload();
            $('.alertOld').append('<span id="alertMessage">Record deleted!</span>');
            $('.alertOld').show();
            $(".alertOld").delay(4000).fadeOut(500);
            setTimeout(function(){
              $('#alertMessage').remove();
            }, 5000);
          },
          error: function(jqxhr, status, exception) {
             alert('Record not deleted. There seems to be a problem. Please contact the administrator to resolve the issue.');
         }

        });  
      }
    }); 

    </script>

@endsection