@extends('layouts.app')
@section('content')
    <hr style="margin: 0 0 0 0; ">
    <div class="block full"  style="margin-bottom: 10px;" >
    <div class="block-title" style="padding: 1px 3px 1px 3px;">
       <h2><strong>{{ $program->AcadPrgrm->acad_prog }} - {{ $program->AcadPrgrm->School->school_code }}</strong>
       </h2>
    </div>
  <div class="alert"></div>
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
    <br>
  <div class=" row">
    <label class="col-sm-2 col-form-label">Visit Date From:</label>
    <label class="col-sm-10 col-form-label">{{$program->visit_date_from.' - '.$program->visit_date_to}}</label>
  </div>

   <div class=" row ">
    <label class="col-sm-2 col-form-label">Valid From:</label>
    <label class="col-sm-10 col-form-label">{{$program->from.' - '.$program->to}}</label>
   </div>

   <div class=" row ">
    <label class="col-sm-2 col-form-label">Remarks:</label>
    <div class="col-sm-10">
      <textarea class="form-control form-control-sm" id="remarks" rows="4" name="remarks" disabled="">{{$program->remarks}}</textarea>
    </div>
   </div>

   <div class=" row mt-4">
    <div class="col-sm-12">
      <a class="btn btn-info mr-2" href="{{ route('accredEdit', $program->id)}}">Edit</a>
      <a class="btn btn-danger" href="{{ route('accredited_programs', $program->AcadPrgrm->school_id) }}"> Back</a>
  	</div>
   </div>
  <hr>
@if(!$program->faap_cert)
  <form id="fcForm" method="POST" enctype="multipart/form-data" action="{{route('addFile')}}">
    @csrf
      <input type="hidden" name="typeForm" value="fc">
      <input type="hidden" name="id" value="{{$program->id}}">


    <div class="form-group row mt-4">
        <label class="col-sm-2 col-form-label">FAAP Certificate:</label>
        <div class="col-sm-4">
          <input type="file" name="faap_cert" class="form-control" required>

        </div>
        <div class="col-sm-1">
          <button class="btn btn-success" type="submit">save</button>
        </div>
     </div>
  </form>
     
   @else
      <div class="form-group row mt-4">
        <label class="col-sm-2 col-form-label">FAAP Certificate:</label>
        
          <div class="col-sm-2  ">
              <a class="btn btn-info btn-block" href="{{asset('uploads/'.$program->faap_cert)}}">View </a>
            
          </div>
          <div class="col-sm-2">
          <button class="btn btn-danger btn-block deleteCert" type ="fc" fileId="{{$program->id}}" >Remove</button>
              
          </div>
    
     </div>
   @endif
   @if(!$program->pacucoa_cert)
    <form id="pcForm" method="POST" enctype="multipart/form-data" action="{{route('addFile')}}">
      @csrf
      <input type="hidden" name="id" value="{{$program->id}}">
      <input type="hidden" name="typeForm" value="pc">
       <div class="form-group row">
          <label class="col-sm-2 col-form-label">PACOCUA Certificate:</label>
          <div class="col-sm-4">
            <input type="file" name="pacucoa_cert" class="form-control" required>
          </div>  
          <div class="col-sm-1">
            <button class="btn btn-success" type="submit">save</button>
          </div>
          
       </div>
     </form>
   @else
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">PACOCUA Certificate:</label>
        <div class="col-sm-2 px-1">
          <a class="btn btn-info btn-block" href="{{asset('uploads/'.$program->pacucoa_cert)}}">View</a>
        </div>
        <div class="col-sm-2 px-1">
          <button class="btn btn-danger btn-block deleteCert" type ="pc" fileId="{{$program->id}}">Remove</button>
        </div>
     </div>
   @endif
   @if(!$program->pacucoa_report)
   <form id="prForm" method="POST" enctype="multipart/form-data" action="{{route('addFile')}}">
    @csrf
      <input type="hidden" name="id" value="{{$program->id}}">
      <input type="hidden" name="typeForm" value="pr">

       <div class="form-group row">
          <label class="col-sm-2 col-form-label">Chairman's Report:</label>
          <div class="col-sm-4">
            <input type="file" name="pacucoa_report" class="form-control" required>
          </div>
          <div class="col-sm-1">
              <button class="btn btn-success">save</button>
          </div>
          
       </div>
     </form>
   @else
   <div class="form-group row">
      <label class="col-sm-2 col-form-label">Chairman's Report:</label>
      <div class="col-sm-2 px-1">
          <a class="btn btn-info btn-block" href="{{asset('uploads/'.$program->pacucoa_report)}}">View</a>
      </div>
      <div class="col-sm-2 px-1">
          <button class="btn btn-danger btn-block deleteCert" type ="pr" fileId="{{$program->id}}">Remove</button>
      </div>
   </div>

    @endif

<script type="text/javascript">


    $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    var token = $("input[name='_token']").val();


  

            $('.alertOld').show();
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
          url:"{{route('deleteCert')}}",
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
// $(document).on('click','.replace',function(){
//       var conf = confirm(' Once you click "OK" this file would be deleted. Are you sure you want to replace this record?');
//       var fileId = $(this).attr('fileId');
//       var type = $(this).attr('type');


//       if(conf){
//         $.ajax({
//           url:"{{route('deleteCert')}}",
//           method:"POST",
//           data:{
//             fileId:fileId,
//             type:type,
//             _token:token
//           },
//           success:function(data){
          
//             location.reload();
//             $('.alertOld').append('<span id="alertMessage">Record deleted!</span>');
//             $('.alertOld').show();
//             $(".alertOld").delay(4000).fadeOut(500);
//             setTimeout(function(){
//               $('#alertMessage').remove();
//             }, 5000);
//           },
//           error: function(jqxhr, status, exception) {
//              alert('this record still has a task. Please delete it all then delete this project.');
//          }

//         });  
//       }
//     }); 



</script>
@endsection