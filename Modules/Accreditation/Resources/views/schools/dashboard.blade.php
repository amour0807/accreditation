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
       <h2><strong>{{$school->school_name}} <br>
                Accredited Programs<span></strong></h2>
    <a class="btn btn-info float-right " href="{{route('userAdd_accred_form')}}">
        Add an accreditation
    </a>
    </div>
  <div class="alert"></div>

     @if (session('error'))
                        <div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('error') }}
                        </div>
                    @endif
                        @if (session('success'))
                            <div class="alert alert-dismissible alert-success">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{ session('success') }}
                            </div>
                        @endif
@if(Session::has('message'))
<div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <div>The program 
    @foreach($expiring as $exp)
        <strong>{{$exp->acad_prog}}'s</strong> from the <strong>{{$exp->school_name}}'s</strong><br> 
    @endforeach
    accreditation will expire in less than a year</div>
          
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
    <hr>
@endsection
