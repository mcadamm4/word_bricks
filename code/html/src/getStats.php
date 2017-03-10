<?php
	require_once "db_connection.php"; //Establish db connection	
	
	$var = "";
	
	//Get average class progress
	function getStats($name)
	{
		$pdo = db_connect(); 

		$stmt = $pdo->prepare("SELECT AVG(progress) FROM progress_Table WHERE class_id = (
									SELECT class_id FROM class_Table WHERE owner_id = (
										SELECT userID FROM user_Table WHERE username = '$name'))");	
		$stmt->execute();
		$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$var = $arr[0]['AVG(progress)'];
		
		if(($stmt->rowCount())>0){
			//results found
			return $var; 
		} 
		else {
			//user doesnt exist
			return 0;
		}	
	}
?>