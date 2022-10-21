<?php

declare(strict_types=1);

namespace Test\Geography;

use Phant\DataStructure\Geography\GpsCoordinates;

use Phant\Error\NotCompliant;

final class GpsCoordinatesTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $gpsCoordinates = new GpsCoordinates(53.3284723, -2.2117116);

        $this->assertEquals('53.3284723;-2.2117116', (string)$gpsCoordinates);

        $this->assertIsFloat($gpsCoordinates->latitude);
        $this->assertEquals(53.3284723, $gpsCoordinates->latitude);

        $this->assertIsFloat($gpsCoordinates->longitude);
        $this->assertEquals(-2.2117116, $gpsCoordinates->longitude);
    }

    public function testCreateFromLambert93(): void
    {
        $gpsCoordinates = GpsCoordinates::makeFromLambert93(350772.53, 7372163.87);

        $this->assertEquals(53.3284723, $gpsCoordinates->latitude);
        $this->assertEquals(-2.2117116, $gpsCoordinates->longitude);
    }

    public function testCreateFromUtm(): void
    {
        $gpsCoordinates = GpsCoordinates::makeFromUtm(153037.74, 5921483.19, 31);

        $this->assertEquals(53.3284723, $gpsCoordinates->latitude);
        $this->assertEquals(-2.2117116, $gpsCoordinates->longitude);
    }

    public function testNotCompliant(): void
    {
        $this->expectException(NotCompliant::class);

        new GpsCoordinates(180, 360);
    }
}
