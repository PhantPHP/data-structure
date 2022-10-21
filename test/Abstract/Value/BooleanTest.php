<?php

declare(strict_types=1);

namespace Test\Abstract\Value;

use Test\Abstract\Fixture\Value\Boolean;

final class BooleanTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $boolean = new Boolean(true);

        $this->assertIsBool($boolean->value);
        $this->assertEquals(true, $boolean->value);
    }
}
