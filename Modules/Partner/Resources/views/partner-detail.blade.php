@extends('layouts.app')
@section('content')
    <hr style="margin: 0 0 0 0;">
    <div class="block full"  style="margin-bottom: 10px;" >
    <div class="row block-title" style="padding: 1px 3px 1px 3px;" id="datatable_wrapper">
      <div class="col-md-5">
         <a href="{{ route('partners') }}"> <i class="mdi mdi-keyboard-backspace link-icon">back</i></a>
       <h2><strong>Company Partners<span></strong></h2>
      </div>
      <div class="col-md-3">
        <input type="button" onclick="Edit();" id="btnEdit" class="btn btn-primary float-right" value="Edit"></input>
        <input type="button" onclick="Renew();" id="btnRenew" class="btn btn-info float-right" value="Renew"></input>
      </div>
      <div class="col-md-4">
      </div>
        
    </div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
    </div>
  @endif
@if(!empty(Session::get('success_modal')) && Session::get('success_modal') == 5)
<script>
      $('#success-modal').modal('show');

</script>
@endif
@foreach($partnerR as $pr)
<div class="row">
<!-- For Editing -->
<div class="col-md-8">
  <div id="forView">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-4">
        @if($pr->supporting_doc == "")
      <div > No Supporting Document</div>
      @else

      <a href="{{asset('moa/'.$pr->supporting_doc)}}" target="_blank;"> 
      <?php  $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief','jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];

        $explodeImage = explode('.', 'moa/'.$pr->supporting_doc);
        $extension = end($explodeImage);
        
        if(in_array($extension, $imageExtensions)){  ?>
            <img src="{{asset('moa/'.$pr->supporting_doc)}}" style="height:220px;width:220px;border: 1px solid gray;">
        <?php }else { ?>
          <img src="{{asset('images/pdf.png')}}" style="height:220px;width:220px;border: 1px solid gray;">
         <?php }?>
     </a>
      @endif
      </div>
      <div class="col-md-8" style="padding: 20px;"><br>
        <h5>{{$pr->company_name}}<br><small>{{$pr->nature_partnership}}</small></h5>
         <div class=" col-md-12">
        <label  class="col-sm-3 col-form-label">Scope:</label>
        <label  class="col-sm-7 col-form-label">{{$pr->scope}}</label>
       </div>
       <div class=" col-md-12">
        <label  class="col-sm-3 col-form-label">Validity:</label>
          <?php $from = date('M. d, Y', strtotime($pr->from)); 
          $to = date('M. d, Y', strtotime($pr->to)); ?>
        <label  class="col-sm-7 col-form-label">{{$from}} - {{$to}}</label>
       </div>
        <div class=" col-md-12">
        <label  class="col-sm-3 col-form-label">Status:</label>
        <label  class="col-sm-7 col-form-label">{{$pr->status}}</label>
       </div>
      </div>
    </div>
    <br>
    <div class="row">
       <div class="row col-md-12">
        <div  class="col-sm-3 col-form-label"><label>Classification:</label></div>
        <div  class="col-sm-8 col-form-label">{{$pr->classification}}<br>
          <?php
            $numOfCols = 3;
            $rowCount = 0;
            $bootstrapColWidth = 12 / $numOfCols;
          ?>
         @if($pr->classification == "School")
                <div class="row">
                @foreach($partnerCS as $pcs)
                <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                      <ul>
                        <li>{{$pcs->school_code}}</li>
                      </ul>
                </div>
                  <?php $rowCount++; ?>
                @if($rowCount % $numOfCols == 0) 
                  </div><div class="row">
                @endif
                @endforeach
              </div>
          @elseif($pr->classification == "Program")
                <div class="row">
                @foreach($partnerCP as $pcp)
                <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                      <ul>
                        <li> {{$pcp->acad_prog_code}}</li>
                      </ul>
                </div>
                  <?php $rowCount++; ?>
                @if($rowCount % $numOfCols == 0) 
                  </div><div class="row">
                @endif
                @endforeach
              </div>
          @endif
        </div>
       </div>
       <div class="row col-md-12">
        <div  class="col-sm-3 col-form-label"><label>Nature of Partnership:</label></div>
        <div  class="col-sm-8 col-form-label">
                <div class="row col-md-12">
                @foreach($pr->partner_nature as $pn)
                <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                      <ul>
                        <li>{{$pn->nature}}</li>
                      </ul>
                </div>
                  <?php $rowCount++; ?>
                 
                @if($rowCount % $numOfCols == 0) 
                </div><div class="row col-md-12">
                @endif
                @endforeach
              </div>
        </div>
      </div>
    </div>
  </div>
