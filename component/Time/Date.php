<?php

declare(strict_types=1);

namespace Phant\DataStructure\Time;

class Date extends DateTime
{
    public function __construct(
        int|string $date,
        string $format = 'Y-m-d'
    ) {
        parent::__construct($date, $format);
    }

    protected static function resetPrecision(
        \DateTimeImmutable $dateTime
    ): \DateTimeImmutable {
        return $dateTime->setTime(0, 0, 0);
    }
}
