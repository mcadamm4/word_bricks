
<?php
	require_once "db_connection.php"; //Establish db connection
	require_once "logUserIn.php"; //Establish db connection

 	// define variables and set to empty values
	$debug = $usernameErr = $passwordErr = "";
	$username = $password = "";

	$valid = True;

	//Open a session for the new user
	session_start(); 
	
	//Check whether the form has been submitted using $_SERVER["REQUEST_METHOD"]. If the REQUEST_METHOD is POST, then the form has been submitted - and it should be validated. If it has not been submitted, skip the validation and display a blank form.


	//EXAMINE FORM INPUTS: ALERT USER TO ERROR or REGISTER NEW USER IN DB.
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		//Check username has been provided
		if (empty($_POST["username"])) {
			$usernameErr = "<div class='alert alert-danger'><strong>* Username is required </strong></div>";
			$valid = False;
		} else {
			$username = test_input($_POST["username"]);
		}

		// Check password has been provided
		if (empty($_POST["password"])) {
			$passwordErr = "<div class='alert alert-danger'><strong>* Password is required </strong></div>";
			$valid = False;
		} else {
			$password = test_input($_POST["password"]);
		}

	
 		//All inputs valid so far, move on to next step
 		if($valid)
		{
			//Register Student User
			$result = logUserIn($username, $password);
			
			//Username already exists, ask for a different username
			if($result == 0) { 
				$_SESSION['login_user']=$username; // Initializing Session
				header("Location:teacherHomePage.php"); // Redirecting To Other Page
			} else if($result == 1) { 
				$_SESSION['login_user']=$username; // Initializing Session
				header("Location:studentHomePage.php"); // Redirecting To Other Page
			} else if($result == 2) { 
				$passwordErr = "<div class='alert alert-danger'><strong> Incorrect password </strong></div>";
			} else if($result == 3) {
				$usernameErr = "<div class='alert alert-danger'><strong> Make sure you are already registered </strong></div>";
			}			
			
		}
	}

//====================================
//	FUNCTIONS 
//====================================

	//TEST INPUT FOR SPECIAL CHARS AND TRIM WHITE SPACES
	function test_input($data) 
	{
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
	}


?>
