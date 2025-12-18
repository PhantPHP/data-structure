<?php

declare(strict_types=1);

namespace Phant\DataStructure\Money;

readonly class Price
{
    public function __construct(
        public float $amount,
        public ?Currency $currency,
        public ?string $unit
    ) {
    }

    public function getFormatted(
        bool $nonBreakingSpace = true
    ): string {
        $price = number_format($this->amount, 2, ',', ' ');

        if ($this->currency) {
            $price .= ' ' . $this->currency->getLabel();
        }

        if ($this->unit) {
            $price .= '/' . $this->unit;
        }

        if ($nonBreakingSpace) {
            $price = str_replace(' ', "\xC2\xA0", $price); // non breaking space
        }

        return $price;
    }

    public function __toString(
    ): string {
        return $this->getFormatted();
    }
}
