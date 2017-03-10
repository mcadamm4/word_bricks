<?php
	require ("../src/studentProgress.php");
	include('../src/session.php');
?>


<html lang='en'>
<head>
   
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<script src="js/bootstrap.js"></script>
	<script src="js/bootstrap.min.css"></script>
	
	<title>Wordbricks student homepage</title>
	
	<link href="https://fonts.googleapis.com/css?family=Baloo" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/regPage.css">
	
	<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
	
</head>

<body onload="displayMedal(), myFunction()">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-offset-2 col-sm-offset-4 col-md-offset-5 col-lg-offset-0"> 
			<div class="mynavbar navbar-light bg-faded"> 
				<div class="container-fluid">
					<p class="mynavbar" href="index.php"> WORD BRICKS <img src="Images/block.ico" height="50px" width="50px"></p>
					<p class="navText pull-right"> <a href="logout.php">Log Out</a> </p>
					<p class="navText pull-left"><?php echo $login_session; ?></p>
				</div>
			</div>
			</div>
		</div>
	</div>

	
    <div class="container col-xs-6 col-sm-6 col-md-6 col-lg-6">
		
		<?php $progressResult = getProgress($login_session);  ?>
		
		<div id="myDiv" style="width: 500px; height: 500px;"> </div>
			<script>
	
				// Enter a speed between 0 and 180
				var level = <?php echo ($progressResult * 6); ?>;

				// Trig to calc meter point
				var degrees = 180-level,
				
				radius = .5;
				var radians = degrees * Math.PI / 180;
				var x = radius * Math.cos(radians);
				var y = radius * Math.sin(radians);

				// Path: may have to change to create a better triangle
				var mainPath = 'M -.0 -0.025 L .0 0.025 L ',
					pathX = String(x),
					space = ' ',
					pathY = String(y),
					pathEnd = ' Z';
				var path = mainPath.concat(pathX,space,pathY,pathEnd);

				var data = [
					{ 
						type: 'scatter',
						x: [0], y:[0],
						marker: {size: 25, color:'850000'},
						showlegend: false,
						name: 'Progress',
						text: <?php echo ($progressResult); ?>,
						hoverinfo: 'text+name'
					},
					
					{ 
						values: [10,10,10, 30 ],
						rotation: 90,
						text: ['Hard',  'Medium', 'Easy'],
						textinfo: 'text',
						textposition:'inside',
						
						textfont:{
							family: 'cursive',
							size: 20,
							color: '#000000'
						},		 
						marker: {
							colors:[/*Hard*/ 'rgb(255, 127, 0)',/*Medium*/ 'rgb(0, 255, 0)',/*Easy*/ 'rgb(75, 70, 130)', 
							'rgba(255, 255, 255,0)']
						},
						labels: ['Hard ex1-10','Medium ex1-10','Easy ex1-10', 'levels'],
						hoverinfo: 'label',
						hole: .5,
						type: 'pie',
						showlegend: false
					}];

				var layout = {
					shapes:[{
						type: 'path',
						path: path,
						fillcolor: '850000',
						line:{
							color: '850000'
						}
					}],
					
					title: '<b>Progress</b> <br> ',
					height: 650,
					width: 650,
					xaxis: {zeroline:false, showticklabels:false,
							showgrid: false, range: [-1, 1]},
							
					yaxis: {zeroline:false, showticklabels:false,
							showgrid: false, range: [-1, 1]},

					paper_bgcolor: 'rgba(0,0,0,0)',
					plot_bgcolor: 'rgba(0,0,0,0,0)',


				};

				Plotly.newPlot('myDiv', data, layout,{displayModeBar:false});
			</script>
	</div>
	
	<br>
	<div class="container layer2 col-xs-12 col-sm-12 col-md-6 col-lg-6  ">
			<h3 align="center"> <p id="message"></p> <p id="message2"></p> <h3>
			<img id="img1" src="Images/medal.png" width="100" height="100">&nbsp;&nbsp;&nbsp;<p id="easy"></p></img> <br><br>
			
			<img id="img2" src="Images/medal.png" width="100" height="100">&nbsp;&nbsp;&nbsp;<p id="med"></p> <br><br>
			
			<img  id="img3" src="Images/medal.png" width="100" height="100">&nbsp;&nbsp;&nbsp;<p id="hard"></p> <br><br>
			
			<a href="expage.php" id="exButton" class="btn btn-warning btn-block btn-lg"> Exercise Page </a> 

           

			
	</div>

	<script>
		function displayMedal(){
			var bronze = document.getElementById("img1");
			var silver = document.getElementById("img2");
			var gold = document.getElementById("img3");
			
			var exercise = <?php echo ($progressResult); ?>;
			
			if(exercise <= 10){
				var text = document.getElementById("message").innerHTML = "Keep up the good work!";
			}
			if(exercise > 10){
				bronze.style.display = "inline";
				var text = document.getElementById("easy").innerHTML = "You completed Easy!!";
				var text = document.getElementById("message").innerHTML = "Keep up the good work!";
			}
			if(exercise > 20){
				silver.style.display = "inline";	
				var text = document.getElementById("med").innerHTML = " You completed Medium!!";
				var text = document.getElementById("message").innerHTML = "Keep up the good work!";
			}
			if(exercise >= 30){
				gold.style.display = "inline";	
				var text = document.getElementById("hard").innerHTML = " You completed Hard!!";
				var text = document.getElementById("message").innerHTML = "";
				var text = document.getElementById("message2").innerHTML = "Well done, no more exercises!";
			}
		}
	</script>

	 <script>
	 	var progress = "<?php echo $progressResult ?>";
    	function myFunction()
		{
			var exButton = document.getElementById("exButton");
			
			if (progress >= 30){
			    exButton.style.display = "none";
			} 
		}

    </script>
	<div class="container">
		<div class="navbar navbar-default navbar-fixed-bottom">
			<p class="navbar-text pull-left">© 2017 - Site Built By Mark McAdam & Méabh Horan.</p>
		</div>
	</div>	
</body>
</html>