<?php
declare(strict_types=1);

namespace Test\Company;

use Phant\DataStructure\Company\Name;

use Phant\Error\NotCompliant;

final class NameTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$name = new Name('Acme');
		
		$this->assertEquals('Acme', (string)$name);
		
		$this->assertIsString($name->get());
		$this->assertEquals('Acme', $name->get());
		
		$serialized = $name->serialize();
		
		$this->assertIsString($serialized);
		$this->assertEquals('Acme', $serialized);
		
		$unserialized = Name::unserialize($serialized);
		
		$this->assertEquals($name, $unserialized);
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new Name('');
	}
}
