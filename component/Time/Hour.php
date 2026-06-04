<?php

declare(strict_types=1);

namespace Phant\DataStructure\Time;

use Phant\Error\NotCompliant;

class Hour
{
    public const PATTERN = '/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/';

    public function __construct(
        public readonly string $hour
    ) {
        if (!preg_match(static::PATTERN, $hour)) {
            throw new NotCompliant('Hour format is invalid : ' . $hour);
        }
    }

    public function __toString(
    ) {
        return $this->hour;
    }

    public function isBefore(self $other): bool
    {
        return strtotime($this->hour) < strtotime($other->hour);
    }

    public function isAfter(self $other): bool
    {
        return strtotime($this->hour) > strtotime($other->hour);
    }

    public function isBetween(self $start, self $end): bool
    {
        return $this->isAfter($start) && $this->isBefore($end);
    }
}
