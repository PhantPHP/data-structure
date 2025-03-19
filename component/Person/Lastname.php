<?php

declare(strict_types=1);

namespace Phant\DataStructure\Person;

use Phant\Error\NotCompliant;

class Lastname extends \Phant\DataStructure\Abstract\Value\Varchar
{
    public function __construct(
        string $lastname
    ) {
        $lastname = trim($lastname);
        $lastname = preg_replace('/\s+/', ' ', $lastname);

        if (strlen($lastname) == 0) {
            throw new NotCompliant();
        }

        $lastname = strtoupper($lastname);

        parent::__construct($lastname);
    }
}
