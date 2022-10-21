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

        $this->assertIsString($date->date);
        $this->assertEquals('1954-06-07', $date->date);

        $this->assertIsInt($date->time);
        $this->assertEquals(-491356800, $date->time);
    }

    public function testBuild(): void
    {
        $date = new Date('now');

        $this->assertIsObject($date);
    }

    public function testBuildFromTime(): void
    {
        $date = new Date(-491356800);

        $this->assertIsObject($date);

        $this->assertIsString($date->date);
        $this->assertEquals('1954-06-07', $date->date);
    }

    public function testNotCompliant(): void
    {
        $this->expectException(NotCompliant::class);

        new Date('wingardium leviosa');
    }
}
