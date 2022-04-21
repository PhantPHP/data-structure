<?php
declare(strict_types=1);

namespace Test\Company;

use Phant\DataStructure\Company\Name;

final class NameTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$name = new Name('Acme');
		
		$this->assertEquals('Acme', (string)$name);
		
		$this->assertIsString($name->get());
		$this->assertEquals('Acme', $name->get());
		
		$this->assertIsString($name->serialize());
		$this->assertEquals('Acme', $name->serialize());
	}
}
