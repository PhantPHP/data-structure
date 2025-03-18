<?php

declare(strict_types=1);

namespace Phant\DataStructure\Money;

enum Currency: string
{
    case AUD = 'AUD';
    case CAD = 'CAD';
    case CHF = 'CHF';
    case DKK = 'DKK';
    case EUR = 'EUR';
    case GBP = 'GBP';
    case SEK = 'SEK';
    case USD = 'USD';
    case ZSD = 'ZSD';

    public function getLabel(
    ): string {
        return match ($this) {
            self::AUD => 'AUD',
            self::CAD => 'CAD',
            self::CHF => 'CHF',
            self::DKK => 'DKK',
            self::EUR => '€',
            self::GBP => '£',
            self::SEK => 'SEK',
            self::USD => 'USD',
            self::ZSD => 'ZSD',
        };
    }
}
