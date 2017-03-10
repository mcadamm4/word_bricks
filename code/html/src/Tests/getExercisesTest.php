<?php 
	require_once '/var/www/html/wordbricks/vendor/autoload.php';
    require_once '/var/www/html/wordbricks/src/getExercises.php';

    use PHPUnit\Framework\TestCase;
    
    class getExercisesTest extends TestCase
    {
        public function testGetLevelSUCCESS() {
            $result = getLevel("testStudent");
            $this->assertEquals(2, $result);
        }

        public function testGetStudentsFAILURE() {
            $result = getLevel("testStudent");
            $this->assertNotEquals(-12, $result);
        }

        public function testSetProgressAndLevelSUCCESS() {
        	//Set new values
            $result = setProgressAndLevel("testStudent", 3, 20);
            //Check db for values
            $pdo = db_connect();
			$stmt = $pdo->prepare("SELECT level_id, progress FROM progress_Table WHERE userID = (SELECT userID from user_Table WHERE username = 'testStudent');");
			$stmt->execute();
			$arr = $stmt->fetch(PDO::FETCH_ASSOC);
			//ASSERT
            $this->assertEquals(3, $arr['level_id']);
            $this->assertEquals(20, $arr['progress']);

            //reset old values
            $result = setProgressAndLevel("testStudent", 2, 15);
            //Check db for values
            $stmt = $pdo->prepare("SELECT level_id, progress FROM progress_Table WHERE userID = (SELECT userID from user_Table WHERE username = 'testStudent');");
			$stmt->execute();
			$arr = $stmt->fetch(PDO::FETCH_ASSOC);
			//ASSERT
            $this->assertEquals(2, $arr['level_id']);
            $this->assertEquals(15, $arr['progress']);
        }
    }

?>