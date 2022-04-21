<?php
declare(strict_types=1);

namespace Test\Number;

use Phant\DataStructure\Number\Rate;

final class RateTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$rate = new Rate(1234.4567);
		
		$this->assertEquals('1234.4567 %', (string)$rate);
		
		$this->assertIsFloat($rate->get());
		$this->assertEquals(1234.4567, $rate->get());
		
		$this->assertIsFloat($rate->serialize());
		$this->assertEquals(1234.4567, $rate->serialize());
	}
}
