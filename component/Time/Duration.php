<?php

declare(strict_types=1);

namespace Phant\DataStructure\Time;

class Duration
{
    // Duration in secondes
    public const MINUTE	    = 60;
    public const HOUR		= 3600;
    public const DAY		= 86400;
    public const MONTH		= 2628000;
    public const YEAR		= 31536000;

    public const SECOND_LABEL = 's';
    public const SECOND_LABEL_PLURAL = 's';
    public const MINUTE_LABEL = 'min';
    public const MINUTE_LABEL_PLURAL = 'min';
    public const HOUR_LABEL = 'h';
    public const HOUR_LABEL_PLURAL = 'h';
    public const DAY_LABEL = 'day';
    public const DAY_LABEL_PLURAL = 'days';
    public const MONTH_LABEL = 'month';
    public const MONTH_LABEL_PLURAL = 'months';
    public const YEAR_LABEL = 'year';
    public const YEAR_LABEL_PLURAL = 'years';

    public readonly string $label;

    public function __construct(
        public readonly int $value
    ) {
        $this->label = $this->buildLabel();
    }

    public function __toString(
    ) {
        return $this->label;
    }

    protected function buildLabel(
    ): string {
        $remainingTime = $this->value;

        $labels = [];

        if ($remainingTime >= self::YEAR) {
            $years = intval($remainingTime / self::YEAR);
            if ($years) {
                $labels[] =  $years . ' ' . ($years > 1 ? self::YEAR_LABEL_PLURAL : self::YEAR_LABEL);
                $remainingTime = $remainingTime % self::YEAR;
            }
        }

        if ($remainingTime >= self::MONTH) {
            $months = intval($remainingTime / self::MONTH);
            if ($months) {
                $labels[] =  $months . ' ' . ($months > 1 ? self::MONTH_LABEL_PLURAL : self::MONTH_LABEL);
                $remainingTime = $remainingTime % self::MONTH;
            }
        }

        if ($remainingTime >= self::DAY) {
            $days = intval($remainingTime / self::DAY);
            if ($days) {
                $labels[] =  $days . ' ' . ($days > 1 ? self::DAY_LABEL_PLURAL : self::DAY_LABEL);
                $remainingTime = $remainingTime % self::DAY;
            }
        }

        if ($remainingTime >= self::HOUR) {
            $hours = intval($remainingTime / self::HOUR);
            if ($hours) {
                $labels[] =  $hours . ' ' . ($hours > 1 ? self::HOUR_LABEL_PLURAL : self::HOUR_LABEL);
                $remainingTime = $remainingTime % self::HOUR;
            }
        }

        if ($remainingTime >= self::MINUTE) {
            $minutes = intval($remainingTime / self::MINUTE);
            if ($minutes) {
                $labels[] =  $minutes . ' ' . ($minutes > 1 ? self::MINUTE_LABEL_PLURAL : self::MINUTE_LABEL);
                $remainingTime = $remainingTime % self::MINUTE;
            }
        }

        if ($remainingTime > 0) {
            $secondes = intval($remainingTime);
            if ($secondes) {
                $labels[] =  $secondes . ' ' . ($secondes > 1 ? self::SECOND_LABEL_PLURAL : self::SECOND_LABEL);
            }
        }

        return implode(', ', $labels);
    }

    public function inMinutes(
    ): int {
        return (int)round($this->value / self::MINUTE, 0);
    }

    public function inHours(
    ): int {
        return (int)round($this->value / self::HOUR, 0);
    }

    public function inDays(
    ): int {
        return (int)round($this->value / self::DAY, 0);
    }

    public function inMonths(
    ): int {
        return (int)round($this->value / self::MONTH, 0);
    }

    public function inYears(
    ): int {
        return (int)round($this->value / self::YEAR, 0);
    }
}
