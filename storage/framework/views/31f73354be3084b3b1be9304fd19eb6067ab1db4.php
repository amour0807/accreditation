<!DOCTYPE html>
<html>
<head>
	<title>UNIVERSITY SCHOLARSHIP / GRANTS</title>
	<?php echo $__env->make('include.report_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<main>
<div class="row">
<div>
	<center><h3>University Scholarships / Grants <?php if($from != 'All' && $to != 'All'): ?>(<?php echo e($from); ?> - <?php echo e($to); ?>) <?php endif; ?></h3></center>
</div>
<div>
	<?php 

		if($scholarship)
			echo '<span class="filters"><strong>Scholarship / Grant:</strong> '.$scholarship.'</span>';
		if($schoolyear)
			echo '<span class="filters"><strong>School Year:</strong> '.$schoolyear.'</span>';

		?>
	</div>
	<table class="bordered" style="table-layout: fixed; text-align:center;">
		<thead>
			<tr>
	   <th rowspan="3" style="width: 30%;"><center>Scholarships/Grants</center></th>
	   <th colspan="8"><center>Academic Year <?php echo e($schoolyear); ?></center></th>
	 </tr>
	 <tr>
	   <th colspan="2"><center>1st Semester</center></th>
	   <th colspan="2"><center>2nd Semester</center></th>
	   <th colspan="2"><center>Short Term</center></th>
	   <th colspan="2"><center>Total</center></th>
	 </tr>
	 <tr>
	   <th>Total</th>
	   <th>Amount</th>
	   <th>Total</th>
	   <th>Amount</th>
	   <th>Total</th>
	   <th>Amount</th>
	   <th>Total</th>
	   <th>Amount</th>
	 </tr>
   </thead>
   <tbody>
		<?php 
			$count = 0;
			foreach ($queryBuilder as $q) {
				$count++;
				echo '<tr>
					  	<td>'.$q->scholar_title.'</td>
			
					  	<td>'.$q->fno.'</td>	
				
					  	<td>'.$q->fphp.'</td>
			
						<td>'.$q->sno.'</td>	
						
					  	<td>'.$q->sphp.'</td>
			
						<td>'.$q->stno.'</td>	
						
						<td>'.$q->stphp.'</td>';
				
              $tno = ($q->fno)+($q->sno)+($q->stno);
              $tphp = ($q->fphp)+($q->sphp)+($q->stphp);
       
					echo'	<td>'.$tno.'</td>	
						
						<td>'.$tphp.'</td>
				
					  </tr>';
			}
		 ?>
   </tbody>
	</table>
	<div style="margin-top: 50px;">
		<label>Generated by:<br><br>
			<?php echo e(auth()->user()->first_name); ?> <?php if(auth()->user()->middle_initial != null): ?><?php echo e(auth()->user()->middle_initial); ?>.<?php endif; ?> <?php echo e(auth()->user()->last_name); ?><br>
			<?php echo e($department->school_name); ?>

		</label>
	</div>
</div>	

	</main>
</body>
</html><?php /**PATH C:\xampp\htdocs\Accreditation\Modules/QuantitativeReport\Resources/views/reports/scholar-report.blade.php ENDPATH**/ ?>