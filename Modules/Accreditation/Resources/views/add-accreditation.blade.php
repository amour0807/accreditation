@extends('accreditation::layouts.master')

@section('content')
<style type="text/css">
	.req{
		color: red;
	}
</style>
	<h4 class="mb-4">Add an Accreditation</h4>

	<form  id="addAccredForm" method="POST">
         @csrf
		<div class="form-row my-2">
			<div class="form-group col-md-4">
			    <label> <span class="req">*</span>School</label>
			    <select class="form-control form-control-sm" id="school" name="school" required>
			    	<option disabled selected value> </option>
			    @foreach ($schools as $school)
			      <option value="{{$school->id}}">{{ $school->school_name }}</option>
			    @endforeach
			    </select>
			</div>
			<div class="form-group col-md-5">
			    <label><span class="req">*</span>Academic Programs</label>
				 <div id='program_choice'>
				 	<select class="form-control form-control-sm " disabled name="program" required> 
				 		<option>--Select school first--</option>
				 	</select>
				 </div>
			</div>
		</div>

		<div class="form-row my-2 mb-4">
			<div class="form-group col-md-4">
			    <label><span class="req">*</span>Date of Visit</label>
			    <input class="form-control form-control-sm" type="month" name="visit_date" required>
			</div>
			<div class="form-group col-md-5">
			    <label><span class="req">*</span>Accreditation Status</label>
			    <select class="form-control form-control-sm" name="accredStat" required>
			    @foreach ($accredStats as $accredStat)
			      <option value="{{$accredStat->id}}">{{ $accredStat->accred_status }}</option>
			    @endforeach
			    </select>
			</div>
		</div>


		<div class="form-row my-6">
		    <label class="col-sm-2 ">Accreditation valid from</label>
		    <div class="col-sm-3">
		    	<input class="form-control form-control-sm" type="date" name="from" required>
			</div>
		
		
		    <label class="col-sm-1 text-center">to</label>
		    <div class="col-sm-3">
		    	<input class="form-control form-control-sm" type="date" name="to" required>
		    </div>
		</div>

		<div class="form-row my-2 mb-4">
			<div class="form-group col-md-4">
			    <label>Remarks</label>
			    <textarea class="form-control form-control-sm" id="remarks" rows="4" name="remarks"></textarea>
			</div>
			
		</div>

		<div class="my-3">
			<div class="form-group col-md-6 ">
				<label for="exampleFormControlFile1">Upload PACUCOA Certification</label>
			    <input type="file" class="form-control-sm form-control-file" name="pacucoaCert">
			</div>
			<div class="form-group col-md-6 my-4">
				<label for="exampleFormControlFile1">Upload FAAP Certification</label>
			    <input type="file" class="form-control-sm form-control-file" name="faapCert">
			</div>
		</div>
		
		<hr>
		<button class="btn btn-primary  m-2" type="submit">Add Accreditation</button>
		<a class="btn btn-secondary  m-2" href='{{ route("accredIndex") }}'>Back</a>
	
	</form>
	<hr>
	
	

	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script type="text/javascript">
		$.ajaxSetup({
		    headers: {
		       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
    	});
    
    	var token = $("input[name='_token']").val();
		$(document).ready(function(){

		   $('#school').on('change',function(){
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



		     //Adding
		    $( "#addAccredForm" ).submit(function( event ) {
		        event.preventDefault();

		        $.ajax({
		          url:"{{route('addAccred')}}",
		          method:"POST",
		          data: $("#addAccredForm").serialize(),
		          success:function(data){
		            $("#addAccredForm")[0].reset();
		            
		          }
		              
		        }); 
		    });  
		});
	</script>
@endsection