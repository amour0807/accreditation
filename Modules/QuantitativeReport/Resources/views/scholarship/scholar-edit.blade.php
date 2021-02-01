@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
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
        <a href="{{route('scholarDetail',$scholar->s_id)}}" class="fa fa-angle-double-left" text="back">&nbsp;&nbsp;Back</a>
          <br><br>
<form id="form" action="{{ route('updateScholar') }}" method="post" enctype="multipart/form-data" autocomplete="off" id="studentForm" class="form-horizontal form-bordered">
     {{ csrf_field() }}
	 <input type="text" name="scholarid" value="{{$scholar->s_id}}" hidden>
	 <input type="text" name="discountid" value="{{$scholar->id}}" hidden>
      <div class="col-md-12">
    <div class="row">
      <div class="col-md-12">
	     <div class="col-md-3"><label><span class="text-danger">*</span>Scholarship / Grant:</label></div>
		 <div class="col-md-4">
      <label><span class="text-danger">*</span> Scholarships / Grants:</label>
            
      <select class="form-control small" name="scholarshipID">
         <option disabled selected value> -- --  </option>
        @foreach($list as $sc)
          <option value = '{{ $sc->id }}' <?=$scholar->scholarship_id == $sc->id ? 'selected="selected"':''?>> {{ $sc->scholar_title}}  </option>
       @endforeach
</select>
		 </div>
	  </div>
	  <div class="col-md-12">
	     <div class="col-md-3"></div>
		 <div class="col-md-4">
          <p>&nbsp;&nbsp;Category: {{$scholar->category}}
          @if($scholar->category == 'External')
          Company: {{$scholar->company}}</p>
          @endif
		 </div>
	  </div>
	  <div class="col-md-12">
	  <div class="col-md-3">
	  <label><span class="text-danger">*</span>School Year:</label></div>
		 <div class="col-md-4">
			<select name="school_year" class="form-control">
				<option disabled selected value> -- --  </option>
				<?php $now = now()->year; ?>
					@for($year = $now; $year >= 2015 ; $year--)
					<?php $add = $year+1; ?>
								 @if($year." - ".$add == $scholar->school_year)
								 <option value='{{$year}} - {{$year+1}}' selected>{{$year}} - {{$year+1}}</option>
								 @else
								 <option value='{{$year}} - {{$year+1}}'>{{$year}} - {{$year+1}}</option>
								 @endif
					@endfor
			</select>
		 </div>
	  </div>
	  
        <div class="table-responsive" id="summary">
          <table id="schooldept_table" class="table table-bordered jambo_table bulk_action" style="width: 100%;">
               <thead>
                 <tr>
            <th colspan="8"><center>Academic Year {{$scholar->school_year}}</center></th>
          </tr>
          <tr>
            <th colspan="2"><center>1st Semester</center></th>
            <th colspan="2"><center>2nd Semester</center></th>
            <th colspan="2"><center>Short Term</center></th>
            <th colspan="2"><center>Total</center></th>
          </tr>
          <tr>
            <th>Total</th>
            <th>Amount</th>
            <th>Total</th>
            <th>Amount</th>
            <th>Total</th>
            <th>Amount</th>
            <th>Total</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><span class="text-danger">*</span><input type="number" class="form-control" name="fno" min="0"value="{{$scholar->fno}}" required></td>
            <td><span class="text-danger">*</span><input type="number" class="form-control" name="fphp" min="0"value="{{$scholar->fphp}}" step=".01" required></td>
            <td><span class="text-danger">*</span><input type="number" class="form-control" name="sno" min="0"value="{{$scholar->sno}}" required></td>
            <td><span class="text-danger">*</span><input type="number" class="form-control" name="sphp" min="0"value="{{$scholar->sphp}}" step=".01" required></td>
            <td><span class="text-danger">*</span><input type="number" class="form-control" name="stno" min="0"value="{{$scholar->stno}}" required></td>
            <td><span class="text-danger">*</span><input type="number" class="form-control" name="stphp" min="0" value="{{$scholar->stphp}}" step=".01" required></td>
            <?php 
              $tno = ($scholar->fno)+($scholar->sno)+($scholar->stno);
              $tphp = ($scholar->fphp)+($scholar->sphp)+($scholar->stphp);
             ?>
            <td>{{number_format($tno)}}</td>
            <td>{{number_format($tphp)}}</td>
          </tr>
        </tbody>
      </table>
      </div>
    </div>
  </div>
  </div>
  <div class="row mt-4">
    <div class=" col-sm-12 float-right">
      <button type="submit" id="save" class="btn btn-primary" >Save Changes</button>
    </div>
    </div>
    </form>
        </div>
      </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">

	function CheckAward(val){
	 var element=document.getElementById('others2');
	 if(val=='External')
	   element.style.display='block';
	 else
	   element.style.display='none';
	}
	</script>
@endsection