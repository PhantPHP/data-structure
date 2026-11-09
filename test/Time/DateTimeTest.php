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

        $expectedDate = (new \DateTimeImmutable('2028-12-31'))->getTimestamp();
        $expectedDateTime = (new \DateTimeImmutable('2028-12-31 13:14:15'))->getTimestamp();
        $expectedOffsetDateTime = (new \DateTimeImmutable('2028-12-31T13:14:15+02:00'))->getTimestamp();

        $dateTimes = [
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

        foreach ($dateTimes as [$dateString, $expectedTime]) {
            $parsedDateTime = new DateTime($dateString);
            $this->assertSame($expectedTime, $parsedDateTime->time, $dateString);
        }
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