</div> <!-- closing view -->
<div id="forEdit"><!--{{route('updatePartner')}}-->
  <form action="" method="post" enctype="multipart/form-data" autocomplete="off" >
                                            {{ csrf_field() }}
  <input type="text"  name="partnerID" value="{{$pr->id}}" hidden>
    <div class="col-md-12">
      <div class="row">
      <div class="col-md-4">
        @if($pr->supporting_doc == "")
      <div > No Supporting Document</div>
      @else
      <a href="{{asset('moa/'.$pr->supporting_doc)}}" target="_blank;"> 
      <?php  $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief','jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];

        $explodeImage = explode('.', 'moa/'.$pr->supporting_doc);
        $extension = end($explodeImage);
        
        if(in_array($extension, $imageExtensions)){  ?>
            <img src="{{asset('moa/'.$pr->supporting_doc)}}" style="height:220px;width:220px; border: 1px solid gray;">
        <?php }else { ?>
          <img src="{{asset('images/pdf.png')}}" style="height:220px;width:220px;border: 1px solid gray;">
         <?php }?>
     </a>
      @endif
        <div class="form-group">
              <i class="fas fa-upload">Update Document</i>
              <input type="text"  id="award_cert" name="award_cert" class="form-control" value="{{$pr->supporting_doc}}" hidden>
              <input type="file"  id="supporting_file" name="supporting_file" class="form-control" onchange="ViewSave('supporting_file');"><br>
              <div style="display:inline-block; vertical-align: middle;">
               <button type="submit" id="saveimage" class="btn btn-primary" hidden>Save Document</button>
             </div>
            </div>
        </div>
        <div class="col-md-8" style="padding: 20px;">
           <div class="row form-group">
                  <label><span class="text-danger">*</span>Name of Partner</label>
                  <input type="text" class="form-control" name="partner" value="{{$pr->company_name}}" required>
            </div>
          <div class="row col-md-12">
              <div  class="col-md-3">
                <label><span class="text-danger">*</span>Scope:</label>
              </div>
              <div class="col-md-9">
                  <select name="scope" class="form-control small" required>
                    <option value="Local" <?=$pr->scope == 'Local' ? ' selected="selected"' : '';?>>Local</option>
                    <option value="Regional" <?=$pr->scope == 'Regional' ? ' selected="selected"' : '';?>>Regional</option>
                    <option value="National" <?=$pr->scope == 'National' ? ' selected="selected"' : '';?>>National</option>
                    <option value="International" <?=$pr->scope == 'International' ? ' selected="selected"' : '';?>>International</option>
                  </select>
              </div>
          </div>
          <div class="row col-md-12">
          <div  class="col-md-3">
            <label><span class="text-danger"></span>Validity:</label>
          </div>
            <div class="col-md-9">
                <div class="row" >
                  <div class="col-md-6">
                      <label><span class="text-danger"></span>From</label>
                      <input type="date" class="form-control" name="from" value="{{$pr->from}}" >
                  </div>
                  <div class="col-md-6">
                      <label><span class="text-danger"></span>To</label>
                      <input type="date" class="form-control" name="to"  value="{{$pr->to}}" >
                  </div>
                </div>
            </div>
         </div>
        </div>
      </div>
      <div class="row">
         <div class="row col-md-12">
          <div  class="col-md-3">
            <label><span class="text-danger"></span>Classification:</label>
          </div>
            <div class="col-md-9">
                <select name="classification" class="form-control small" onchange='CheckClas(this.value);' required>
                <option value="Institutional" <?=$pr->classification == 'Institutional' ? ' selected="selected"' : '';?>>Institutional</option>
                <option value="School" <?=$pr->classification == 'School' ? ' selected="selected"' : '';?>>School</option>
                <option value="Program" <?=$pr->classification == 'Program' ? ' selected="selected"' : '';?>>Program</option>
              </select>
              <?php
            $numOfCols = 4;
            $rowCount = 0;
            $bootstrapColWidth = 12 / $numOfCols;
          ?>
         @if($pr->classification == 'School')
          <fieldset id="schoolset" style='display:block;'>
        @else
        <fieldset id="schoolset" style='display:none;'>
          @endif
            <legend>Schools</legend>
                <div class="row">
                @foreach($school as $sc)
                <div class="col-md-<?php echo $bootstrapColWidth; ?>">
           
                  <input type="checkbox" id="{{$sc->id}}" name="schoolc[]" value="{{$sc->id}}">
                      <label for="{{$sc->id}}"> {{$sc->school_code}}</label>
                </div>
                  <?php $rowCount++; ?>
                @if($rowCount % $numOfCols == 0) 
                  </div><div class="row">
                @endif
                @endforeach
              </div>
          </fieldset>
          @if($pr->classification == 'Program')
          <fieldset id="program" style='display:block;'>
          @else
          <fieldset id="program" style='display:none;'>
          @endif
            <legend>Programs</legend>
                <div class="row">
                @foreach($program as $prog)
                <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                     <input type="checkbox" id="{{$pr->id}}" name="programc[]" value="{{$prog->id}}">
                    <label for="{{$prog->id}}"> {{$prog->acad_prog_code}}</label>
                </div>
                  <?php $rowCount++; ?>
                @if($rowCount % $numOfCols == 0) 
                  </div><div class="row">
                @endif
                @endforeach
              </div>
          </fieldset>
        </div>
      </div>
      </div>
      <div class="row form-group">
      <?php 
          $true = '';   //Define first blank the variable
          foreach($pr->partner_nature as $pn) { 
            $array[] = $pn->nature;
          } 
          ?>
            <legend>Nature of Partnership</legend>
          <div class="row col-md-12">
                <div class="col-md-4">
                <input type="checkbox"  name="nature[]" value="Faculty Dev't" <?php $array == "Faculty Dev't" ? ' checked="checked"' : '';?>>
                    <label >Faculty Dev't</label>
              </div>
              <div class="col-md-4">
                <input type="checkbox"  name="nature[]" value="Staff Dev't">
                    <label >Staff Dev't</label>
              </div>
              <div class="col-md-4">
                <input type="checkbox"  name="nature[]" value="Student Dev't">
                    <label >Student Dev't</label>
              </div>
          </div>
          <div class="row col-md-12">
              <div class="col-md-4">
                <input type="checkbox"  name="nature[]" value="Research">
                    <label >Research</label>
              </div>
              <div class="col-md-4">
                <input type="checkbox"  name="nature[]" value="ECOS">
                    <label >ECOS</label>
              </div>
              <div class="col-md-4">
                <input type="checkbox" id="others" onclick="otherNature()"  name="nature[]" value="Others">
                    <label >Others</label>
              </div>
          </div>
      </div>
          <div class="row form-group" id="naturegrp" style="display: none;">
            <div class="row col-md-12">
              <div class="col-md-8">
                <label><span class="text-danger"></span>Others</label>
                <input type="hidden" class="form-control" value="1" id="total_nature">
                <input type="text" class="form-control" name="nature[]">
                <div id="new_nature"></div>
              </div>
              <div class="col-md-4"><br>
                <a onclick="add()" class=" mdi mdi-plus-circle" style="font-size: 20px; color:red;"></a>
                <a onclick="remove()" class=" mdi mdi-minus-circle" style="font-size: 20px; color:gray;"></a>
              </div>
            </div>
          </div>
    </div>
    <div class="col-sm-12">
      <button type="submit" id="save" class="btn btn-primary float-right" >Save Changes</button>
    </div>
  </form>
