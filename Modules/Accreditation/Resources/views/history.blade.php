@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
  <h2><a href="{{route('adminAcred_prog')}}" class="fa fa-angle-double-left" text="back">&nbsp;&nbsp;{{ $program->AcadPrgrm->acad_prog }} Accreditation History </a></h2>
 
  <div class="clearfix"></div>
</div>
	  <div class="x_content">
		  <div class="row">
			  <div class="col-sm-12">
          <div class="table-responsive">
            <table id="history_table" class="table table-striped jambo_table bulk_action" style="width: 100%;">
              <thead>
              <tr class="headings">

                  <th>Accreditation Status</th>
                  <th>Visit Date</th>
                  <th>Validity</th>


                  <th>PACUCOA Certificate</th>
                  <th>FAAP Certificate</th>
                  <th>Chairman's Report</th>

                  <th>Remarks</th>

                  <th>Actions</th>

            </tr>
          </thead>   
      </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script type="text/javascript">

  $.ajaxSetup({
    headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  var token = $("input[name='_token']").val();
 
$('.alertOld').hide();


 // program table

      var dataTable= $('#history_table').DataTable( {
        "ajax": "{{route('history_dtb', $program->AcadPrgrm->id)}}",
        responsive: true,
        "ordering": false,
        "columns": [
            { "data": "accred_stat" },
            
            { "data": "visit_date" },
            { "data": "validity" },
            { "data": "cert1" },
            { "data": "cert2" },
            { "data": "cert3" },
            { "data": "remarks" },
            { "data": "actions" },
        ],
        "columnDefs": [
        { "width": '50pt', "targets": 7 }
      ]
        });


      
  $(document).on('click','.delete',function(){
    var id = $(this).attr('progid');
    Swal.fire({
        title: 'Are you sure ?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
          url:"{{route('deleteProg')}}",
          method:"POST",
          data:{
            id:id,
            _token:token
          },
          success:function(data){
            Swal.fire(
            'Deleted!',
            'Record has been deleted.',
            'success'
            
          ) 
          dataTable.ajax.reload();
          },
          error: function(jqxhr, status, exception) {
            Swal.fire(
            'Cannot be Deleted!',
            'Record not deleted. There are records associated with this Record',
            'error'
          )
         }

        }); 
         
        }
      })
    }); 

  </script>
@endsection