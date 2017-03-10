<html lang='en'>

<head>

    <?php 

        require "../src/getExercises.php"; 
        include "../src/session.php";

    ?>

	<script src="blockly/blockly_compressed.js"></script>
	<script src="blockly/blocks_compressed.js"></script>
	<script src="blockly/javascript_compressed.js"></script>
	<script src="blockly/msg/js/en.js"></script>

    <title>WORD BRICKS</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Baloo" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/regPage.css">

</head>

<body>
    <?php
    
        $level = getLevel($login_session);
        $difficulty = "";
        switch($level){
            case($level == 1):
                $difficulty = "easy";
                break;
            case($level == 2):
                $difficulty = "medium";
                break;
            case($level == 3):
                $difficulty = "hard";
                break;
        }

        $progress = getProgress($login_session); //Users progress, used later to end game
        $progressMod = getProgress($login_session)%10; //Get the users progress, modulus 10 to get progress for current section i.e.(Easy,Med,Hard)

        $array = getExercises($login_session); //Retrive a new set of words for the exercise

        $verb_word = $array[0]; 
        $noun_word = $array[1]; 
        $adj_word = $array[2];

    ?>

   <script>
   //Blockly block generation

    // BLOCK ONE
    Blockly.Blocks['verb_block'] = {
      init: function() {
        this.appendValueInput("verb")
            .setCheck(null)
            .appendField("<?php echo  $verb_word; ?>");
        this.setColour(120);
        this.setTooltip('');
        this.setHelpUrl('http://www.example.com/');
      }
    };
  
    Blockly.JavaScript['verb_block'] = function(block) {
        var value_verb = Blockly.JavaScript.valueToCode(this, 'verb', Blockly.JavaScript.ORDER_ATOMIC);
        var code = "<?php echo 1; ?>";
        return [code] + value_verb;
    };
    
    // BLOCK TWO
    Blockly.Blocks['noun_block'] = {
      init: function() {
        this.appendValueInput("noun")
            .setCheck("String")
            .appendField("<?php echo  $noun_word; ?>");
        this.setOutput(true, null);
        this.setColour(160);
        this.setTooltip('');
        this.setHelpUrl('http://www.example.com/');
      }
    };

    Blockly.JavaScript['noun_block'] = function(block) {
        var value_noun = Blockly.JavaScript.valueToCode(this, 'noun', Blockly.JavaScript.ORDER_ATOMIC);
        var code = "<?php echo 2; ?>";
        return [[code] + value_noun];
    };
    
    // BLOCK THREE
    Blockly.Blocks['adj_block'] = {
      init: function() {
        this.appendDummyInput()
            .setAlign(Blockly.ALIGN_RIGHT)
            .appendField("<?php echo  $adj_word; ?>");
        this.setOutput(true, null);
        this.setColour(20);
        this.setTooltip('');
        this.setHelpUrl('http://www.example.com/');
      }
    };

    Blockly.JavaScript['adj_block'] = function(block) {
        var value_adj = Blockly.JavaScript.valueToCode(this, 'adj', Blockly.JavaScript.ORDER_ATOMIC);
        var code = "<?php echo 3; ?>";
        return [code];
    };



    // CHECK ANSWER
    //Called when check answer button is clicked
    function runCode() { 
        code = Blockly.JavaScript.workspaceToCode(workspace); //Grab values from blocks as string
        
        try {
            var result = evalAnswer(code);

            if(result == true){ 
                //Update user level and progress if correct
                var modal = document.getElementById('correctAnswer'); //Show overlay for correct answer
                var name = "<?php echo $login_session ?>";

                //Use POST to pass username back to PHP so it can update users progress
                $.ajax({
                    type: 'POST',
                    url: 'updateProgress.php',
                    data: {'name': name}, 
                    success: function(response) {
                        alert ('search is: ' + search + ', Response from PHP script: ' + response);
                    },
                    //Display error message if POST fails
                    error: function(xhr) {
                        var response = xhr.responseText;
                        console.log(response);
                        var statusMessage = xhr.status + ' ' + xhr.statusText;
                        var message  = 'Query failed, php script returned this status: ';
                        var message = message + statusMessage + ' response: ' + response;
                        alert(message);
                    }
                });    
            } else {
                //Show overlay for wrong answer
                var modal = document.getElementById('wrongAnswer');
            }

            // Open whichever modal was selected above
            modal.style.display = "block";
            
            //Do not reload page just get rid of overlay if they are trying again
            document.getElementById("tryAgain").onclick = function() {myFunction()};
            function myFunction() {
                modal.style.display = "none";
            }

        } catch (e) {
          alert(e);
        }
    } 

    function evalAnswer(blockTypes) {
        //Correct sentences will be in the form 123 or (Verb, Noun, Adj)
        if(blockTypes == "123") {
            return true;
        } else {
            return false;
        }
    }
    </script>

    <!-- NAV BAR -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-offset-2 col-sm-offset-4 col-md-offset-5 col-lg-offset-0"> 
            <div class="mynavbar navbar-light bg-faded">
                <div class="container-fluid">
                    <p class="mynavbar"  href="studentHomePage.php"> WORD BRICKS <img src="Images/block.ico" height="50px" weight="50px"></p>
					<a href="studentHomePage.php" class="btn btn-warning btn-lg pull-right">Home Page <span class="glyphicon glyphicon-home"></span></a>
                    <p class="navText pull-left"><?php echo $login_session; ?></p>
                </div>
            </div>
            </div>
        </div>
    </div>
    <br>

    <div class="container-fluid layer2">

        <!-- CORRECT ANSWER OVERLAY -->
        <div id="correctAnswer" class="modal">
            <div class="modal-content alert alert-success alert-dismissable fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>CORRECT ANSWER</strong> -> <?php echo 10-($progressMod) . " questions to go" ?>
                <br>
                <img src="Images/wellDone.png" class="img-rounded" alt="Cinque Terre" width="304" height="236">
                <br>
                <br>
                <a href="#" id="checkAnswer" class="btn btn-success btn-block btn-lg">Next Question &nbsp; </span><span class="glyphicon glyphicon-chevron-right"></span></a>

                <script type="text/javascript">
                    var progress = "<?php echo $progress ?>";

                    if (progress >= 29){
                        document.getElementById("checkAnswer").onclick = function() {
                            document.getElementById("checkAnswer").href="studentHomePage.php"; 
                        }
                    } else {
                        document.getElementById("checkAnswer").onclick = function() {
                            document.getElementById("checkAnswer").href="expage.php"; 
                        }
                    }
                </script>
            </div>
        </div>

        <!-- WRONG ANSWER OVERLAY -->
        <div id="wrongAnswer" class="modal">
            <div class="modal-content alert alert-warning alert-dismissable fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>TRY AGAIN</strong>
                <br>
                <img src="Images/tryAgain.png" class="img-rounded" alt="Cinque Terre" width="304" height="236">
                <br>
                <br>
                <a id="tryAgain" class="btn btn-warning btn-block btn-lg">Try again &nbsp; </span><span class="glyphicon glyphicon-chevron-left"></span></a>
            </div>
        </div>

        <!-- BLOCKLY WORK-SPACE -->  
        <div id="blocklyDiv" style="height: 450px; "></div>

        <!-- PROGRESS BAR -->
        <div class="progress"> <!-- Use PHP echo to set progress bar, second number in $progress + 0 gives correct progress % -->
            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" 
                aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="<?php echo "width: " . $progressMod . "0%";?>">
                <?php echo $progressMod ?>0% Complete
            </div>
        </div>

        <p class="navText pull-center"><?php echo (10-($progressMod)) . " more questions to go on " . $difficulty . "!"; ?></p>
        <!-- Submit answer Button -->
        <a onclick="runCode()" class="btn-primary btn-lg pull-right"> Check your answer
        <span class="glyphicon glyphicon-ok"></span></a>
    </div>
    
    <!-- NAV BAR -->
	<br>
	<br>
	<br>
    <div class="navbar navbar-default navbar-fixed-bottom">
        <div class="container-fluid">
            <p class="navbar-text pull-left">© 2017 - Site Built By Mark McAdam & Méabh Horan.</p>
        </div>
    </div>
    
       <!-- WORD BRICK TOOLBOX -->
        <xml id="toolbox" style="display: none">

            <block type="verb_block"></block>
            <block type="noun_block"></block>
            <block type="adj_block"></block>

        </xml>

    <!-- GENERATE BRICKS -->
 
</body>

    <script>
        
        //Inject BLOCKLY into page and define attributes of workspace and toolbox for the page

        var workspace = Blockly.inject('blocklyDiv',{ 
        toolbox: document.getElementById('toolbox'),
        maxBlocks:3,
        grid:
             {spacing: 20,
              length: 3,
              colour: '#ccc',
              snap: true},
        zoom:{
            controls: true,
            startScale: 2.0,
            maxScale: 3,
            minScale: 0.3,
            scaleSpeed: 1.2},
        trashcan: true});
    </script>

</html>