</div> <!-- closing view -->
<div id="forRenew">
  <form action="{{route('renewPartner')}}" method="post" enctype="multipart/form-data" autocomplete="off" >
                                            {{ csrf_field() }}
  <input type="text"  name="renew_partnerID" value="{{$pr->id}}" hidden>
    <div class="col-md-12">
      <div class="row col-md-12">
        <h5>{{$pr->company_name}}<br><small>{{$pr->nature_partnership}}</small></h5>
      </div>
       <hr>
      <div class="row">
        <div class="col-md-4">
        <div class="form-group">
              <i class="fas fa-upload">Upload Document</i>
              <input type="file"  id="supporting_file" name="supporting_file" class="form-control" required><br>
              <div style="display:inline-block; vertical-align: middle;">
               <button type="submit" id="saveimage" class="btn btn-primary" hidden>Save Document</button>
             </div>
            </div>
        </div>
        <div class="col-md-8">

          <div class="row col-md-12">
          <div  class="col-md-3">
            <label><span class="text-danger"></span>Validity:</label>
          </div>
            <div class="col-md-9">
                <div class="row" >
                  <div class="col-md-6">
                      <label><span class="text-danger"></span>From</label>
                      <input type="date" class="form-control" name="from" required>
                  </div>
                  <div class="col-md-6">
                      <label><span class="text-danger"></span>To</label>
                      <input type="date" class="form-control" name="to" required>
                  </div>
                </div>
            </div>
         </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12">
      <button type="submit" id="save" class="btn btn-primary float-right" >Renew</button>
    </div>
  </form>
