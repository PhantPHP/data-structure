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

    public function testGetLabel(): void
    {
        $this->assertIsString(Currency::AUD->getLabel());
        $this->assertIsString(Currency::CAD->getLabel());
        $this->assertIsString(Currency::CHF->getLabel());
        $this->assertIsString(Currency::DKK->getLabel());
        $this->assertIsString(Currency::EUR->getLabel());
        $this->assertIsString(Currency::GBP->getLabel());
        $this->assertIsString(Currency::SEK->getLabel());
        $this->assertIsString(Currency::USD->getLabel());
        $this->assertIsString(Currency::ZSD->getLabel());
    }
}
