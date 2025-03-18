<?php

declare(strict_types=1);

namespace Test\Id;

use Phant\DataStructure\Color\Hexadecimal;
use Phant\Error\NotCompliant;

final class HexadecimalTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $hex3 = new Hexadecimal('#c00');

        $this->assertEquals('#c00', (string)$hex3);
        $this->assertIsString($hex3->value);
        $this->assertEquals('#c00', $hex3->value);

        $hex6 = new Hexadecimal('#cc0000');

        $this->assertEquals('#cc0000', (string)$hex6);
        $this->assertIsString($hex6->value);
        $this->assertEquals('#cc0000', $hex6->value);

        $hex8 = new Hexadecimal('#cc000088');

        $this->assertEquals('#cc000088', (string)$hex8);
        $this->assertIsString($hex8->value);
        $this->assertEquals('#cc000088', $hex8->value);
    }

    public function testNotCompliant(): void
    {
        $this->expectException(NotCompliant::class);

        new Hexadecimal('#cc000');
    }
}
