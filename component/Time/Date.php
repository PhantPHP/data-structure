<?php

declare(strict_types=1);

namespace Phant\DataStructure\Time;

use Phant\Error\NotCompliant;

class Date
{
    public readonly int $time;
    public readonly string $date;
    public readonly string $format;

    public function __construct(
        int|string $date,
        string $format = 'Y-m-d'
    ) {
        if (is_string($date) && strtolower($date) == 'now') {
            $date = strtotime('today midnight');
        }

        $time = is_string($date) ? strtotime($date) : $date;

        if (!is_a($this, DateTime::class) && $time) {
            $time = (new \DateTime())->setTimestamp($time)->setTime(0, 0)->getTimestamp();
        }

        if ($time === false) {
            throw new NotCompliant('Date: ' . $date);
        }

        $this->time = $time;
        $this->format = $format;
        $this->date = date($format, $this->time);
    }

    public function isBefore(
        string|int|Date|DateTime $date
    ): bool {
        if (is_string($date) || is_int($date)) {
            $date = new DateTime($date);
        }

        if ($date->time <= $this->time) {
            return false;
        }

        return true;
    }

    public function isCurrent(
        string|int|Date|DateTime $date
    ): bool {
        if (is_string($date) || is_int($date)) {
            $date = new DateTime($date);
        }

        if ($date->time != $this->time) {
            return false;
        }

        return true;
    }

    public function isAfter(
        string|int|Date|DateTime $date
    ): bool {
        if (is_string($date) || is_int($date)) {
            $date = new DateTime($date);
        }

        if ($date->time >= $this->time) {
            return false;
        }

        return true;
    }

    public function __toString()
    {
        return $this->date;
    }
}
