<?php

declare(strict_types=1);

namespace Phant\DataStructure\Time;

enum Unit
{
    case Second;
    case Minute;
    case Hour;
    case Day;
    case Month;
    case Year;

    public function getLabel(
    ): string {
        return match ($this) {
            self::Second => 's',
            self::Minute => 'min',
            self::Hour => 'h',
            self::Day => 'day',
            self::Month => 'month',
            self::Year => 'year',
        };
    }

    public function getLabelPlural(
    ): string {
        return match ($this) {
            self::Second => 's',
            self::Minute => 'min',
            self::Hour => 'h',
            self::Day => 'days',
            self::Month => 'months',
            self::Year => 'years',
        };
    }
}
