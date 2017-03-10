<?php
	function db_connect()
	{
		$servername = "localhost";
		$username = "root";
		$password = "mcadam2012";
		$dbname = "word_bricks";

		try {
		    $pdo = new PDO("mysql:host=$servername;charset=utf8mb4;dbname=$dbname", $username, $password);
		    // set the PDO error mode to exception
		    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    return $pdo; 
	    }
		catch(PDOException $e)
	    {
	    	echo "Connection failed: " . $e->getMessage();
	    }
}
?>
