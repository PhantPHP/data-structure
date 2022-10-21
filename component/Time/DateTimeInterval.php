<?php

declare(strict_types=1);

namespace Phant\DataStructure\Time;

use Phant\DataStructure\Time\{
    DateTime,
    Duration,
};

use Phant\Error\NotCompliant;

class DateTimeInterval
{
    public readonly ?Duration $duration;

    public function __construct(
        public readonly ?DateTime $from,
        public readonly ?DateTime $to
    ) {
        if (!$from && !$to) {
            throw new NotCompliant('Date time intervals: from ' . $from . ' to' . $to);
        }

        $this->calculateDuration();
    }

    public function isDuring(int|string|DateTime $dateTime): bool
    {
        if (is_string($dateTime) || is_int($dateTime)) {
            $dateTime = new DateTime($dateTime);
        }

        if ($this->from && $dateTime->time < $this->from->time) {
            return false;
        }

        if ($this->to && $dateTime->time > $this->to->time) {
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
