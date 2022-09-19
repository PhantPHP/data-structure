<?php
declare(strict_types=1);

namespace Test\Time;

use Phant\DataStructure\Time\DateTimeInterval;

use Phant\Error\NotCompliant;

final class DateTimeIntervalTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$dateTimeInterval = new DateTimeInterval(
			'1954-06-07 12:34:56',
			'1970-01-01 00:00:00'
		);
		
		$this->assertIsObject($dateTimeInterval->getFrom());
		$this->assertEquals('1954-06-07 12:34:56', (string)$dateTimeInterval->getFrom());
		
		$this->assertIsObject($dateTimeInterval->getTo());
		$this->assertEquals('1970-01-01 00:00:00', (string)$dateTimeInterval->getTo());
		
		$this->assertIsObject($dateTimeInterval->getDuration());
		$this->assertEquals('15 years, 6 months, 28 days, 23 h, 25 min, 4 s', (string)$dateTimeInterval->getDuration());
	}
	
	public function testIsDuring(): void
	{
		$dateTimeInterval = new DateTimeInterval(
			'1954-06-07 12:34:56',
			'1970-01-01 00:00:00'
		);
		
		// Before
		$result = $dateTimeInterval->isDuring('1954-05-07 12:34:55');
		$this->assertIsBool($result);
		$this->assertEquals(false, $result);
		
		// After
		$result = $dateTimeInterval->isDuring('1970-01-01 00:00:01');
		$this->assertIsBool($result);
		$this->assertEquals(false, $result);
		
		// During
		$result = $dateTimeInterval->isDuring('1960-02-23 12:34:55');
		$this->assertIsBool($result);
		$this->assertEquals(true, $result);
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new DateTimeInterval(null, null);
	}
}
