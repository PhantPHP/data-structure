<?php

declare(strict_types=1);

namespace Phant\DataStructure\Abstract\Value;

abstract class Decimal
{
    public function __construct(
        public readonly float $value
    ) {
    }
}
