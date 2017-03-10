<!-- TO-DO Make this method accommodate both teacher and student regitrations -->

<?php
	require_once "db_connection.php"; //Establish db connection
	require_once "addStudent.php"; 

 	// define variables and set to empty values
	$usernameErr = $emailErr = $passwordErr = $confirmErr = $classNameErr = $lang = "";
	$username = $password = $confirm = $className = "";

	$userExistsErr_Code = 1;
	$classNameErr_Code = 2;
	$success_Code = 3;

	$valid = True;

	//Open a session for the new user
	session_start(); 
	
	//Check whether the form has been submitted using $_SERVER["REQUEST_METHOD"]. If the REQUEST_METHOD is POST, then the form has been submitted - and it should be validated. If it has not been submitted, skip the validation and display a blank form.


	//EXAMINE FORM INPUTS: ALERT USER TO ERROR or REGISTER NEW USER IN DB.
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		//Check language selected
		if ($_POST["radioIrish"]) {
			$lang = 1;
		} else {
			$lang = 2;
		}

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

		//Check password confirmation
		if (empty($_POST["confirm"]) || ($_POST["password"]) != ($_POST["confirm"])) {
			$confirmErr = "<div class='alert alert-danger'><strong>* Please confirm your password </strong></div>";
			$valid = False;
		} else {
			$confirm = test_input($_POST["confirm"]);
		}

		//Check class name
		if (empty($_POST["class-name"])) {
			$className = "";
		} else {
			$className = test_input($_POST["class-name"]);
 		}
	
 		//All inputs valid so far, move on to next step
 		if($valid)
		{
			$result = 0;
			//Register Student User
			$result = addStudent($username, $password, $className, $lang);
			
			//Username already exists, ask for a different username
			if($result==1) { 
				$usernameErr = "<div class='alert alert-danger'><strong> That username already exists </strong></div>";

			} else if ($result==2) {
				//Student is trying to join a class that does not exist
				$classNameErr = "<div class='alert alert-danger'><strong> This class does not exist, please type the name carefully.</strong></div>";

			} else {
				//SUCCESSFUL REGISTRATION, log user in and redirect to home page 
				$_SESSION['login_user']=$username; // Initializing Session
				header("Location:studentHomePage.php"); // Redirecting To Other Page
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
