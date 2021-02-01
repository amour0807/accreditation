@extends('layouts.appAlumni')
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
        <a href="{{route('graduateindex')}}" class="fa fa-angle-double-left" text="back">&nbsp;&nbsp;Back</a>
        <br><br>
        <form id="form" action="{{route('alumniUpdateGraduate')}}" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered" style="padding: 0px 8px 0px 16px;">
                                            {{ csrf_field() }}
          	  <div class="modal-body">
		      	 <div class="form-group">
		    	<input type="hidden" value="{{$graduate->id}}" name="id">
				<div class="row form-group"> 
						<div class="col-md-4">
							<label><span class="text-danger">*</span>School:</label>
							  <select class="form-control form-control-sm" id="schoolchange" name="school" required <?=$userRole == 'admin' ? '' :'disabled';?>>
								<option disabled selected value> -- -- --</option>
								@foreach ($list as $school)
								  <option value="{{$school->id}}" <?=$graduate->school_id == $school->id ? ' selected="selected"' : '';?>>{{ $school->school_name }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-4">
							<label><span class="text-danger">*</span>Program:</label>
							  <div id='program_choice'>
								 <select class="form-control form-control-sm" <?=$userRole == 'admin' ? 'disabled' :'';?>  name="program" required> 
                 @foreach ($acad_prog->where('school_id',$graduate->school_id) as $ac)
								 <option value ="{{$ac->id}}" <?=$ac->id == $graduate->program_id ? 'selected="selected"' : '';?>> {{ $ac->acad_prog }}  </option>
								@endforeach
								 </select>
							 </div>
						</div>
						<div class="col-md-4">
							<label><span class="text-danger"></span>Major:</label>
							<input type="text" name="major" class="form-control small" value="{{$graduate->major}}">
						</div>
				</div>
				
				<div class="row form-group">
					<div class= "col-md-6"> 
						<label><span class="text-danger">*</span>Semester:</label>
						<select class="form-control small" name="semester" required disabled>
							<option value = '1st Sem'> First Semester  </option>
							<option value = '2nd Sem'   selected> Second Semester  </option>
						</select>
							</div>
							<div class="col-md-6 form-group">
								<label><span class="text-danger">*</span>School Year:</label>
								<select name="schoolyear" class="form-control" disabled>
								<option selected value = "2020 - 2021"> 2020 - 2021 </option>
									{{-- <?php $now = now()->year; ?>
									@for($year = $now; $year >= 2015 ; $year--)
									<option value='{{$year}}'>{{$year}}</option>
									@endfor --}}
								</select>
						</div>
				</div>
				
				
		        <div class="row form-group">
		        	<div class= "col-md-3"> 
		        <label><span class="text-danger">*</span>ID Number:</label>
					<input type="number" min="0" name="idnumber" value='{{$graduate->id_number}}' class="form-control" required>
					</div>
					<div class="col-md-3 form-group">
						<label><span class="text-danger">*</span>First Name:</label>
						<input type="text" name="firstname" class="form-control" value='{{$graduate->first_name}}' required>
				</div>

				<div class="col-md-3 form-group">
					<label><span class="text-danger"></span>Middle Name</label>
					<input type="text" name="middlename" class="form-control" value='{{$graduate->middle_name}}'>
                </div>
                <div class="col-md-3 form-group">
					<label><span class="text-danger">*</span>Last Name</label>
					<input type="text" name="lastname" class="form-control" value='{{$graduate->last_name}}'required>
				</div>
                </div>
                
		        <div class="row form-group">
                    <div class="col-md-12 form-group">
                        <label><span class="text-danger"></span>Email</label>
                        <input type="email" name="email" value='{{$graduate->email}}' class="form-control">
                    </div>
                </div>
		      <div class="modal-footer">
		        <button type="submit" class="btn btn-info">Update</button>
	      	  </div>
	      	</div>
            </div>
             </form>
@endsection
@section('scripts')

<script type="text/javascript">
	
	$.ajaxSetup({
			headers: {
			   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		
		var token = $("input[name='_token']").val();

    $('#schoolchange').on('change',function(){
            var id = $(this).val();
            $.ajax({
            url:"{{route('alumniGraduate_select')}}",
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
	
	</script>
@endsection