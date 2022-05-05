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
		
		$serialized = $dateTime->serialize();
		
		$this->assertIsString($serialized);
		$this->assertEquals('1954-06-07 12:34:56', $serialized);
		
		$unserialized = DateTime::unserialize($serialized);
		
		$this->assertEquals($dateTime, $unserialized);
	}
	
	public function testBuild(): void
	{
		$dateTime = new DateTime('now');
		
		$this->assertIsObject($dateTime);
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new DateTime('wingardium leviosa');
	}
}
