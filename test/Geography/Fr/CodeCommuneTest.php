<?php

declare(strict_types=1);

namespace Test\Geography\Fr;

use Phant\DataStructure\Geography\Fr\CodeCommune;

use Phant\Error\NotCompliant;

final class CodeCommuneTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $codeCommune = new CodeCommune('97421');

        $this->assertEquals('97421', (string)$codeCommune);

        $this->assertIsString($codeCommune->value);
        $this->assertEquals('97421', $codeCommune->value);

        $this->assertIsObject($codeCommune->getNumeroDepartement());
        $this->assertEquals('974', (string)$codeCommune->getNumeroDepartement());
    }

    public function testNotCompliant(): void
    {
        $this->expectException(NotCompliant::class);

        new CodeCommune('690I');
    }
}
