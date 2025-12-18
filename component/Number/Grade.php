<?php

declare(strict_types=1);

namespace Phant\DataStructure\Number;

use Phant\Error\NotCompliant;

readonly class Grade
{
    public function __construct(
        public int $position,
        public int $scale
    ) {
        if ($position < 0) {
            throw new NotCompliant('Note : ' . $position);
        }

        if ($scale < 0) {
            throw new NotCompliant('Scale : ' . $scale);
        }
    }

    public function __toString(
    ): string {
        return $this->position . '/' . $this->scale;
    }

    public static function make(
        string $grade
    ): self {
        $parts = explode('/', $grade);

        return new static(
            (int) $parts[0],
            (int) $parts[1]
        );
    }
}
