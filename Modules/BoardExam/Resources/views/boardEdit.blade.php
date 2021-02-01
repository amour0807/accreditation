@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
  <h2><small><a href="{{ route('boardDetail',$board->id) }}" class="fa fa-angle-double-left" >&nbsp;&nbsp;Licensure Exam Edit</a> </small></h2>
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

<form action="{{route('updateBoard')}}" method="post" enctype="multipart/form-data" autocomplete="off" class="form-horizontal form-bordered">
        {{ csrf_field() }}
        <input type="text" value="{{$board->id}}" name="boardID" hidden>
    <div class="col-md-12">

    <div class="row">
        <div class="col-md-4">
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
         </a><br>
          <!--  <a class="btn btn-danger deleteDocu" fileId="{{$board->id}}" style="color: white">Remove Document</a> <br> -->
          @endif
          <div class="form-group">
            <i class="fa fa-upload">Certificate</i>
            <input type="text" class="form-control" value="{{$board->supporting_doc}}" hidden>
            <input type="file" name="supporting_doc" class="form-control"><br>
		  <span class="small">Files accepted: jpeg,jpg, png, pdf </span>
          </div>
          </div>

      <div class="col-md-8">
        <span class="text-danger">* Required Fields</span><br>
      <div class="row form-group">
      <label><span class="text-danger">*</span>Licensure Examination</label>
            <select name="exam" class="form-control" required>
              <option value="Architects"<?=$board->licensure_exam == 'Architects' ? ' selected="selected"' : '';?>>Architects
              </option>
              <option value="Certified Public Accountants"<?=$board->licensure_exam == 'Certified Public Accountants' ? ' selected="selected"' : '';?>>Certified Public Accountants</option>
              <option value="Civil Engineers"<?=$board->licensure_exam == 'Civil Engineers' ? ' selected="selected"' : '';?>>Civil Engineers
              </option>
              <option value="Criminologists"<?=$board->licensure_exam == 'Criminologists' ? ' selected="selected"' : '';?>>Criminologists</option>
              <option value="Dentist - Written"<?=$board->licensure_exam == 'Dentist - Written' ? ' selected="selected"' : '';?>>Dentist - Written</option>
              <option value="Dentist - Practical"<?=$board->licensure_exam == 'Dentist - Practical' ? ' selected="selected"' : '';?>>Dentist - Practical</option>
              
              <option value="Electronic Engineers"<?=$board->licensure_exam == 'Electronic Engineers' ? ' selected="selected"' : '';?>>Electronic Engineers</option>
              <option value="Lawyers"<?=$board->licensure_exam == 'Lawyers' ? ' selected="selected"' : '';?>>Lawyers
              </option>
              <option value="Medical Technologists"<?=$board->licensure_exam == 'Medical Technologists' ? ' selected="selected"' : '';?>>Medical Technologists</option>
              <option value="Midwives"<?=$board->licensure_exam == 'Midwives' ? ' selected="selected"' : '';?>>Midwives
              </option>
              <option value="Nurses"<?=$board->licensure_exam == 'Nurses' ? ' selected="selected"' : '';?>>Nurses
              </option>
              <option value="Physical Therapists"<?=$board->licensure_exam == 'Physical Therapists' ? ' selected="selected"' : '';?>>Physical Therapists
              </option>
              <option value="Psychometricians"<?=$board->licensure_exam == 'Psychometricians' ? ' selected="selected"' : '';?>>Psychometricians</option>
              <option value="Sanitary Engineers"<?=$board->licensure_exam == 'Sanitary Engineers' ? ' selected="selected"' : '';?>>Sanitary Engineers
              </option>
              <option value="Teachers - Secondary Level "<?=$board->licensure_exam == 'Teachers - Secondary Level ' ? ' selected="selected"' : '';?>>Teachers - Secondary Level 
              </option>
              <option value="Teachers - Elementary Level "<?=$board->licensure_exam == 'Teachers - Elementary Level ' ? ' selected="selected"' : '';?>>Teachers - Elementary Level 
              </option>
            </select>
      </div>
        <div class="row form-group">
           <div class="col-md-5">
              <label><span class="text-danger">*</span>Month</label>
                <select  class="form-control" name="month" required>
                  <option value="January" <?=$board->exam_month == 'January' ? 'selected="selected"' : '';?>>January</option>
                  <option value="February" <?=$board->exam_month == 'February' ? 'selected="selected"' : '';?>>February</option>
                  <option value="March" <?=$board->exam_month == 'March' ? 'selected="selected"' : '';?>>March</option>
                  <option value="April" <?=$board->exam_month == 'April' ? 'selected="selected"' : '';?>>April</option>
                  <option value="May" <?=$board->exam_month == 'May' ? 'selected="selected"' : '';?>>May</option>
                  <option value="Jun" <?=$board->exam_month == 'Jun' ? 'selected="selected"' : '';?>>Jun</option>
                  <option value="July" <?=$board->exam_month == 'July' ? 'selected="selected"' : '';?>>July</option>
                  <option value="August" <?=$board->exam_month == 'August' ? 'selected="selected"' : '';?>>August</option>
                  <option value="September" <?=$board->exam_month == 'September' ? 'selected="selected"' : '';?>>September</option>
                  <option value="October" <?=$board->exam_month == 'October' ? 'selected="selected"' : '';?>>October</option>
                  <option value="November" <?=$board->exam_month == 'November' ? 'selected="selected"' : '';?>>November</option>
                  <option value="December" <?=$board->exam_month == 'December' ? 'selected="selected"' : '';?>>December</option>
                </select>
          </div>
            <div class="col-md-5">
                <label><span class="text-danger">*</span>Year</label>
                <label>Year</label>
                <input type="text" value="{{$board->exam_year}}" id="exam_year" hidden>
                <select  class="form-control" name="year" id="dropdownYear" name="year" required>
               </select>
          </div>
          <div class="col-md-2">
              <label><span class="text-danger">*</span>School Rank</label>
              <input type="number" class="form-control" name="school_rank"  min="0" max="10"placeholder="ex. 1" value="{{$board->school_rank}}" required>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
      
        <div class="table-responsive">
          <table id="schooldept_table" class="table table-striped jambo_table" style="table-layout: fixed; width: 100%;">
               <thead>
                 <tr class="headings">
            <th colspan="4"><center>First Takers</center></th>
            <th>UB Passsing<br>Percentage<br>(First Takers)</th>
            <th colspan="4"><center>Total No. of Takers</center></th>
            <th >UB Overall<br>Passsing<br>Percentage</th>
            <th style="width:11%;">National<br>Passsing<br>Percentage</th>
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
            <td class="ftaker-me"><input type="number" class="ftaker form-control" id="fpassed" name="fpassed" min="0" max="100"oninput="calculateSum()" value="{{$board->ftaker_passed}}" required></td>
            <td class="ftaker-me"><input type="number" class="ftaker form-control" name="ffailed" min="0" max="100" oninput="calculateSum()" value="{{$board->ftaker_failed}}" required></td>
            <td class="ftaker-me"><input type="number" class="ftaker form-control" name="fcon" min="0" max="100"oninput="calculateSum()" value="{{$board->ftaker_cond}}"required> </td>
            <td id="ftotal"></td>
            <td id="fpercent"></td>
            <td class="total-me"><input type="number" class="ttaker form-control" id="tpassed" name="tpassed" min="0" max="100" oninput="calculateSum()" value="{{$board->total_passed}}" required></td>
            <td class="total-me"><input type="number" class="ttaker form-control" name="tfailed" min="0" max="100" oninput="calculateSum()" value="{{$board->total_failed}}"required> </td>
            <td class="total-me"><input type="number" class="ttaker form-control" name="tcon" min="0" max="100" oninput="calculateSum()" value="{{$board->total_cond}}"required> </td>
            <td id="ttotal"></td>
            <td id="tpercent"></td>
            <td><input type="number" class="form-control" name="npasser" min="0" max="100" step=".01" style="font-size:13px;" value="{{$board->national_percent}}" required></td>
          </tr>
        </tbody>
      </table>
        </div>
      </div>
    </div>
  <hr>
  </div>
  @if($topnotcher->count() == null)
  <div class="col-md-12 form-group">
            <div class="col-md-8">
              <label><span class="text-danger"></span>Topnotcher/s</label>
              
              <input type="hidden" class="form-control" value="1" id="total_top" >
              <input type="text" class="form-control" name="topname[]" id="txt">
              <div id="new_top"></div>
            </div>
            <div class="col-md-2">
              <label><span class="text-danger"></span>Rank</label>
              
              <input type="hidden" class="form-control" value="1" id="total_rank">
              <input type="number" min="0" max="10" class="form-control" name="toprank[]" placeholder="ex. 1">
              <div id="new_rank"></div>
            </div>
            <div class="col-md-2"><br>
                  <a onclick="add()" class="fa fa-plus-circle" style="font-size: 20px; color:red;"></a>
                  <a onclick="remove()" class="fa fa-minus-circle" style="font-size: 20px; color:gray;"></a>
                </div>
          </div>
          @else
    <div class="col-md-12">
        
      <strong>Topnotcher/s:</strong> 
      <a onclick="insRow()" class="fa fa-plus-circle" style="font-size: 20px; color:red;"></a>
    
    <div class="row">
    
    <table class="display" id="topTable" style="width:60%">
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
        <input type="text" class="form-control" name="topID[]" value="{{$top->id}}" hidden>
        <?php $count++;
        echo '<tr>
          <td>'.$count.'.</td>' ?>
          <td><input type="text" class="form-control" name="top[]" value="{{$top->name}}"></td>
          <td><input type="number" min="0" max="10"class="form-control" name="rank[]" value="{{$top->rank}}"></td>
          <td><a onclick="deleteRow(this)" class="fa fa-minus-circle" style="font-size: 20px; color:gray;"></a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
