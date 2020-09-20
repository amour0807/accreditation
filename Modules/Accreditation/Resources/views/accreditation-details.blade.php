@extends('accreditation::layouts.master')

@section('content')
<h4  class="mb-3">{{ $program->AcadPrgrm->acad_prog }} - {{ $program->AcadPrgrm->School->school_code }}</h4>


<div class="col-md-6 card mt-4 p-4 rounded" >
  <div class=" row">
    <label  class="col-sm-5 col-form-label">Accreditation Status:</label>
    <label  class="col-sm-7 col-form-label">{{$program->AccredStat->accred_status}}</label>
    
  </div>
  <div class=" row">
    <label class="col-sm-5 col-form-label">Visit Date From:</label>
    <label class="col-sm-7 col-form-label">{{$program->visit_date_from.' - '.$program->visit_date_to}}</label>
  </div>
<!--   <div class="row"> 
  	
    <label class="col-sm-2 col-form-label">Visit Date To:</label>
    <label class="col-sm-2 col-form-label">Visit Date to</label>
  </div> -->

   <div class=" row ">
    <label class="col-sm-5 col-form-label">Valid From:</label>
    <label class="col-sm-7 col-form-label">{{$program->from.' - '.$program->to}}</label>
   
   </div>

   <div class=" row ">
    <label class="col-sm-5 col-form-label">Remarks:</label>
    <div class="col-sm-7">
      <textarea class="form-control form-control-sm" id="remarks" rows="4" name="remarks" disabled="">{{$program->remarks}}</textarea>
    </div>
    
   </div>
    
<!--   <div class="row mb-4">
  	<label class="col-sm-2 col-form-label">Valid To:</label>
    <label class="col-sm-2 col-form-label">Valid To</label>
  </div> -->
	<hr>
  @if($program->faap_cert)
   <div class=" row mt-3">
   		<label class="col-sm-5 col-form-label">FAAP Certificate</label>
   		<label class="col-sm-7 col-form-label">
   			<a href="{{asset('uploads/'.$program->faap_cert)}}">View Certificate</a>
   		</label>
	    
   </div>
   @endif
   @if($program->pacucoa_cert)
   <div class=" row">
   		<label class="col-sm-5 col-form-label">PACOCUA Certificate</label>
   		<label class="col-sm-7 col-form-label">
   			<a href="{{asset('uploads/'.$program->pacucoa_cert)}}">View Certificate</a>
   		</label>
	    
   </div>
   @endif
   @if($program->pacucoa_report)
   <div class=" row">
   		<label class="col-sm-5 col-form-label">PACUCOA Report</label>
   		<label class="col-sm-7 col-form-label">
   			<a href="{{asset('uploads/'.$program->pacucoa_report)}}">View Report</a>
   		</label>
	    
   </div>
   @endif
   <div class=" row mt-4">
    <div class="col-sm-12">
      <a class="btn bg-ub-red mr-2" href="{{ route('accredEdit', $program->id)}}">Edit</a>
      <a class="btn btn-secondary" href="{{ route('accredited_programs', $program->AcadPrgrm->school_id) }}"> Back</a>
  	</div>
   </div>
</div>
  

@endsection