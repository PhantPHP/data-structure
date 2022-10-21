<?php

declare(strict_types=1);

namespace Test\Company\Fr;

use Phant\DataStructure\Company\Fr\Siren;

use Phant\Error\NotCompliant;

final class SirenTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $siren = new Siren('512747395');

        $this->assertEquals('512747395', (string)$siren);

        $this->assertIsString($siren->value);
        $this->assertEquals('512747395', $siren->value);

        $this->assertIsString($siren->getFormatted());
        $this->assertEquals('512 747 395', $siren->getFormatted());
    }

    public function testNotCompliant(): void
    {
        $this->expectException(NotCompliant::class);

        new Siren('123456789');
    }
}
