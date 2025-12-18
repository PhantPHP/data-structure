<?php

declare(strict_types=1);

namespace Phant\DataStructure\Abstract\Value;

abstract readonly class Integer
{
    public function __construct(
        public int $value
    ) {
    }
}
