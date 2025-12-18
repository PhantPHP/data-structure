<?php

declare(strict_types=1);

namespace Phant\DataStructure\Time;

use Phant\DataStructure\Time\DateTime;
use Phant\DataStructure\Time\Duration;
use Phant\Error\NotCompliant;

readonly class DateTimeInterval
{
    public ?Duration $duration;

    public function __construct(
        public ?DateTime $from,
        public ?DateTime $to
    ) {
        if (!$from && !$to) {
            throw new NotCompliant('A datetime interval must contain at least one date');
        }
        if ($from && $to && $from->time > $to->time) {
            throw new NotCompliant('Invalid datetime interval: from datetime (' . $from . ') cannot be after to datetime (' . $to . ')');
        }

        $this->duration = ($this->from && $this->to) ? new Duration($this->to->time - $this->from->time) : null;
    }

    public function isBefore(
        string|int|DateTime $dateTime
    ): bool {
        if (is_string($dateTime) || is_int($dateTime)) {
            $dateTime = new DateTime($dateTime);
        }

        if ($this->from && !$this->from->isBefore($dateTime)) {
            return false;
        }

        if ($this->to && !$this->to->isBefore($dateTime)) {
            return false;
        }

        return true;
    }

    public function isDuring(
        int|string|DateTime $dateTime
    ): bool {
        if (is_string($dateTime) || is_int($dateTime)) {
            $dateTime = new DateTime($dateTime);
        }

        if ($this->from && !$this->from->isBefore($dateTime) && !$this->from->isCurrent($dateTime)) {
            return false;
        }

        if ($this->to && !$this->to->isAfter($dateTime) && !$this->to->isCurrent($dateTime)) {
            return false;
        }

        return true;
    }

    public function isAfter(
        string|int|DateTime $dateTime
    ): bool {
        if (is_string($dateTime) || is_int($dateTime)) {
            $dateTime = new DateTime($dateTime);
        }

        if ($this->from && !$this->from->isAfter($dateTime)) {
            return false;
        }

        if ($this->to && !$this->to->isAfter($dateTime)) {
            return false;
        }

        return true;
    }

    public static function make(
        null|int|string $from,
        null|int|string $to
    ): static {
        if (is_string($from) || is_int($from)) {
            $from = new DateTime($from);
        }

        if (is_string($to) || is_int($to)) {
            $to = new DateTime($to);
        }

        return new static(
            $from,
            $to
        );
    }
}
