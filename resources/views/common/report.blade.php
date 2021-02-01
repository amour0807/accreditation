<?php 

$agree = 0; $disagree = 0; $stronglyAgree =0; $stronglyDisagree =0;
					$no =0; $yes =0;
                    $none=0; $acad=0; $employee=0; $sciehigh=0; $sibling=0; $director=0; $sa=0; 
                    $none = 0; $marshall=0;
                    $others = array();
                    $otherContact = array();
					$ub=0; $ese=0; $athletes=0; $gov=0; 
					$cp=0; $email=0; $messenger=0;
foreach ($new as $q) {
    echo '<ul>';
        $answer = trim($q->answer);
        
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
    
    if($qlist->id == '2' || $qlist->id == '3' || $qlist->id == '5' || $qlist->id == '6' || $qlist->id == '8' && $qlist->id != '12'){
       if(strlen($answer) < 4 || $answer == 'None' || $answer =='none' || $answer == 'Nothing' || $answer =='None.' || $answer =='Nothing.' || $answer =='No Comment.')
            $none++;
    }
        if($qlist->id == '11'){
                $explodes = explode(",",$answer);
            $counts = count($explodes);
            if($counts == 0){
                if($answer == 'Cellphone number')
                    $cp++;
                elseif($answer == 'Email')
                    $email++;
                elseif($answer == 'Messenger')
                    $messenger++;
                else
                    $otherContact[] = $answer;
            }else{
                for($x = 0; $x < $counts; $x++){
                    $cut = trim($explodes[$x]);
                    if($cut == 'Cellphone number')
                    $cp++;
                elseif($cut == 'Email')
                    $email++;
                elseif($cut == 'Messenger')
                    $messenger++;
                    else
                    $otherContact[] = $cut;
                }
            }
        }
                if($qlist->id == '12'){
            $explode = explode(",",$answer);
            $count = count($explode);
            if($count == 0){
                if($answer == 'None')
                $none++;
            elseif($answer == 'Academic Scholar')
                $acad++;
            elseif($answer == 'Employee Dependent')
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
                else
                $others[] = $answer;
            }else{
                for($i = 0; $i < $count; $i++){
                    $trim = trim($explode[$i]);
                    if($trim == 'None')
                    $none++;
                    elseif($trim == 'Academic Scholar')
                        $acad++;
                    elseif($trim == 'Employee Dependent')
                        $employee++;
                    elseif($trim == 'Science High School Graduate / UB High Top Graduate')
                        $sciehigh++;
                    elseif($trim == 'Sibling Disount')
                        $sibling++;
                    elseif($trim == "Director's Grantee")
                        $director++;
                    elseif($trim == 'Student Assistant')
                        $sa++;
                    elseif($trim == 'Marshall')
                        $marshall++;
                    elseif($trim == 'University Choir / Dance Troupe / Band')
                        $ub++;
                    elseif($trim == "ESE Scholarship")
                        $ese++;
                    elseif($trim == 'Athletes')
                        $athletes++;
                    elseif($trim == 'Government Scholar')
                         $gov++;
                    else
                        $others[] = $trim;
            }
        }
    }
            
            if($qlist->id != '4' && $qlist->id != '7' && $qlist->id != '9' && $qlist->id != 10 && $qlist->id != 11 && $qlist->id != 12){
              if($answer != 'None' && $answer !='none' && $answer != 'Nothing' && $answer !='None.' && $answer !='Nothing.' && $answer !='No Comment.' && strlen($answer) > 3){
                echo '<li>'.$answer.'</li>';
              }
            }
    echo '</ul>';
            
    }
    if($none > 0 && $qlist->id != '12'){
        if($none == 1)
        echo '<ul> <li> None </li></ul>';
        else
    echo '<ul> <li> None / Nothing = '.$none.'</li></ul>';
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
        if($total != 0){
        $noP = ($no/$total)*100;
        $yesP = ($yes/$total)*100;
        echo '<ul> <li> Yes = '.round($yesP, 2).' %</li>
        <li> No = '.round($noP, 2).' %</li></ul>';
        }
    }
    if($qlist->id == '11'){
        $d = count($otherContact);
        $total = $cp+$email+$messenger+$d;
    if($total != 0){
        $cpP =  ($cp/$total)*100;
        $emailP = ($email/$total)*100;
        $messengerP = ($messenger/$total)*100;
        echo "<ul> <li> Cellphone number = ".round($cpP, 2)." %</li>
        <li> Email = ".round($emailP, 2)." %</li>
        <li> Messenger = ".round($messengerP, 2)." %</li>";
        
        if($d != 0){
            echo "<li> Others = ";
            for($b=0; $b<$d; $b++){
             echo''. $otherContact[$b].', ';
            }
           echo " </li>";
        } 
        echo "</ul>";
    }
    }
    if($qlist->id == '12'){
        $c = count($others);
            $total = $none+$acad+$employee+$sciehigh+$sibling+$director+$sa+$marshall+$ub+$ese+$athletes+$gov+$c;
        
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
        <li> Employee Dependent = ".round($employeeP, 2)." %</li>
        <li> Science High School Graduate / UB High Top Graduate = ".round($sciehighP, 2)." %</li>
        <li> Sibling Disount = ".round($siblingP, 2)." %</li>
        <li> Director's Grantee = ".round($directorP, 2)." %</li>
        <li> Student Assistant = ".round($saP, 2)." %</li>
        <li> Marshall = ".round($marshallP, 2)." %</li>
        <li> University Choir / Dance Troupe / Band = ".round($ubP, 2)." %</li>
        <li> ESE Scholarship = ".round($eseP, 2)." %</li>
        <li> Athletes = ".round($athletesP, 2)." %</li>
        <li> Government Scholar = ".round($govP, 2)." %</li>";
        if($c != 0){
            echo "<li> Others = ";
            for($a=0; $a<$c; $a++){
             echo''. $others[$a].', ';
            }
           echo " </li>";
        } 
       echo" </ul>";
    }
    }
    ?>