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
@foreach($partner as $pr)

 <form id="form" action="{{route('updateInstAward')}}" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered">
                                            {{ csrf_field() }}
<input type="text" class="form-control" name="awardID" value="{{$pr->id}}" hidden>
<div class="col-md-12" style="float: center;">
  <div class="row">
    <div class="col-md-5">
      @if($pr->supporting_doc == "")
      <div > No Supporting Document</div>
      @else
      <a href="{{asset('certificates/'.$pr->supporting_doc)}}"> 
      <img src="{{asset('certificates/'.$pr->supporting_doc)}}" style="height:200;width:300px;"></a>
       <a class="btn btn-danger deleteDocu" fileId="{{$pr->id}}" style="color: white">Remove Document</a> <br>
      
      @endif
      <div class="form-group">
              <i class="fas fa-upload">Supporting Document</i>
              <input type="text"  id="award_cert" name="award_cert" class="form-control" value="{{$pr->supporting_doc}}" hidden>
              <input type="file"  id="award_cert_file" name="award_cert_file" class="form-control" onchange="ViewSave('award_cert_file');"><br>
              <div style="display:inline-block; vertical-align: middle;">
               <button type="submit" id="saveimage" class="btn btn-primary" hidden>Save Document</button>
               
             </div>
            </div>
     </div>
    <div class="col-md-7">
      <div class="row form-group">
            <div class="col-md-10">
                  <label><span class="text-danger">*</span>Name of Partner</label>
                  <input type="text" class="form-control" name="award" value="{{$pr->company_name}}" required>
            </div>
            <div class="col-md-2">
               <label><span class="text-danger">*</span>Scope:</label>
                <select name="scope" class="form-control small" required>
                  <option value="Active" <?=$pr->scope == 'Active' ? ' selected="selected"' : '';?>>Active</option>
                  <option value="Inactive" <?=$pr->scope == 'Inactive' ? ' selected="selected"' : '';?>>Inactive</option>
                </select>
              </div>
        </div>
          <div class="row form-group">
            <div class="col-md-6">
              <label><span class="text-danger">*</span>Scope:</label>
                <select name="scope" class="form-control small" required>
                  <option value="Local" <?=$pr->scope == 'Local' ? ' selected="selected"' : '';?>>Local</option>
                  <option value="Regional" <?=$pr->scope == 'Regional' ? ' selected="selected"' : '';?>>Regional</option>
                  <option value="National" <?=$pr->scope == 'National' ? ' selected="selected"' : '';?>>National</option>
                  <option value="International" <?=$pr->scope == 'International' ? ' selected="selected"' : '';?>>International</option>
                </select>
            </div>
            <div class="col-md-6">
                <label><span class="text-danger"></span>Nature of Partner</label>
                <!-- <input type="text" class="form-control" name="nature"  value="{{$pr->nature_partner}}" > -->
            </div>
          </div>
          <div class="row form-group">
           <label><span class="text-danger">*</span>Classification:</label>
              <select name="classification" class="form-control small" onchange='CheckClas(this.value);' required>
                <option value="Institutional" <?=$pr->classification == 'Institutional' ? ' selected="selected"' : '';?>>Institutional</option>
                <option value="School" <?=$pr->classification == 'School' ? ' selected="selected"' : '';?>>School</option>
                <option value="Program" <?=$pr->classification == 'Program' ? ' selected="selected"' : '';?>>Program</option>
              </select>
          </div>

          <?php
            $numOfCols = 4;
            $rowCount = 0;
            $bootstrapColWidth = 12 / $numOfCols;
          ?>
         
          <fieldset id="schoolc" style='display:none;'>
            <legend>Schools</legend>
                <div class="row">
                @foreach($school as $sc)
                <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                      <input type="checkbox" id="{{$sc->id}}" name="schoolc[]" value="{{$sc->id}}">
                <label for="{{$sc->id}}"> {{$sc->school_code}}</label>
                </div>
                  <?php $rowCount++; ?>
                @if($rowCount % $numOfCols == 0) 
                  </div><div class="row">
                @endif
                @endforeach
              </div>
          </fieldset>
          <fieldset id="program" style='display:none;'>
            <legend>Programs</legend>
                <div class="row">
                @foreach($program as $pr)
                <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                     <input type="checkbox" id="{{$pr->id}}" name="programc[]" value="{{$pr->id}}">
                    <label for="{{$pr->id}}"> {{$pr->acad_prog_code}}</label>
                </div>
                  <?php $rowCount++; ?>
                @if($rowCount % $numOfCols == 0) 
                  </div><div class="row">
                @endif
                @endforeach
              </div>
          </fieldset>

          <div class="row form-group">
            <div class="col-md-6">
                <label><span class="text-danger"></span>From</label>
                <input type="date" class="form-control" name="from" value="{{$pr->from}}" >
            </div>
            <div class="col-md-6">
                <label><span class="text-danger"></span>To</label>
                <input type="date" class="form-control" name="to"  value="{{$pr->to}}" >
            </div>
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

    function CheckClas(val){
     var school=document.getElementById('schoolc');
     var program=document.getElementById('program');
     if(val=='School'){
       school.style.display='block';
       program.style.display='none';
     }else if (val=='Program'){
       program.style.display='block';
       school.style.display='none';
      }else{
        school.style.display='none';
        program.style.display='none';
      }
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