</div>
</div>
@endif
<div class="row mt-4">
    <div id="clasValidate" class=" col-sm-12 float-right">
      <button type="submit" id="save" class="btn btn-primary" >Save Changes</button>
      <a class="btn btn-danger" href="{{ route('boardDetail',$board->id) }}"> Back</a>
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
@include('common.functions')
<script type="text/javascript">
$('#dropdownYear').each(function() {

var year = (new Date()).getFullYear();
var current = year;
year -= 30;
var taon = $("#exam_year").val();
for (var i = 30; i > 0; i--) {
    $(this).append('<option value="' + (year + i) + '" '
+
        (taon == (year + i) ? 'selected="selected"' : '') +'>' + (year + i) + '</option>');
}
})
function add(){
          var new_top_no = parseInt($('#total_top').val())+1;
          var new_rank_no = parseInt($('#total_rank').val())+1;
          var new_top="<input type='text' class='form-control' name='topname[]' id='top_"+new_top_no+"'>";
          var new_rank="<input type='text' class='form-control' name='toprank[]' id='rank_"+new_rank_no+"'>";
          $('#new_top').append(new_top);
          $('#new_rank').append(new_rank);

          $('#total_top').val(new_top_no);
          $('#total_rank').val(new_rank_no)
        }
        function remove(){
          var last_top_no = $('#total_top').val();
          var last_rank_no = $('#total_rank').val();
          if(last_top_no>1){
            $('#top_'+last_top_no).remove();
            $('#total_top').val(last_top_no-1);
            $('#rank_'+last_rank_no).remove();
            $('#total_rank').val(last_rank_no-1);
          }
        }
