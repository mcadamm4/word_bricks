<?php
require '/var/www/html/wordbricks/vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Goutte\Client;

class teacherRegTest extends TestCase
{
	//Is initial form empty
	public function testTeacherReg_WithGET_HasBlankForm() {
		$client = new Client();
		$response = $client->request('GET', 'http://wordbricks.xyz/teacherReg.php'); 
		$this->assertCount(1, $response->filter('form')); //Check for one form on the page
		$this->assertEquals('', $response->filter('form input[name=username]')->attr('value')); //Check the value of each field
		$this->assertEquals('',	$response->filter('form input[name=email]')->attr('value')); 
		$this->assertEquals('',	$response->filter('form input[name=password]')->attr('value')); 
		$this->assertEquals('', $response->filter('form input[name=confirm]')->attr('value'));
		$this->assertEquals('', $response->filter('form input[name=class-name]')->attr('value'));
	}
}
