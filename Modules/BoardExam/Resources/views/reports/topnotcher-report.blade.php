<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
            /** Define the margins of your page **/
             @page {
                margin: 50px 70px 70px 70px;
            }
            header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;

                text-align: center;
                line-height: 35px;
            }

            footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 50px; 

                text-align: right;
                line-height: 35px;
            }
            p, label{
			    padding : 0;
			    margin-top : 0;
			    line-height : 20px;
			}
			table {
			  border-collapse: collapse;
			  width: 100%;
			  table-layout:fixed;
			}

			table, th, td {
			  border: 1px solid black;
			  padding: 3px;
			  font-size:15px;
			  word-wrap:break-word;
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
	        .column {
			  float: left;
			  width: 33.33%;/* Should be removed. Only for demonstration */
			}

			/* Clear floats after the columns */
			.row:after {
			  content: "";
			  display: table;
			  clear: both;
			}
        </style>
</head>
<body>
          <br>
            <center><img src="{{asset('images/ubname.png')}}" style="width:20%;margin-bottom: 0;">
            	<p><b>{{$department->school_name}}</b><br>General Luna Rd., Baguio City, Philippines 2600</p>
            </center>
              <hr style="margin-top:0; margin-bottom:0;border:1px solid #000000;">
              <div class="row">
              	<div class="column">
           	  	  <label style="font-size: 12px;">Telefax No.: (074) 619-0003</label>
           		</div>
           		<div class="column" style="text-align: center;"> 
                  <label style=" font-size: 12px; ">Website:www.ubaguio.edu</label>
           		</div>
           		<div class="column" style="text-align: right;">
               	  <label style="font-size: 12px;"> Email Address: registrar@ubaguio.edu</label>
               	</div>
           </div>
<br>
<div class="row">	
<div>
	<center><h3>Topnotchers</h3></center>
</div>
<div>
	<?php 
		if($exam)
			echo '<span class="filters"><strong>Award:</strong> '.$exam.'</span>';
		if($rank)
			echo '<span class="filters"><strong>Award:</strong> '.$rank.'</span>';
		if($from && $to)
			echo '<span class="filters" ><strong>From:</strong> '.date('M, d Y', strtotime($from)).'<strong>&nbsp;&nbsp;&nbsp;To:&nbsp;&nbsp;</strong> '.date('M, d Y', strtotime($to)).'</span><br>';
	 ?>
	</div>
	 <table id="history_table"  class="display compact cell-border" style="text-align: center;">
        <thead>
          <tr>
          	<?php 
				if(!$exam){
					echo "<th>Licensure Exam</th>";
				}
			 ?>
            <th>Name</th>
            <th>Examination Date</th>
            <?php 
				if(!$rank){
					echo "<th>Rank</th>";
				}
			 ?>
           </tr>
        </thead>
         <tbody>

		<?php 
			$count = 0;
			foreach ($queryBuilder as $q) {
				$count++;
				echo '<tr>';
				if(!$exam){
							echo '<td>'.$q->licensure_exam.'</td>';
						}
				
				echo '
					  	<td>'.$q->name.'</td>';
						$examd = date('M. d, Y', strtotime($q->exam_date));

				echo '
					  	<td>'.$examd.'</td>';
					  
				if(!$rank){
				 echo '<td>'.$q->rank.'</td>';
						}
				echo '
					  </tr>';
			}
		 ?>
		</tbody>
	</table>
	<div style="margin-top: 50px;">
		<label>Generated by:<br>
			{{auth()->user()->name}}<br>
			{{$department->school_name}}
		</label>
	</div>
</div>


<footer>
 <?php echo date('F, d Y') ?>
</footer>
</body>
</html>