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

        $this->assertEquals('1 234,56 €/kg', (string)$price);

        $this->assertIsFloat($price->amount);
        $this->assertEquals(1234.56, $price->amount);

        $this->assertIsObject($price->currency);
        $this->assertEquals(Currency::EUR, $price->currency);

        $this->assertIsString($price->unit);
        $this->assertEquals('kg', (string)$price->unit);
    }
}
