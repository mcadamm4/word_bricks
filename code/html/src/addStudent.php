<?php
		//REGISTER A NEW STUDENT USER
	function addStudent($name, $pwd, $clsNme, $lang)
	{
		$pdo = db_connect();

		//Does this username already exist??
		$stmt = $pdo->prepare("SELECT username FROM user_Table WHERE username = '" . $name . "';");
		$stmt->execute();

		if ($stmt->fetch()>0) { 
			//User exists already
			return 1; 

		} else if ($clsNme != "") {

			//Does the class they want to join exist??
			$clsStmt = $pdo->prepare("SELECT class_id FROM class_Table WHERE class_name = '" . $clsNme . "';");
			$clsStmt->execute();
			$arr = $clsStmt->fetch(PDO::FETCH_ASSOC);
			
			if ($arr['class_id'] != NULL) { 
				$user_Type = "S";

				//Insert new record with class id
				$stmt = $pdo->prepare("INSERT INTO `user_Table`(`username`, `user_Type`, `password`, `classID`, `lang_id`) VALUES ('" . $name . "', 'S', '" . $pwd . "', '" . $arr['class_id'] . "'," . $lang . ");");
				$stmt->execute();
				
				//Get new userID
				$stmt = $pdo->prepare("SELECT userID, classID FROM user_Table WHERE username = ('" . $name . "')");
				$stmt->execute();

				$arr = $stmt->fetch(PDO::FETCH_ASSOC);

				//Insert new record in progress table
				$stmt = $pdo->prepare("INSERT INTO `progress_Table`(`userID`, `level_id`, `progress`, `class_id`) VALUES ('" . $arr['userID'] . "', 1 , 0, '" . $arr['classID'] . "');");
				$stmt->execute();

				return 3; 

			} else {
				//Class does not exist
				return 2;

			}
		} else {
			//Insert new record
			$stmt = $pdo->prepare("INSERT INTO `user_Table`(`username`, `user_Type`, `password`, `lang_id`) VALUES ('" . $name . "', 'S', '" . $pwd . "', " . $lang . ");");
			$stmt->execute();

			//Get new userID
			$stmt = $pdo->prepare("SELECT userID FROM user_Table WHERE username = ('" . $name . "')");
			$stmt->execute();

			$arr = $stmt->fetch(PDO::FETCH_ASSOC);

			//Insert new record in progress table
			$stmt = $pdo->prepare("INSERT INTO `progress_Table`(`userID`, `level_id`, `progress`) VALUES ('" . $arr['userID'] . "', 1 , 0);");
			$stmt->execute();

			return 3;

		}
	}
?>