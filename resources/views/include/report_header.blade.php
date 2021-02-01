<style>
            /** Define the margins of your page **/
			@page {
                margin: 0cm 0cm;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 4.5cm;
                margin-left: 1.27cm;
                margin-right: 1.27cm;
                margin-bottom: 1.27cm;
            }

            /** Define the header rules **/
            header {
				padding:15px;
                position: fixed;
                top: 0.5cm;
                left: 0cm;
                right: 0cm;
                height: 3cm;
            }

            /** Define the footer rules **/
           
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
			ul { margin: 5px 0; }
		</style>
</head>
<body>
      <header>
		<?php
			$path = 'images/ubname.png';
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$data = file_get_contents($path);
			$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
			?>
            <center>
				<img src="<?php echo $base64?>" style="width:17%;margin-bottom: 0;"><br>
            	<b>{{$department->school_name}}</b><br>General Luna Rd., Baguio City, Philippines 2600
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
</header>