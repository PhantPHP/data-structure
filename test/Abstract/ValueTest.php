<?php
declare(strict_types=1);

namespace Test\Abstract;

use Test\Abstract\Fixture\Value;

final class ValueTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$value = new Value('foo bar');
		
		$this->assertEquals('foo bar', (string)$value->get());
		
		$this->assertIsString($value->get());
		$this->assertEquals('foo bar', $value->get());
		
		$serialized = $value->serialize();
		
		$this->assertIsString($serialized);
		$this->assertEquals('foo bar', $serialized);
		
		$unserialized = Value::unserialize($serialized);
		
		$this->assertEquals($value, $unserialized);
	}
}
