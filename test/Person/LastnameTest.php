<?php
declare(strict_types=1);

namespace Test\Person;

use Phant\DataStructure\Person\Lastname;

use Phant\Error\NotCompliant;

final class LastnameTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$lastname = new Lastname(' doe ');
		
		$this->assertEquals('DOE', (string)$lastname);
		
		$this->assertIsString($lastname->get());
		$this->assertEquals('DOE', $lastname->get());
		
		$this->assertIsString($lastname->serialize());
		$this->assertEquals('DOE', $lastname->serialize());
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new Lastname('');
	}
}
