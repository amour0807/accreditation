@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
  <h2><small>User Details </small></h2>
  <a class="btn btn-app float-right"  href="{{route('userEdit',$user->u_id)}}">
    <i class="fa fa-plus-square-o"></i> Edit users 
  </a>
  <div class="clearfix"></div>
</div>
	  <div class="x_content">
		  <div class="row">
			  <div class="col-sm-12">
  <div class="alert"></div>
  @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
    </div>
  @endif
  @if ($message = Session::get('error'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
    </div>
  @endif
  
<div style="float: center;">
  <div class="form-group">
    <center><label>{{$user->first_name}} {{$user->middle_initial}}, {{$user->last_name}}
    <br>{{$user->role_name}}<br>{{$user->school_name}}<label></center>
  </div>
  <div class="form-group">
    <label class="col-sm-2 col-form-label">Permissions</label><br><br>
    <div class="row">
    <?php
        $numOfCols = 4;
        $rowCount = 0;
        $bootstrapColWidth = 12 / $numOfCols;
    ?>
    @foreach($permissions as $p)
                <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                    <li> {{$p->slug}}</li>
                </div>
                  <?php $rowCount++; ?>
                @if($rowCount % $numOfCols == 0) 
                  </div><div class="row">
                @endif
                @endforeach
              </div>
  </div>
</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection