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

        $time = is_string($date) ? self::getTimeFromString($date) : $date;

        if (!is_a($this, DateTime::class) && $time) {
            $time = (new \DateTime())->setTimestamp($time)->setTime(0, 0)->getTimestamp();
        }

        if ($time === false || $time === null) {
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

    public function __toString(
    ) {
        return $this->date;
    }

    public static function getTimeFromString(
        string $dateString
    ): ?int {
        $trimmed = trim($dateString);
        if (empty($trimmed)) {
            return null;
        }

        // 1. If this is already a numeric UNIX timestamp (e.g. "1861833600")
        if (ctype_digit($trimmed)) {
            return (int) $trimmed;
        }

        // 2. List of formats to try, in order of priority
        // Note: European (Day/Month) formats come BEFORE American formats for a French/European audience.
        $formats = [
            // Standard ISO formats
            'Y-m-d',
            'Y-m-d H:i:s',
            'Y-m-d\TH:i:sP', // ISO 8601 / ATOM format

            // European formats (d/m/Y, d-m-Y, or d.m.Y)
            'd/m/y',
            'd/m/Y',
            'd-m-Y',
            'd.m.Y',
            'd/m/Y H:i:s',

            // American formats (m/d/Y)
            'm/d/Y',
            'm-d-Y',

            // Simple French/English text format (e.g. "31 Dec 2028")
            'j M Y',
            'd F Y',
        ];

        foreach ($formats as $format) {
            // '!' resets the hour/minute/second to 00:00:00 if the format does not include a time
            $date = \DateTime::createFromFormat('!' . $format, $trimmed);

            // Strict validation: DateTime::getLastErrors() checks for silent over-parsing
            $errors = \DateTime::getLastErrors();
            if ($date !== false && ($errors === false || ($errors['warning_count'] === 0 && $errors['error_count'] === 0))) {
                return $date->getTimestamp();
            }
        }

        // 3. Last resort: try strtotime after replacing slashes with hyphens (forces European d-m-Y mode)
        $normalized = str_replace('/', '-', $trimmed);
        $timestamp = strtotime($normalized);
        if ($timestamp !== false) {
            return $timestamp;
        }

        return null; // Unrecognized date
    }
}
