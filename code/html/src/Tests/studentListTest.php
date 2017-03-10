<?php
    require_once '/var/www/html/wordbricks/vendor/autoload.php';
    require_once '/var/www/html/wordbricks/src/studentList.php';

    use PHPUnit\Framework\TestCase;
    
    class studentListTest extends TestCase
    {
        public function testGetStudentsSuccess() {
            $result = getStudents("testTeacher");
            $this->assertEquals('testStudent', $result[0]['username']);
        }

        public function testGetStudentsFailure() {
            $result = getStudents("testTeacher");
            $this->assertNotEquals('', $result[0]['username']);
        }

        public function testFakeTeacherReturnsEmpty() {
            $result = getStudents("%&$%&*");
            $this->assertEmpty($result);
        }
    }
?>