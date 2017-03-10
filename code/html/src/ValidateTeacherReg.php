<!-- TO-DO Make this method accommodate both teacher and student regitrations -->

<?php
	require_once "db_connection.php"; //Establish db connection
	require_once "addTeacher.php";

 	// define variables and set to empty values
	$usernameErr = $emailErr = $passwordErr = $confirmErr = $classNameErr = "";
	$username = $email = $password = $confirm = $className = "";

	$userExistsErr_Code = 1;
	$classNameErr_Code = 2;
	$success_Code = 3;

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

		//Only teacher need to provide an email
		//Check email has been provided
		if (empty($_POST["email"])) {
			$emailErr = "<div class='alert alert-danger'><strong>* Please enter a valid email address </strong></div>";
			$valid = False;
		} else {
			$email = test_input($_POST["email"]);
		}

		// Check password has been provided
		if (empty($_POST["password"])) {
			$passwordErr = "<div class='alert alert-danger'><strong>* Password is required </strong></div>";
			$valid = False;
		} else {
			$password = test_input($_POST["password"]);
		}

		//Check password confirmation
		if (empty($_POST["confirm"]) || ($_POST["password"]) != ($_POST["confirm"])) {
			$confirmErr = "<div class='alert alert-danger'><strong>* Please confirm your password </strong></div>";
			$valid = False;
		} else {
			$confirm = test_input($_POST["confirm"]);
		}

		//Check class name
		if (empty($_POST["class-name"])) {
			$classNameErr = "<div class='alert alert-danger'><strong>* Please create a class </strong></div>";
			$valid = False;
		} else {
			$className = test_input($_POST["class-name"]);
 		}
	
 		//All inputs valid so far, move on to next step
 		if($valid)
		{
			$result = 0;
			//Register Teacher User
			$result = addTeacher($username, $email, $password, $className);
			
			//Username already exists, ask for a different username
			if($result == 1) { 
				$usernameErr = "<div class='alert alert-danger'><strong> That username already exists </strong></div>";
			} else if ($result == 2) {
				//This error means different thing for each user
				$classNameErr = "<div class='alert alert-danger'><strong> That class name already exists</strong></div>";

			} else {
				//SUCCESSFUL REGISTRATION, log user in and redirect to home page 
				$_SESSION['login_user']=$username; // Initializing Session
				header("Location:teacherHomePage.php"); // Redirecting To Other Page
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
