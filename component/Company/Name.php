<?php

declare(strict_types=1);

namespace Phant\DataStructure\Company;

class Name extends \Phant\DataStructure\Abstract\Value\Varchar
{
    public const PATTERN = '/^.{1,}$/';

    public function __construct(string $name)
    {
        $name = trim($name);

        parent::__construct($name);
    }
}
