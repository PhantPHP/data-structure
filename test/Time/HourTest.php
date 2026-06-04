<?php

declare(strict_types=1);

namespace Test\Time;

use Phant\DataStructure\Time\Hour;
use Phant\Error\NotCompliant;

final class HourTest extends \PHPUnit\Framework\TestCase
{
    protected Hour $fixture;

    public function setUp(): void
    {
        $this->fixture = new Hour('12:34');
    }

    public function testInterface(): void
    {
        $this->assertEquals('12:34', (string)$this->fixture);
    }

    public function testNotCompliantHour(): void
    {
        $this->expectException(NotCompliant::class);

        new Hour('24:00');
    }

    public function testNotCompliantMinute(): void
    {
        $this->expectException(NotCompliant::class);

        new Hour('00:60');
    }

    public function testIsBefore(): void
    {
        $this->assertTrue((new Hour('12:00'))->isBefore(new Hour('13:00')));
        $this->assertFalse((new Hour('13:00'))->isBefore(new Hour('13:00')));
        $this->assertFalse((new Hour('14:00'))->isBefore(new Hour('13:00')));
    }

    public function testIsAfter(): void
    {
        $this->assertFalse((new Hour('12:00'))->isAfter(new Hour('13:00')));
        $this->assertFalse((new Hour('13:00'))->isAfter(new Hour('13:00')));
        $this->assertTrue((new Hour('14:00'))->isAfter(new Hour('13:00')));
    }

    public function testIsBetween(): void
    {
        $this->assertTrue((new Hour('12:00'))->isBetween(new Hour('11:00'), new Hour('13:00')));

        $this->assertFalse((new Hour('11:00'))->isBetween(new Hour('11:00'), new Hour('13:00')));
        $this->assertFalse((new Hour('13:00'))->isBetween(new Hour('11:00'), new Hour('13:00')));
        $this->assertFalse((new Hour('10:00'))->isBetween(new Hour('11:00'), new Hour('13:00')));
        $this->assertFalse((new Hour('14:00'))->isBetween(new Hour('11:00'), new Hour('13:00')));
    }
}
