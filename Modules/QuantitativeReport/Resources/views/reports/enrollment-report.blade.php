<!DOCTYPE html>
<html>
<head>
	<title>UNIVERSITY ENROLLMENT</title>
	@include('include.report_header')
	<main>
<div class="row">
<div>
	<center><h3>University Enrollment @if($from != 'All' && $to != 'All')({{$from}} - {{$to}}) @endif</h3></center>
</div>
<div>
	<?php 

		if($school)
			echo '<span class="filters"><strong>School:</strong> '.$school.'</span>';
		if($program)
			echo '<span class="filters"><strong>Program:</strong> '.$program.'</span>';
		if($sem)
			echo '<span class="filters"><strong>Semester:</strong> '.$sem.'</span>';
		if($schoolyear)
			echo '<span class="filters"><strong>School Year:</strong> '.$schoolyear.'</span>';

		?>
	</div>
	<table class="bordered" style="table-layout: fixed; text-align:center;">
		
		<tr style="font-size: 9pt;">
			<th style="width: 2%">#</th>

			<?php 
				if(!$school){
					echo '<th style="width: 5%;">School</th>';
				}

				if(!$program){
					echo "<th style='width: 7%;'> Program</th>";
				}

				if(!$sem){
					echo "<th style='width: 7%;'> Semester</th>";
				}

				if(!$schoolyear){
					echo "<th style='width: 7%;'> School Year</th>";
				}
			 ?>
			 <th style='width: 7%;'>Freshmen</th>
			 <th style='width: 7%;'>Transfery</th>
			 <th style='width: 7%;'>Old Student</th>
			 <th style='width: 7%;'>Total</th>
			
		</tr>

		<?php 
			$t=0;
			$count = 0;
			foreach ($queryBuilder as $q) {
				$count++;
				echo '<tr>
						<td>'.$count.'</td>';
						if(!$school){
							echo '<td>'.$q->school_name.'</td>';
						}
						if(!$program){
							echo '<td>'.$q->acad_prog.'</td>';
						}
						if(!$sem){
							echo '<td>'.$q->semester.'</td>';
						}
				
						if(!$schoolyear){
							echo '<td>'.$q->school_year.'</td>';
						}	
				echo '
					  	<td>'.$q->freshmen.'</td>
					  	<td>'.$q->transfery.'</td>
					  	<td>'.$q->old_student.'</td>';
				$sum = $q->freshmen+$q->transfery+$q->old_student;
					 echo' 	<td>'.$sum.'</td>	
					  </tr>';
					  $t+= $sum;
			}
			echo '<tr>';
				if(!$school && !$sem && !$schoolyear && !$program){
					echo '<td style="text-align: right;" colspan="8"><strong>Total:</strong></td>';
				}elseif($school && $sem && $schoolyear && $program){
					echo '<td style="text-align: right;" colspan="4"><strong>Total:</strong></td>';
				}elseif($school && $sem && $schoolyear || $school && $schoolyear && $program|| $sem && $schoolyear && $program || $school && $program && $sem|| $schoolyear && $program && $school || $sem && $program && $schoolyear){
					echo '
					<td style="text-align: right;" colspan="5"><strong>Total:</strong></td>';
				}elseif($school && $sem || $school && $schoolyear || $sem && $schoolyear || $school && $program || $schoolyear && $program || $sem && $program){
					echo '
					<td style="text-align: right;" colspan="6"><strong>Total:</strong></td>';
					
				}else{
					echo '
					<td style="text-align: right;" colspan="7"><strong>Total:</strong></td>';
				}
				
				echo'<td>'.$t.'</td>
				</tr>';
		 ?>
	</table>
	<div style="margin-top: 50px;">
		<label>Generated by:<br><br>
			{{auth()->user()->first_name}} @if(auth()->user()->middle_initial != null){{auth()->user()->middle_initial}}.@endif {{auth()->user()->last_name}}<br>
			{{$department->school_name}}<br>
			<?php
			date_default_timezone_set('Asia/Hong_Kong');
		 echo '<label>'.date('M d,Y h:i:sa').'</label>';?>
		</label>
	</div>
</div>	

	</main>
</body>
</html>