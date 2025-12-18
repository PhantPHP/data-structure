<?php

declare(strict_types=1);

namespace Phant\DataStructure\Abstract\Value;

abstract readonly class Decimal
{
    public function __construct(
        public float $value
    ) {
    }
}
