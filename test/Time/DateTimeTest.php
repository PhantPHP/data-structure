<?php
declare(strict_types=1);

namespace Test\Time;

use Phant\DataStructure\Time\DateTime;

use Phant\Error\NotCompliant;

final class DateTimeTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$dateTime = new DateTime('1954-06-07 12:34:56', 'Y-m-d H:i:s');
		
		$this->assertEquals('1954-06-07 12:34:56', (string)$dateTime);
		
		$this->assertIsString($dateTime->get());
		$this->assertEquals('1954-06-07 12:34:56', $dateTime->get());
		
		$this->assertIsInt($dateTime->getTime());
		$this->assertEquals(-491311504, $dateTime->getTime());
		
		$this->assertIsString($dateTime->getUtc());
		$this->assertEquals('1954-06-07T12:34:56Z', $dateTime->getUtc());
	}
	
	public function testBuild(): void
	{
		$dateTime = new DateTime('now');
		
		$this->assertIsObject($dateTime);
	}
	
	public function testBuildFromTime(): void
	{
		$dateTime = new DateTime(-491311504);
		
		$this->assertIsObject($dateTime);
		
		$this->assertIsString($dateTime->get());
		$this->assertEquals('1954-06-07 12:34:56', $dateTime->get());
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new DateTime('wingardium leviosa');
	}
}
