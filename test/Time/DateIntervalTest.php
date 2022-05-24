<?php
declare(strict_types=1);

namespace Test\Time;

use Phant\DataStructure\Time\DateInterval;

use Phant\Error\NotCompliant;

final class DateIntervalTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$dateInterval = new DateInterval(
			'1954-06-07',
			'1970-01-01'
		);
		
		$this->assertIsObject($dateInterval->getFrom());
		$this->assertEquals('1954-06-07', (string)$dateInterval->getFrom());
		
		$this->assertIsObject($dateInterval->getTo());
		$this->assertEquals('1970-01-01', (string)$dateInterval->getTo());
		
		$this->assertIsObject($dateInterval->getDuration());
		$this->assertEquals('15 years, 6 months, 29 days, 12 h', (string)$dateInterval->getDuration());
		
		$serialized = $dateInterval->serialize();
		
		$this->assertIsArray($serialized);
		$this->assertEquals([
				'from'	=> '1954-06-07',
				'to'	=> '1970-01-01',
				'duration'	=> [
					'value' => 491356800,
					'label' => '15 years, 6 months, 29 days, 12 h',
				],
			], $serialized);
		
		$unserialized = DateInterval::unserialize($serialized);
		
		$this->assertEquals($dateInterval, $unserialized);
	}
	
	public function testIsDuring(): void
	{
		$dateInterval = new DateInterval(
			'1954-06-07',
			'1970-01-01'
		);
		
		// Before
		$result = $dateInterval->isDuring('1954-05-6');
		$this->assertIsBool($result);
		$this->assertEquals(false, $result);
		
		// After
		$result = $dateInterval->isDuring('1970-01-03');
		$this->assertIsBool($result);
		$this->assertEquals(false, $result);
		
		// During
		$result = $dateInterval->isDuring('1960-02-23');
		$this->assertIsBool($result);
		$this->assertEquals(true, $result);
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new DateInterval(null, null);
	}
	
	public function testUnserializeNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		DateInterval::unserialize([ 'foo' => 'bar' ]);
	}
}
