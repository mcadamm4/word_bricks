<?php
require '/var/www/html/wordbricks/vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Goutte\Client;

class studentRegRegTest extends TestCase
{
	//Is initial form empty
	public function testStudentReg_WithGET_HasBlankForm()
	{
		$client = new Client();
		$response = $client->request('GET', 'http://wordbricks.xyz/studentReg.php');
		$this->assertCount(1, $response->filter('form')); //Check for one form on the page
		$this->assertEquals('', $response->filter('form input[name=username]')->attr('value')); //Check the value of each field
		$this->assertEquals('',	$response->filter('form input[name=password]')->attr('value')); 
		$this->assertEquals('', $response->filter('form input[name=confirm]')->attr('value'));
		$this->assertEquals('', $response->filter('form input[name=class-name]')->attr('value'));
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
