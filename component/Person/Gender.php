<?php

declare(strict_types=1);

namespace Phant\DataStructure\Person;

enum Gender: string
{
    case Female = 'female';

    case Male = 'male';

    public function getLabel(): string
    {
        return match ($this) {
            self::Female => 'Female',
            self::Male => 'Male',
        };
    }
}
