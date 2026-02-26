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

    public function add(self $price): self
    {
        if ($this->currency !== $price->currency) {
            throw new \InvalidArgumentException('Cannot add prices with different currencies.');
        }

        if ($this->unit !== $price->unit) {
            throw new \InvalidArgumentException('Cannot add prices with different units.');
        }

        return new self(
            amount: round($this->amount + $price->amount, 2),
            currency: $this->currency,
            unit: $this->unit
        );
    }

    public function substract(self $price): self
    {
        if ($this->currency !== $price->currency) {
            throw new \InvalidArgumentException('Cannot substract prices with different currencies.');
        }

        if ($this->unit !== $price->unit) {
            throw new \InvalidArgumentException('Cannot substract prices with different units.');
        }

        return new self(
            amount: round($this->amount - $price->amount, 2),
            currency: $this->currency,
            unit: $this->unit
        );
    }

    public function multiply(float $factor): self
    {
        return new self(
            amount: round($this->amount * $factor, 2),
            currency: $this->currency,
            unit: $this->unit
        );
    }

    public function addPercentage(float $percentage): self
    {
        if ($percentage < 0) {
            throw new \InvalidArgumentException('Percentage must be a positive value.');
        }

        $factor = 1 + ($percentage / 100);

        return $this->multiply($factor);
    }

    public function substractPercentage(float $percentage): self
    {
        if ($percentage < 0 || $percentage >= 100) {
            throw new \InvalidArgumentException('Percentage must be between 0 and 100.');
        }

        $factor = 1 - ($percentage / 100);

        return $this->multiply($factor);
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
