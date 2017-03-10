<?php
	require "../src/ValidateStudentReg.php"; //Validate input and add user to db

?>

<html lang='en'>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>Wordbricks student registration</title>

	<script src="js/bootstrap.js"></script>
	<script src="js/bootstrap.min.css"></script>
	<link href="https://fonts.googleapis.com/css?family=Baloo" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/regPage.css">
	
</head>
<body onload="myFunction()">

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-offset-2 col-sm-offset-4 col-md-offset-5 col-lg-offset-0"> 
			<div class="mynavbar navbar-light bg-faded">
				<div class="container-fluid">
					<p class="mynavbar" href="index.php"> WORD BRICKS <a href="index.php"> <img src="Images/block.ico" height="50px" width="50px"></a></p>
					<a href="index.php" class="btn btn-warning btn-lg pull-right"><span class="glyphicon glyphicon-circle-arrow-left"></span></a>
				</div>
			</div>
			</div>
		</div>
	</div>
	<br>
	<!--Registration Form container -->
	<div class="container layer">
		<div class="row main">
				<div class="main-login main-center">
				<h3 class="lead text-center"><strong>STUDENT</strong></h3>

					<u>*required</u>
					<br>
					<br>
					<?php echo $lang;?>
					<br>

					<!-- Page posts the data to itself, htmlspecialchar() prevents code injection and cross stie scripting -->
					<form class="" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<div class="form-group">
							<div class="radio">
	  							<label id="Irish" class="radio-inline control-label"><input type="radio" name="radioIrish">Irish</label><br>
								<label id="Scottish-Gaelic" class="radio-inline"><input type="radio" name="radioScotsGaelic">Scottish Gaelic</label>
							</div>
						</div>

						<div class="form-group">
							<label for="username" class="cols-sm-2 control-label">Username: *</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<input type="text" class="form-control" name="username" id="username"  placeholder="Enter your Username"/>
								</div>
							</div>
							<!-- Warning that field is required if left blank-->
							<?php echo $usernameErr; ?>
						</div>

						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Password: *</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
									<input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password"/>
								</div>
							</div>
							<!-- Warning that field is required if left blank-->
							<?php echo $passwordErr;?>
						</div>

						<div class="form-group">
							<label for="confirm_password" class="cols-sm-2 control-label">Confirm Password: *</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
									<input type="password" class="form-control" name="confirm" id="confirm"  placeholder="Confirm your Password"/>
								</div>
							</div>
							<!-- Warning that field is required if left blank-->
							<?php echo $confirmErr;?>
						</div>

						<div class="form-group">
						<label for="class-name" class="cols-sm-2 control-label">Are you joining with your class? </label>
  							<label><input type="checkbox" id="yes" onclick="myFunction()" value="yes"> YES </label>
  							<label><input type="checkbox" id="no" value="no"> NO </label>
						</div>

						<div id="class" class="form-group">
							<label for="class-name" class="cols-sm-2 control-label">Class Name: </label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
									<input type="text" class="form-control" name="class-name" id="class-name"  placeholder="Ask your teacher for the class name"/>
								</div>
							</div>
						</div>
						
						<div class="form-group ">
  							<button type="submit" id="button" class="btn btn-warning btn-lg btn-block login-button">Register</button>
						</div>
					</form>
				</div>
			</div>
		<br>
	</div>

	<script>
		function myFunction()
		{
			if (document.getElementById('yes').checked){
			    document.getElementById('class').style.display = ""
			}
			
			else if (!document.getElementById('no').checked){
			    document.getElementById('class').style.display = "none"  
			}
		}
	</script>
	
	
	<div class="navbar navbar-default navbar-fixed-bottom">
		<div class="container">
			<p class="navbar-text pull-left">© 2017 - Site Built By Mark McAdam & Méabh Horan.</p>
		</div>
  </div>
</body>
</html>