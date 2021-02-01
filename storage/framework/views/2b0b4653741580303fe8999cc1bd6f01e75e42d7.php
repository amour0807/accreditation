
<?php $__env->startSection('content'); ?>
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
     
  <h2><a href="<?php echo e(route('partners')); ?>" class="fa fa-angle-double-left" >&nbsp;&nbsp;Company Partners </a></h2>
  <?php if(Auth::user()->hasPermission('edit-partner')): ?>
        <input type="button" onclick="Edit();" id="btnEdit" class="btn btn-primary float-right" value="Edit"></input>
        
        <input type="button" onclick="Renew();" id="btnRenew" class="btn btn-info float-right" value="Renew"></input>
        <?php endif; ?>
  <div class="clearfix"></div>
</div>
	  <div class="x_content">
		  <div class="row">
			  <div class="col-sm-12">
  
<div class="row">
<!-- For Editing -->
<div class="col-md-12">
  <div id="forView">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-4">
        <?php if($partner->supporting_doc == ""): ?>
      <div > No Supporting Document</div>
      <?php else: ?>

      <a href="<?php echo e(asset('moa/'.$partner->supporting_doc)); ?>" target="_blank;"> 
      <?php  $imageExtensions = ['jpg', 'jpeg','png'];

        $explodeImage = explode('.', 'moa/'.$partner->supporting_doc);
        $extension = end($explodeImage);
        
        if(in_array($extension, $imageExtensions)){  ?>
            <img src="<?php echo e(asset('moa/'.$partner->supporting_doc)); ?>" style="height:220px;width:220px;border: 1px solid gray;">
        <?php }else { ?>
          <img src="<?php echo e(asset('images/pdf.png')); ?>" style="height:220px;width:220px;border: 1px solid gray;">
         <?php }?>
     </a>
      <?php endif; ?>
      </div>
      <div class="col-md-8" style="padding: 20px;"><br>
        <h5><center><?php echo e($partner->company_name); ?><br><?php echo e($partner->nature_partnership); ?></center></h5>
         <div class=" col-md-12">
        <label  class="col-sm-3 col-form-label">Scope:</label>
        <label  class="col-sm-7 col-form-label"><?php echo e($partner->scope); ?></label>
       </div>
       <div class=" col-md-12">
        <label  class="col-sm-3 col-form-label">Validity:</label>
          <?php $from = date('M. d, Y', strtotime($partner->from)); 
          $to = date('M. d, Y', strtotime($partner->to)); ?>
        <label  class="col-sm-7 col-form-label"><?php echo e($from); ?> - <?php echo e($to); ?></label>
       </div>
        <div class=" col-md-12">
        <label  class="col-sm-3 col-form-label">Status:</label>
        <label  class="col-sm-7 col-form-label"><?php echo e($partner->status); ?></label>
       </div>
      </div>
    </div>
    <br>
    <div class="row">
       <div class="row col-md-12">
        <div  class="col-sm-3 col-form-label"><label>Classification:</label></div>
        <div  class="col-sm-8 col-form-label"><?php echo e($partner->classification); ?><br>
          <?php
            $numOfCols = 3;
            $rowCount = 0;
            $bootstrapColWidth = 12 / $numOfCols;
          ?>
         <?php if($partner->classification == "School"): ?>
                <div class="row">
                <?php $__currentLoopData = $partnerCS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vpcs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                      <ul>
                        <li><?php echo e($vpcs->school_code); ?></li>
                      </ul>
                </div>
                  <?php $rowCount++; ?>
                <?php if($rowCount % $numOfCols == 0): ?> 
                  </div><div class="row">
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
          <?php elseif($partner->classification == "Program"): ?>
                <div class="row">
                <?php $__currentLoopData = $partnerCP; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pcp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                      <ul>
                        <li> <?php echo e($pcp->acad_prog_code); ?></li>
                      </ul>
                </div>
                  <?php $rowCount++; ?>
                <?php if($rowCount % $numOfCols == 0): ?> 
                  </div><div class="row">
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
          <?php endif; ?>
        </div>
       </div>
       <div class="row col-md-12">
        <div  class="col-sm-3 col-form-label"><label>Nature of Partnership:</label></div>
        <div  class="col-sm-8 col-form-label">
                <div class="row col-md-12">
                <?php $__currentLoopData = $partnerN; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                      <ul>
                        <li><?php echo e($pn->nature); ?></li>
                      </ul>
                </div>
                  <?php $rowCount++; ?>
                 
                <?php if($rowCount % $numOfCols == 0): ?> 
                </div><div class="row col-md-12">
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
        </div>
      </div>
    </div>
  </div>
