<?php
	//Log student in
	function logUserIn($name, $pwd)
	{
		$pdo = db_connect();

		//Does this username already exist??
		$stmt = $pdo->prepare("SELECT username, password, user_Type FROM user_Table WHERE username = '" . $name . "';");
		$stmt->execute();

		$arr = $stmt->fetch(PDO::FETCH_ASSOC);

		if (($stmt->rowCount())>0 && $arr['password']==$pwd) { 
			if($arr['user_Type']=='T')
				return 0; //Teacher exists and password is correct
			if($arr['user_Type']=='S')
				return 1; //Student exists and password is correct

		} else if (($stmt->rowCount())>0) {
			return 2; //Password is wrong
		} else {
			return 3; //Username is wrong
		}
	}

?>