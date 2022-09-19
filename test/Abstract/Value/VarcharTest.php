<?php
declare(strict_types=1);

namespace Test\Abstract\Value;

use Test\Abstract\Fixture\Value\Varchar;

use Phant\Error\NotCompliant;

final class VarcharTest extends \PHPUnit\Framework\TestCase
{	
	public function testInterface(): void
	{
		$varchar = new Varchar('Hello world!');
		
		$this->assertEquals('Hello world!', (string)$varchar->get());
		
		$this->assertIsString($varchar->get());
		$this->assertEquals('Hello world!', $varchar->get());
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new Varchar('');
	}
}