</div> <!-- closing view -->
<div id="forEdit"><!--<?php echo e(route('updatePartner')); ?>-->
<form id="formValidate" action="<?php echo e(route('updatePartner')); ?>" method="post" enctype="multipart/form-data" autocomplete="off" >
                                            <?php echo e(csrf_field()); ?>

  <input type="text"  name="partnerID" value="<?php echo e($partner->id); ?>" hidden>
    <div class="col-md-12">
      <div class="row">
      <div class="col-md-5" >
        <?php if($partner->supporting_doc == ""): ?>
      <div > No Supporting Document</div>
      <?php else: ?>
      <a href="<?php echo e(asset('moa/'.$partner->supporting_doc)); ?>" target="_blank;"> 
      <?php  $imageExtensions = ['jpg', 'jpeg', 'png'];

        $explodeImage = explode('.', 'moa/'.$partner->supporting_doc);
        $extension = end($explodeImage);
        
        if(in_array($extension, $imageExtensions)){  ?>
            <img src="<?php echo e(asset('moa/'.$partner->supporting_doc)); ?>" style="height:220px;width:220px; border: 1px solid gray;">
        <?php }else { ?>
          <img src="<?php echo e(asset('images/pdf.png')); ?>" style="height:220px;width:220px;border: 1px solid gray;">
         <?php }?>
     </a>
      <?php endif; ?>
        <div class="form-group">
              <i class="fa fa-upload">Update Document</i>
              <input type="text"  id="award_cert" name="award_cert" class="form-control" value="<?php echo e($partner->supporting_doc); ?>" hidden>
              <input type="file"  id="supporting_file" name="supporting_file" class="form-control" onchange="ViewSave('supporting_file');"><br>
              <div style="display:inline-block; vertical-align: middle;">
               <button type="submit" id="saveimage" class="btn btn-primary" hidden>Save Document</button>
             </div>
            </div>
        </div>
        <div class="col-md-7" style="padding: 20px;">
          
        <span class="text-danger">* Required Fields</span><br>
           <div class="row form-group">
                  <label><span class="text-danger">*</span>Name of Partner</label>
                  <input type="text" class="form-control" name="partner" value="<?php echo e($partner->company_name); ?>" required>
            </div>
          <div class="row col-md-12">
              <div  class="col-md-3">
                <label><span class="text-danger">*</span>Scope:</label>
              </div>
              <div class="col-md-9">
                  <select name="scope" class="form-control" required>
                    <option value="Local" <?=$partner->scope == 'Local' ? ' selected="selected"' : '';?>>Local</option>
                    <option value="National" <?=$partner->scope == 'National' ? ' selected="selected"' : '';?>>National</option>
                    <option value="International" <?=$partner->scope == 'International' ? ' selected="selected"' : '';?>>International</option>
                    <option value="Regional" <?=$partner->scope == 'Regional' ? ' selected="selected"' : '';?>>Regional</option>
                    <option value="Institutional" <?=$partner->scope == 'Institutional' ? ' selected="selected"' : '';?>>Institutional</option>
                  </select>
              </div>
          </div>
          <label><span class="text-danger"></span>Validity:</label><br />
          <div class="row col-md-12">
           
                  <div class="col-md-6  col-sm-6">
                      <label><span class="text-danger">*</span>From</label>
                      <input type="date" class="form-control" style="font-size:13px;" name="from" id="fromVal"value="<?php echo e($partner->from); ?>" required>
                  </div>
                  <div class="col-md-6 col-sm-6">
                      <label><span class="text-danger"></span>To</label>
                      <input type="date" class="form-control" name="to" style="font-size:13px;" id="toVal" value="<?php echo e($partner->to); ?>" >
                      <span id="spnErrorDate" class="error text-danger" style="display: none;">*Must be greater than the starting Date.</span>
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
                <select id="classification" name="classification" class="form-control" onchange='CheckClas(this.value);' required>
                <option value="Institutional" <?=$partner->classification == 'Institutional' ? ' selected="selected"' : '';?>>Institutional</option>
                <option value="School" <?=$partner->classification == 'School' ? ' selected="selected"' : '';?>>School</option>
                <option value="Program" <?=$partner->classification == 'Program' ? ' selected="selected"' : '';?>>Program</option>
              </select>
              <?php
            $numOfCols = 4;
            $rowCount = 0;
            $bootstrapColWidth = 12 / $numOfCols;
          ?>
         <?php if($partner->classification == 'School'): ?>
          <fieldset id="schoolset" style='display:block;'>
        <?php else: ?>
        <fieldset id="schoolset" style='display:none;'>
          <?php endif; ?>
                <div class="row">
               <div class="row col-md-12">
              <div class="col-md-6 col-sm-6">
                    <label>Schools</label>
                    <select id="list1" multiple="multiple" style="height: 150px;"class="form-control">
                    <?php
                          $items = array();
                        foreach($partnerCS as $epcs) {
                        $items[] = $epcs;
                        } ?>
                    <?php $__currentLoopData = $school; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($sc->id); ?>"><?php echo e($sc->school_code); ?></option>
              
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <br>
                    <input id="button1" type="button" value="Select" class="form-control"/>
                    <span id="spnErrorSchool" class="error text-danger" style="display: none;">*Please select at-least one School.</span>
                    
                </div>
                <div class="col-md-6 col-sm-6">
                    <label>Selected</label>
                    <select id="list2" name="schoolc[]" multiple="multiple" class="form-control small" style="height: 150px;">
                    <?php $__currentLoopData = $partnerCS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $epcs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($epcs->id); ?>" selected><?php echo e($epcs->school_code); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <br>
                    <input id="button2" type="button" value="Remove" class="form-control"/>
                </div>
            </div>
              </div>
          </fieldset>
          <?php if($partner->classification == 'Program'): ?>
          <fieldset id="program" style='display:block;'>
          <?php else: ?>
          <fieldset id="program" style='display:none;'>
          <?php endif; ?>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <label>Programs</label>
                        <select id="lbprogram" multiple="multiple" class="form-control" style="height: 150px;">
                        <?php $__currentLoopData = $program; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($prog->id); ?>"><?php echo e($prog->acad_prog_code); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <br>
                        <input id="btnprogram" type="button" value="Select" class="form-control"/>
                        <span id="spnErrorProgram" class="error text-danger" style="display: none;">*Please select at-least one Program.</span>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <label>Selected</label>
                        <select id="lbpselect" name="programc[]" multiple="multiple" class="form-control small" style="height: 150px;">
                          <?php $__currentLoopData = $partnerCP; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $epcp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($epcp->id); ?>" selected><?php echo e($epcp->acad_prog_code); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <br>
                        <input id="btnpselect" type="button" value="Remove" class="form-control"/>
                    </div>
              </div>
          </fieldset>
        </div>
      </div>
      </div>
      <div class="row form-group">
        <?php 
        foreach($natureList as $value)
        {
          $lists[] = $value;
        }
        ?>
        <br />
       
      <label>Nature of Partnership</label>
          <div class="row col-md-12">
                <div class="col-md-4">
                <input type="checkbox"  name="nature[]" value="Faculty Dev't" <?=in_array("Faculty Dev't", $lists) ? ' checked="checked"' : '';?>>
                    <label >Faculty Dev't</label>
              </div>
              <div class="col-md-4">
                <input type="checkbox"  name="nature[]" value="Staff Dev't" <?=in_array("Staff Dev't", $lists) ? ' checked="checked"' : '';?>>
                    <label >Staff Dev't</label>
              </div>
              <div class="col-md-4">
                <input type="checkbox"  name="nature[]" value="Student Dev't" <?=in_array("Student Dev't", $lists) ? ' checked="checked"' : '';?>>
                    <label >Student Dev't</label>
              </div>
          </div>
          <div class="row col-md-12">
              <div class="col-md-4">
                <input type="checkbox"  name="nature[]" value="Research" <?=in_array("Research", $lists) ? ' checked="checked"' : '';?>>
                    <label >Research</label>
              </div>
              <div class="col-md-4">
                <input type="checkbox"  name="nature[]" value="ECOS" <?=in_array("ECOS", $lists) ? ' checked="checked"' : '';?>>
                    <label >ECOS</label>
              </div>
              <div class="col-md-4">
                <input type="checkbox" id="others" onclick="otherNature()"  name="nature[]" value="Others">
                    <label >Others</label>
              </div>
          </div>
      </div>
      <?php
        $array = array("Faculty Dev't","Staff Dev't","Student Dev't","Research","ECOS");
       $x = 0; 
      $count = count($lists);?>
      <?php $__currentLoopData = $natureList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php if(!in_array($n,$array)): ?>
          <input type="text" class="form-control" name="nature[]" value="<?php echo e($n); ?>">
          
          <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      
      <span id="spnError" class="error text-danger" style="display: none;">*Please select at-least one Nature of Partnership.</span>
          <div class="row form-group" id="naturegrp" style="display: none;">
            <div class="row col-md-12">
              <div class="col-md-8">
                <label><span class="text-danger"></span>Others</label>
                <input type="hidden" class="form-control" value="1" id="total_nature">
                <input type="text" class="form-control" name="nature[]">
                <div id="new_nature"></div>
              </div>
              <div class="col-md-4"><br>
                <a onclick="add()" class=" fa fa-plus-circle" style="font-size: 20px; color:red;"></a>
                <a onclick="remove()" class=" fa fa-minus-circle" style="font-size: 20px; color:gray;"></a>
              </div>
            </div>
          </div>
    </div>
    <div id="clasValidate" class="col-sm-12">
      <button type="submit" id="save" class="btn btn-primary float-right" >Save Changes</button>
    </div>
  </form>
</div> <!-- closing view -->
<div id="forRenew">
  <form action="<?php echo e(route('renewPartner')); ?>" method="post" enctype="multipart/form-data" autocomplete="off" >
                                            <?php echo e(csrf_field()); ?>

  <input type="text"  name="renew_partnerID" value="<?php echo e($partner->id); ?>" hidden>
    <div class="col-md-12">
      <div class="row col-md-12">
        <h5><?php echo e($partner->company_name); ?><br><?php echo e($partner->nature_partnership); ?></h5>
      </div>
       <hr>
      <div class="row">
        <div class="col-md-4">
        <div class="form-group">
              <i class="fa fa-upload">Upload Document</i>
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
                  <div class="col-md-6 col-sm-6">
                      <label><span class="text-danger"></span>From</label>
                      <input type="date" class="form-control" name="from" required>
                  </div>
                  <div class="col-md-6 col-sm-6">
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
</div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php echo $__env->make('common.inputVal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
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

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Accreditation\Modules/Partner\Resources/views/partner-detail.blade.php ENDPATH**/ ?>