<?php
declare(strict_types=1);

namespace Test\Time;

use Phant\DataStructure\Time\{
	DateTime,
	DateTimeInterval,
};

use Phant\Error\NotCompliant;

final class DateTimeIntervalTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$dateTimeInterval = new DateTimeInterval(
			new DateTime('1954-06-07 12:34:56'),
			new DateTime('1970-01-01 00:00:00')
		);
		
		$this->assertIsObject($dateTimeInterval->getFrom());
		$this->assertEquals('1954-06-07 12:34:56', (string)$dateTimeInterval->getFrom());
		
		$this->assertIsObject($dateTimeInterval->getTo());
		$this->assertEquals('1970-01-01 00:00:00', (string)$dateTimeInterval->getTo());
		
		$this->assertIsObject($dateTimeInterval->getDuration());
		$this->assertEquals('15 years, 6 months, 28 days, 23 h, 25 min, 4 s', (string)$dateTimeInterval->getDuration());
		
		$this->assertIsArray($dateTimeInterval->serialize());
		$this->assertEquals([
				'from'	=> '1954-06-07 12:34:56',
				'to'	=> '1970-01-01 00:00:00',
				'duration'	=> [
					'value' => 491311504,
					'label' => '15 years, 6 months, 28 days, 23 h, 25 min, 4 s',
				],
			], $dateTimeInterval->serialize());
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new DateTimeInterval(null, null);
	}
}
