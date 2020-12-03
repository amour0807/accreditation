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
@foreach($award as $aw)

 <form id="form" action="{{ route('updateStudentAward') }}" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered">
                                            {{ csrf_field() }}
<div class="col-md-10" style="float: center;">
  <div class="row">
    <div class="col-md-5">
      @if($aw->award_cert == "" || $aw->award_cert == 'blank_cert.png')
      <img src="{{asset('certificates/blank_cert.png')}}" style="height:200;width:300px;"><br>
      @else
      <a href="{{asset('certificates/'.$aw->award_cert)}}"> 
      <img src="{{asset('certificates/'.$aw->award_cert)}}" style="height:200;width:300px;"></a>
       <a class="btn btn-danger deleteCertAward" fileId="{{$aw->aw_id}}" style="color: white">Remove Certificate</a> <br>
      
      @endif
      <div class="form-group">
              <i class="fas fa-upload">Certificate</i>
              <input type="text"  id="award_cert" name="award_cert" class="form-control" value="{{$aw->award_cert}}" hidden>
              <input type="file"  id="award_cert_file" name="award_cert_file" class="form-control" onchange="ViewSave('award_cert_file');"><br>
              <div style="display:inline-block; vertical-align: middle;">
               <button type="submit" id="saveimage" class="btn btn-primary" hidden>Save Image</button>
               
             </div>
            </div>
     </div>
    <div class="col-md-7">
     <div class=" row">
        <div class="row form-group">
            <div class="col-md-4">
              <label><span class="text-danger">*</span>First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name2" value="{{$aw->first_name}}" required>
            </div>
            <div class="col-md-4">
              <label><span class="text-danger"></span>Middle Initial</label>
              <input type="text" class="form-control" maxlength="1" id="middle_i" name="middle_i2" value="{{$aw->middle_initial}}" required >
            </div>
             <div class="col-md-4">
              <label><span class="text-danger">*</span>Last Name</label>
              <input type="text" class="form-control" id="last_name" name="last_name2" value="{{$aw->last_name}}"  required>
            </div>
        </div>
    </div>
    <div class="row">
          <label><span class="text-danger">*</span>{{$school->school_code}} Program:</label>
          <input type="text" class="form-control small" id="awardID" name="awardID" value="{{$aw->aw_id}}" hidden/>
          <select class="form-control small" id="acad_prgram_id" name="acad_prgram_id2" >
            @foreach($acad_prog as $ap)
              @if($ap->a_id == $aw->aw_id)
              <option value = '{{ $ap->a_id }}' selected> {{ $ap->acad_prog }}  </option>
              @else
             <option value = '{{ $ap->a_id }}'> {{ $ap->acad_prog }}  </option>
             @endif
           @endforeach
          </select>
    </div>
    <div class="row">
      <label><span class="text-danger">*</span>Award / Recognition /Achivement:</label>
      <select class="form-control small" id="achievement" name="award2" onchange='CheckAward(this.value);' >
            <option value="First Place" <?=$aw->scope == 'First Place' ? ' selected="selected"' : '';?>>First Place</option>
            <option value="Second Place" <?=$aw->scope == 'Second Place' ? ' selected="selected"' : '';?>>Second Place</option>
            <option value="Third Place" <?=$aw->scope == 'Third Place' ? ' selected="selected"' : '';?>>Third Place</option>
            <option value="Fourth Place" <?=$aw->scope == 'Fourth Place' ? ' selected="selected"' : '';?>>Fourth Place</option>
            <option value="Champion" <?=$aw->scope == 'Champion' ? ' selected="selected"' : '';?>>Champion</option>
            <option value="1st Runner Up" <?=$aw->scope == '1st Runner Up' ? ' selected="selected"' : '';?>>1st Runner Up</option>
            <option value="2nd Runner Up" <?=$aw->scope == '2nd Runner Up' ? ' selected="selected"' : '';?>>2nd Runner Up</option>
            <option value="3rd Runner Up" <?=$aw->scope == '3rd Runner Up' ? ' selected="selected"' : '';?>>3rd Runner Up</option>
            <option value="Gold" <?=$aw->scope == 'Gold' ? ' selected="selected"' : '';?>>Gold</option>
            <option value="Silver" <?=$aw->scope == 'Silver' ? ' selected="selected"' : '';?>>Silver</option>
            <option value="Bronze" <?=$aw->scope == 'Bronze' ? ' selected="selected"' : '';?>>Bronze</option>
            <option value="Finalist" <?=$aw->scope == 'Finalist' ? ' selected="selected"' : '';?>>Finalist</option>
            <option value="others" <?=$aw->scope == 'others' ? ' selected="selected"' : '';?>>Others</option>
          </select><br>
              
              <input type="text" class="form-control" id="others1" name="others1"  style='display:none;'/>
    </div>
    <div class="row">
      <label><span class="text-danger">*</span>Title of Competition</label>
              <input type="text" class="form-control" id="titlec" name="title_competitions2"  required value="{{$aw->title_competitions}}">
    </div><br>
    <div class=" row">
        <label  class="col-sm-3 col-form-label">Scope:</label>
        <div  class="col-sm-7">
           <select id="scope" name="scope2" class="form-control small" required >
            
            <option value="School" <?=$aw->scope == 'School' ? ' selected="selected"' : '';?>>School</option>
            <option value="Institutional" <?=$aw->scope == 'Institutional' ? ' selected="selected"' : '';?>>Institutional</option>
            <option value="Local" <?=$aw->scope == 'Local' ? ' selected="selected"' : '';?>>Local</option>
            <option value="Regional" <?=$aw->scope == 'Regional' ? ' selected="selected"' : '';?>>Regional</option>
            <option value="National" <?=$aw->scope == 'National' ? ' selected="selected"' : '';?>>National</option>
            <option value="International" <?=$aw->scope == 'International' ? ' selected="selected"' : '';?>>International</option>
           
          </select>
        </div>
    </div>
  <div class=" row">
    <label class="col-sm-3 col-form-label">Category:</label>
    <div class="col-sm-7">
      <select id="category" name="category2" class="form-control small" required >
            <option value="Academics" <?=$aw->category == 'Individual' ? ' selected="selected"' : '';?>>Academics</option>
            <option value="Non-Academics" <?=$aw->category == 'Individual' ? ' selected="selected"' : '';?>>Non-Academic</option>
          </select>
    </div>
  </div>
  <div class=" row">
    <label class="col-sm-3 col-form-label">Participant's Classification:</label>
    <div class="col-sm-7">
      <select id="classification" name="classification2" class="form-control small" required >
            <option value="Individual" <?=$aw->classification == 'Individual' ? ' selected="selected"' : '';?> >Individual</option>
            <option value="Group" <?=$aw->classification == 'Group' ? ' selected="selected"' : '';?>>Group</option>
          </select>
    </div>
  </div>
   <div class=" row">
    <label class="col-sm-3 col-form-label">Venue:</label>
    <div class="col-sm-7">
     <input type="text" class="form-control" id="venue" name="venue2" placeholder="" required  value="{{$aw->venue}}">
    </div>
  </div>
  <div class=" row">
    <label class="col-sm-3 col-form-label">Award Giving Body:</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" id="givingbody" name="award_giving_body2" required  value="{{$aw->award_giving_body}}">
    </div>
  </div>
  <div class=" row">
    <label class="col-sm-3 col-form-label">Date:</label>
    <div class="col-sm-7">
     <input type="date" class="form-control small" id="date" name="date2" value="{{$aw->date_awarded}}" required>
    </div>
  </div>
   <div class=" row mt-4">
    <div class="col-sm-12">
      <button type="submit" id="save" class="btn btn-primary" >Save Changes</button>
      <a class="btn btn-danger" href="{{ route('userAwardDetails', $aw->aw_id) }}"> Back</a>
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
  $(document).on('click','.deleteCertAward',function(){
      var conf = confirm('Are you sure you want to delete this record?');
      var fileId = $(this).attr('fileId');
      if(conf){
        $.ajax({
          url:"{{route('userDeleteCertAward')}}",
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