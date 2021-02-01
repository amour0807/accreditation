<!DOCTYPE html>
<html>
<head>
	<title></title>
	@include('include.report_header')
</head>
	<main>
<div class="row">
	<center><strong>Students Feedback May 2020 @if($schoolyear) ({{$schoolyear}})@endif</strong>
	<?php 
	  if($school != 'ALL' && $school != null ){
		  echo '<br><label>'.$schoolname->school_name.'</label>';
	  }
	 	 $acad_prog = $progname->where('id',$program)->first();
		
	 if($program != 'ALL' && $program != null){
		 echo '<br><label>'.$acad_prog->acad_prog.'</label>';
	 }
		if($question)
		echo '<br><span class="filters"><strong>Question:</strong> '.$question.'</span>';
	 ?></center>
	<br>
	<div class="col-md-10">
	
		<?php
		 $count =1;
	foreach($schoolList as $schoolname => $schoolid){
		if($school == 'ALL' || $school == null)echo '<strong>'.$count.'. '.$schoolname.'</strong><br />';
		$count++;
	foreach($programList as $pname => $pschoolid){
		if($schoolid == $pschoolid){
			$acad_prog = $progname->where('id',$pname)->first();
		if($program == 'ALL' || $program == null)echo '<strong><br>'.$acad_prog->acad_prog.'</strong>';
		$count++;
	 foreach($questionList as $qlist){
	 		echo '<label><br>'.$qlist->question.'</label>';
			$agree = 0; $disagree = 0; $stronglyAgree =0; $stronglyDisagree =0;
			$no =0; $yes =0;
			$none=0; $acad=0; $employee=0; $sciehigh=0; $sibling=0; $director=0; $sa=0; $marshall=0;
			$others = array();
			$ub=0; $ese=0; $athletes=0; $gov=0; 
			$cp=0; $email=0; $messenger=0; 

			$new = $queryBuilder->where('q_id',$qlist->id)->where('program_id',$pname);
	 	foreach ($new as $q) {
				echo '<ul>';
					$answer = $q->answer;
					
						if($answer == 'Agree')
							$agree++;
						elseif($answer == 'Disagree')
							$disagree++;
						elseif($answer == 'Strongly Agree')
							$stronglyAgree++;
						elseif($answer == 'Strongly Disagree')
							$stronglyDisagree++;
						
							if($answer == 'No')
							 $no++;
							if($answer == 'Yes')
							 $yes++;

						if($answer == 'Cellphone number')
							$cp++;
						elseif($answer == 'Email')
							$email++;
						elseif($answer == 'Messenger')
							$messenger++;
						
					if($qlist->id == '12'){
						
						if($answer == 'None')
							$none++;
						elseif($answer == 'Academic Scholar')
							$acad++;
						elseif($answer == 'Employee Depended')
						    $employee++;
						elseif($answer == 'Science High School Graduate / UB High Top Graduate')
						    $sciehigh++;
						elseif($answer == 'Sibling Disount')
						    $sibling++;
						elseif($answer == "Director's Grantee")
						    $director++;
						elseif($answer == 'Student Assistant')
						    $sa++;
						elseif($answer == 'Marshall')
						    $marshall++;
						elseif($answer == 'University Choir / Dance Troupe / Band')
						    $ub++;
						elseif($answer == "ESE Scholarship")
						    $ese++;
						elseif($answer == 'Athletes')
						    $athletes++;
						elseif($answer == 'Government Scholar')
							$gov++;
					}
						
						if($qlist->id != '4' && $qlist->id != '7' && $qlist->id != '9' && $qlist->id != 10 && $qlist->id != 11 && $qlist->id != 12){
							echo '
							<li>'.$answer.'</li>';
						}
				echo '</ul>';
				}
				if($qlist->id == '4'){
					$total = $agree+$disagree+$stronglyAgree+$stronglyDisagree;
					if($total != 0){
					$stronglyAgreeP = ($stronglyAgree/$total)*100;
					$agreeP = ($agree/$total)*100;
					$disagreeP = ($disagree/$total)*100;
					$stronglyDisagreeP = ($stronglyDisagree/$total)*100;
					echo '<ul> <li> Strongly Agree = '.round($stronglyAgreeP, 2).' %</li>
					<li> Agree = '.round($agreeP, 2).' %</li>
					<li> Disagree = '.round($disagreeP, 2).' %</li>
					<li> Strongly Disagree = '.round($stronglyDisagreeP, 2).' %</li></ul>';
					}
				}
				
				if($qlist->id == '7' || $qlist->id == '9' || $qlist->id == '10'){
					$total = $no+$yes;
					$noP = ($no/$total)*100;
					$yesP = ($yes/$total)*100;
					echo '<ul> <li> Yes = '.round($yesP, 2).' %</li>
					<li> No = '.round($noP, 2).' %</li></ul>';
				}
				if($qlist->id == '11'){
					$total = $cp+$email+$messenger;
				if($total != 0){
					$cpP =  ($cp/$total)*100;
					$emailP = ($email/$total)*100;
					$messengerP = ($messenger/$total)*100;
					

					echo '<ul> <li> Cellphone number = '.round($cpP, 2).' %</li>
					<li> Email = '.round($emailP, 2).' %</li>
					<li> Messenger = '.round($messengerP, 2).' %</li></ul>';
				}
				}
				if($qlist->id == '12'){
					$total = $none+$acad+$employee+$sciehigh+$sibling+$director+$sa+$marshall+$ub+$ese+$athletes+$gov;
					if($total != 0){
					$noneP = ($none/$total)*100;
					$acadP = ($acad/$total)*100;
					$employeeP = ($employee/$total)*100;
					$sciehighP = ($sciehigh/$total)*100;
					$siblingP = ($sibling/$total)*100;
					$directorP = ($director/$total)*100;
					$saP = ($sa/$total)*100;
					$marshallP = ($marshall/$total)*100;
					$ubP = ($ub/$total)*100;
					$eseP = ($ese/$total)*100;
					$athletesP = ($athletes/$total)*100;
					$govP = ($gov/$total)*100;

					echo "<ul> <li> None = ".round($noneP, 2)." %</li>
					<li> Academic Scholar = ".round($acadP, 2)." %</li>
					<li> Employee Depended = ".round($employeeP, 2)." %</li>
					<li> Science High School Graduate / UB High Top Graduate = ".round($sciehighP, 2)." %</li>
					<li> Sibling Disount = ".round($siblingP, 2)." %</li>
					<li> Director's Grantee = ".round($directorP, 2)." %</li>
					<li> Student Assistant = ".round($saP, 2)." %</li>
					<li> Marshall = ".round($marshallP, 2)." %</li>
					<li> University Choir / Dance Troupe / Band = ".round($ubP, 2)." %</li>
					<li> ESE Scholarship = ".round($eseP, 2)." %</li>
					<li> Athletes = ".round($athletesP, 2)." %</li>
					<li> Government Scholar = ".round($govP, 2)." %</li>
					</ul>";
				}
				}

			}
		}
		}
	}

		 ?>
</div>
	<div style="margin-top: 50px;">
		<label>Generated by:<br><br>
       <label>{{Auth::guard('alumni')->user()->first_name}} @if(Auth::guard('alumni')->user()->middle_name != null){{Auth::guard('alumni')->user()->middle_name}}.@endif {{Auth::guard('alumni')->user()->last_name}}</label><br>
					
			{{$department->school_code}} {{auth()->guard('alumni')->user()->user_role}}
		</label>
	</div>
</div>
		</main>

</body>
</html>