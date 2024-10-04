<?php

declare(strict_types=1);

namespace Test\Geography\Fr;

use Phant\DataStructure\Geography\Fr\CodePostal;

use Phant\Error\NotCompliant;

final class CodePostalTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $codePostal = new CodePostal('69001');

        $this->assertEquals('69001', (string)$codePostal);

        $this->assertIsString($codePostal->value);
        $this->assertEquals('69001', $codePostal->value);
    }

    public function testNotCompliant(): void
    {
        $this->expectException(NotCompliant::class);

        new CodePostal('690I');
    }

    public function testGetNumeroDepartement(): void
    {
        $codePostal = new CodePostal('69001');
        $this->assertIsObject($codePostal->getNumeroDepartement());
        $this->assertEquals('69', (string)$codePostal->getNumeroDepartement());

        $codePostal = new CodePostal('20169');
        $this->assertIsObject($codePostal->getNumeroDepartement());
        $this->assertEquals('2A', (string)$codePostal->getNumeroDepartement());

        $codePostal = new CodePostal('20290');
        $this->assertIsObject($codePostal->getNumeroDepartement());
        $this->assertEquals('2B', (string)$codePostal->getNumeroDepartement());

        $codePostal = new CodePostal('97400');
        $this->assertIsObject($codePostal->getNumeroDepartement());
        $this->assertEquals('974', (string)$codePostal->getNumeroDepartement());

        $codePostal = new CodePostal('98735');
        $this->assertIsObject($codePostal->getNumeroDepartement());
        $this->assertEquals('987', (string)$codePostal->getNumeroDepartement());
    }
}
