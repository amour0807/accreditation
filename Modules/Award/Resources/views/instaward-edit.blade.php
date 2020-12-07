@extends('layouts.app')
@section('content')

    <hr style="margin: 0 0 0 0;">
    <div class="block full"  style="margin-bottom: 10px;" >
    <div class="block-title" style="padding: 1px 3px 1px 3px;">
       <h2><strong><span></strong></h2>
         
    </div>
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
@foreach($instAward as $ia)

 <form id="form" action="{{route('updateInstAward')}}" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered">
                                            {{ csrf_field() }}
<input type="text" class="form-control" name="awardID" value="{{$ia->id}}" hidden>
<div class="col-md-12" style="float: center;">
  <div class="row">
    <div class="col-md-5">
      @if($ia->supporting_doc == "")
      <div > No Supporting Document</div>
      @else
      <a href="{{asset('certificates/'.$ia->supporting_doc)}}"> 
      <img src="{{asset('certificates/'.$ia->supporting_doc)}}" style="height:200;width:300px;"></a>
       <a class="btn btn-danger deleteDocu" fileId="{{$ia->id}}" style="color: white">Remove Document</a> <br>
      
      @endif
      <div class="form-group">
              <i class="fas fa-upload">Supporting Document</i>
              <input type="text"  id="award_cert" name="award_cert" class="form-control" value="{{$ia->supporting_doc}}" hidden>
              <input type="file"  id="award_cert_file" name="award_cert_file" class="form-control" onchange="ViewSave('award_cert_file');"><br>
              <div style="display:inline-block; vertical-align: middle;">
               <button type="submit" id="saveimage" class="btn btn-primary" hidden>Save Document</button>
               
             </div>
            </div>
     </div>
    <div class="col-md-7">
        <div class="row form-group">
              <label><span class="text-danger">*</span>Title of Award</label>
              <input type="text" class="form-control" name="award" value="{{$ia->award}}" required>
          </div>
          <div class="row form-group">
            <div class="col-md-6">
                <label><span class="text-danger"></span>From</label>
                <input type="date" class="form-control" name="from" value="{{$ia->from}}" >
            </div>
            <div class="col-md-6">
                <label><span class="text-danger"></span>To</label>
                <input type="date" class="form-control" name="to"  value="{{$ia->to}}" >
            </div>
          </div>
          <div class="row form-group">
              <label><span class="text-danger"></span>Venue</label>
              <input type="text" class="form-control" name="venue"  value="{{$ia->venue}}" >
          </div>
          <div class="row form-group">
              <label><span class="text-danger">*</span>Award Giving Body</label>
              <input type="text" class="form-control" name="award_gb"  value="{{$ia->award_giving_body}}" required>
          </div>
   <div class=" row mt-4">
    <div class="col-sm-12">
      <button type="submit" id="save" class="btn btn-primary" >Save Changes</button>
      <a class="btn btn-danger" href="{{ route('instAward') }}"> Back</a>
    </div>
    </div>
  </div>
  </div>
   </div>
 </form>

@endforeach
  <hr>

<script type="text/javascript">


    $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    var token = $("input[name='_token']").val();

  function CheckAward(val){
   var element=document.getElementById('others1');
   var element2=document.getElementById('others2');
   if(val=='others')
     element.style.display='block';
   else
     element.style.display='none';

  if(val=='others2')
     element2.style.display='block';
   else 
    element2.style.display='none';
    
  }

  function ViewSave(val){
   if(val !='' || val !='No file chosen')
    document.getElementById("saveimage").hidden = false;
  }
  

    $(".alertOld").delay(4000).fadeOut(500);
    setTimeout(function(){
      $('#alertMessage').remove();
    }, 5000);
  //delete
  $(document).on('click','.deleteDocu',function(){
      var conf = confirm('Are you sure you want to delete this record?');
      var fileId = $(this).attr('fileId');
      if(conf){
        $.ajax({
          url:"{{route('deleteDocu')}}",
          method:"POST",
          data:{
            fileId:fileId,
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