<?php

declare(strict_types=1);

namespace Test\Abstract\Value;

use Test\Abstract\Fixture\Value\Integer;

final class IntegerTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $integer = new Integer(1234);

        $this->assertIsInt($integer->value);
        $this->assertEquals(1234, $integer->value);
    }
}
