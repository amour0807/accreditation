@extends('accreditation::layouts.master')

@section('content')
<h4  class="mb-5">{{ $program->AcadPrgrm->acad_prog }}</h4>

      <table id="program_table" class="display compact table-bordered" style="width:100%">
          <thead class="thead">
            <tr>

                  <th>Accreditation Status</th>
                  <th>Visit Date</th>
                  <th>From</th>
                  <th>To</th>

                  <th>PACUCUA Certificate</th>
                  <th>FAAP Certificate</th>
                  <th>PACUCUA Report</th>
                  <th>Remarks</th>

                  <th>Actions</th>

            </tr>
          </thead>   
      </table>


@endsection