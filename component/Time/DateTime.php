<?php

declare(strict_types=1);

namespace Phant\DataStructure\Time;

use Phant\Error\NotCompliant;

class DateTime extends \DateTimeImmutable
{
    public readonly int $time;
    public readonly string $date;
    public readonly ?string $format;

    public function __construct(
        int|string $date,
        string $format = 'Y-m-d H:i:s',
        ?\DateTimeZone $timeZone = null
    ) {
        $dateTime = null;
        if (is_int($date)) {
            $dateTime = (new \DateTimeImmutable('now', $timeZone))->setTimestamp($date);
        }

        if (is_string($date)) {
            try {
                $dateTime = new \DateTimeImmutable($date, $timeZone);
            } catch (\DateMalformedStringException) {
            }
        }

        if (!$dateTime) {
            throw new NotCompliant('Not compliant datetime : "' . $date . '"');
        }

        $dateTime = static::resetPrecision($dateTime);
        $this->date = $dateTime->format($format);
        $this->time = $dateTime->getTimestamp();
        $this->format = $format;

        parent::__construct(
            $dateTime->format('Y-m-d H:i:s.u'),
            $dateTime->getTimezone()
        );
    }

    protected static function resetPrecision(
        \DateTimeImmutable $dateTime
    ): \DateTimeImmutable {
        return $dateTime;
    }

    /**
     * @param string|int|DateTime $date
     * @param bool $strict If set to false the same time will return true
     */
    public function isBefore(
        string|int|self $date,
        bool $strict = true
    ): bool {
        if (is_string($date) || is_int($date)) {
            $date = new static($date);
        }

        $current = static::resetPrecision($this);

        return $strict ? $current < $date : $current <= $date;
    }

    public function isCurrent(
        string|int|self $date
    ): bool {
        if (is_string($date) || is_int($date)) {
            $date = new static($date);
        }

        if ($date != static::resetPrecision($this)) {
            return false;
        }

        return true;
    }

    /**
     * @param string|int|DateTime $date
     * @param bool $strict If set to false the same time will return true
     */
    public function isAfter(
        string|int|self $date,
        bool $strict = true
    ): bool {
        if (is_string($date) || is_int($date)) {
            $date = new static($date);
        }

        $current = static::resetPrecision($this);

        return $strict ? $current > $date : $current >= $date;
    }

    public function getUtc(
    ): string {
        return gmdate('Y-m-d\TH:i:s\Z', $this->time + date('Z', $this->time));
    }

    public function __toString(
    ) {
        return $this->format($this->format);
    }
}
