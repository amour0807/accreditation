
<?php $__env->startSection('content'); ?>
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
      <h2><small>Topnotchers </small></h2>
      <div class="clearfix"></div>
    </div>
    <form class="mb-4" action="<?php echo e(route('topfilterReport')); ?>" target="_blank" method="POST">
      <?php echo csrf_field(); ?> 
    <div class="row">
        <div class="col-md-4">
           <strong>Sort by:</strong>
        </div>
        <div class="col-md-4 col-sm-6">
          <strong>Examination:</strong>
        </div>
        <div class="col-md-4 col-sm-6">
          <strong>Exam Range:</strong>
        </div>
      </div>
     <div class="form-group row">
     <div class="col-md-4 col-sm-6">
      <div class="col-md-6">
        <label >Licensure Exam</label>
        <div id="filters1">
        </div>
      </div>
      <div class="col-md-6">
        <label >Rank</label>
        <div id="filters2">
        </div>
      </div>
     </div>
      <div class="col-md-4 col-sm-6">
        <div class="col-md-6 ">
              <label>Month </label>
              <div id="filters3"></div>
        </div>
        <div class="col-md-6">
         <label>Year</label>
         <div id="filters4"></div>
       </div>
      </div>
      <div class="col-md-4 col-sm-12">
        <div class="col-md-6 col-sm-6">
              <label>From </label>
              <select  class="form-control" name="min" id="min">
                 <option>All</option>
               </select>
        </div>
        <div class="col-md-6 col-sm-6">
         <label>To</label>
         <select  class="form-control" name="max" id="max">
                 <option>All</option>
               </select>
       </div>
      </div>
    </div>
    <div class="row">
     <div class="col-md-8">
     <input type="checkbox"  name="summary[]" value="SBT">
       <label >Summary of Board Topnotchers</label>&nbsp;&nbsp;
      <input type="checkbox"  name="summary[]" value="STS">
       <label >Summary of Top Schools</label>&nbsp;&nbsp;
     <input type="checkbox"  name="summary[]" value="BT">
       <label >Board of Topnotchers</label>
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
    <div class="table-responsive">
      <table id="topnotcher_table" class="table table-striped jambo_table" style="table-layout: fixed; width: 100%;">
           <thead>
             <tr class="headings">
                <th>Examination Date</th>
                <th></th>
                <th>Licensure Exam</th>
                <th>Name</th>
                <th>Rank</th>
              </tr>
        </thead>   
    </table>
    </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
  <script type="text/javascript">
 $('.alert').hide();
   
     $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    var token = $("input[name='_token']").val();
    $('#min').each(function() {

var year = (new Date()).getFullYear();
var current = year;
year -= 30;
for (var i = 30; i > 0; i--) {
  
    $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
}

})
$('#max').each(function() {

var year = (new Date()).getFullYear();
var current = year;
year -= 30;
for (var i = 30; i > 0; i--) {
  
    $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
}

})

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = $('#min').val();
        var max = $('#max').val();
        var age =  data[1]  || 0; 
        if ( ( isNaN( min ) && isNaN( max ) ) ||
             ( isNaN( min ) && age <= max ) ||
             ( min <= age   && isNaN( max ) ) ||
             ( min <= age   && age <= max ) )
        {
            return true;
        }else{
        	return false;
        }
        
    }
); 
   var count = 0;
   // program table
        var dataTable= $('#topnotcher_table').DataTable( {
          "scrollX": true,
          "ordering": false,
          "ajax": "<?php echo e(route('topnotcher_dtb')); ?>",
          
           dom: 'Blfrtip',
          lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10', '25', '50', 'Show all' ]
        ],
        buttons: [
               {
                extend: 'excelHtml5',
                title: 'University Topnotchers'
            },
            ],
          "columns": [
              { "data": "exam_month" },
              { "data": "exam_year" },
              { "data": "licensure_exam" },
              { "data": "name"},
              { "data": "rank"}
              // { "data": null , 
              //   "render" : function ( data, type, full ) { 
              //     if(full['rank'] == 1)
              //     return full['rank']+'<sup>st</sup> Place';
              //     else if(full['rank'] == 2)
              //     return full['rank']+'<sup>nd</sup> Place';
              //     else if(full['rank'] == 3)
              //     return full['rank']+'<sup>rd</sup> Place';
              //     else
              //     return full['rank']+'<sup>th</sup> Place';
              //     }
              //   }
          ],
          responsive: true,
          initComplete: function () {
            var $buttons = $('.dt-buttons').hide();
            $('.dataTables_length').show();
             $('#exportLink').on('click', function() {
                $('.buttons-excel').click(); 
             })

              this.api().columns([2,4,0,1]).every( function () {
                  var column = this;
                  count++;
                  $('<div id="lalagyan'+count+'"></div>')
                      .appendTo( "#filters"+count );

                  var select = $('<select class="form-control" name="select'+count+'"><option value="">All</option></select>')
                      .appendTo( "#lalagyan"+count )
                      .on( 'change', function () {
                          var val = $.fn.dataTable.util.escapeRegex(
                              $(this).val()
                          );
   
                          column
                              .search( val ? '^'+val+'$' : '', true, false )
                              .draw();
                      } );
   
                  column.data().unique().sort().each( function ( d, j ) {
                      select.append( '<option value="'+d+'">'+d+'</option>' )
                  } );
              } );
          },

    
        });
  $('#min, #max').change(function () {
                dataTable.draw();
        
            });
      

    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Accreditation\Modules/BoardExam\Resources/views/topnotcher.blade.php ENDPATH**/ ?>