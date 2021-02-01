@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12 ">
	<div class="x_panel">
    <div class="x_title">
     
  <h2><a href="{{ route('partners') }}" class="fa fa-angle-double-left" >&nbsp;&nbsp;{{$partner->company_name}} </a></h2>

  <div class="clearfix"></div>
</div>
	  <div class="x_content">
		  <div class="row">
			  <div class="col-sm-12">
                    <label>Partnership History</label>
                    <hr>
                        <!-- Table showing awards -->
                    
                        <div class="table-responsive">
                          <table id="partner_history_table" class="table table-striped jambo_table" style="table-layout: fixed; width: 100%;">
                               <thead>
                                 <tr class="headings">
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Supporting <br>Document</th>
                                  </tr>
                            </thead>   
                        </table>
                        </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
@include('common.inputVal');
<script type="text/javascript">
    $.ajaxSetup({
	    headers: {
	       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
    });

    var token = $("input[name='_token']").val();

 var dataTable = $('#partner_history_table').DataTable( {
          "processing" : true,
          "serverSide" : true,
          "paging" : false,
          "searching" : false,
          "bSort" : false,

          "ajax": "{{route('partner_history_dtb', $partner->id)}}",
          
          responsive: false,
          "scrollX": false,
          
          "columns": [
              { "data": "from" },
              { "data": "to" },
              { "data": "supporting_doc" },
          ],

        });
    </script>
@endsection
