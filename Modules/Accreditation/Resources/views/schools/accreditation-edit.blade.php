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
       <h2><strong>{{ $program->AcadPrgrm->acad_prog }} - {{ $program->AcadPrgrm->School->school_code }}<span></strong></h2>
    </div>

<form method="POST" action="{{ route('userSaveEdit') }}">
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
      <button type="submit" class="btn btn-success">Save Changes</button>
      <a class="btn btn-danger" href="{{ route('userAccredDetails', $program->id) }}"> Back</a>
    </div>
  </div>
</form>
@endsection