@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
  <h2> <a href="{{ route('boardExam') }}" class="fa fa-angle-double-left" >&nbsp;&nbsp;Licensure Exam Details </a></h2>
  @if(Auth::user()->hasPermission('edit-board'))
  <a class="btn btn-app float-right" href="{{route('boardEdit',$board->id)}}">
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
      <div class="col-md-4 col-sm-6 col-xs-6">
        @if($board->supporting_doc == "")
      <div > No Supporting Document</div>
      @else

      <a href="{{asset('board/'.$board->supporting_doc)}}" target="_blank;"> 
      <?php  $imageExtensions = ['jpg', 'jpeg', 'png'];

        $explodeImage = explode('.', 'board/'.$board->supporting_doc);
        $extension = end($explodeImage);
        
        if(in_array($extension, $imageExtensions)){  ?>
            <img src="{{asset('board/'.$board->supporting_doc)}}" style="height:150px;width:150px;">
        <?php }else { ?>
          <img src="{{asset('images/pdf.png')}}" style="height:150px;width:150px;">
         <?php }?>
     </a>
      <!--  <a class="btn btn-danger deleteDocu" fileId="{{$board->id}}" style="color: white">Remove Document</a> <br> -->
      @endif
      </div>
      <div class="col-md-8 col-sm-6 col-xs-6">
        <h5>{{$board->licensure_exam}}<br><small>{{$board->type}}<br> 
         {{$board->exam_month}} {{$board->exam_year}}
       <br>School Rank : {{$board->school_rank}}
        </small></h5>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive" id="summary">
          <table id="schooldept_table" class="table table-striped jambo_table bulk_action" style="width: 100%;">
               <thead>
                 <tr class="headings">
            <th colspan="4"><center>First Takers</center></th>
            <th>UB Passsing<br>Percentage<br>(First Takers)</th>
            <th colspan="4"><center>Total No. of Takers</center></th>
            <th>UB Overall<br>Passsing<br>Percentage</th>
            <th>National<br>Passsing<br>Percentage</th>
          </tr>
          <tr>
            <th>Passed</th>
            <th>Failed</th>
            <th>Con</th>
            <th>Total</th>
            <th></th>
            <th>Passed</th>
            <th>Failed</th>
            <th>Con</th>
            <th>Total</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="ftaker-me" id="fpassed">{{$board->ftaker_passed}}</td>
            <td class="ftaker-me">{{$board->ftaker_failed}}</td>
            <td class="ftaker-me">{{$board->ftaker_cond}}</td>
            <td id="ftotal"></td>
            <td id="fpercent"></td>
            <td class="total-me" id="tpassed">{{$board->total_passed}}</td>
            <td class="total-me">{{$board->total_failed}}</td>
            <td class="total-me">{{$board->total_cond}}</td>
            <td id="ttotal"></td>
            <td id="tpercent"></td>
            <td>{{$board->national_percent}}%</td>
          </tr>
        </tbody>
      </table>
      </div>
    </div>
  </div>
  </div>
  <hr>
  <div class="row col-md-12">
    @if(!$topnotcher->isEmpty())
      <strong>Topnotcher/s:</strong>
    <table class="display" style="width:50%">
      <thead>
        <tr>
          <th></th>
          <th>Name</th>
          <th>Rank</th>
        </tr>
      </thead>
      <tbody>
        <?php $count = 0; ?>
        @foreach($topnotcher as $top)
        <?php $count++;
        echo '<tr>
          <td>'.$count.'.</td>' ?>
          <td>{{$top->name}}</td>
          <td>{{$top->rank}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
    <div>
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
        title: 'Done!',
        text: 'Successfully Updated!',
        timer: 1500
      })
      </script>
        @elseif(\Session::has('error'))
        <script>
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong!',
          footer: "<a>Back</a>"
        }) 
        </script>
        @endif
<script type="text/javascript">

$.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $(document).ready(function(){
     var tds = document.getElementById('summary').getElementsByTagName('td');
            var sum = 0;
            var total = 0;
            for(var i = 0; i < tds.length; i ++) {
                if(tds[i].className == 'ftaker-me') {
                    sum += isNaN(tds[i].innerHTML) ? 0 : parseInt(tds[i].innerHTML);
                }
            }
             $('#ftotal').html(sum);
             var fpassed = $(this).find("#fpassed").html();   
             var fpercent = (fpassed/sum)*100;
             $('#fpercent').html(fpercent.toFixed(2)+"%");

             for(var i = 0; i < tds.length; i ++) {
                if(tds[i].className == 'total-me') {
                    total += isNaN(tds[i].innerHTML) ? 0 : parseInt(tds[i].innerHTML);
                }
            }
            $('#ttotal').html(total);
             var tpassed = $(this).find("#tpassed").html();   
             var tpercent = (tpassed/total)*100;
             $('#tpercent').html(tpercent.toFixed(2)+"%");

});
    
    var token = $("input[name='_token']").val();

            $('.alertOld').show();
            $(".alertOld").delay(4000).fadeOut(500);
            setTimeout(function(){
              $('#alertMessage').remove();
            }, 5000);
  //delete
  $(document).on('click','.deleteCert',function(){
      var conf = confirm('Are you sure you want to delete this record?');
      var fileId = $(this).attr('fileId');
      var type = $(this).attr('type');


      if(conf){
        $.ajax({
          url:"{{route('deleteCert')}}",
          method:"POST",
          data:{
            fileId:fileId,
            type:type,
            _token:token
          },
          success:function(data){
          
            location.reload();
            $('.deleteAlert').append('<span id="alertMessage">Record deleted!</span>');
            
          },
          error: function(jqxhr, status, exception) {
             alert('this record still has a task. Please delete it all then delete this project.');
         }

        });  
      }
    }); 
</script>
@endsection