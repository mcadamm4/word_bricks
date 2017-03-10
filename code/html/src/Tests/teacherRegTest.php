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

	function testIsProperFormSubmissionSuccessful() {
		$client = new Client();
		$response = $client->request('GET', 'http://wordbricks.xyz/teacherReg.php');
  		$this->setField("username", "TestTeacher");
		$this->setField("email", "wj@example.com");
		$this->setField("password", "password");
		$this->setField("confirm", "password");
		
		$this->clickSubmit("submit");

		$this->assertResponse(200);
		$this->assertText("We will be in touch within 24 hours.");
	}


	// public function testTeacherReg_WthPOST_IsRedirected()
	// {
	// 	$client = new \GuzzleHttp\Client();
	// 	$response = $client->request('POST',
	// 		'#################',
	// 		[
	// 			'allow_redirects' => false,
	// 			'form_params' => ['########'],
	// 		]);
	// 	$this->assertEquals(302, $response->getStatusCode());
	// 	$this->assertEquals('/', $response->getHeaderLine('Location'););

	// 	$pdo = new PDO(
	// 		'mysql:host=localhost;dbname=word_bricks','root','mcadam2012');
	// 	$statement = $pdo->prepare('SELECT * FROM teacher_Table WHERE...');
	// 	$statement->execute();
	// 	$result = $statement->fatchAll(PDO::FETCH_ASSOC);

	// 	$this->assertCount(1, $result);
	// 	$this->assertEquals([
	// 		'#####' => '###', 
	// 		'#####' => '###', 
	// 		'#####' => '###'], 
	// 		$result[0]);
	// }
}
