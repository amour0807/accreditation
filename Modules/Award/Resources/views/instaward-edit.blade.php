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
        <a href="{{route('instAward')}}" class="fa fa-angle-double-left" text="back">&nbsp;&nbsp;Back</a>
        <br><br>
 <form id="form" action="{{route('updateInstAward')}}" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered">
                                            {{ csrf_field() }}
<input type="text" class="form-control" name="awardID" value="{{$instAward->id}}" hidden>
<div class="col-md-12" style="float: center;">
  <div class="row">
    <div class="col-md-5">
    @if($instAward->supporting_doc == "")
    <div > No Supporting Document</div>
    @else

    <a href="{{asset('certificates/'.$instAward->supporting_doc)}}" target="_blank;"> 
    <?php  $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief','jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];

      $explodeImage = explode('.', 'certificates/'.$instAward->supporting_doc);
      $extension = end($explodeImage);
      
      if(in_array($extension, $imageExtensions)){  ?>
          <img src="{{asset('certificates/'.$instAward->supporting_doc)}}" style="height:220px;width:220px;border: 1px solid gray;">
          <a class="btn btn-danger deleteDocu" fileId="{{$instAward->id}}" style="color: white">Remove Document</a> <br>
          <?php }else { ?>
        <img src="{{asset('images/pdf.png')}}" style="height:220px;width:220px;border: 1px solid gray;">
       <?php }?>
   </a>
    @endif
    <div class="form-group">
      <i class="fa fa-upload">Supporting Document</i>
      <input type="text"  id="award_cert" name="award_cert" class="form-control" value="{{$instAward->supporting_doc}}" hidden>
      <input type="file"  id="award_cert_file" name="award_cert_file" class="form-control" onchange="ViewSave('award_cert_file');"><br>
      <div style="display:inline-block; vertical-align: middle;">
       <button type="submit" id="saveimage" class="btn btn-primary" hidden>Save Document</button>
       
     </div>
    </div>
     
     </div>
    <div class="col-md-7">
      <span class="text-danger">* Required Fields</span><br>
        <div class="row form-group">
              <label><span class="text-danger">*</span>Title of Award</label>
              <input type="text" class="form-control" name="award" value="{{$instAward->award}}" required>
          </div>
          <div class=" row form-group">
        <label  class="col-sm-3 col-form-label"><span class="text-danger">*</span>Scope:</label>
        <div  class="col-sm-7">
           <select id="scope" name="scope" class="form-control" required >
            
            <option value="School" <?=$instAward->scope == 'School' ? ' selected="selected"' : '';?>>School</option>
            <option value="Institutional" <?=$instAward->scope == 'Institutional' ? ' selected="selected"' : '';?>>Institutional</option>
            <option value="Local" <?=$instAward->scope == 'Local' ? ' selected="selected"' : '';?>>Local</option>
            <option value="National" <?=$instAward->scope == 'National' ? ' selected="selected"' : '';?>>National</option>
            <option value="International" <?=$instAward->scope == 'International' ? ' selected="selected"' : '';?>>International</option>
           
          </select>
        </div>
    </div>
    <div class="row form-group">
      <div class="col-md-6">
          <label><span class="text-danger"></span>Date Issued</label>
          <input type="date" class="form-control" name="date_issued" value="{{$instAward->date_issued}}" required>
      </div>
    </div>
          <div class="row form-group">
            
            <div class="col-md-6">
                <label><span class="text-danger"></span>Valid &nbsp;&nbsp;From</label>
                <input type="date" class="form-control" name="from" id="fromVal" value="{{$instAward->from}}" >
            </div>
            <div class="col-md-6">
                <label><span class="text-danger"></span>To</label>
                <input type="date" class="form-control" name="to" id="toVal" value="{{$instAward->to}}" >
                <span id="spnErrorDate" class="error text-danger" style="display: none;">*Must be greater than the starting Date.</span>
            </div>
          </div>
          {{-- <div class="row form-group">
              <label><span class="text-danger"></span>Venue</label>
              <input type="text" class="form-control" name="venue"  value="{{$instAward->venue}}" >
          </div> --}}
          <div class="row form-group">
              <label><span class="text-danger">*</span>Award Giving Body</label>
              <input type="text" class="form-control" name="award_gb"  value="{{$instAward->award_giving_body}}" required>
          </div>
   <div class=" row mt-4">
    <div class="col-sm-12" id="clasValidate">
      <button type="submit" id="save" class="btn btn-primary" >Save Changes</button>
      <a class="btn btn-danger" href="{{ route('instAward') }}"> Back</a>
    </div>
    </div>
  </div>
  </div>
   </div>
 </form>
@endsection
@section('scripts')
@include('common.inputVal')
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