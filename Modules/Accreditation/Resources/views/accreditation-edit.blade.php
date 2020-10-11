@extends('accreditation::layouts.master')

@section('content')




<h2  class="mb-4">{{ $program->AcadPrgrm->acad_prog }} - {{ $program->AcadPrgrm->School->school_code }}</h2>
<hr>
<form method="POST" action="{{ route('saveEdit') }}">
  @csrf
  <div class="form-group row">
    <label  class="col-sm-2 col-form-label"><span class="text-danger">*</span>Accreditation Status</label>
    <div class="col-sm-4">
      <input type="hidden" name="id" value="{{$program->id}}">
      <select class="form-control" required name="accredStat">
      	@foreach($accredStats as $accredStat)
          @if ($accredStat->id == $program->accred_stat_id)
            <option value="{{$accredStat->id}}" selected>{{$accredStat->accred_status}}</option>
          @else
            <option value="{{$accredStat->id}}">{{$accredStat->accred_status}}</option>
          @endif
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label"><span class="text-danger">*</span>Visit Date From</label>
    <div class="col-sm-4">
      <input type="date" class="form-control" value="{{$program->visit_date_from}}" required name="visitFrom">
    </div>

    <label class="col-sm-2 col-form-label">Visit Date To</label>
    <div class="col-sm-4">
      <input type="date" class="form-control" value="{{$program->visit_date_to}}"  name="visitTo">
    </div>
  </div>

   <div class="form-group row mb-4">
    <label class="col-sm-2 col-form-label"><span class="text-danger">*</span>Valid From</label>
    <div class="col-sm-4">
      <input type="date" class="form-control" value="{{$program->from}}" required name="validFrom">
    </div>

    <label class="col-sm-2 col-form-label"><span class="text-danger">*</span>Valid To</label>
    <div class="col-sm-4">
      <input type="date" class="form-control" value="{{$program->to}}" required name="validTo">
    </div>
  </div>

  <div class=" row ">
    <label class="col-sm-2 col-form-label">Remarks:</label>
    <div class="col-sm-4">
      <textarea class="form-control form-control-sm" id="remarks" rows="4" name="remarks">{{$program->remarks}}</textarea>
    </div>
    
   </div>
	<hr>
    
  <div class="form-group row mt-4">
    <div class="col-sm-10">
      <button type="submit" class="btn bg-ub-red">Save Changes</button>
      <a class="btn btn-secondary" href="{{ route('accredDetails', $program->id) }}"> Back</a>
    </div>
  </div>
</form>
@endsection