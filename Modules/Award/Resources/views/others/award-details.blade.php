@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
	  <div class="x_content">
		  <div class="row">
			  <div class="col-sm-12">

 @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        @endif
@foreach($award as $aw)
<div class="x_title">
  <h2><small><a href="{{route('userStudentAward')}}" class="fa fa-angle-double-left" text="back">&nbsp;&nbsp;{{ $aw->school_name }}: {{ $aw->acad_prog_code }}</a></small></h2>
<div class="clearfix"></div>
   </div>

  <div class="row">
    <div class="col-md-5">
      @if($aw->award_cert == "")
      <img src="{{asset('certificates/blank_cert.png')}}" style="height:200;width:300px;">
      @else
       <a href="{{asset('certificates/'.$aw->award_cert)}}"> 
      <img src="{{asset('certificates/'.$aw->award_cert)}}" style="height:200;width:300px;"></a>
      @endif
    </div>
    <div class="col-md-7">
     <div class=" row">
      <center>
       
        <label style="font-size:14px;"><b>{{$aw->first_name}} 
          @if($aw->middle_initial != ""){{$aw->middle_initial}}.
          @endif
          {{$aw->last_name}}<br>
          
        {{$aw->award}}<br>
        {{$aw->title_competitions}}</b></label><br>
      </center>
    </div>
    <div class=" row">
        <label  class="col-sm-3 col-form-label">Scope:</label>
        <label  class="col-sm-7 col-form-label">{{$aw->scope}}</label>
    </div>
  <div class=" row">
    <label class="col-sm-3 col-form-label">Category:</label>
    <label class="col-sm-7 col-form-label">{{$aw->category}}</label>
  </div>
  <div class=" row">
    <label class="col-sm-3 col-form-label">Participant's Classification:</label>
    <label class="col-sm-7 col-form-label">{{$aw->classification}}</label>
  </div>
  <div class=" row">
    <label class="col-sm-3 col-form-label">Venue:</label>
    <label class="col-sm-7 col-form-label">{{$aw->venue}}</label>
  </div>
  <div class=" row">
    <label class="col-sm-3 col-form-label">Award Giving Body:</label>
    <label class="col-sm-7 col-form-label">{{$aw->award_giving_body}}</label>
  </div>
  <div class=" row">
    <label class="col-sm-3 col-form-label">Date:</label>
    <label class="col-sm-7 col-form-label">{{$aw->date_awarded}}</label>
  </div>
  </div>
   <div class=" row mt-4">
    <div class="col-sm-12">
      @if(Auth::user()->hasPermission('edit-student'))
      <a class="btn btn-info mr-2" href="{{ route('userAwardEdit', $aw->aw_id)}}">Edit</a>
      @endif
      <a class="btn btn-danger" href="{{ route('userStudentAward') }}"> Back</a>
    </div>
    </div>
  </div>
@endforeach
  
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
@if(\Session::has('success'))
<script>
Swal.fire({
  icon: 'success',
  title: 'Done!',
  text: 'Successfully updated!',
  timer: 1500
})
</script>
  @elseif(\Session::has('error'))
  <script>
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Something went wrong!',
    footer: "<a>Back</a>"
  }) 
  </script>
  @endif
@endsection