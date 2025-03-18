<?php

declare(strict_types=1);

namespace Phant\DataStructure\Money;

class Price
{
    public function __construct(
        public readonly float $amount,
        public readonly ?Currency $currency,
        public readonly ?string $unit
    ) {
    }

    public function getFormatted(
        bool $espaceInsecable = true
    ): string {
        $price = number_format($this->amount, 2, ',', ' ');

        if ($this->currency) {
            $price .= ' ' . $this->currency->getLabel();
        }

        if ($this->unit) {
            $price .= '/' . $this->unit;
        }

        if ($espaceInsecable) {
            $price = str_replace(' ', "\xC2\xA0", $price); // Espace insécable
        }

        return $price;
    }

    public function __toString(
    ): string {
        return $this->getFormatted();
    }
}
