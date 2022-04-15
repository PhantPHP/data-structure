<?php
declare(strict_types=1);

namespace Test\Money;

use Phant\DataStructure\Money\{
	Currency,
	Price,
};

final class PriceTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$price = new Price(1234.56, new Currency(Currency::EUR));
		
		$this->assertEquals('1234.56 €', (string)$price);
		
		$this->assertIsFloat($price->get());
		$this->assertEquals(1234.56, $price->get());
		
		$this->assertIsObject($price->getCurrency());
		$this->assertEquals('€', (string)$price->getCurrency());
		
		$this->assertIsArray($price->serialize());
		$this->assertEquals([
			'price' => 1234.56,
			'currency' => [
				'value' => 'EUR',
				'label' => '€',
			],
		], $price->serialize());
	}
}
