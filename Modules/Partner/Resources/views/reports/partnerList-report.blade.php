<!DOCTYPE html>
<html>
<head>
	<title>LIST OF UNIVERSITY PARTNERS</title>
@include('include.report_header')
<main>
<div class="row">	
	<center><h3>Lists of University Partners</h3></center>
<div>
	<?php 
	if($status != 'All')
	echo '<span class="filters" ><strong>Status:</strong> '.$status.'</span><br>';
		if($from != 'All' && $to!= 'All' )
			echo '<span class="filters" ><strong>From:</strong> '.$from.'<strong>&nbsp;&nbsp;&nbsp;To:&nbsp;&nbsp;</strong> '.$to.'</span><br>';
	 ?>
	</div>
	 <table id="partnerList_table"  class="display compact cell-border" style="text-align: center;">
		
		@if($name == null)
        <thead>
          <tr>
			<th style="width: 4%;"></th>
			<th>Company Name</th>
            <th>Scope</th>
            <th>Classification</th>
            <th>Validity</th>
           </tr>
		</thead>
         <tbody>

		<?php 
			$count = 0;
			
	 foreach($partnerList as $pl){
			foreach ($queryBuilder as $q) {
				if($q->company_name == $pl){
				$count++;
				echo '<tr>
				<td>'.$count.'</td>';
				
				echo '
				<td>'.$q->company_name.'</td>';

				echo '
					  	<td>'.$q->scope.'</td>';
					  
				 echo '<td>'.$q->classification.
				
				'</td>';
				 $from = date('M. d, Y', strtotime($q->from));
				 $to = date('M. d, Y', strtotime($q->to));

				 echo '<td>'.$from.' - '.$to.'</td>';
				echo '
					  </tr>';
			}
		}
		}
		 ?>
		</tbody>
		@else
		@foreach($partnerList as $pl)
        <thead>
		<tr>
				<th colspan="4" style="text-align: left;">{{$pl}}</th>
			</tr>
		
          <tr>
			<th style="width: 4%;"></th>
            <th>Scope</th>
            <th>Classification</th>
            <th>Validity</th>
           </tr>
		</thead>
         <tbody>

		<?php 
			$count = 0;
			foreach ($queryBuilder as $q) {
				if($q->company_name == $pl){
				$count++;
				echo '<tr>
				<td>'.$count.'</td>';

				echo '
					  	<td>'.$q->scope.'</td>';
					  
				 echo '<td>'.$q->classification.
				
				'</td>';
				 $from = date('M. d, Y', strtotime($q->from));
				 $to = date('M. d, Y', strtotime($q->to));

				 echo '<td>'.$from.' - '.$to.'</td>';
				echo '
					  </tr>';
			}
		}
		 ?>
		</tbody>
		@endforeach
		@endif
	</table>
	<div style="margin-top: 50px;">
		<label>Generated by:<br><br>
			{{auth()->user()->first_name}} @if(auth()->user()->middle_initial != null){{auth()->user()->middle_initial}}.@endif {{auth()->user()->last_name}}<br>
			{{$department->school_name}}<br><?php
	   
			date_default_timezone_set('Asia/Hong_Kong');
			echo '<label>'.date('M d,Y h:i:sa').'</label>';?>
		</label>
	</div>
</div>
		  </main>
</body>
</html>