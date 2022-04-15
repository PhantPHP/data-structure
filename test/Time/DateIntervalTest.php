<?php
declare(strict_types=1);

namespace Test\Time;

use Phant\DataStructure\Time\{
	Date,
	DateInterval,
};

use Phant\Error\NotCompliant;

final class DateIntervalTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$dateInterval = new DateInterval(
			new Date('1954-06-07'),
			new Date('1970-01-01')
		);
		
		$this->assertIsObject($dateInterval->getFrom());
		$this->assertEquals('1954-06-07', (string)$dateInterval->getFrom());
		
		$this->assertIsObject($dateInterval->getTo());
		$this->assertEquals('1970-01-01', (string)$dateInterval->getTo());
		
		$this->assertIsObject($dateInterval->getDuration());
		$this->assertEquals('15 years, 6 months, 29 days, 12 h', (string)$dateInterval->getDuration());
		
		$this->assertIsArray($dateInterval->serialize());
		$this->assertEquals([
				'from'	=> '1954-06-07',
				'to'	=> '1970-01-01',
				'duration'	=> [
					'value' => 491356800,
					'label' => '15 years, 6 months, 29 days, 12 h',
				],
			], $dateInterval->serialize());
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new DateInterval(null, null);
	}
}
