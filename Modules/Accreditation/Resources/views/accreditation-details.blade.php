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

@if (session('success'))
     <div class="alert alert-info alert-block">
            <strong>{{ session('success') }}</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
     
@endif
<a href="{{route('adminAcred_prog')}}" class="fa fa-angle-double-left" text="back">&nbsp;&nbsp;Back</a>
    <br><br>
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
      @if(Auth::user()->hasRole('admin'))
      <a class="btn btn-info mr-2" href="{{ route('accredEdit', $program->id)}}">Edit</a>
      @endif
      <a class="btn btn-danger" href="{{ route('adminAcred_prog') }}"> Back</a>
  	</div>
   </div>
  <hr>
@if(!$program->faap_cert)
  @if(Auth::user()->hasRole('admin'))
  <form id="fcForm" method="POST" enctype="multipart/form-data" action="{{route('addFile')}}">
    @csrf
      <input type="hidden" name="typeForm" value="fc">
      <input type="hidden" name="id" value="{{$program->id}}">


    <div class="form-group row mt-4">
        <label class="col-sm-2 col-form-label">FAAP Certificate:</label>
        <div class="col-md-4 col-sm-4">
          <input type="file" name="faap_cert" class="form-control" required>
		    <span class="small">Files accepted: jpeg,jpg, png, pdf </span>
        </div>
        <div class="col-md-1 col-sm-1">
          <button class="btn btn-success" type="submit">save</button>
        </div>
     </div>
  </form>
     @endif
   @else
      <div class="form-group row mt-4">
        <label class="col-sm-2 col-form-label">FAAP Certificate:</label>
        
          <div class="col-md-2 col-sm-12  ">
              <a class="btn btn-info btn-block" href="{{asset('uploads/'.$program->faap_cert)}}" target="_blank">View </a>
          </div>
          @if(Auth::user()->hasPermission('delete-accred'))
          <div class="col-md-2 col-sm-12">
          <button class="btn btn-danger btn-block deleteCert" type ="fc" fileId="{{$program->id}}" >Remove</button>
          </div>
          @endif
    
     </div>
   @endif
   @if(!$program->pacucoa_cert)
   @if(Auth::user()->hasPermission('delete-accred'))
    <form id="pcForm" method="POST" enctype="multipart/form-data" action="{{route('addFile')}}">
      @csrf
      <input type="hidden" name="id" value="{{$program->id}}">
      <input type="hidden" name="typeForm" value="pc">
       <div class="form-group row">
          <label class="col-sm-2 col-form-label">PACOCUA Certificate:</label>
          <div class="col-sm-4">
            <input type="file" name="pacucoa_cert" class="form-control" required>
		  <span class="small">Files accepted: jpeg,jpg, png, pdf </span>
          </div>  
          <div class="col-sm-1">
            <button class="btn btn-success" type="submit">save</button>
          </div>
          
       </div>
     </form>
     @endif
   @else
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">PACUCOA Certificate:</label>
        <div class="col-sm-2 px-1">
          <a class="btn btn-info btn-block" href="{{asset('uploads/'.$program->pacucoa_cert)}}">View</a>
        </div>
        @if(Auth::user()->hasPermission('delete-accred'))
        <div class="col-sm-2 px-1">
          <button class="btn btn-danger btn-block deleteCert" type ="pc" fileId="{{$program->id}}">Remove</button>
        </div>
        @endif
     </div>
   @endif
   @if(!$program->pacucoa_report)
   @if(Auth::user()->hasPermission('delete-accred'))
   <form id="prForm" method="POST" enctype="multipart/form-data" action="{{route('addFile')}}">
    @csrf
      <input type="hidden" name="id" value="{{$program->id}}">
      <input type="hidden" name="typeForm" value="pr">

       <div class="form-group row">
          <label class="col-sm-2 col-form-label">Chairman's Report:</label>
          <div class="col-sm-4">
            <input type="file" name="pacucoa_report" class="form-control" required>
            
		  <span class="small">Files accepted: jpeg,jpg, png, pdf </span>
          </div>
          <div class="col-sm-1">
              <button class="btn btn-success">save</button>
          </div>
          
       </div>
     </form>
   @endif
   @else
   <div class="form-group row">
      <label class="col-sm-2 col-form-label">Chairman's Report:</label>
      <div class="col-sm-2 px-1">
          <a class="btn btn-info btn-block" href="{{asset('uploads/'.$program->pacucoa_report)}}">View</a>
      </div>
      @if(Auth::user()->hasPermission('delete-accred'))
      <div class="col-sm-2 px-1">
          <button class="btn btn-danger btn-block deleteCert" type ="pr" fileId="{{$program->id}}">Remove</button>
      </div>
      @endif
   </div>

    @endif
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
  <script type="text/javascript">
    //delete
    
  var token = $("input[name='_token']").val();
  
  $(document).on('click','.deleteCert',function(){
      var fileId = $(this).attr('fileId');
      var type = $(this).attr('type');
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
          url:"{{route('deleteCert')}}",
          method:"POST",
          data:{
            fileId:fileId,
            type:type,
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