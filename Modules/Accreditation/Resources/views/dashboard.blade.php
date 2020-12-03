@extends('layouts.app')
@section('content')
          <hr style="margin: 0 0 0 0;">
          <div class="block full"  style="margin-bottom: 10px;" >
         <div class="block-title" style="padding: 1px 3px 1px 3px;">
         <h2><strong>Dashboard</strong></h2>
          
  </div>

        
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
        <div class="row text-center mt-4 py-3" >
        
        <div class="col-md-2 ">
            <div class="card hvr-shadow">
                <h1 class="card-title">{{$count4}}</h1>
                <a href="#" class="bg-ub-grey stretched-link ">Level IV</a>
            </div>
        </div>
        <div class="col-md-2 ">
            <div class="card hvr-shadow">

                <h1 class="card-title">{{$count3}}</h1>
                <a href="#" class="bg-ub-grey stretched-link">Level III</a>

            </div>
        </div>
        <div class="col-md-2 ">
            <div class="card hvr-shadow">

                <h1 class="card-title">{{$count2}}</h1>
                <a href="#" class="bg-ub-grey stretched-link">Level II</a>

            </div>
        </div>
        <div class="col-md-2">
            <div class="card hvr-shadow">
                <h1 class="card-title">{{$count1}}</h1>
                <a href="#" class="bg-ub-grey stretched-link">Level I</a>

            </div>
        </div>

        <div class="col-md-2 ">
            <div class="card hvr-shadow">
                <h1 class="card-title">{{$count6}}</h1>
                <a href="#" class="bg-ub-grey stretched-link">Candidate Status</a>

            </div>
        </div>

        <div class="col-md-2  ">
            <div class="card hvr-shadow">
                <h1 class="card-title">{{$count5}}</h1>
                <a href="#" class="bg-ub-grey stretched-link">Orientation</a>

            </div>
        </div>
 
    </div>
    <br>
@endsection
