<?php

declare(strict_types=1);

namespace Phant\DataStructure\Person;

use Phant\Error\NotCompliant;

class Firstname extends \Phant\DataStructure\Abstract\Value\Varchar
{
    public function __construct(string $firstname)
    {
        $firstname = trim($firstname);
        $firstname = preg_replace('/\s+/', ' ', $firstname);

        if (strlen($firstname) == 0) {
            throw new NotCompliant();
        }

        $firstname = strtolower($firstname);
        $firstname = ucwords($firstname);

        parent::__construct($firstname);
    }
}
