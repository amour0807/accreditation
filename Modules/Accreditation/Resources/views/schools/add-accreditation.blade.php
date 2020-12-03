@extends('layouts.app')
@section('content')
@section('breadcrumb')
<li class="breadcrumb-item">
    <a class= 'link-blue' href="{{ url('home') }}">Dashboard</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Users</li>
<li class="nav-item dropdown ml-auto">
    <a class="nav-link" href="#" id="notificationDropdown" data-toggle="dropdown" aria-expanded="false"></a>  
</li>
@endsection
    <hr style="margin: 0 0 0 0;">
    <div class="block full"  style="margin-bottom: 10px;" >
    <div class="block-title" style="padding: 1px 3px 1px 3px;">
       <h2><strong>Add an Accreditation<span></strong></h2>
    </div>
  <div class="alert"></div>

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

@if(!empty(Session::get('error_code')) && Session::get('error_code') == 5)
	<script>
	$(function() {
	    $('#success-modal').modal('show');
	});
	</script>
@endif

<form  id="addAccredForm" method="POST" enctype="multipart/form-data" action="{{route('userAddAccred')}}">
    @csrf
	<div class="form-group row ASASD">
		<label class="col-md-2 col-form-label">School</label>
		<div class="col-md-4">
      		<select class="form-control form-control-sm" id="school" name="school" required disabled>
			      <option value="{{$school->id}}">{{ $school->school_name }}</option>
			   
		    </select>
    	</div>

    	<label class="col-md-2 col-form-label"> <span class='text-danger'>*</span>Academic Programs</label>
		<div class="col-md-4">
      		<select class="form-control-sm form-control" name="program" required>
                @if ($programs->count() != 0)
		            @foreach ($programs as $program) 
		                <option value='{{$program->id}}' >{{$program->acad_prog}}</option>
		            @endforeach
		        
		        @else
		            <option vlaue=''>No Academic Program Added yet</option>
		        @endif
        
		 	</select>
			 </div>
    	</div>
	    


	<div class="form-group row">

		    <label class="col-md-2 col-form-label"><span class='text-danger'>*</span>Accreditation Status</label>
		    <div class="col-md-4">
			    <select class="form-control form-control-sm" name="accredStat" required>
			    	<option disabled selected value> </option>
			    @foreach ($accredStats as $accredStat)
			      <option value="{{$accredStat->id}}">{{ $accredStat->accred_status }}</option>
			    @endforeach
			    </select>
			</div>
		
	</div>

  <div class="form-group row">
    <label class="col-md-2 col-form-label"><span class='text-danger'>*</span>Visit Date From</label>
    <div class="col-md-4">
      <input class="form-control form-control-sm" type="date" name="visit_date" required value="{{Request::old('visit_date')}}">
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
	    </div>
	    @error('faap_cert')
    <div class=" alert-danger">{{ $message }}</div>
@enderror
   </div>
   <div class="form-group row">
   		<label class="col-md-2 col-form-label">PACOCUA Certificate</label>
	    <div class="col-md-4">
	      <input type="file" name="pacucoa_cert" class="form-control">
	    </div>
	    @error('pacocua_cert')
    <div class=" alert-danger">{{ $message }}</div>
@enderror
   </div><div class="form-group row">
   		<label class="col-md-2 col-form-label">PACOCUA Report</label>
	    <div class="col-md-4">
	      <input type="file" name="pacucoa_report" class="form-control">
	    </div>
	    @error('pacocua_report')
    <div class="alert-danger">{{ $message }}</div>
@enderror
   </div>

 
  <div class="form-group row mt-4">
    <div class="col-md-10">
      <button class="btn btn-info m-2" type="submit">Add Accreditation</button>
		<a class="btn btn-danger  m-2" href='{{ route("userAccredIndex") }}'>Back</a>
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
        <a class="btn btn-danger" href="{{route('userAccredIndex')}}">Proceed to Dashboard</a>
        <button type="button" class="btn btn-info" data-dismiss="modal">Add Another Record</button>
      </div>
    </div>
  </div>
</div>
	
	


	<script type="text/javascript">
		$.ajaxSetup({
		    headers: {
		       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
    	});
    
    	var token = $("input[name='_token']").val();
		$(document).ready(function(){

		  



		     //Adding
		    // $( "#addAccredForm" ).submit(function( event ) {
		    //     event.preventDefault();
		    //     var formData = new FormData($(this)[0]);
		    //     $.ajax({
		    //       url:"{{route('userAddAccred')}}",
		    //       method:"POST",
		    //       data:new FormData(this),

				  //  contentType: false,
				  //  cache: false,
				  //  processData: false,
		    //       success:function(data){
		    //         $("#addAccredForm")[0].reset();
		    //         $('#success-modal').modal('show');
		            
		    //       },
		    //       error: function(xhr, status, error){
			   //       var errorMessage = xhr.error + ': ' + xhr.statusText
			   //       alert('You might have uploaded an invalid file. Please re-check your inputs and take note of the following: \n FAAP Certificate: accepts .pdf and .xls files only \n PACOCUA Certificate: accepts .pdf and .xls files only \n FAAP Report: accepts .PNG and .JPEG files only');
			   //   }

		              
		    //     }); 
		    // });  
		});
	</script>
@endsection