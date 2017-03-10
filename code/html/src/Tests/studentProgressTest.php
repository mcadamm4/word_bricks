<?php
    require_once '/var/www/html/wordbricks/vendor/autoload.php';
    require_once '/var/www/html/wordbricks/src/studentProgress.php';

    use PHPUnit\Framework\TestCase;
    
    class studentProgressTest extends TestCase
    {
        public function testGetProgressSuccess() {
            $result = getProgress("testStudent");
            $this->assertEquals('15', $result);
        }
        public function testGetProgressFailer() {
            $result = getProgress("testStudent");
            $this->assertNotEquals('-1', $result);
        }
    }
?>
