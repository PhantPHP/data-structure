<?php
declare(strict_types=1);

namespace Test\Money;

use Phant\DataStructure\Money\Currency;

use Phant\Error\NotCompliant;

final class CurrencyTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$currency = new Currency(Currency::EUR);
		
		$this->assertEquals('€', (string)$currency);
		
		$this->assertIsString($currency->getValue());
		$this->assertEquals('EUR', $currency->getValue());
		
		$this->assertIsString($currency->getLabel());
		$this->assertEquals('€', $currency->getLabel());
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new Currency('Franc');
	}
}
