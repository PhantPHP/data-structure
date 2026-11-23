<?php

declare(strict_types=1);

namespace Phant\DataStructure\Time;

class Date extends DateTime
{
    public function __construct(
        int|string $date,
        string $format = 'Y-m-d',
        ?\DateTimeZone $timezone = null
    ) {
        parent::__construct($date, $format, $timezone);
    }

    protected static function resetPrecision(
        \DateTimeImmutable $dateTime
    ): \DateTimeImmutable {
        return $dateTime->setTime(0, 0, 0);
    }
}
