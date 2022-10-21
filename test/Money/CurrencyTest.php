<?php

declare(strict_types=1);

namespace Test\Money;

use Phant\DataStructure\Money\Currency;

final class CurrencyTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $currency = Currency::EUR;

        $this->assertIsString($currency->value);
        $this->assertEquals('EUR', $currency->value);

        $this->assertIsString($currency->getLabel());
        $this->assertEquals('€', $currency->getLabel());
    }
}