function deleteRow(row) {
  var i = row.parentNode.parentNode.rowIndex;
  document.getElementById('topTable').deleteRow(i);
}


function insRow() {
  var x = document.getElementById('topTable');
  var new_row = x.rows[1].cloneNode(true);
  var len = x.rows.length;
  new_row.cells[0].innerHTML = len;

  var inp1 = new_row.cells[1].getElementsByTagName('input')[0];
  inp1.id += len;
  inp1.value = '';
  var inp2 = new_row.cells[2].getElementsByTagName('input')[0];
  inp2.id += len;
  inp2.value = '';
  x.appendChild(new_row);
}
var $check = $("#checkinput");

$("#txt").keyup(function() {
    $check.val( this.value );
});
    $(document).ready(function(){
     
    var sum = 0;
    var fpassed = document.getElementById("fpassed").value;

    $(".ftaker").each(function() {

      if(!isNaN(this.value)) {
        sum += parseFloat(this.value);
      }

    });
    var fpercent = (fpassed/sum)*100;
    //.toFixed() method will roundoff the final sum to 2 decimal places
    $("#ftotal").html(sum);
    $("#fpercent").html(fpercent.toFixed(2)+"%");


    var total = 0;
    var tpassed = document.getElementById("tpassed").value;
    $(".ttaker").each(function() {

      if(!isNaN(this.value)) {
        total += parseFloat(this.value);
      }

    });
    var tpercent = (tpassed/total)*100;
    var npercent = fpercent+tpercent;
    //.toFixed() method will roundoff the final sum to 2 decimal places
    $("#ttotal").html(total);
    $("#tpercent").html(tpercent.toFixed(2)+"%");
    $("#npercent").html(npercent.toFixed(2)+"%s");
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