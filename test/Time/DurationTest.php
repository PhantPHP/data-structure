<?php

declare(strict_types=1);

namespace Test\Time;

use Phant\DataStructure\Time\Duration;

use Phant\Error\NotCompliant;

final class DurationTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $time = Duration::YEAR + Duration::MONTH + Duration::DAY + Duration::HOUR + Duration::MINUTE + 1;
        $duration = new Duration($time);

        $this->assertEquals('1 year, 1 month, 1 day, 1 h, 1 min, 1 s', (string)$duration);

        $this->assertIsInt($duration->value);
        $this->assertEquals($time, $duration->value);

        $this->assertIsString($duration->label);
        $this->assertEquals('1 year, 1 month, 1 day, 1 h, 1 min, 1 s', $duration->label);
    }
}
