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
		
		$this->assertIsFloat($gpsCoordinates->getLatitude());
		$this->assertEquals(53.3284723, $gpsCoordinates->getLatitude());
		
		$this->assertIsFloat($gpsCoordinates->getLongitude());
		$this->assertEquals(-2.2117116, $gpsCoordinates->getLongitude());
			
		$serialized = $gpsCoordinates->serialize();
		
		$this->assertIsArray($serialized);
		$this->assertEquals([
				'latitude'	=> 53.3284723,
				'longitude'	=> -2.2117116,
			], $serialized);
		
		$unserialized = GpsCoordinates::unserialize($serialized);
		
		$this->assertEquals($gpsCoordinates, $unserialized);
	}
	
	public function testCreateFromLambert93(): void
	{
		$gpsCoordinates = GpsCoordinates::createFromLambert93(350772.53, 7372163.87);
		
		$this->assertEquals(53.3284723, $gpsCoordinates->getLatitude());
		$this->assertEquals(-2.2117116, $gpsCoordinates->getLongitude());
	}
	
	public function testCreateFromUtm(): void
	{
		$gpsCoordinates = GpsCoordinates::createFromUtm(153037.74, 5921483.19, 31);
		
		$this->assertEquals(53.3284723, $gpsCoordinates->getLatitude());
		$this->assertEquals(-2.2117116, $gpsCoordinates->getLongitude());
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new GpsCoordinates(180, 360);
	}
	
	public function testUnserializeNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		GpsCoordinates::unserialize([ 'foo' => 'bar' ]);
	}
}
