<?php
	require '/var/www/html/wordbricks/vendor/autoload.php';
    require '/var/www/html/wordbricks/src/logUserIn.php';

    use PHPUnit\Framework\TestCase;
    
    class logUserInTest extends TestCase
    {
    	//Teacher exists and password is correct
        public function testLogTeacherInSuccess() {
            $result = logUserIn("testTeacher", "test");
            $this->assertEquals(0, $result);
        }

        //Student exists and password is correct
        public function testLogStudentInFailure() {
            $result = logUserIn("testStudent", "test");
            $this->assertEquals(1, $result);
        }

        //Username is wrong
        public function testIncorrectUsername() {
            $result = logUserIn("$%&^^%$", "test");
            $this->assertEquals(3, $result);
        }
        
        //Password is wrong
        public function testCorrectUsername_WrongPassword() {
            $result = logUserIn("testTeacher", "123456789098765432");
            $this->assertEquals(2, $result);
        }
    }
?>