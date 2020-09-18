@extends('accreditation::layouts.master')

@section('content')
<h4  class="mb-4">{{ $program->AcadPrgrm->acad_prog }} - {{ $program->AcadPrgrm->School->school_code }}</h4>
<hr>
<form>
  <div class="form-group row">
    <label  class="col-sm-2 col-form-label">Accreditation Status</label>
    <div class="col-sm-4">
      <select class="form-control">
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
    <label class="col-sm-2 col-form-label">Visit Date From</label>
    <div class="col-sm-4">
      <input type="date" class="form-control" value="{{$program->visit_date_from}}">
    </div>

    <label class="col-sm-2 col-form-label">Visit Date To</label>
    <div class="col-sm-4">
      <input type="date" class="form-control" value="{{$program->visit_date_to}}">
    </div>
  </div>

   <div class="form-group row mb-4">
    <label class="col-sm-2 col-form-label">Valid From</label>
    <div class="col-sm-4">
      <input type="date" class="form-control" value="{{$program->from}}">
    </div>

    <label class="col-sm-2 col-form-label">Valid To</label>
    <div class="col-sm-4">
      <input type="date" class="form-control" value="{{$program->to}}">
    </div>
  </div>
	<hr>
   <div class="form-group row mt-4">
   		<label class="col-sm-2 col-form-label">FAAP Certificate</label>
	    <div class="col-sm-4">
	      <input type="file" name="" class="form-control">
	    </div>
   </div>
   <div class="form-group row">
   		<label class="col-sm-2 col-form-label">PACOCUA Certificate</label>
	    <div class="col-sm-4">
	      <input type="file" name="" class="form-control">
	    </div>
   </div><div class="form-group row">
   		<label class="col-sm-2 col-form-label">PACOCUA Report</label>
	    <div class="col-sm-4">
	      <input type="file" name="" class="form-control">
	    </div>
   </div>
 
  <div class="form-group row mt-4">
    <div class="col-sm-10">
      <button type="submit" class="btn bg-ub-red">Save Changes</button>
      <a class="btn btn-secondary" href="{{ route('accredDetails', $program->id) }}"> Back</a>
    </div>
  </div>
</form>
@endsection