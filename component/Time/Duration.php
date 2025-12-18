<?php

declare(strict_types=1);

namespace Phant\DataStructure\Time;

readonly class Duration
{
    // Duration in seconds
    public const MINUTE	= 60;
    public const HOUR	= 3600;
    public const DAY	= 86400;
    public const MONTH	= 2628000;
    public const YEAR	= 31536000;

    public string $label;

    public function __construct(
        public int $value
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
                $labels[] =  $years . ' ' . ($years > 1 ? Unit::Year->getLabelPlural() : Unit::Year->getLabel());
                $remainingTime = $remainingTime % self::YEAR;
            }
        }

        if ($remainingTime >= self::MONTH) {
            $months = intval($remainingTime / self::MONTH);
            if ($months) {
                $labels[] =  $months . ' ' . ($months > 1 ? Unit::Month->getLabelPlural() : Unit::Month->getLabel());
                $remainingTime = $remainingTime % self::MONTH;
            }
        }

        if ($remainingTime >= self::DAY) {
            $days = intval($remainingTime / self::DAY);
            if ($days) {
                $labels[] =  $days . ' ' . ($days > 1 ? Unit::Day->getLabelPlural() : Unit::Day->getLabel());
                $remainingTime = $remainingTime % self::DAY;
            }
        }

        if ($remainingTime >= self::HOUR) {
            $hours = intval($remainingTime / self::HOUR);
            if ($hours) {
                $labels[] =  $hours . ' ' . ($hours > 1 ? Unit::Hour->getLabelPlural() : Unit::Hour->getLabel());
                $remainingTime = $remainingTime % self::HOUR;
            }
        }

        if ($remainingTime >= self::MINUTE) {
            $minutes = intval($remainingTime / self::MINUTE);
            if ($minutes) {
                $labels[] =  $minutes . ' ' . ($minutes > 1 ? Unit::Minute->getLabelPlural() : Unit::Minute->getLabel());
                $remainingTime = $remainingTime % self::MINUTE;
            }
        }

        if ($remainingTime > 0) {
            $secondes = intval($remainingTime);
            if ($secondes) {
                $labels[] =  $secondes . ' ' . ($secondes > 1 ? Unit::Second->getLabelPlural() : Unit::Second->getLabel());
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
