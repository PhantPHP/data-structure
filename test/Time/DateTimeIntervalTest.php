<?php

declare(strict_types=1);

namespace Test\Time;

use Phant\DataStructure\Time\DateTimeInterval;

use Phant\Error\NotCompliant;

final class DateTimeIntervalTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $dateTimeInterval = DateTimeInterval::make(
            '1954-06-07 12:34:56',
            '1970-01-01 00:00:00'
        );

        $this->assertIsObject($dateTimeInterval->from);
        $this->assertEquals('1954-06-07 12:34:56', (string)$dateTimeInterval->from);

        $this->assertIsObject($dateTimeInterval->to);
        $this->assertEquals('1970-01-01 00:00:00', (string)$dateTimeInterval->to);

        $this->assertIsObject($dateTimeInterval->duration);
        $this->assertEquals('15 years, 6 months, 28 days, 23 h, 25 min, 4 s', (string)$dateTimeInterval->duration);
    }

    public function testIsDuring(): void
    {
        $dateTimeInterval = DateTimeInterval::make(
            '1954-06-07 12:34:56',
            '1970-01-01 00:00:00'
        );

        // Before
        $result = $dateTimeInterval->isDuring('1954-05-07 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // After
        $result = $dateTimeInterval->isDuring('1970-01-01 00:00:01');
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);

        // During
        $result = $dateTimeInterval->isDuring('1960-02-23 12:34:55');
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);
    }

    public function testNotCompliant(): void
    {
        $this->expectException(NotCompliant::class);

        new DateTimeInterval(null, null);
    }
}
