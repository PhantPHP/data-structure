<?php

declare(strict_types=1);

namespace Test\Time;

use Phant\DataStructure\Time\DateTimeInterval;

use Phant\Error\NotCompliant;

final class DateTimeIntervalTest extends \PHPUnit\Framework\TestCase
{
    protected DateTimeInterval $fixture;
    protected DateTimeInterval $fixtureWithoutFrom;
    protected DateTimeInterval $fixtureWithoutEnd;

    public function setUp(): void
    {
        $this->fixture = DateTimeInterval::make(
            '1954-06-07 12:34:56',
            '1970-01-01 00:00:00'
        );
        $this->fixtureWithoutFrom = DateTimeInterval::make(
            null,
            '1970-01-01 00:00:00'
        );
        $this->fixtureWithoutEnd = DateTimeInterval::make(
            '1954-06-07 12:34:56',
            null
        );
    }

    public function testInterface(): void
    {
        $this->assertIsObject($this->fixture->from);
        $this->assertEquals('1954-06-07 12:34:56', (string)$this->fixture->from);

        $this->assertIsObject($this->fixture->to);
        $this->assertEquals('1970-01-01 00:00:00', (string)$this->fixture->to);

        $this->assertIsObject($this->fixture->duration);
        $this->assertEquals('15 years, 6 months, 28 days, 23 h, 25 min, 4 s', (string)$this->fixture->duration);
    }

    public function testIsBefore(): void
    {
        // Before
        $result = $this->fixture->isBefore('1954-06-07 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isBefore('1954-06-07 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isBefore('1954-06-07 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // During start
        $result = $this->fixture->isBefore('1954-06-07 12:34:56');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isBefore('1954-06-07 12:34:56');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isBefore('1954-06-07 12:34:56');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // During
        $result = $this->fixture->isBefore('1960-02-23 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isBefore('1960-02-23 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isBefore('1960-02-23 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        // During end
        $result = $this->fixture->isBefore('1970-01-01 00:00:00');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isBefore('1970-01-01 00:00:00');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isBefore('1970-01-01 00:00:00');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        // After
        $result = $this->fixture->isBefore('1970-01-01 00:00:01');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixtureWithoutFrom->isBefore('1970-01-01 00:00:01');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixtureWithoutEnd->isBefore('1970-01-01 00:00:01');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);
    }

    public function testIsDuring(): void
    {
        // Before
        $result = $this->fixture->isDuring('1954-06-07 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isDuring('1954-06-07 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isDuring('1954-06-07 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // During start
        $result = $this->fixture->isDuring('1954-06-07 12:34:56');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixtureWithoutFrom->isDuring('1954-06-07 12:34:56');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isDuring('1954-06-07 12:34:56');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // During
        $result = $this->fixture->isDuring('1960-02-23 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixtureWithoutFrom->isDuring('1960-02-23 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isDuring('1960-02-23 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // During end
        $result = $this->fixture->isDuring('1970-01-01 00:00:00');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixtureWithoutFrom->isDuring('1970-01-01 00:00:00');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isDuring('1970-01-01 00:00:00');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // After
        $result = $this->fixture->isDuring('1970-01-01 00:00:01');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isDuring('1970-01-01 00:00:01');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isDuring('1970-01-01 00:00:01');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);
    }

    public function testIsAfter(): void
    {
        // Before
        $result = $this->fixture->isAfter('1954-06-07 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixtureWithoutFrom->isAfter('1954-06-07 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixtureWithoutEnd->isAfter('1954-06-07 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        // During start
        $result = $this->fixture->isAfter('1954-06-07 12:34:56');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isAfter('1954-06-07 12:34:56');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixtureWithoutEnd->isAfter('1954-06-07 12:34:56');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // During
        $result = $this->fixture->isAfter('1960-02-23 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isAfter('1960-02-23 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixtureWithoutEnd->isAfter('1960-02-23 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // During end
        $result = $this->fixture->isAfter('1970-01-01 00:00:00');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isAfter('1970-01-01 00:00:00');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isAfter('1970-01-01 00:00:00');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // After
        $result = $this->fixture->isAfter('1970-01-01 00:00:01');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isAfter('1970-01-01 00:00:01');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isAfter('1970-01-01 00:00:01');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);
    }

    public function testNotCompliant(): void
    {
        $this->expectException(NotCompliant::class);

        new DateTimeInterval(null, null);
    }
}
