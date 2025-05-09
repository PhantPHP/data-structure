<?php

declare(strict_types=1);

namespace Test\Geography\Fr;

use Phant\DataStructure\Geography\Fr\NumeroDepartement;
use Phant\Error\NotCompliant;

final class NumeroDepartementTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $numeroDepartement = new NumeroDepartement('1');

        $this->assertEquals('01', (string)$numeroDepartement);

        $this->assertIsString($numeroDepartement->value);
        $this->assertEquals('01', $numeroDepartement->value);
    }

    public function testNotCompliant(): void
    {
        $this->expectException(NotCompliant::class);

        new NumeroDepartement('2C');
    }
}
