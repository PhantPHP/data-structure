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

    protected static function normalize(
        \DateTimeImmutable $dateTime
    ): \DateTimeImmutable {
        return $dateTime->setTime(0, 0, 0);
    }

    public function isBefore(
        string|int|DateTime $date
    ): bool {
        if (is_string($date) || is_int($date)) {
            $date = new static($date);
        }

        if ($date <= $this) {
            return false;
        }

        return true;
    }

    public function isCurrent(
        string|int|DateTime $date
    ): bool {
        if (is_string($date) || is_int($date)) {
            $date = new static($date);
        }

        if ($date != $this) {
            return false;
        }

        return true;
    }

    public function isAfter(
        string|int|DateTime $date
    ): bool {
        if (is_string($date) || is_int($date)) {
            $date = new static($date);
        }

        if ($date >= $this) {
            return false;
        }

        return true;
    }

    public function __toString(
    ) {
        return $this->format('Y-m-d');
    }
}
