<?php

declare(strict_types=1);

namespace Test\Time;

use Phant\DataStructure\Time\Duration;

use Phant\Error\NotCompliant;

final class DurationTest extends \PHPUnit\Framework\TestCase
{
    protected int $time;
    protected Duration $fixture;

    public function setUp(): void
    {
        $this->time = Duration::YEAR + Duration::MONTH + Duration::DAY + Duration::HOUR + Duration::MINUTE + 1;
        $this->fixture = new Duration($this->time);
    }

    public function testInterface(): void
    {
        $this->assertEquals('1 year, 1 month, 1 day, 1 h, 1 min, 1 s', (string)$this->fixture);

        $this->assertIsInt($this->fixture->value);
        $this->assertEquals($this->time, $this->fixture->value);

        $this->assertIsString($this->fixture->label);
        $this->assertEquals('1 year, 1 month, 1 day, 1 h, 1 min, 1 s', $this->fixture->label);
    }

    public function testInMinutes(): void
    {
        $value = $this->fixture->inMinutes();

        $this->assertIsInt($value);
        $this->assertEquals(570901, $value);
    }

    public function testInHours(): void
    {
        $value = $this->fixture->inHours();

        $this->assertIsInt($value);
        $this->assertEquals(9515, $value);
    }

    public function testInDays(): void
    {
        $value = $this->fixture->inDays();

        $this->assertIsInt($value);
        $this->assertEquals(396, $value);
    }

    public function testInMonths(): void
    {
        $value = $this->fixture->inMonths();

        $this->assertIsInt($value);
        $this->assertEquals(13, $value);
    }

    public function testInYears(): void
    {
        $value = $this->fixture->inYears();

        $this->assertIsInt($value);
        $this->assertEquals(1, $value);
    }
}
