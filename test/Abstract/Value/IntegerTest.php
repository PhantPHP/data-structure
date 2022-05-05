<?php
declare(strict_types=1);

namespace Test\Abstract\Value;

use Test\Abstract\Fixture\Value\Integer;

final class IntegerTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$integer = new Integer(1234);
		
		$this->assertEquals('1234', (string)$integer->get());
		
		$this->assertIsInt($integer->get());
		$this->assertEquals(1234, $integer->get());
		
		$this->assertIsInt($integer->serialize());
		$this->assertEquals(1234, $integer->serialize());
		
		$serialized = $integer->serialize();
		
		$this->assertIsInt($serialized);
		$this->assertEquals(1234, $serialized);
		
		$unserialized = Integer::unserialize($serialized);
		
		$this->assertEquals($integer, $unserialized);
	}
}
