<?php

declare(strict_types=1);

namespace Test\Money;

use Phant\DataStructure\Money\Currency;
use Phant\DataStructure\Money\Price;

final class PriceTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $price = new Price(1234.56, Currency::EUR, 'kg');

        $this->assertEquals('1 234,56 €/kg', (string) $price);

        $this->assertIsFloat($price->amount);
        $this->assertEquals(1234.56, $price->amount);

        $this->assertIsObject($price->currency);
        $this->assertEquals(Currency::EUR, $price->currency);

        $this->assertIsString($price->unit);
        $this->assertEquals('kg', (string) $price->unit);
    }

    public function testAdd(): void
    {
        $price1 = new Price(100, Currency::EUR, 'Mwh');
        $price2 = new Price(50, Currency::EUR, 'Mwh');

        $result = $price1->add($price2);

        $this->assertEquals(150, $result->amount);
        $this->assertEquals(Currency::EUR, $result->currency);
        $this->assertEquals('Mwh', $result->unit);
    }

    public function testsubtract(): void
    {
        $price1 = new Price(100, Currency::EUR, 'Mwh');
        $price2 = new Price(50, Currency::EUR, 'Mwh');

        $result = $price1->subtract($price2);

        $this->assertEquals(50, $result->amount);
        $this->assertEquals(Currency::EUR, $result->currency);
        $this->assertEquals('Mwh', $result->unit);
    }

    public function testMultiply(): void
    {
        $price = new Price(100, Currency::EUR, 'Mwh');

        $result = $price->multiply(2);

        $this->assertEquals(200, $result->amount);
        $this->assertEquals(Currency::EUR, $result->currency);
        $this->assertEquals('Mwh', $result->unit);
    }

    public function testApplyPercentage(): void
    {
        $price = new Price(100, Currency::EUR, 'Mwh');

        $result = $price->applyPercentage(10);
        $this->assertEquals(110.00, $result->amount);
        $this->assertEquals(Currency::EUR, $result->currency);
        $this->assertEquals('Mwh', $result->unit);

        $result = $price->applyPercentage(-10);
        $this->assertEquals(90.00, $result->amount);
        $this->assertEquals(Currency::EUR, $result->currency);
        $this->assertEquals('Mwh', $result->unit);
    }
}
