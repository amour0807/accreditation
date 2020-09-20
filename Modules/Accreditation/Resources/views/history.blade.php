@extends('accreditation::layouts.master')

@section('content')
<h4  class="mb-5">{{ $program->AcadPrgrm->acad_prog }}</h4>

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

    </script>

@endsection