<?php 
   	require '/var/www/html/wordbricks/vendor/autoload.php';
    require '/var/www/html/wordbricks/src/getStats.php';

    use PHPUnit\Framework\TestCase;
    
    class getStatsTest extends TestCase
    {
        public function testGetStatsSuccess() {
            $result = getStats("testTeacher");
            $this->assertEquals(15.0000, $result);
        }

        public function testGetStatsFailure() {
            $result = getStats("12345678");
            $this->assertEquals(0, $result);
        }
    }
?>