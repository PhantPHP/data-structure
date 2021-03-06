<?php
declare(strict_types=1);

namespace Test\Money;

use Phant\DataStructure\Money\{
	Currency,
	Price,
};

use Phant\Error\NotCompliant;

final class PriceTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$price = new Price(1234.56, Currency::EUR, 'kg');
		
		$this->assertEquals('1 234,56 €/kg', (string)$price);
		
		$this->assertIsFloat($price->get());
		$this->assertEquals(1234.56, $price->get());
		
		$this->assertIsObject($price->getCurrency());
		$this->assertEquals('€', (string)$price->getCurrency());
		
		$this->assertIsString($price->getUnit());
		$this->assertEquals('kg', (string)$price->getUnit());
			
		$serialized = $price->serialize();
		
		$this->assertIsArray($serialized);
		$this->assertEquals([
			'price' => 1234.56,
			'currency' => [
				'code' => 'EUR',
				'sign' => '€',
			],
			'unit' => 'kg',
		], $serialized);
		
		$unserialized = Price::unserialize($serialized);
		
		$this->assertEquals($price, $unserialized);
	}
	
	public function testUnserializeNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		Price::unserialize([ 'foo' => 'bar' ]);
	}
}
