@extends('layouts.app')
@section('content')

<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
      <h2><small>Licensure Examination </small></h2>
      @if(Auth::user()->hasPermission('create-board'))
      <a class="btn btn-app float-right" data-toggle="modal" data-target="#addAwardModal">
        <i class="fa fa-plus-square-o"></i> New Exam
      </a>
        @endif
      <div class="clearfix"></div>
    </div>
    <form class="mb-4" action="{{route('boardfilterReport')}}" target="_blank" method="POST">
      @csrf 
   <div class="row">
        <div class="col-md-6 col-sm-6">
           <strong>Sort by:</strong>
        </div>
        <div class="col-md-6 col-sm-6">
          <strong>Exam Range:</strong>
        </div>
        {{-- <div class="col-md-4 col-12">
          <strong>Exam Range:</strong>
        </div> --}}
   </div>
     <div class="form-group row">
     
      <div class="col-md-6 col-sm-12 ">
        <label >Type:</label>
        <select name="examtype" id="examtype" class="form-control" required>
          <option> All  </option>
          <option>Architects </option>
          <option>Certified Public Accountants</option>
          <option>Civil Engineers </option>
          <option>Criminologists</option>
          <option>Dentist - Written</option>
          <option>Dentist - Practical</option>
          <option>Electronic Engineers</option>
          <option>Lawyers</option>
          <option>Medical Technologists</option>
          <option>Master Plumbers</option>
          <option>Midwives</option>
          <option>Nurses</option>
          <option>Physical Therapists</option>
          <option>Psychometricians</option>
          <option>Sanitary Engineers</option>
          <option>Teachers - Secondary Level </option>
          <option>Teachers - Elementary Level </option>
        </select>
        {{-- <div id="filters1">   
        </div> --}}
      </div>
      <div class="col-md-6 col-12">
      <div class="col-6 col-md-6">
        <label >Month:</label>
        <select  class="form-control" name="examonth" id="examonth" required>
          <option>All</option>
          <option >January</option>
          <option >February</option>
          <option >March</option>
          <option >April</option>
          <option >May</option>
          <option >Jun</option>
          <option >July</option>
          <option >August</option>
          <option >September</option>
          <option >October</option>
          <option >November</option>
          <option >December</option>
        </select>
      </div>
      <div class="col-6 col-md-6">
        <label >Year:</label>
        <select  class="form-control" name="examyear" id="examyear" required>
          <option>All</option>
        </select>
      </div>
     </div>
      {{-- <div class="col-md-4 col-12">
        <div class="col-6 col-md-6">
              <label>From </label>
              <select  class="form-control" name="min" id="min">
                 <option>All</option>
               </select>
        </div>
        <div class="col-6 col-md-6">
         <label>To</label>
         <select  class="form-control" name="max" id="max">
                 <option>All</option>
               </select>
       </div>
      </div> --}}
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

    <!-- Table showing awards -->
    
    <div class="table-responsive">
      <table id="boardexam_table" class="table table-striped jambo_table action_bulk" style=" width: 100%;">
           <thead>
             <tr class="headings">
                <th style="width: 30%;">Licensure Examination&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="width: 10%;">Month &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="width: 10%;">Year&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="width: 10%;">Supporting <br>Document</th>
                <th style="width: 10%;">Top<br>notcher/s&nbsp;&nbsp;</th>
                <th style="width: 10%;">Top<br>notcher/s&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="width: 10%;">School<br> Rank</th>
                <th style="width: 20%;" nowrap>Action</th>
              </tr>
        </thead>   
    </table>
    </div>
    <!-- Modal -->
  <div class="modal fade" id="addAwardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Exam</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

         <form action="{{route('addBoardExam')}}" method="post" enctype="multipart/form-data" autocomplete="off" class="form-horizontal form-bordered" style="padding: 0px 8px 0px 16px;">
          {{ csrf_field() }}
          
					<span class="text-danger">* Required Fields</span><br>
        <div class="modal-body">
          <div class="row form-group">
          <label><span class="text-danger">*</span>Licensure Examination</label>
              <select name="exam" class="form-control" required>
                <option disabled selected value> -- --  </option>
                <option>Architects </option>
                <option>Certified Public Accountants</option>
                <option>Civil Engineers </option>
                <option>Criminologists</option>
                <option>Dentist - Written</option>
                <option>Dentist - Practical</option>
                <option>Electronic Engineers</option>
                <option>Lawyers</option>
                <option>Medical Technologists</option>
                <option>Master Plumbers</option>
                <option>Midwives</option>
                <option>Nurses</option>
                <option>Physical Therapists</option>
                <option>Psychometricians</option>
                <option>Sanitary Engineers</option>
                <option>Teachers - Secondary Level </option>
                <option>Teachers - Elementary Level </option>
                    </select>
          </div>
          <div class="row form-group">
            <div class="col-md-4">
              
              <label><span class="text-danger">*</span>Month</label>
                <select  class="form-control" name="month" required>
                  <option disabled selected value> -- --  </option>
                  <option >January</option>
                  <option >February</option>
                  <option >March</option>
                  <option >April</option>
                  <option >May</option>
                  <option >Jun</option>
                  <option >July</option>
                  <option >August</option>
                  <option >September</option>
                  <option >October</option>
                  <option >November</option>
                  <option >December</option>
                </select>

            </div>
              <div class="col-md-4">
                <label><span class="text-danger">*</span>Year</label>
                <label>Year</label>
                <select  class="form-control" name="year" id="dropdownYear" required>
                  <option disabled selected value> -- --  </option>
               </select>
            </div>
            <div class="col-md-4">
                <label><span class="text-danger">*</span>School Rank</label>
                <input type="number" class="form-control"  name="school_rank"  min="0" max="10" value="0" required>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-8">
              <label><span class="text-danger"></span>Topnotcher/s</label>
              
              <input type="hidden" class="form-control" value="1" id="total_top">
              <input type="text" class="form-control" name="top[]">
              <div id="new_top"></div>
            </div>
            <div class="col-md-2">
              <label><span class="text-danger"></span>Rank</label>
              
              <input type="hidden" class="form-control" value="1" id="total_rank">
              <input type="number" min="0" max="10" class="form-control" name="rank[]" placeholder="ex. 1">
              <div id="new_rank"></div>
            </div>
            <div class="col-md-2"><br>
                  <a onclick="add()" class="fa fa-plus-circle" style="font-size: 20px; color:red;"></a>
                  <a onclick="remove()" class="fa fa-minus-circle" style="font-size: 20px; color:gray;"></a>
                </div>
          </div>
          <div class="row col-md-12">
            <fieldset class="row col-md-12">
              <div class="col-md-4">
               <label>First Takers :</label>
              </div>
              <div class="col-md-2">
                <label><span class="text-danger">*</span>Passed</label>
                <input type="number" class="ftaker form-control" id="fpassed" name="fpassed" min="0" max="100"oninput="calculateSum()" value="0" required>
             </div>
              <div class="col-md-2">
                <label><span class="text-danger">*</span>Failed</label>
                <input type="number" class="ftaker form-control" name="ffailed" min="0" max="100" oninput="calculateSum()" value="0" required>
              </div>
              <div class="col-md-2">
                <label><span class="text-danger">*</span>Con</label>
                <input type="number" class="ftaker form-control" name="fcon" min="0" max="100"oninput="calculateSum()" value="0" required>
              </div>
              <div class="col-md-1">
                <label><span class="text-danger"></span>Total</label><br>
                <span id="ftotal">0</span>
              </div>
              <div class="col-md-1">
                <label><span class="text-danger"></span>Percentage</label><br>
                <span id="fpercent" value="0%"></span>
              </div>
              </fieldset>
          </div>
          <div class="row col-md-12">
            <fieldset class="row col-md-12">
              <div class="col-md-4">
               <br><label>Total No. of Takers :</label>
              </div>
              <br>
              <div class="col-md-2">
                <label><span class="text-danger">*</span>Passed</label>
                <input type="number" class="ttaker form-control" id="tpassed" name="tpassed" min="0" max="100" oninput="calculateSum()" value="0" required>
             </div>
              <div class="col-md-2">
                <label><span class="text-danger">*</span>Failed</label>
                <input type="number" class="ttaker form-control" name="tfailed" min="0" max="100" oninput="calculateSum()" value="0" required>
              </div>
              <div class="col-md-2">
                <label><span class="text-danger">*</span>Con</label>
                <input type="number" class="ttaker form-control" name="tcon" min="0" max="100" oninput="calculateSum()" value="0" required>
              </div>
              <div class="col-md-1">
                <label><span class="text-danger"></span>Total</label><br>
                <span id="ttotal">0</span>
              </div>
              <div class="col-md-1">
                <label><span class="text-danger"></span>Percentage</label><br>
                <span id="tpercent" value="0%"></span>
              </div>
              </fieldset>
              <div class="row col-md-12">
                <div class="col-md-4">
                  <br><label><span class="text-danger">*</span>National Passing Percentage</label>
                 </div>
                 <div class="col-md-2">
                   
                  <br><input type="number" class="form-control" name="npasser" min="0" max="100" step=".01" value="0" required>
                </div>
              </div>
          </div>
          <div class="row col-md-12">
           
            <div class="col-md-9"><br>
              <label><span class="text-danger">*</span><i class="fa fa-upload">Supporting Document</i></label><br>
              <input type="file" name="supporting_doc" class="form-control"><br>
              <span class="small">Files accepted: jpeg,jpg, png, pdf </span>
            </div>
              
            </div>
          <div class=" modal-footer">
            <button type="submit" class="btn btn-info">Add Licensure Examination</button>
            
          <div>
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
@endsection
@section('scripts')

