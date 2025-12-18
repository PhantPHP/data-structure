<?php

declare(strict_types=1);

namespace Phant\DataStructure\Abstract\Value;

abstract readonly class Boolean
{
    public function __construct(
        public bool $value
    ) {
    }
}
