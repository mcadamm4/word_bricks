<?php
	require_once "db_connection.php"; //Establish db connection	

	function getProgress($name)
    {
    	$pdo = db_connect();

		$stmt = $pdo->prepare("SELECT progress FROM progress_Table WHERE userID = ( SELECT userID FROM user_Table WHERE username = '" . $name . "');");
		$stmt->execute();

		$arr = $stmt->fetch(PDO::FETCH_ASSOC);

		if(($stmt->rowCount())>0){
			return $arr['progress']; //results found
		} 
		else {
			return 0; //user doesnt exist
		}
    }
?>