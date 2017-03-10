<?php
	require_once "db_connection.php"; //Establish db connection	
	
	//Get class list
	function getStudents($name)
	{
		$pdo = db_connect(); 
		
		$stmt = $pdo->prepare("(SELECT `username` FROM `user_Table` WHERE `classID`= (SELECT `class_id` FROM `class_Table` WHERE `owner_id` = (SELECT `userID` FROM `user_Table` WHERE `username`='$name') ) )");
		$stmt->execute();
		
		$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $arr;
		
	}
?>