<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<style type="text/css">
		table {
		  border-collapse: collapse;
		  width: 100%;
		}

		table, th, td {
		  border: 1px solid black;
		  padding: 3px;
		}
		.filters{
			padding-right: 30px;
		}
		footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 50px; 
        }
        .sans{
        	font-family: Arial, Helvetica, sans-serif;

        }

	</style>
<h1 class="sans" style="text-align: center; margin-bottom: 25px;">Accreditation Report</h1>
<div class="sans" style="margin-bottom: 10px;">
	<?php 

		if($school)
			echo '<span class="filters"><strong>School:</strong> '.$school.'</span>';
		if($accredStatus)
			echo '<span class="filters"><strong>Accreditation Level:</strong> '.$accredStatus.'</span>';

		if($expiry == 'Active')
			echo '<span class="filters"><strong>Status:</strong> Active</span>';
		else if($expiry == 'Expired')
			echo '<span class="filters"><strong>Status:</strong> Expired</span>';

		echo "<p>";

		if($min && $max)
			echo '<label class="filters" style="float: left;"><strong>From:</strong> '.date('M, d Y', strtotime($min)).' <strong>To:</strong> '.date('M, d Y', strtotime($max)).'</label>';


		if($visitYear && $min && $max )
			echo '<label class="filters" style="float: right;"><strong>Visitation Year:</strong> '.$visitYear.'</label>';
		else if ($visitYear)
			echo '<label class="filters"><strong>Visitation Year:</strong> '.$visitYear.'</label>';

		echo "</p>";
	 ?>
</div>
<br>	
	<table>
		<tr>
			<th style="width: 30px;"></th>
			<?php 
				if(!$school){
					echo '<th style="width: 80px;">School</th>';
				}
			 ?>
			
			<th>Program</th>
			<?php 
				if(!$accredStatus){
					echo "<th> Accreditation Status</th>";
				}
			 ?>
			<th style="width: 90px;">Valid from</th>
			<th style="width: 90px;">Valid to</th>
			



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
					  	<td>'.$q->acad_prog.'</td>';
						if(!$accredStatus){
							echo '<td>'.$q->accred_status.'</td>';
						}
				echo '
					  	<td>'.date('M. d Y', strtotime($q->from)).'</td>
					  	<td>'.date('M. d Y', strtotime($q->to)).'</td>

					  </tr>';
			}
		 ?>
	</table>


<footer>
	<?php echo date('F, d Y') ?>
</footer>
</body>
</html>