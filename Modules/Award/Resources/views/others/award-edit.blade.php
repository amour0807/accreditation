@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
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
        <a href="{{route('userAwardDetails',$award->aw_id)}}" class="fa fa-angle-double-left" text="back">&nbsp;&nbsp;Back</a>
          <br><br>
 <form id="form" action="{{ route('updateStudentAward') }}" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered">
                                            {{ csrf_field() }}
<div class="col-md-10" style="float: center;">
  <div class="row">
    <div class="col-md-5">
      @if($award->award_cert == "" || $award->award_cert == 'blank_cert.png')
      <img src="{{asset('certificates/blank_cert.png')}}" style="height:200;width:300px;"><br>
      @else
      <a href="{{asset('certificates/'.$award->award_cert)}}" target="_blank"> 
      <img src="{{asset('certificates/'.$award->award_cert)}}" style="height:200;width:300px;"></a>
       <a class="btn btn-danger deleteCertAward" fileId="{{$award->aw_id}}" style="color: white">Remove Certificate</a> <br>
      
      @endif
      <div class="form-group">
              <i class="fa fa-upload">Certificate</i>
              <input type="text"  id="award_cert" name="award_cert" class="form-control" value="{{$award->award_cert}}" hidden>
              <input type="file"  id="award_cert_file" name="award_cert_file" class="form-control" onchange="ViewSave('award_cert_file');"><br>
              <div style="display:inline-block; vertical-align: middle;">
               <button type="submit" id="saveimage" class="btn btn-primary" hidden>Save Image</button>
               
             </div>
            </div>
     </div>
    <div class="col-md-7">
      <span class="text-danger">* Required Fields</span><br>
     <div class=" row">
        <div class="row form-group">
            <div class="col-md-4">
              <label><span class="text-danger">*</span>First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name2" value="{{$award->first_name}}" required>
            </div>
            <div class="col-md-4">
              <label><span class="text-danger"></span>Middle Initial</label>
              <input type="text" class="form-control" maxlength="1" id="middle_i" name="middle_i2" value="{{$award->middle_initial}}" >
            </div>
             <div class="col-md-4">
              <label><span class="text-danger">*</span>Last Name</label>
              <input type="text" class="form-control" id="last_name" name="last_name2" value="{{$award->last_name}}"  required>
            </div>
        </div>
    </div>
    <div class="row">
          <label><span class="text-danger">*</span>@if(!Auth::user()->hasRole('admin')){{$school->school_code}}@endif Program:</label>
          <input type="text" class="form-control " id="awardID" name="awardID" value="{{$award->aw_id}}" hidden/>
          <select class="form-control " id="acad_prgram_id" name="acad_prgram_id2" >
            @foreach($acad_prog as $ap)
              @if($ap->a_id == $award->id)
              <option value = '{{ $ap->a_id }}' selected> {{ $ap->acad_prog }}  </option>
              @else
             <option value = '{{ $ap->a_id }}'> {{ $ap->acad_prog }} </option>
             @endif
           @endforeach
          </select>
    </div>
    <div class="row">
      <label><span class="text-danger">*</span>Award / Recognition /Achivement:</label>
      <select class="form-control " id="achievement" name="award2" onchange='CheckAward(this.value);' >
            <option value="First Place" <?=$award->award == 'First Place' ? ' selected="selected"' : '';?>>First Place</option>
            <option value="Second Place" <?=$award->award == 'Second Place' ? ' selected="selected"' : '';?>>Second Place</option>
            <option value="Third Place" <?=$award->award == 'Third Place' ? ' selected="selected"' : '';?>>Third Place</option>
            <option value="Fourth Place" <?=$award->award == 'Fourth Place' ? ' selected="selected"' : '';?>>Fourth Place</option>
            <option value="Champion" <?=$award->award == 'Champion' ? ' selected="selected"' : '';?>>Champion</option>
            <option value="1st Runner Up" <?=$award->award == '1st Runner Up' ? ' selected="selected"' : '';?>>1st Runner Up</option>
            <option value="2nd Runner Up" <?=$award->award == '2nd Runner Up' ? ' selected="selected"' : '';?>>2nd Runner Up</option>
            <option value="3rd Runner Up" <?=$award->award == '3rd Runner Up' ? ' selected="selected"' : '';?>>3rd Runner Up</option>
            <option value="Gold" <?=$award->award == 'Gold' ? ' selected="selected"' : '';?>>Gold</option>
            <option value="Silver" <?=$award->award == 'Silver' ? ' selected="selected"' : '';?>>Silver</option>
            <option value="Bronze" <?=$award->award == 'Bronze' ? ' selected="selected"' : '';?>>Bronze</option>
            <option value="Finalist" <?=$award->award == 'Finalist' ? ' selected="selected"' : '';?>>Finalist</option>
            <option value="others" <?=$award->award != 'First Place' && $award->award != 'Second Place' && $award->award != 'Third Place' && $award->award != 'Fourth Place' && $award->award != 'Champion' && $award->award != '1st Runner Up' && $award->award != '2nd Runner Up' && $award->award != '3rd Runner Up' && $award->award != 'Gold' && $award->award != 'Silver' && $award->award != 'Bronze' && $award->award != 'Finalist' ? ' selected="selected"' : '';?>>Others</option>
          </select><br>
              
              <input type="text" class="form-control" id="others1" name="others1" value="{{$award->award}}" style='display:none;'/>
    </div>
    <div class="row">
      <label><span class="text-danger">*</span>Title of Competition</label>
              <input type="text" class="form-control" id="titlec" name="title_competitions2"  required value="{{$award->title_competitions}}">
    </div><br>
    <div class=" row">
        <label  class="col-sm-3 col-form-label"><span class="text-danger">*</span>Scope:</label>
        <div  class="col-sm-7">
           <select id="scope" name="scope2" class="form-control " required >
            
            <option value="School" <?=$award->scope == 'School' ? ' selected="selected"' : '';?>>School</option>
            <option value="Institutional" <?=$award->scope == 'Institutional' ? ' selected="selected"' : '';?>>Institutional</option>
            <option value="Local" <?=$award->scope == 'Local' ? ' selected="selected"' : '';?>>Local</option>
            <option value="National" <?=$award->scope == 'National' ? ' selected="selected"' : '';?>>National</option>
            <option value="International" <?=$award->scope == 'International' ? ' selected="selected"' : '';?>>International</option>
           
          </select>
        </div>
    </div>
  <div class=" row">
    <label class="col-sm-3 col-form-label"><span class="text-danger">*</span>Category:</label>
    <div class="col-sm-7">
      <select id="category" name="category2" class="form-control " required >
            <option value="Academics" <?=$award->category == 'Individual' ? ' selected="selected"' : '';?>>Academics</option>
            <option value="Non-Academics" <?=$award->category == 'Individual' ? ' selected="selected"' : '';?>>Non-Academic</option>
          </select>
    </div>
  </div>
  <div class=" row">
    <label class="col-sm-3 col-form-label"><span class="text-danger">*</span>Participant's Classification:</label>
    <div class="col-sm-7">
      <select id="classification" name="classification2" class="form-control " required >
            <option value="Individual" <?=$award->classification == 'Individual' ? ' selected="selected"' : '';?> >Individual</option>
            <option value="Group" <?=$award->classification == 'Group' ? ' selected="selected"' : '';?>>Group</option>
          </select>
    </div>
  </div>
   <div class=" row">
    <label class="col-sm-3 col-form-label"><span class="text-danger">*</span>Venue:</label>
    <div class="col-sm-7">
     <input type="text" class="form-control" id="venue" name="venue2" placeholder="" required  value="{{$award->venue}}">
    </div>
  </div>
  <div class=" row">
    <label class="col-sm-3 col-form-label"><span class="text-danger">*</span>Award Giving Body:</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" id="givingbody" name="award_giving_body2" required  value="{{$award->award_giving_body}}">
    </div>
  </div>
  <div class=" row">
    <label class="col-sm-3 col-form-label"><span class="text-danger">*</span>Date:</label>
    <div class="col-sm-7">
     <input type="date" class="form-control " id="date" name="date2" value="{{$award->date_awarded}}" required>
    </div>
  </div>
   <div class=" row mt-4">
    <div class="col-sm-12">
      <button type="submit" id="save" class="btn btn-primary" >Save Changes</button>
      <a class="btn btn-danger" href="{{ route('userAwardDetails', $award->aw_id) }}"> Back</a>
    </div>
    </div>
  </div>
  </div>
   </div>
 </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">


  $.ajaxSetup({
    headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  var token = $("input[name='_token']").val();
  $(document).ready(function(){
    var award = jQuery("#achievement").val();
        if( award == "others") {
          var element=document.getElementById('others1');
          element.style.display='block';
        }
  });
function CheckAward(val){
 var element=document.getElementById('others1');
 if(val=='others')
   element.style.display='block';
 else
   element.style.display='none';

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
    var fileId = $(this).attr('fileId');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
        url:"{{route('userDeleteCertAward')}}",
        method:"POST",
        data:{
          fileId:fileId,
          _token:token
        },
          success:function(data){
            Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          ) 
            location.reload();
          },
          error: function(jqxhr, status, exception) {
            Swal.fire(
            'Cannot be Deleted!',
            'this record still has a task. Please delete it all then delete this project.',
            'error'
          )
         }

        }); 
         
        }
      })
  }); 
</script>
@endsection