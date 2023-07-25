<?php

declare(strict_types=1);

namespace Test\Time;

use Phant\DataStructure\Time\DateInterval;

use Phant\Error\NotCompliant;

final class DateIntervalTest extends \PHPUnit\Framework\TestCase
{
    protected DateInterval $fixture;
    protected DateInterval $fixtureWithoutFrom;
    protected DateInterval $fixtureWithoutEnd;

    public function setUp(): void
    {
        $this->fixture = DateInterval::make(
            '1954-06-07',
            '1970-01-01'
        );
        $this->fixtureWithoutFrom = DateInterval::make(
            null,
            '1970-01-01'
        );
        $this->fixtureWithoutEnd = DateInterval::make(
            '1954-06-07',
            null
        );
    }

    public function testInterface(): void
    {
        $this->assertIsObject($this->fixture->from);
        $this->assertEquals('1954-06-07', (string)$this->fixture->from);

        $this->assertIsObject($this->fixture->to);
        $this->assertEquals('1970-01-01', (string)$this->fixture->to);

        $this->assertIsObject($this->fixture->duration);
        $this->assertEquals('15 years, 6 months, 29 days, 12 h', (string)$this->fixture->duration);
    }

    public function testIsBefore(): void
    {
        // Before
        $result = $this->fixture->isBefore('1954-06-06');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isBefore('1954-06-06');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isBefore('1954-06-06');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // During start
        $result = $this->fixture->isBefore('1954-06-07');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isBefore('1954-06-07');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isBefore('1954-06-07');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // During
        $result = $this->fixture->isBefore('1960-02-23');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isBefore('1960-02-23');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isBefore('1960-02-23');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        // During end
        $result = $this->fixture->isBefore('1970-01-01');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isBefore('1970-01-01');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isBefore('1970-01-01');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        // After
        $result = $this->fixture->isBefore('1970-01-03');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixtureWithoutFrom->isBefore('1970-01-03');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixtureWithoutEnd->isBefore('1970-01-03');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);
    }

    public function testIsDuring(): void
    {
        // Before
        $result = $this->fixture->isDuring('1954-06-06');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isDuring('1954-06-06');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isDuring('1954-06-06');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // During start
        $result = $this->fixture->isDuring('1954-06-07');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixtureWithoutFrom->isDuring('1954-06-07');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isDuring('1954-06-07');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // During
        $result = $this->fixture->isDuring('1960-02-23');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixtureWithoutFrom->isDuring('1960-02-23');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isDuring('1960-02-23');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // During end
        $result = $this->fixture->isDuring('1970-01-01');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixtureWithoutFrom->isDuring('1970-01-01');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isDuring('1970-01-01');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // After
        $result = $this->fixture->isDuring('1970-01-03');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isDuring('1970-01-03');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isDuring('1970-01-03');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);
    }

    public function testIsAfter(): void
    {
        // Before
        $result = $this->fixture->isAfter('1954-06-06');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixtureWithoutFrom->isAfter('1954-06-06');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixtureWithoutEnd->isAfter('1954-06-06');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        // During start
        $result = $this->fixture->isAfter('1954-06-07');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isAfter('1954-06-07');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixtureWithoutEnd->isAfter('1954-06-07');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // During
        $result = $this->fixture->isAfter('1960-02-23');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isAfter('1960-02-23');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);

        $result = $this->fixtureWithoutEnd->isAfter('1960-02-23');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // During end
        $result = $this->fixture->isAfter('1970-01-01');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isAfter('1970-01-01');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isAfter('1970-01-01');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // After
        $result = $this->fixture->isAfter('1970-01-03');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutFrom->isAfter('1970-01-03');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        $result = $this->fixtureWithoutEnd->isAfter('1970-01-03');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);
    }

    public function testNotCompliant(): void
    {
        $this->expectException(NotCompliant::class);

        new DateInterval(null, null);
    }
}
