<?php 

	// Receives username via POST from expage.php and uses it to update a users progress after they have answered a question correctly

    require "../src/getExercises.php"; //Needs access to funtions for updates

    $name = $_POST['name'];

    $overallProgress = getProgress($name); //Get the users old progress
    $overallProgress++; 
    
    $userLevel = $overallProgress / 10; //Not ideal to have these hard coded values but we have 3 sections with 10 Qs each, dividing progress by 10 gives us a users diffculty level
    if($userLevel == 1 || $userLevel == 2 || $userLevel == 3)
    	$userLevel++;
    $userLevel = ceil($userLevel); //Always round up or else it may return 0. (Zero is not a valid level)
    $setProg = setProgressAndLevel($name, $userLevel, $overallProgress); //Update new values in db

?>