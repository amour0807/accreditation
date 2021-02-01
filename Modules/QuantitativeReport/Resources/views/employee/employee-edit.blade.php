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
        <a href="{{route('hrInput')}}" class="fa fa-angle-double-left" text="back">&nbsp;&nbsp;Back</a>
        <br><br>
        <form id="form" action="{{ route('updateEmployee') }}" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered" style="padding: 0px 8px 0px 16px;">
											{{ csrf_field() }}
			
											<span class="text-danger">* Required Fields</span><br>
          	  <div class="modal-body">
		      	 <div class="form-group">
		    	<input name="id" value='{{$employee->id}}' hidden>
				<div class="row form-group">
					
				<div class= "col-md-6"> 
                        <label><span class="text-danger">*</span>@if(!Auth::user()->hasRole('admin')){{$school->school_code}}@endif Schools:</label>
            
                    <select class="form-control small" name="department" required>
                      @foreach($list as $sc)
                      @if($sc->school_code == $employee->department)
                        <option value = '{{ $sc->school_code }}' selected> {{ $sc->school_name }}  </option>
                        @else
                        <option value = '{{ $sc->school_code }}'> {{ $sc->school_name }}  </option>
                        @endif
                     @endforeach
                    </select>
                      </div>
					<div class= "col-md-3"> 
					<label><span class="text-danger">*</span>Semester:</label>
					<select class="form-control small" name="sem" required>
                      
                        <option value = '1st Semester' <?=$employee->semester == '1st Semester' ? ' selected="selected"' : '';?>> First Sem  </option>
                        <option value = '2nd Semester' <?=$employee->semester == '2nd Semester' ? ' selected="selected"' : '';?>> Second Sem  </option>
                    </select>
						</div>
						<div class="col-md-3 form-group">
							<label><span class="text-danger">*</span>School Year:</label>
							<select name="school_year" class="form-control">
								<?php $now = now()->year; ?>
                                @for($year = $now; $year >= 2015 ; $year--)
                                <?php $add = $year+1; ?>
                                @if($year." - ".$add == $employee->school_year)
								    <option value='{{$year}} - {{$year+1}}' selected>{{$year}} - {{$year+1}}</option>
                                @else
                                    <option value='{{$year}} - {{$year+1}}'>{{$year}} - {{$year+1}}</option>
                                    @endif
								@endfor
							</select>
					</div>
				</div>
				
				<label>Teaching:</label>
		        <div class="row form-group">
		        	<div class= "col-md-3"> 
		        <label><span class="text-danger">*</span>Permanent:</label>
					<input type="number" min="0" max="100" name="tpermanent" class="form-control" value='{{$employee->no_Tpermanent}}' required>
					</div>
					<div class="col-md-3 form-group">
						<label><span class="text-danger">*</span>Probationary:</label>
						<input type="number" min="0" max="100" name="tprobationary" class="form-control" value='{{$employee->no_Tprobationary}}' required>
				</div>

				<div class="col-md-3 form-group">
					<label><span class="text-danger">*</span>Contractual</label>

					<input type="number" min="0" max="100" name="tcontractual" class="form-control" value='{{$employee->no_Tcontractual}}' required>
				</div>
				<div class="col-md-3 form-group">
						<label><span class="text-danger">*</span>Part Time:</label>
						<input type="number" min="0" max="100" name="tpartime" class="form-control" value='{{$employee->no_Tpartime}}' required>
				</div>
				</div>
				<label>Non Teaching:</label>
				<div class="row form-group">
					
				<div class="col-md-3 form-group">
						<label><span class="text-danger">*</span>Permanent:</label>
						<input type="number" min="0" max="100" name="ntpermanent" value='{{$employee->no_NTpermanent}}' class="form-control" required>
				</div>
				<div class="col-md-3 form-group">
						<label><span class="text-danger">*</span>Probationary:</label>
						<input type="number" min="0" max="100" name="ntprobationary" value='{{$employee->no_NTprobationary}}'class="form-control" required>
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

@endsection