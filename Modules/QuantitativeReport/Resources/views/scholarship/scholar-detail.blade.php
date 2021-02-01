@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
  <h2><a href="{{ route('scholarIndex') }}" class="fa fa-angle-double-left" >&nbsp;&nbsp;Scholarship / Grant Detail </a></h2>
  @if(Auth::user()->hasPermission('edit-scholar'))
  <a class="btn btn-app float-right" href="{{route('scholarEdit',$scholar->s_id)}}">
    <i class="fa fa-plus-square-o"></i> Edit
  </a>
    @endif
  <div class="clearfix"></div>
</div>
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
    <br>
  <div class=" row">
      <div class="col-md-12">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive" id="summary">
          <table id="schooldept_table" class="table table-bordered jambo_table bulk_action" style="width: 100%;">
               <thead>
                 <tr>
            <th rowspan="3" style="width: 30%;"><center>Scholarships/Grants</center></th>
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
            <td>{{$scholar->scholar_title}}<br>{{$scholar->category}}<br>{{$scholar->company}}</td>
            <td>{{number_format($scholar->fno)}}</td>
            <td>{{number_format($scholar->fphp)}}</td>
            <td>{{number_format($scholar->sno)}}</td>
            <td>{{number_format($scholar->sphp)}}</td>
            <td>{{number_format($scholar->stno)}}</td>
            <td>{{number_format($scholar->stphp)}}</td>
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
  <hr>
    </div>
        </div>
      </div>
@endsection