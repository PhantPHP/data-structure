<?php
declare(strict_types=1);

namespace Test\Person;

use Phant\DataStructure\Person\Firstname;

use Phant\Error\NotCompliant;

final class FirstnameTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$firstname = new Firstname(' john ');
		
		$this->assertEquals('John', (string)$firstname);
		
		$this->assertIsString($firstname->get());
		$this->assertEquals('John', $firstname->get());
			
		$serialized = $firstname->serialize();
		
		$this->assertIsString($serialized);
		$this->assertEquals('John', $serialized);
		
		$unserialized = Firstname::unserialize($serialized);
		
		$this->assertEquals($firstname, $unserialized);
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new Firstname('');
	}
}
