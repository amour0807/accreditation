@extends('layouts.app')
@section('content')
    <hr style="margin: 0 0 0 0;">
    <div class="block full"  style="margin-bottom: 10px;" >
@if(Session::has('message'))
<div class="alert alertOld alert-info alert-dismissible fade show alertOld" role="alert">
  {{ Session::get('message') }}
            <button type="button" class="close" data-dismiss="alert">×</button>
</div> 
@endif
@if(Session::has('red'))
  
<div class="alert alertOld alert-danger alert-dismissible fade show alertOld" role="alert">
  {{ Session::get('red') }}
            <button type="button" class="close" data-dismiss="alert">×</button>
</div> 

@endif

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

@if (session('success'))
     <div class="alert alert-info alert-block">
            <strong>{{ session('success') }}</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
     
@endif
@foreach($award as $aw)
 <div class="block-title" style="padding: 1px 3px 1px 3px;">
<h4  class="mb-3">{{ $aw->school_name }}</h4>
<h5  class="mb-3">{{ $aw->acad_prog_code }}</h5>
   </div>

  <div class="row">
    <div class="col-md-5">
      @if($aw->award_cert == "")
      <img src="{{asset('certificates/blank_cert.png')}}" style="height:200;width:300px;">
      @else
      <img src="{{asset('certificates/'.$aw->award_cert)}}" style="height:200;width:300px;">
      @endif
    </div>
    <div class="col-md-7">
     <div class=" row">
      <center>
        <label style="font-size:14px;"><b>{{$aw->first_name}}, {{$aw->middle_initial}}, {{$aw->last_name}}<br>
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
      <a class="btn btn-info mr-2" href="{{ route('userAwardEdit', $aw->aw_id)}}">Edit</a>
      <a class="btn btn-danger" href="{{ route('userStudentAward') }}"> Back</a>
    </div>
    </div>
  </div>
@endforeach
  <hr>

<script type="text/javascript">


    $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    var token = $("input[name='_token']").val();


  

    $(".alertOld").delay(4000).fadeOut(500);
    setTimeout(function(){
      $('#alertMessage').remove();
    }, 5000);
  //delete
  $(document).on('click','.deleteCert',function(){
      var conf = confirm('Are you sure you want to delete this record?');
      var fileId = $(this).attr('fileId');
      var type = $(this).attr('type');


      if(conf){
        $.ajax({
          url:"{{route('userDeleteCert')}}",
          method:"POST",
          data:{
            fileId:fileId,
            type:type,
            _token:token
          },
          success:function(data){
          
            location.reload();
            $('.deleteAlert').append('<span id="alertMessage">Record deleted!</span>');
            
          },
          error: function(jqxhr, status, exception) {
             alert('this record still has a task. Please delete it all then delete this project.');
         }

        });  
      }
    }); 
</script>
@endsection