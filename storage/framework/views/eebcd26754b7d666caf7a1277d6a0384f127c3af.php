
<?php $__env->startSection('content'); ?>
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
      <h2><small>Company Partners </small></h2>
      <?php if(Auth::user()->hasPermission('create-partner')): ?>
      <a class="btn btn-app float-right"data-toggle="modal" data-target="#addAwardModal">
        <i class="fa fa-plus-square-o"></i> Add Partnership
      </a>
        <?php endif; ?>
      <div class="clearfix"></div>
    </div>
       
<form class="mb-4" action="<?php echo e(route('partnerfilterReport')); ?>" target="_blank" method="POST">
  <?php echo csrf_field(); ?> 
<div class="row">
    <div class="col-md-7">
       <strong>Sort by:</strong>
    </div>
    <div class="col-md-4">
      <strong>Range of Partnership</strong>
   </div>
  </div>
 <div class="form-group row">
   <div class="row col-md-7">
  <div class="col-md-6 ">
    <label >Name of Partner</label>
    <select name="partner1" id="partner" class="form-control" required>
      <option> All  </option>
    <?php $__currentLoopData = $partner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option><?php echo e($a->company_name); ?> </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>
  </div>
  <div class="col-md-6 ">
    <label >Status</label>
    <select name="status1" id="status" class="form-control" required>
      <option> All  </option>
      <option>Active</option>
      <option>Inactive </option>
  </select>
  </div>
  
   </div>
  <div class="col-md-4 col-12">
    <div class="col-6 col-md-6">
          <label>From </label>
          <select  class="form-control" name="from" id="from">
             <option>All</option>
           </select>
    </div>
    <div class="col-6 col-md-6">
      <strong>&nbsp;</strong>
     <label>To</label>
     <select  class="form-control" name="to" id="to">
             <option>All</option>
           </select>
  </div>
  </div>
</div>
<div class="row">
 <div class="col-md-8">
 </div>
<div class="col-md-4">
 <div class="float-right">
   <a id="exportLink" class="btn btn-outline-success btn-sm edit " target="_blank" title="view excel" ><i class="fa fa-file-excel-o"></i></a>
     <button type="submit" class="btn btn-outline-danger btn-sm edit " target="_blank" title="view pdf" id="addBtn"><i class="fa fa-file-pdf-o"></i></button>
 </div><br><br>
 </div>
</div>
</form>
  </div>
