<?php
declare(strict_types=1);

namespace Test\Time;

use Phant\DataStructure\Time\Date;

use Phant\Error\NotCompliant;

final class DateTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$date = new Date('1954-06-07', 'Y-m-d');
		
		$this->assertEquals('1954-06-07', (string)$date);
		
		$this->assertIsString($date->get());
		$this->assertEquals('1954-06-07', $date->get());
		
		$this->assertIsInt($date->getTime());
		$this->assertEquals(-491356800, $date->getTime());
	}
	
	public function testBuild(): void
	{
		$date = new Date('now');
		
		$this->assertIsObject($date);
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new Date('wingardium leviosa');
	}
}
