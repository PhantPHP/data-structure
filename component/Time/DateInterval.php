<?php

declare(strict_types=1);

namespace Phant\DataStructure\Time;

use Phant\DataStructure\Time\Date;
use Phant\DataStructure\Time\Duration;
use Phant\Error\NotCompliant;

class DateInterval
{
    public readonly ?Duration $duration;

    public function __construct(
        public readonly ?Date $from,
        public readonly ?Date $to
    ) {
        if (!$from && !$to) {
            throw new NotCompliant('Date intervals: from ' . $from . ' to' . $to);
        }
        if ($from && $to && $from->time > $to->time) {
            throw new NotCompliant('From can be after To : ' . $from . '/' . $to);
        }

        $this->duration = ($this->from && $this->to) ? new Duration(($this->to->time + Duration::DAY - 1) - $this->from->time) : null;
    }

    public function isBefore(
        string|int|Date $date
    ): bool {
        if (is_string($date) || is_int($date)) {
            $date = new Date($date);
        }

        if ($this->from && !$this->from->isBefore($date)) {
            return false;
        }

        if ($this->to && !$this->to->isBefore($date)) {
            return false;
        }

        return true;
    }

    public function isDuring(
        string|int|Date $date
    ): bool {
        if (is_string($date) || is_int($date)) {
            $date = new Date($date);
        }

        if ($this->from && !$this->from->isBefore($date) && !$this->from->isCurrent($date)) {
            return false;
        }

        if ($this->to && !$this->to->isAfter($date) && !$this->to->isCurrent($date)) {
            return false;
        }

        return true;
    }

    public function isAfter(
        string|int|Date $date
    ): bool {
        if (is_string($date) || is_int($date)) {
            $date = new Date($date);
        }

        if ($this->from && !$this->from->isAfter($date)) {
            return false;
        }

        if ($this->to && !$this->to->isAfter($date)) {
            return false;
        }

        return true;
    }

    public static function make(
        null|int|string $from,
        null|int|string $to
    ): static {
        if (is_string($from) || is_int($from)) {
            $from = new Date($from);
        }

        if (is_string($to) || is_int($to)) {
            $to = new Date($to);
        }

        return new static(
            $from,
            $to
        );
    }
}
