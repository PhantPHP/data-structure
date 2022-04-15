<?php
declare(strict_types=1);

namespace Test\Abstract\Value;

use Test\Abstract\Fixture\Value\Boolean;

final class BooleanTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$boolean = new Boolean(true);
		
		$this->assertEquals('1', (string)$boolean->get());
		
		$this->assertIsBool($boolean->get());
		$this->assertEquals(true, $boolean->get());
		
		$this->assertIsBool($boolean->serialize());
		$this->assertEquals(true, $boolean->serialize());
	}
}
