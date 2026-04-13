<?php

declare(strict_types=1);

namespace Phant\DataStructure\Money;

class Price
{
    public function __construct(
        public readonly float $amount,
        public readonly ?Currency $currency,
        public readonly ?string $unit,
        public readonly ?int $precision = 2
    ) {
    }

    public function add(self $price): static
    {
        if ($this->currency !== $price->currency) {
            throw new \InvalidArgumentException('Cannot add prices with different currencies.');
        }

        if ($this->unit !== $price->unit) {
            throw new \InvalidArgumentException('Cannot add prices with different units.');
        }

        return new static(
            amount: round($this->amount + $price->amount, $this->precision),
            currency: $this->currency,
            unit: $this->unit,
            precision: $this->precision
        );
    }

    public function subtract(self $price): static
    {
        if ($this->currency !== $price->currency) {
            throw new \InvalidArgumentException('Cannot subtract prices with different currencies.');
        }

        if ($this->unit !== $price->unit) {
            throw new \InvalidArgumentException('Cannot subtract prices with different units.');
        }

        return new static(
            amount: round($this->amount - $price->amount, $this->precision),
            currency: $this->currency,
            unit: $this->unit,
            precision: $this->precision
        );
    }

    public function multiply(float $factor): static
    {
        return new static(
            amount: round($this->amount * $factor, $this->precision),
            currency: $this->currency,
            unit: $this->unit,
            precision: $this->precision
        );
    }

    public function applyPercentage(float $percentage): static
    {
        return $this->multiply(1 + $percentage / 100);
    }

    public function getFormatted(
        bool $espaceInsecable = true
    ): string {
        $price = number_format($this->amount, $this->precision, ',', ' ');

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
