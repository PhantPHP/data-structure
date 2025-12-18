<?php

declare(strict_types=1);

namespace Test\Company;

use Phant\DataStructure\Company\Euid;
use Phant\Error\NotCompliant;

final class EuidTest extends \PHPUnit\Framework\TestCase
{
    public function testInterfaceWithValidFrenchEuid(): void
    {
        $euid = new Euid('FR001.512747395');

        $this->assertEquals('FR001.512747395', (string)$euid);

        $this->assertIsString($euid->value);
        $this->assertEquals('FR001.512747395', $euid->value);

        $this->assertIsString($euid->getFormatted());
        $this->assertEquals('FR 001 . 512 747 395', $euid->getFormatted(false));
    }

    public function testFormattedWithoutNonBreakingSpace(): void
    {
        $euid = new Euid('FR001.512747395');

        $formatted = $euid->getFormatted(false);
        $this->assertEquals('FR 001 . 512 747 395', $formatted);
        $this->assertStringNotContainsString("\xC2\xA0", $formatted);
    }

    public function testFormattedWithNonBreakingSpace(): void
    {
        $euid = new Euid('FR001.512747395');

        $formatted = $euid->getFormatted(true);
        $this->assertEquals("FR\xC2\xA0001\xC2\xA0.\xC2\xA0512\xC2\xA0747\xC2\xA0395", $formatted);
    }

    public function testExtractParts(): void
    {
        $euid = new Euid('FR001.512747395');
        $parts = $euid->extractParts();

        $this->assertEquals('FR', $parts->countryCode);
        $this->assertEquals('001', $parts->registryCode);
        $this->assertEquals('.', $parts->separator);
        $this->assertEquals('512747395', $parts->companyCode);
    }

    public function testConstructorWithNonComplianceCheck(): void
    {
        // Test avec un SIREN valide français
        $euid = new Euid('FR001.512747395', true);
        $this->assertEquals('FR001.512747395', (string)$euid);

        // Test sans vérification de compliance
        $euid = new Euid('FR001.123456789', false);
        $this->assertEquals('FR001.123456789', (string)$euid);
    }

    public function testInvalidCountryCode(): void
    {
        $this->expectException(NotCompliant::class);
        $this->expectExceptionMessage('Not compliant country code');

        new Euid('XX001.512747395');
    }

    public function testInvalidFrenchSiren(): void
    {
        $this->expectException(NotCompliant::class);

        // SIREN invalide avec vérification activée
        new Euid('FR001.123456789', true);
    }

    public function testValidEuropeanCountryCodes(): void
    {
        $validCountryCodes = ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK'];

        foreach ($validCountryCodes as $countryCode) {
            $euid = new Euid("{$countryCode}001.123456789", false);
            $this->assertEquals("{$countryCode}001.123456789", (string)$euid);
        }
    }

    public function testCompanyCodeFormatting(): void
    {
        // Test avec différentes longueurs de codes entreprise
        $testCases = [
            ['FR001.12345', '12 345'], // 5 digits
            ['FR001.123456', '123 456'], // 6 digits
            ['FR001.1234567', '123 4567'], // 7 digits
            ['FR001.12345678', '12 345 678'], // 8 digits
            ['FR001.123456789', '123 456 789'], // 9 digits
        ];

        foreach ($testCases as [$input, $expectedFormatting]) {
            $euid = new Euid($input, false);
            $formatted = $euid->getFormatted(false);
            $this->assertStringContainsString($expectedFormatting, $formatted);
        }
    }

    public function testPatternConformity(): void
    {
        $euid = new Euid('FR001.512747395');

        $this->assertMatchesRegularExpression(Euid::PATTERN, $euid->value);
    }

    public function testStringRepresentation(): void
    {
        $euid = new Euid('DE002.987654321', false);

        // Test du cast en string
        $this->assertEquals('DE002.987654321', (string)$euid);

        // Test de la propriété value
        $this->assertEquals('DE002.987654321', $euid->value);
    }

    public function testWithDifferentRegistryCodes(): void
    {
        $euid1 = new Euid('FR001.512747395');
        $euid2 = new Euid('FR999.512747395');

        $parts1 = $euid1->extractParts();
        $parts2 = $euid2->extractParts();

        $this->assertEquals('001', $parts1->registryCode);
        $this->assertEquals('999', $parts2->registryCode);
    }
}
