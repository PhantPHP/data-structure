<?php

declare(strict_types=1);

namespace Phant\DataStructure\Time;

use Phant\Error\NotCompliant;

class DateTime extends \DateTimeImmutable
{
    public readonly int $time;
    public readonly string $date;
    public readonly string $format;


    public function __construct(
        int|string $date,
        string $format = 'Y-m-d H:i:s'
    ) {
        if (is_string($date)) {
            if (strtolower($date) == 'now') {
                $dateTime = new \DateTimeImmutable('today midnight');
            } else {
                $dateTime = \DateTimeImmutable::createFromFormat($format, $date);
            }
        }

        if (is_int($date)) {
            $dateTime = \DateTimeImmutable::createFromTimestamp($date);
        }

        if (!$dateTime) {
            throw new NotCompliant('Date: ' . $date);
        }

        $dateTime = static::normalize($dateTime);
        $this->time = $dateTime->getTimestamp();
        $this->date = $dateTime->format($format);
        $this->format = $format;

        parent::__construct($dateTime->format('c'));
    }

    protected static function normalize(
        \DateTimeImmutable $dateTime
    ): \DateTimeImmutable {
        return $dateTime;
    }

    public function isBefore(
        string|int|self $date
    ): bool {
        if (is_string($date) || is_int($date)) {
            $date = new self($date);
        }

        if ($date <= $this) {
            return false;
        }

        return true;
    }

    public function isCurrent(
        string|int|self $date
    ): bool {
        if (is_string($date) || is_int($date)) {
            $date = new self($date);
        }

        if ($date != $this) {
            return false;
        }

        return true;
    }

    public function isAfter(
        string|int|self $date
    ): bool {
        if (is_string($date) || is_int($date)) {
            $date = new self($date);
        }

        if ($date >= $this) {
            return false;
        }

        return true;
    }

    public function getUtc(
    ): string {
        return gmdate('Y-m-d\TH:i:s\Z', $this->time + date('Z', $this->time));
    }

    public function __toString(
    ) {
        return $this->format('Y-m-d H:i:s');
    }
}
