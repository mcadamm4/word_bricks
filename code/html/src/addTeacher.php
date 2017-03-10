<?php

	
	//REGISTER A NEW TEACHER USER
	function addTeacher($name, $eml, $pwd, $clsNme)
	{	
		$type = 'T';
		$pdo = db_connect();

		//Does this username already exist??
		$usrStmt = $pdo->prepare("SELECT username FROM user_Table WHERE username = '" . $name . "';");
		$usrStmt->execute();

		//Does this classname already exist??
		$clsStmt = $pdo->prepare("SELECT class_name FROM class_Table WHERE class_name = '" . $clsNme . "';");
		$clsStmt->execute();

		//Execute query
		if ($usrStmt->fetch()>0) 
		{ 
			//User already exists
			return 1; 

		} else if ($clsStmt->fetch()>0) 
		{
			//Class already exists
			return 2;

		} else {

			$stmt = $pdo->prepare("INSERT INTO `user_Table`(`username`, `email`, `user_Type`, `password`) VALUES ('" . $name . "', '" . $eml . "','" . $type . "', '" . $pwd . "');" );
			$stmt->execute();

			//Insert new class into class table if $class-name set
			if (!empty( $clsNme)) {

				//Get new users ID
				$stmt = $pdo->prepare("SELECT userID FROM user_Table WHERE username = '" . $name . "';");
				$stmt->execute();
				$arr = $stmt->fetch(PDO::FETCH_ASSOC);

				//Add new class with userID as foreign key
				$stmt = $pdo->prepare("INSERT INTO `class_Table`(`class_name`, `owner_id`) VALUES ('" . $clsNme . "', '" . $arr['userID'] . "');" );
				$stmt->execute();
			}

			//New user and/or class added successfully
			return 3; 
		}
	}
?>