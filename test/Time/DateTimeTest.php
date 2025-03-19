<?php

declare(strict_types=1);

namespace Test\Time;

use Phant\DataStructure\Time\DateTime;
use Phant\Error\NotCompliant;

final class DateTimeTest extends \PHPUnit\Framework\TestCase
{
    protected DateTime $fixture;

    public function setUp(): void
    {
        $this->fixture = new DateTime('1954-06-07 12:34:56', 'Y-m-d H:i:s');
    }

    public function testInterface(): void
    {
        $this->assertEquals('1954-06-07 12:34:56', (string)$this->fixture);

        $this->assertIsString($this->fixture->date);
        $this->assertEquals('1954-06-07 12:34:56', $this->fixture->date);

        $this->assertIsInt($this->fixture->time);
        $this->assertEquals(-491311504, $this->fixture->time);

        $this->assertIsString($this->fixture->getUtc());
        $this->assertEquals('1954-06-07T12:34:56Z', $this->fixture->getUtc());
    }

    public function testBuild(): void
    {
        $dateTime = new DateTime('now');

        $this->assertIsObject($dateTime);
    }

    public function testBuildFromTime(): void
    {
        $dateTime = new DateTime(-491311504);

        $this->assertIsObject($dateTime);

        $this->assertIsString($dateTime->date);
        $this->assertEquals('1954-06-07 12:34:56', $dateTime->date);
    }

    public function testNotCompliant(): void
    {
        $this->expectException(NotCompliant::class);

        new DateTime('wingardium leviosa');
    }

    public function testIsBefore(): void
    {
        // Before
        $result = $this->fixture->isBefore('1954-06-07 12:34:57');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        // Current
        $result = $this->fixture->isBefore('1954-06-07 12:34:56');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // After
        $result = $this->fixture->isBefore('1954-06-07 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);
    }

    public function testIsCurrent(): void
    {
        // Before
        $result = $this->fixture->isCurrent('1954-06-07 12:34:57');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // Current
        $result = $this->fixture->isCurrent('1954-06-07 12:34:56');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        // After
        $result = $this->fixture->isCurrent('1954-06-07 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);
    }

    public function testIsAfter(): void
    {
        // Before
        $result = $this->fixture->isAfter('1954-06-07 12:34:56');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // Current
        $result = $this->fixture->isAfter('1954-06-07 12:34:56');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // After
        $result = $this->fixture->isAfter('1954-06-07 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);
    }
}