</div>
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
	  <div class="x_content">
		  <div class="row">
			  <div class="col-sm-12">
    <!-- Table showing awards -->
    
    <div class="table-responsive">
      <table id="partner_table" class="table table-striped jambo_table action_bulk" style="width: 100%;">
           <thead>
             <tr class="headings">
                <th>Name of <br>Partner</th>
                <th>From</th>
	            	<th>To</th>
                <th>Status</th>
                <th>Supporting<br>Document</th>
                <th>Action</th>
	            	<th>Classification</th>
                <th>Nature</th>
	            </tr>
		    </thead>   
    </table>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addAwardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Partnership</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
  
           <form id="formValidate" enctype="multipart/form-data" autocomplete="off"  class="form-horizontal form-bordered" style="padding: 0px 8px 0px 16px;">
                                              <?php echo e(csrf_field()); ?>

  
                                              <span class="text-danger">* Required Fields</span><br>
          <div class="modal-body">
            <div class="row form-group">
                <label><span class="text-danger">*</span>Name of Partner</label>
                <input type="text" class="form-control" name="partner" placeholder="" required>
            </div>
            <div class= "row form-group"> 
              <div class="col-md-6">
                  <label><span class="text-danger">*</span>Scope:</label>
                  <select name="scope" class="form-control" required>
                    <option disabled selected value> -- --  </option>
                    <option value="Local">Local</option>
                    <option value="National">National</option>
                    <option value="International">International</option>
                    <option value="Regional">Regional</option>
                    <option value="Institutional">Institutional</option>
                  </select>
              </div>
              <div class= "col-md-6"> 
                <label><span class="text-danger">*</span>Classification:</label>
                <select id="classification" name="classification" class="form-control" onchange='CheckClas(this.value);' required>
                  <option disabled selected value> -- --  </option>
                  <option value="Institutional">Institutional</option>
                  <option value="School">School</option>
                  <option value="Program">Program</option>
                </select>
              </div>
            </div>
            <!-- For school and Program Classification -->
            <fieldset id="schoolcon" style='display:none;'>
            <div class="row col-md-12">
              <div class="col-md-6">
                    <label>Schools</label>
                    <select id="list1" multiple="multiple" class="form-control" style="height: 150px;">
                    <?php $__currentLoopData = $school; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($sc->id); ?>"><?php echo e($sc->school_code); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <br>
                    <input id="button1" type="button" value="Select" class="form-control"/>
                </div>
                <div class="col-md-6">
                    <label>Selected</label>
                    <select id="list2" name="schoolc[]" multiple="multiple" style="height: 150px;"class="form-control small">
                        
                    </select>
                    <br>
                    <input id="button2" type="button" value="Remove" class="form-control"/>
                </div>
            </div>
            <span id="spnErrorSchool" class="error text-danger" style="display: none;">*Please select at-least one School.</span>
            </fieldset>
            <fieldset id="program" style='display:none;'>
            <div class="row col-md-12">
              <div class="col-md-6">
                  <label>Programs</label>
                  <select id="lbprogram" multiple="multiple" class="form-control" style="height: 150px;">
                  <?php $__currentLoopData = $program; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($pr->id); ?>"><?php echo e($pr->acad_prog_code); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                  <br>
                  <input id="btnprogram" type="button" value="Select" class="form-control"/>
              </div>
              <div class="col-md-6">
                  <label>Selected</label>
                  <select id="lbpselect" name="programc[]" multiple="multiple" style="height: 150px;" class="form-control small">
                      
                  </select>
                  <br>
                  <input id="btnpselect" type="button" value="Remove" class="form-control"/>
              </div>
            </div>
            <span id="spnErrorProgram" class="error text-danger" style="display: none;">*Please select at-least one Program.</span>
            </fieldset>
            
              <!--  -->
              <fieldset>
            <div class="row form-group">
              <div class="col-md-6">
                  <label><span class="text-danger">*</span>From</label>
                  <input type="date" class="form-control" id="fromVal" name="from" required>
              </div>
              <div class="col-md-6">
                  <label><span class="text-danger"></span>To</label>
                  <input type="date" class="form-control" name="to" id="toVal" placeholder="" >
                  <span id="spnErrorDate" class="error text-danger" style="display: none;">*Must be greater than the starting Date.</span>
              </div>
            </div>
          </fieldset>
            <fieldset>
              <label><span class="text-danger">*</span>Nature of Partnership</label>
            <div class="row form-group">
              <div class="col-md-6">
                  <input type="checkbox"  name="nature[]" value="Faculty Dev't" />
                     Faculty Dev't<br />
                  <input type="checkbox"  name="nature[]" value="Staff Dev't" />
                    Staff Dev't <br />
                  <input type="checkbox"  name="nature[]" value="Student Dev't" />
                      Student Dev't <br />
              </div>
              <div class="col-md-6">
                  <input type="checkbox"  name="nature[]" value="Research" />
                      Research <br />
                  <input type="checkbox"  name="nature[]" value="ECOS" />
                      ECOS <br />
                  <input type="checkbox" id="others" onclick="otherNature()"  name="nature[]" value="Others" />
                      Others <br />
              </div>
            </div>
            <div class="row form-group" id="naturegrp" style="display: none;">
              <div class="row col-md-12">
                <div class="col-md-8">
                  <label><span class="text-danger"></span>Others</label>
                  <input type="hidden" class="form-control" value="1" id="total_nature">
                  <input type="text" class="form-control removeVal" name="nature[]">
                  <span id="spnErrorOthers" class="error text-danger" style="display: none;">*Required Input.</span>
                  <div id="new_nature"></div>
                </div>
                <div class="col-md-4"><br>
                  <a onclick="add()" class=" fa fa-plus-circle" style="font-size: 20px; color:red;"></a>
                  <a onclick="remove()" class=" fa fa-minus-circle" style="font-size: 20px; color:gray;"></a>
                </div>
              </div>
            </div>
            <span id="spnError" class="error text-danger" style="display: none;">*Please select at-least one Nature of Partnership.</span>
            <br />
          </fieldset>
            <div class="row form-group">
                <label><span class="text-danger">*</span><i class="fa fa-upload"></i> Supporting Document</label>
                <input type="file" name="supporting_doc" class="form-control" required>
              </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <div id="clasValidate">
              <button type="submit" class="btn btn-info">Add Partner</button>
              </div>
            </div>
               </form>
        </div>
      </div>
    </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php if(\Session::has('success')): ?>