</div> <!-- closing view -->
</div>
<div class="col-md-4" style="border-left: 2px solid silver; ">
<label>Partnership History</label>
<hr>
    <!-- Table showing awards -->

    <table id="partner_history_table" class="display compact cell-border" style="table-layout: fixed">
        <thead>
              <tr>
                <th>From</th>
                <th>To</th>
                <th>Supporting <br>Document</th>
              </tr>
        </thead>   
    </table>
    </div>
</div>

<script type="text/javascript">

  $(document).ready(function(){
    var edit = document.getElementById("forEdit");
    var renew = document.getElementById("forRenew");
    renew.style.display='none';
    edit.style.display='none';

  });
    $.ajaxSetup({
	    headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
    });

     
    var token = $("input[name='_token']").val();

    function CheckClas(val){
     var school=document.getElementById('schoolset');
     var program=document.getElementById('program');
     if(val=='School'){
       school.style.display='block';
       program.style.display='none';
     }else if (val=='Program'){
       program.style.display='block';
       school.style.display='none';
      }else{
        school.style.display='none';
        program.style.display='none';
      }
    }
    function CheckRenew(val){
     var school=document.getElementById('renew_school');
     var program=document.getElementById('renew_program');
     if(val=='School'){
       school.style.display='block';
       program.style.display='none';
     }else if (val=='Program'){
       program.style.display='block';
       school.style.display='none';
      }else{
        school.style.display='none';
        program.style.display='none';
      }
    }
    function Edit(){
    var edit = document.getElementById("forEdit");
    var view = document.getElementById("forView");
    var renew = document.getElementById("forRenew");
    var btnRenew = document.getElementById("btnRenew");
    var btnEdit = document.getElementById("btnEdit");
        if (edit.style.display === "none") {
          edit.style.display = "block";
          view.style.display = "none";
          renew.style.display = "none";
          btnEdit.value = "Cancel";
          btnRenew.value = "Renew"
          btnRenew.style.display = "block";
        } else{
          edit.style.display = "none";
          view.style.display = "block";
          btnEdit.value = "Edit";
        }
    }
    function Renew(){
    var edit = document.getElementById("forEdit");
    var view = document.getElementById("forView");
    var renew = document.getElementById("forRenew");
    var btnRenew = document.getElementById("btnRenew");
    var btnEdit = document.getElementById("btnEdit");
        if (renew.style.display === "none") {
          edit.style.display = "none";
          view.style.display = "none";
          renew.style.display = "block";
          btnRenew.value = "Cancel";
          btnEdit.value = "Edit";
        } else{
          edit.style.display = "none";
          renew.style.display = "none";
          view.style.display = "block";
          btnRenew.value = "Renew";
        }
    }
    function otherNature() {
      var checkBox = document.getElementById("others");
      // Get the output text
      var grp = document.getElementById("naturegrp");

      // If the checkbox is checked, display the output text
      if (checkBox.checked == true){
        grp.style.display = "block";
      } else {
        grp.style.display = "none";
      }
    }
    function add(){
          var new_nature_no = parseInt($('#total_nature').val())+1;
          var new_nature="<input type='text' class='form-control' name='nature[]' id='nature_"+new_nature_no+"'>";
          
          $('#new_nature').append(new_nature);
          $('#total_nature').val(new_nature_no);
        }
        function remove(){
          var last_nature_no = $('#total_nature').val();
          if(last_nature_no>1){
            $('#nature_'+last_nature_no).remove();
            $('#total_nature').val(last_nature_no-1);
          }
        }
 var dataTable = $('#partner_history_table').DataTable( {
          "processing" : true,
          "serverSide" : true,
          "paging" : false,
          "searching" : false,
          "bSort" : false,

          "ajax": "{{route('partner_history_dtb', $pr->id)}}",
          
          responsive: false,
          "scrollX": false,
          
          "columns": [
              { "data": "from" },
              { "data": "to" },
              { "data": "supporting_doc" },
          ],

        });
    </script>
    @endforeach
@endsection
