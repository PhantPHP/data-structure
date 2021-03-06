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
			
		$serialized = $lastname->serialize();
		
		$this->assertIsString($serialized);
		$this->assertEquals('DOE', $serialized);
		
		$unserialized = Lastname::unserialize($serialized);
		
		$this->assertEquals($lastname, $unserialized);
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new Lastname('');
	}
}