@if(\Session::has('success'))
<script>
Swal.fire({
  title: 'Successfully saved!',
  text: "Add another record?",
  icon: 'success',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes',
  cancelButtonText: 'Back to List'
}).then((result) => {
  if (result.isConfirmed) {
	$('#addAwardModal').modal('show');
  }
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
  @elseif(\Session::has('duplicate'))
  <script>
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Duplicate entry!',
    footer: "<a>Back</a>"
  }) 
  </script>
  @endif
@include('common.functions')

  <script type="text/javascript">
$('#dropdownYear, #examyear').each(function() {
var year = (new Date()).getFullYear();
var current = year;
year -= 30;
for (var i = 30; i > 0; i--) {
    $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
}

})
    $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var token = $("input[name='_token']").val();

    var count = 0;
    $('#min').each(function() {

      var year = (new Date()).getFullYear();
      year -= 30;
      for (var i = 30; i > 0; i--) {
        
          $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
      }

      })
      $('#max').each(function() {

      var year = (new Date()).getFullYear();
      year -= 30;
      for (var i = 30; i > 0; i--) {
        
          $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
      }

      })
// DaATA TABLES SEARCH
    $.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = $('#min').val();
        var max = $('#max').val();
        var age =  data[2]  || 0; 
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

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var type = $('#examtype').val()
            dbtype =  data[0]
        if (type == dbtype || type == 'All' )
          return true;
        else
        	return false;
    }
);
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var month = $('#examonth').val(); 
            dbmonth =  data[1]
        if ( month == dbmonth || month == 'All')
          return true;
        else
        	return false;
    }
);
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var year = $('#examyear').val(); 
            dbyear =  data[2]
        if ( year == dbyear || year == 'All')
          return true;
        else
        	return false;
    }
);
 var dataTable = $('#boardexam_table').DataTable( {
          "processing" : true,
          "bSort" : false,
          "ordering": false,
          "ajax": "{{route('boardexam_dtb')}}",

           dom: 'Blfrtip',
          lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10', '25', '50', 'Show all' ]
        ],
        buttons: [
               {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 5, 6 ]
                },
                title: 'Licensure Exams'
            },
            ],
          responsive: true,
          
          "columns": [
              { "data": "licensure_exam" },
              { "data": "exam_month" },
              { "data": "exam_year" },
              { "data": "supporting_doc" },
              { "data": "topnotcher" },
              { "data": "name" ,
					      "visible": false},
              { "data": "school_rank" },
              { "data": "actions" },
          ],

          initComplete: function () {
            var $buttons = $('.dt-buttons').hide();
            $('.dataTables_length').show();
             $('#exportLink').on('click', function() {
                $('.buttons-excel').click(); 
             })
          },
        });

 $('#min, #max, #examtype, #examonth, #examyear').change(function () {
                dataTable.draw();
            });

     function add(){
          var new_top_no = parseInt($('#total_top').val())+1;
          var new_rank_no = parseInt($('#total_rank').val())+1;
          var new_top="<input type='text' class='form-control' name='top[]' id='top_"+new_top_no+"'>";
          var new_rank="<input type='text' class='form-control' name='rank[]' id='rank_"+new_rank_no+"'>";
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

      
    $(document).on('click','.destroy',function(){
	var id = $(this).attr('awardid');
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
			  url:"{{route('deleteBoard')}}",
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
@endsection
