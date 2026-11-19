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

        $this->assertInstanceOf(\DateTimeImmutable::class, $this->fixture);
    }

    public function testBuild(): void
    {
        $date = new Date('now');

        $this->assertIsObject($date);

        $expectedDate = (new \DateTimeImmutable('2028-12-31'))->getTimestamp();
        $expectedDateTime = (new \DateTimeImmutable('2028-12-31 13:14:15'))->getTimestamp();
        $expectedOffsetDateTime = (new \DateTimeImmutable('2028-12-31T13:14:15+02:00'))->getTimestamp();

        $dates = [
            ['1861833600', 1861833600],
            ['2028-12-31', $expectedDate],
            ['2028-12-31 13:14:15', $expectedDateTime],
            ['2028-12-31T13:14:15+02:00', $expectedOffsetDateTime],
            ['31/12/2028', $expectedDate],
            ['31-12-2028', $expectedDate],
            ['31.12.2028', $expectedDate],
            ['31/12/2028 13:14:15', $expectedDateTime],
            ['31/12/28', $expectedDate],
            ['12/31/2028', $expectedDate],
            ['12-31-2028', $expectedDate],
            ['31 Dec 2028', $expectedDate],
            ['31 December 2028', $expectedDate],
            [' December 31, 2028 ', $expectedDate],
            ['31/12/2028 13:14', (new \DateTimeImmutable('2028-12-31 13:14:00'))->getTimestamp()],
        ];

        foreach ($dates as [$dateString, $expectedTime]) {
            $this->assertSame($expectedTime, Date::getTimeFromString($dateString), $dateString);
        }

        foreach (['', '   ', 'not a date'] as $dateString) {
            $this->assertNull(Date::getTimeFromString($dateString), $dateString);
        }
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
