@extends('accreditation::layouts.master')

@section('content')
<div class="alert alertOld alert-info alert-dismissible fade show alertOld" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
  
</div>  
<h2 >{{ $program->AcadPrgrm->acad_prog }}</h2>
<h4  class="mb-3">Accreditation History</h4>

  <hr>
      <table id="history_table" class="display compact table-bordered" style="width:100%">
          <thead class="thead">
            <tr>

                  <th>Accreditation Status</th>
                  <th>Visit Date</th>
                  <th>Validity</th>


                  <th>PACUCUA Certificate</th>
                  <th>FAAP Certificate</th>
                  <th>PACUCUA Report</th>

                  <th>Remarks</th>

                  <th>Actions</th>

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
          "ajax": "{{route('history_dtb', $program->AcadPrgrm->id)}}",
          responsive: true,

          "columns": [
              { "data": "accred_stat" },
              
              { "data": "visit_date" },
              { "data": "validity" },
              { "data": "cert1" },
              { "data": "cert2" },
              { "data": "cert3" },
              { "data": "remarks" },
              { "data": "actions" },
          ],
          "columnDefs": [
          { "width": '50pt', "targets": 7 }
        ]
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