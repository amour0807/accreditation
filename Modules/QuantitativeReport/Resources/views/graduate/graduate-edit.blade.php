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
        <a href="{{route('graduate')}}" class="fa fa-angle-double-left" text="back">&nbsp;&nbsp;Back</a>
		<br><br>

		<form id="form" action="{{ route('updateGraduate') }}" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered" style="padding: 0px 8px 0px 16px;">
										 {{ csrf_field() }}
			
										 <span class="text-danger">* Required Fields</span><br>
			 <div class="modal-body">
				<div class="form-group">
					<input name="id" value='{{$graduate->e_id}}' hidden>
			 <div class="row form-group">
					 <div class="col-md-6">
						 <label><span class="text-danger">*</span>School:</label>
						   <select class="form-control form-control-sm" id="schoolchange" name="school" required>
							 @foreach ($list as $school)
							 @if($school->id == $graduate->school_id)
							 	<option value ="{{$school->id}}" selected> {{ $school->school_name }}  </option>
							 @else
							   <option value="{{$school->id}}">{{ $school->school_name }}</option>
							  @endif
							 @endforeach
						 </select>
					 </div>
					 <div class="col-md-6">
						 <label><span class="text-danger">*</span>Program:</label>
						   <div id='program_choice'>
							  <select class="form-control form-control-sm " name="program" required> 
								@foreach ($acad_prog->where('school_id',$graduate->school_id) as $ac)
								 <option value ="{{$ac->id}}" <?=$ac->id == $graduate->acad_prog ? 'selected="selected"' : '';?>> {{ $ac->acad_prog }}  </option>
								@endforeach
							  </select>
						  </div>
					 </div>
			 </div>
			 <div class="row form-group">
				 <div class= "col-md-6"> 
					 <label><span class="text-danger">*</span>Semester:</label>
					 <select class="form-control small" name="sem" required>
						<option disabled selected value> -- --  </option>
					   
						 <option value = '1st Semester'<?=$graduate->semester == '1st Semester' ? ' selected="selected"' : '';?>> First Sem  </option>
						 <option value = '2nd Semester'<?=$graduate->semester == '2nd Semester' ? ' selected="selected"' : '';?>> Second Sem  </option>
					 </select>
						 </div>
						 <div class="col-md-6 form-group">
							 <label><span class="text-danger">*</span>School Year:</label>
							 <select name="school_year" class="form-control">
							 <option disabled selected value> -- --  </option>
								 <?php $now = now()->year; ?>
								 @for($year = $now; $year >= 2015 ; $year--)
								 <?php $add = $year+1; ?>
								 @if($year." - ".$add == $graduate->school_year)
								 <option value='{{$year}} - {{$year+1}}' selected>{{$year}} - {{$year+1}}</option>
								 @else
								 <option value='{{$year}} - {{$year+1}}'>{{$year}} - {{$year+1}}</option>
								 @endif
								 @endfor
							 </select>
					 </div>
			 </div>
			 
			 
			 <div class="row form-group">
				 <div class= "col-md-3"> 
			 <label><span class="text-danger">*</span>Undergrad:</label>
				 <input type="number" min="0"  name="undergrad" value="{{$graduate->undergrad}}" class="form-control">
				 </div>
				 <div class="col-md-3 form-group">
					 <label><span class="text-danger">*</span>Non Degree:</label>
					 <input type="number" min="0" value="{{$graduate->non_degree}}" name="nondegree" class="form-control">
			 </div>

			 <div class="col-md-3 form-group">
				 <label><span class="text-danger">*</span>Basic Ed.</label>

				 <input type="number" min="0" value="{{$graduate->basic_ed}}" name="basiced" class="form-control">
			 </div>
			 </div>
		   <div class="modal-footer">
			 <button type="submit" class="btn btn-info">Update</button>
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

$('#schoolchange').on('change',function(){
		var id = $(this).val();
		$.ajax({
		 url:"{{route('graduate_select')}}",
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