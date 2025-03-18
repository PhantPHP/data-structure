<?php

declare(strict_types=1);

namespace Test\Time;

use Phant\DataStructure\Time\Date;
use Phant\Error\NotCompliant;

final class DateTest extends \PHPUnit\Framework\TestCase
{
    protected Date $fixture;

    public function setUp(): void
    {
        $this->fixture = new Date('1954-06-07');
    }

    public function testInterface(): void
    {
        $this->assertEquals('1954-06-07', (string)$this->fixture);

        $this->assertIsString($this->fixture->date);
        $this->assertEquals('1954-06-07', $this->fixture->date);

        $this->assertIsInt($this->fixture->time);
        $this->assertEquals(-491356800, $this->fixture->time);
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

    public function testIsBefore(): void
    {
        // Before
        $result = $this->fixture->isBefore('1954-06-08');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        // Current
        $result = $this->fixture->isBefore('1954-06-07');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // After
        $result = $this->fixture->isBefore('1954-06-06');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);
    }

    public function testIsCurrent(): void
    {
        // Before
        $result = $this->fixture->isCurrent('1954-06-08');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // Current
        $result = $this->fixture->isCurrent('1954-06-07');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        // After
        $result = $this->fixture->isCurrent('1954-06-06');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);
    }

    public function testIsAfter(): void
    {
        // Before
        $result = $this->fixture->isAfter('1954-06-08');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // Current
        $result = $this->fixture->isAfter('1954-06-07');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // After
        $result = $this->fixture->isAfter('1954-06-06');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);
    }
}
