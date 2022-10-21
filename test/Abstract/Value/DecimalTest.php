<?php

declare(strict_types=1);

namespace Test\Abstract\Value;

use Test\Abstract\Fixture\Value\Decimal;

final class DecimalTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $decimal = new Decimal(1234.5678);

        $this->assertIsFloat($decimal->value);
        $this->assertEquals(1234.5678, $decimal->value);
    }
}
