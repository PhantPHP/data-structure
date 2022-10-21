<?php

declare(strict_types=1);

namespace Phant\DataStructure\Abstract\Value;

abstract class Boolean
{
    public function __construct(
        public readonly bool $value
    ) {
    }
}
