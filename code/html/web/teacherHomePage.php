<?php
	require("../src/getStats.php");
	include('../src/studentList.php');
	include('../src/session.php');
?>

<!DOCTYPE html>
<html lang='en'>
<head>
   
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<script src="js/bootstrap.js"></script>
	<script src="js/bootstrap.min.css"></script>
	
	<title>Wordbricks teacher homepage</title>
	
	<link href="https://fonts.googleapis.com/css?family=Baloo" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/regPage.css">
	
	<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
	
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-offset-2 col-sm-offset-4 col-md-offset-5 col-lg-offset-0"> 
			<div class="mynavbar navbar-light bg-faded"> 
				<div class="container-fluid">
					<p class="mynavbar" href="index.php"> WORD BRICKS <img src="Images/block.ico" height="50px" width="50px"></p>
					<p class="navText pull-right"> <a href="logout.php">Log Out </a> </p>
					<p class="navText pull-left"><?php echo $login_session; ?></p>
				</div>
			</div>
			</div>
		</div>
	</div>

	<br>
	
    <div class="container  col-xs-12 col-sm-12 col-md-6 col-lg-6">		

		<?php $avgResult = getStats($login_session); ?>
		
		<div id="myDiv" style= "border-radius: 25px; width: 500px; height: 500px;"> </div>
			<script>
			
				var avg = [
				  {
					x: [ 'Current Class'],
					y: [ '<?php echo ($avgResult); ?>'],
					name: 'Current average class grade',
					textfont:{ family: 'san serif', 
								size: 18, 
								color: '#1f77b4'
							},
					type: 'bar'
				  }
				];
				
				var layout = {
					title: '<b>Class Average Grade</b> <br> ',
					height: 400,
					width: 400,
					
					
					
					paper_bgcolor: 'rgba(70, 150, 200, 0.3)',
					plot_bgcolor: 'rgba(0,0,0,0,0)',
				};
				
				Plotly.newPlot('myDiv', avg, layout,{displayModeBar:false});	
				
			</script>
	</div>
	

	<div class="container layer2 col-xs-12 col-sm-10 col-md-7 col-lg-6 ">
		
		<h2> Class list </h2><br>
		<?php 

			$studentListResult = getStudents($login_session); 

			$arrSize = count($studentListResult);
			for($i=0; $i < $arrSize; $i++)
			{
				echo $studentListResult[$i]['username'];
				echo "<br>";
			}	

		 ?>
		 	
		 
	</div>	

	<div class="container">
		<div class="navbar navbar-default navbar-fixed-bottom">
			<p class="navbar-text pull-left">© 2017 - Site Built By Mark McAdam & Méabh Horan.</p>
		</div>
	</div>	
</body>
</html>