<script>
Swal.fire({
  icon: 'success',
  title: 'Done!',
  text: 'Successfully Saved!',
  timer: 1500
})
</script>
  <?php elseif(\Session::has('error')): ?>
  <script>
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Something went wrong!',
    footer: "<a>Back</a>"
  }) 
  </script>
  <?php elseif(\Session::has('success_add')): ?>
  <script>
    Swal.fire({
        title: 'Done',
        text: "Successfully Saved!",
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'add another partner'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#addAwardModal').modal('show');
        }
      })
  </script>
  <?php endif; ?>
<?php echo $__env->make('common.inputVal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
<script type="text/javascript">
    var token = $("input[name='_token']").val();
    var count = 0;
    $( "#formValidate" ).submit(function( event ) {
        event.preventDefault();
        $.ajax({
                    type: 'POST',
                    url: "<?php echo e(route('addPartner')); ?>",
                    data:$("#formValidate").serialize(),
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === true) {
                            $("#formValidate")[0].reset();
                            $('#addAwardModal').modal('hide');
                            dataTable.ajax.reload();
                            swal.fire("Done!", results.message, "success");
                          
                        } else {
                            swal.fire("Error!", results.message, "error");
                        }
                    }
                });
    });
    $('#from').each(function() {
        var year = (new Date()).getFullYear();
        year -= 30;
        for (var i = 30; i > 0; i--) {
          
            $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
        }
        })
        $('#to').each(function() {

        var year = (new Date()).getFullYear();
        year += 4;
        year -= 30;
        for (var i = 30; i > 0; i--) {
          
            $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
        }
      }) 

      $.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = $('#from').val()
			max = $('#to').val()
			dfrom = data[1].split(' ')
			dto = data[2].split(' ');

        if ( ( isNaN( min ) && isNaN( max ) ) ||
             ( isNaN( min ) && dfrom[1] <= max ) ||
             ( min <= dfrom[2] && isNaN( max ) ) ||
             ( min <= dfrom[2] && dto[2] <= max ) )
        {
            return true;
        }else{
        	return false;
        }
        
    }
);

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var partner = $('#partner').val()
            dbtype =  data[0]
        if (partner == dbtype || partner == 'All' )
          return true;
        else
        	return false;
    }
);
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var status = $('#status').val()
            dbtype =  data[0]
        if (status == dbtype || status == 'All' )
          return true;
        else
        	return false;
    }
);
 var dataTable = $('#partner_table').DataTable( {
          "processing" : true,
          "ajax": "<?php echo e(route('partner_dtb')); ?>",
          "bSort": false,
           dom: 'Blfrtip',
          lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10', '25', '50', 'Show all' ]
        ],
          buttons: [
               {
                extend: 'excelHtml5',
                title: 'UniversityPartner'
            },
         ],

          responsive: true,
          
          "columns": [
              { "data": "company_name" },
              { "data": "from" },
              { "data": "to" },
              { "data": "status" },
              { "data": "supporting_doc" },
              { "data": "actions" },
              { "data": "classification",
                "visible": false,
              },
              { "data": "nature",
              "visible": false,
              },
          ],
        });

     $('#from, #to, #clarify, #status, #partner').change(function () {
                dataTable.draw();
                    });


    $(document).on('click','.destroy',function(){
	      var id = $(this).attr('partnerid');
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
          url:"<?php echo e(route('deletePartner')); ?>",
          method:"POST",
          data:{
            id:id,
            _token:token
          },
          success:function(data){
            Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          ) 
          dataTable.ajax.reload();
          },
          error: function(jqxhr, status, exception) {
            Swal.fire(
            'Cannot be Deleted!',
            'this record still has a task. Please delete it all then delete this project.',
            'error'
          )
         }

        }); 
         
        }
      })
    });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Accreditation\Modules/Partner\Resources/views/index.blade.php ENDPATH**/ ?>