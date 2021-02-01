@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
	  <div class="x_content">
		  <div class="row">
			  <div class="col-sm-12">
     		@if (count($errors) > 0)
            <div class="alert alert-danger">
            	 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
                <strong>Whoops!</strong> There were some problems with your input.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

@if(!empty(Session::get('success_modal')) && Session::get('success_modal') == 5)
	<script>
	$(function() {
	    $('#success-modal').modal('show');
	});
	</script>
@endif
	<br>
	<label><span class="text-danger"> * Required Fields</span></label>
<form  id="addAccredForm" method="POST" enctype="multipart/form-data" action="{{route('addAccred')}}">
    @csrf
	<div class="form-group row">
		<label class="col-md-2 col-form-label"> <span class="text-danger">*</span>School</label>
		<div class="col-md-4">
      		<select class="form-control form-control-sm" id="schoolchange" name="school" required>
		    	<option disabled selected value> -- -- --</option>
			    @foreach ($schools as $school)
			      <option value="{{$school->id}}">{{ $school->school_name }}</option>
			    @endforeach
		    </select>
    	</div>

    	<label class="col-md-2 col-form-label"> <span class='text-danger'>*</span>Academic Programs</label>
		<div class="col-md-4">
      		<div id='program_choice'>
			 	<select class="form-control form-control-sm " disabled name="program" required> 
			 		<option>--Select school first--</option>
			 	</select>
			 </div>
    	</div>
	    
	</div>

	<div class="form-group row">

		    <label class="col-md-2 col-form-label"><span class='text-danger'>*</span>Accreditation Status</label>
		    <div class="col-md-4">
			    <select class="form-control form-control-sm" name="accredStat" required>
			    	<option disabled selected value>-- -- -- </option>
			    @foreach ($accredStats as $accredStat)
			      <option value="{{$accredStat->id}}">{{ $accredStat->accred_status }}</option>
			    @endforeach
			    </select>
			</div>
		
	</div>

  <div class="form-group row">
    <label class="col-md-2 col-form-label"><span class='text-danger'></span>Visit Date From</label>
    <div class="col-md-4">
      <input class="form-control form-control-sm" type="date" name="visit_date" value="{{Request::old('visit_date')}}">
    </div>

    <label class="col-md-2 col-form-label">Visit Date To</label>
    <div class="col-md-4">
      <input class="form-control form-control-sm" type="date" name="visit_date_to" value="{{Request::old('visit_date_to')}}">
    </div>
  </div>

   <div class="form-group row mb-4">
    <label class="col-md-2 col-form-label"><span class='text-danger'>*</span>Valid From</label>
    <div class="col-md-4">
      <input class="form-control form-control-sm" type="month" name="from" required value="{{Request::old('from')}}">
    </div>

    <label class="col-md-2 col-form-label"><span class='text-danger'>*</span>Valid To</label>
    <div class="col-md-4">
      <input class="form-control form-control-sm" type="month" name="to" required value="{{Request::old('to')}}">
    </div>
  </div>

  <div class="form-row my-2 mb-4">
			<div class="form-group col-md-6">
			    <label>Remarks</label>
			    <textarea class="form-control form-control-sm" id="remarks" rows="4" name="remarks">{{Request::old('remarks')}}</textarea>
			</div>
			
		</div>

	<hr>
   <div class="form-group row mt-4">
		   <label class="col-md-2 col-form-label">FAAP Certificate</label>
	    <div class="col-md-4">
		  <input type="file" name="faap_cert" class="form-control">
		  <span class="small">Files accepted: jpeg,jpg, png, pdf </span>
	    </div>
	    @error('faap_cert')
    <div class=" alert-danger">{{ $message }}</div>
@enderror
   </div>
   <div class="form-group row">
   		<label class="col-md-2 col-form-label">PACUCOA Certificate</label>
	    <div class="col-md-4">
		  <input type="file" name="pacucoa_cert" class="form-control">
		  <span class="small">Files accepted: jpeg,jpg, png, pdf </span>
	    </div>
	    @error('pacocua_cert')
    <div class=" alert-danger">{{ $message }}</div>
@enderror
   </div><div class="form-group row">
   		<label class="col-md-2 col-form-label">Chairman's Report</label>
	    <div class="col-md-4">
		  <input type="file" name="pacucoa_report" class="form-control">
		  <span class="small">Files accepted: jpeg,jpg, png, pdf </span>
	    </div>
	    @error('pacocua_report')
    <div class="alert-danger">{{ $message }}</div>
@enderror
   </div>

 
  <div class="form-group row mt-4">
    <div class="col-md-10">
      <button class="btn btn-info m-2" type="submit">Add Accreditation</button>
		<a class="btn btn-danger  m-2" href='{{ route("accredIndex") }}'>Back</a>
    </div>
  </div>
</form>

<!-- Modal -->
<div class="modal fade " data-backdrop="static" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
      </div>
      <div class="modal-body">
        Record saved. Add another record?
      </div>
      <div class="modal-footer">
        <a class="btn btn-danger" href="{{route('accredIndex')}}">Proceed to Dashboard</a>
        <button type="button" class="btn btn-info" data-dismiss="modal">Add Another Record</button>
      </div>
    </div>
  </div>
</div>
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
  title: 'Successfully saved!',
  text: "Add another record?",
  icon: 'success',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes',
  cancelButtonText: 'Back to List'
}).then((result) => {
  if (!result.isConfirmed) {
	window.location.href = "adminAcred_prog";
  }
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
	$.ajaxSetup({
		headers: {
		   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	var token = $("input[name='_token']").val();
	$(document).ready(function(){

	   $('#schoolchange').on('change',function(){
			   var id = $(this).val();
			   $.ajax({
				url:"{{route('school_select')}}",
				method:"POST",
				data:{
				  id:id,
				  _token:token
				},
				success:function(data){
				  $('#program_choice').html(data);
				}   
			 }); 
		});

	});
</script>
@endsection