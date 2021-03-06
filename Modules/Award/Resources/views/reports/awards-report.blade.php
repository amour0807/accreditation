<!DOCTYPE html>
<html>
<head>
	<title></title>
	@include('include.report_header')
	<main>
<div class="row">
<div>
	<center><h3>Student's Award</h3></center>
</div>
<div>
	<?php 

		if($school)
			echo '<span class="filters"><strong>School:</strong> '.$school.'</span>';
		if($scope)
			echo '<span class="filters"><strong>Scope:</strong> '.$scope.'</span>';
		if($category)
			echo '<span class="filters"><strong>Category:</strong> '.$category.'</span>';

		if($from && $to)
			echo '<span class="filters" ><strong>From:</strong> '.date('M, d Y', strtotime($from)).'<strong>&nbsp;&nbsp;&nbsp;To:&nbsp;&nbsp;</strong> '.date('M, d Y', strtotime($to)).'</span><br>';
	 ?>
	</div>
	<table class="bordered" style="table-layout: fixed;">
		<tr style="font-size: 9pt;">
			<th style="width: 2%;"></th>

			<?php 
				if(!$school){
					echo '<th style="width: 5%;">School</th>';
				}
			 ?>
			<th style="width: 11%;">Student Name</th>
			<?php 
				if(!$scope){
					echo "<th style='width: 7%;'> Scope</th>";
				}
			 ?>
			<?php 
				if(!$category){
					echo "<th style='width: 7%;'> Category</th>";
				}
			 ?>
			 <th style="width: 6%;">Award</th>
			 <th style="width: 8%;">Classification</th>
			 <th style="width: 15%;">Competition</th>
			 <th style="width: 15%;">Award Giving Body</th>
			<th style="width: 9%;">Date Awarded</th>
			<th style="width: 15%;">Venue</th>
			
		</tr>

		<?php 
			$count = 0;
			foreach ($queryBuilder as $q) {
				$count++;
				echo '<tr>
						<td>'.$count.'</td>';
						if(!$school){
							echo '<td>'.$q->school_code.'</td>';
						}

				echo '
					  	<td>'.$q->first_name.', '.$q->middle_initial.'. '.$q->last_name.'</td>';
						if(!$scope){
							echo '<td>'.$q->scope.'</td>';
						}
				
						if(!$category){
							echo '<td>'.$q->category.'</td>';
						}	
				echo '
					  	<td>'.$q->award.'</td>';
				echo '
					  	<td>'.$q->classification.'</td>';	
				echo '
					  	<td>'.$q->title_competitions.'</td>';	
				echo '
					  	<td>'.$q->award_giving_body.'</td>';	
				echo '
					  	<td>'.date('M. d, Y', strtotime($q->date_awarded)).'</td>';
				echo '
					  	<td>'.$q->venue.'</td>
					  </tr>';
			}
		 ?>
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