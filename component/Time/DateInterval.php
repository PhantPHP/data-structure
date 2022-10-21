<?php

declare(strict_types=1);

namespace Phant\DataStructure\Time;

use Phant\DataStructure\Time\{
    Date,
    Duration,
};

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

        $this->calculateDuration();
    }

    public function isDuring(string|int|Date $date): bool
    {
        if (is_string($date) || is_int($date)) {
            $date = new Date($date);
        }

        if ($this->from && $date->time < $this->from->time) {
            return false;
        }

        if ($this->to && $date->time > $this->to->time) {
            return false;
        }

        return true;
    }

    private function calculateDuration(): void
    {
        $this->duration = ($this->from && $this->to) ? new Duration($this->to->time - $this->from->time) : null;
    }

    public static function make(
        null|int|string $from,
        null|int|string $to
    ): self {
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
