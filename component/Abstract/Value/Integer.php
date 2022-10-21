<?php

declare(strict_types=1);

namespace Phant\DataStructure\Abstract\Value;

abstract class Integer
{
    public function __construct(
        public readonly int $value
    ) {
    }
}
