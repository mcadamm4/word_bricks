
<?php
	require_once 'db_connection.php';

	session_start();// Starting Session

	//Storing Session
	$name=$_SESSION['login_user'];

	$pdo = db_connect();

	//Does this username already exist??
	$stmt = $pdo->prepare("SELECT userID, username FROM user_Table WHERE username = '" . $name . "';");
	//Execute query
	$stmt->execute();

	//SQL Query To Fetch Complete Information Of User
	$result = $stmt->fetchAll();
	foreach ($result as $value) {
		$login_session = $value['username'];
	}
	
	if(!isset($login_session)){
	 	mysql_close($connection); // Closing Connection
	 	header('Location: index.php'); // Redirecting To Home Page
	}
?>