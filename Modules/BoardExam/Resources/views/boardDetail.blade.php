@extends('layouts.app')
@section('content')
    <hr style="margin: 0 0 0 0; ">
    <div class="block full"  style="margin-bottom: 10px;" >
    <div class="block-title" style="padding: 1px 3px 1px 3px;">
       <h2><strong>Licensure Exam Details</strong>
       </h2>
    </div>
  <div class="alert"></div>
  @if(Session::has('message'))
    <div class="alert alertOld alert-info alert-dismissible fade show alertOld" role="alert">
      {{ Session::get('message') }}
                <button type="button" class="close" data-dismiss="alert">×</button>
    </div> 
    @endif
    @if(Session::has('red'))
      
    <div class="alert alertOld alert-danger alert-dismissible fade show alertOld" role="alert">
      {{ Session::get('red') }}
                <button type="button" class="close" data-dismiss="alert">×</button>
    </div> 
  @endif
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

@if (session('success'))
     <div class="alert alert-info alert-block">
            <strong>{{ session('success') }}</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
     
@endif
    <br>
  <div class=" row">
      <div class="col-md-12">
    <div class="row">
      <div class="col-md-4">
        @if($board->supporting_doc == "")
      <div > No Supporting Document</div>
      @else

      <a href="{{asset('board/'.$board->supporting_doc)}}" target="_blank;"> 
      <?php  $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief','jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];

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
      <div class="col-md-4">
        <h5>{{$board->licensure_exam}}<br><small>{{$board->type}}<br> 
          <?php $exam = date('M. d, Y', strtotime($board->exam_date));  ?>
       {{$exam}}
        </small></h5>
      </div>
      @if(!$topnotcher->isEmpty())
      <div class="col-md-4">
        <strong>Topnotchers:</strong>
      <table class="display" style="width:100%">
        <thead>
          <tr>
            <th>Name</th>
            <th>Rank</th>
          </tr>
        </thead>
        <tbody>
           @foreach($topnotcher as $top)
          <tr>
            <td>{{$top->name}}</td>
            <td>{{$top->rank}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      </div>
      @endif
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
      <table class="display table-bordered" style="width:100%" id="summary">
        <thead>
          <tr>
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


<script type="text/javascript">
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
    $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
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