@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
	  <div class="x_content">
		  <div class="row">
			  <div class="col-sm-12">
   <div class="alert"></div>
  
  @if(Session::has('message'))
        <div class="alert alert-dismissible alert-info">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <div>The program @foreach($expiring as $exp) <strong>{{$exp->acad_prog_code}}</strong> from the <strong>{{$exp->school_code}}</strong><br>
    @endforeach accreditation will expire in less than a year</div>
          
        </div>
        
@endif
<div class="row col-md-12" style="display: inline-block;" >
    <div class="tile_count">
      
      <div class="col-md-2 col-sm-4 col-xs-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-level-up"></i> Orientation</span>
        <div class="count">{{$count5}}</div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-level-up"></i> Candidate Status</span>
        <div class="count">{{$count6}}</div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-level-up"></i> Level I</span>
        <div class="count">{{$count1}}</div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-level-up"></i> Level II</span>
        <div class="count">{{$count2}}</div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-level-up"></i> Level III</span>
        <div class="count">{{$count3}}</div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-level-up"></i> Level IV</span>
        <div class="count">{{$count4}}</div>
      </div>
    </div>
  </div>
  <div class="row col-md-12" style="display: inline-block;">
    <div class="top_tiles">
      <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 ">
        <div class="tile-stats">
          <div class="icon"><i class="fa "></i></div>
          <div class="count">{{$topnotcher}}</div>
          <h3>Topnotchers</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 ">
        <div class="tile-stats">
          <div class="icon"><i class="fa "></i></div>
          <div class="count">{{$activeP}}</div>
          <h3>Active Partners</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 ">
        <div class="tile-stats">
          <div class="icon"><i class="fa "></i></div>
          <div class="count">{{$inactiveP}}</div>
          <h3>Inactive Partners</h3>
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
  icon: 'success',
  title: 'Your password has been updated!',
  showConfirmButton: false,
  timer: 1500
})
</script>
@endif
@endsection