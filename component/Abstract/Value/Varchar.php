<?php

declare(strict_types=1);

namespace Phant\DataStructure\Abstract\Value;

use Phant\Error\NotCompliant;

abstract readonly class Varchar
{
    public const PATTERN = null;

    public function __construct(
        public string $value
    ) {
        if (defined(get_class($this) . '::PATTERN') && static::PATTERN && !preg_match(static::PATTERN, $value)) {
            throw new NotCompliant('Value : ' . $value);
        }
    }

    public function __toString(
    ): string {
        return $this->value;
    }

    public function addNonBreakingSpace(
    ): string {
        return str_replace(' ', "\xC2\xA0", $this->value);
    }
}
