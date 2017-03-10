
 <!-- PHP script to retrieve exrcises from database -->
<?php
    require_once "db_connection.php";
    require_once "studentProgress.php";

    function getLang($name)
    {
    	$pdo = db_connect();
		$stmt = $pdo->prepare("SELECT lang_id FROM user_Table WHERE username = '" . $name . "';");
		$stmt->execute();

		$arr = $stmt->fetch(PDO::FETCH_ASSOC);

		return $arr['lang_id']; //Convert returned value to an integer
    }
    
    function getLevel($name)
    {
    	$pdo = db_connect();
		$stmt = $pdo->prepare("SELECT level_id FROM progress_Table WHERE userID = (SELECT userID from user_Table WHERE username = '" . $name . "');");
		$stmt->execute();

		$arr = $stmt->fetch(PDO::FETCH_ASSOC);

		return $arr['level_id']; //Convert returned value to an integer
    }

	function setProgressAndLevel($name, $lvl, $pgs)
    {
    	$pdo = db_connect();

		$stmt = $pdo->prepare("UPDATE `progress_Table` SET `level_id`='" . $lvl . "',`progress`='" . $pgs . "' WHERE userID = (SELECT userID from user_Table WHERE username = '" . $name . "');");
		$stmt->execute();
		return true;
    }            


    function getExercises($name)
    {
    	$pdo = db_connect();

		$level = getLevel($name);
		$lang = getLang($name);

        $sqlStatement = "CALL getWordsForLvl($level, $lang);";

   	    $stmt = $pdo->prepare($sqlStatement);
		$stmt->execute();
		$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$v = 0;
		$n = 0;
		$a = 0;

		//Set words
		for($i=0; $i<count($arr); $i++)
		{
			//Array of verbs
			if($arr[$i]['pos_type_id'] == 1) {
				$verbArr[$v] = $arr[$i]['token'];
				$v++;	
			}	
			//Array of nouns
			if($arr[$i]['pos_type_id'] == 2) {
				$nounArr[$n] = $arr[$i]['token'];
				$n++;
			}
			//Array of adjectives
			if($arr[$i]['pos_type_id'] == 3) {
				$adjArr[$a] = $arr[$i]['token'];
				$a++;
			}
		}
		
		$verb = $verbArr[rand(0, count($verbArr)-1)];
		$noun = $nounArr[rand(0, count($nounArr)-1)];
		$adj = $adjArr[rand(0, count($adjArr)-1)];

		$array = array($verb, $noun, $adj);

		return $array;

	}
?>