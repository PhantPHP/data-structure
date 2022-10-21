<?php

declare(strict_types=1);

namespace Phant\DataStructure\Web;

use Phant\Error\NotCompliant;

class UserName extends \Phant\DataStructure\Abstract\Value\Varchar
{
    public const PATTERN = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))$/i';

    public function __construct(
        string $userName
    ) {
        $userName = preg_replace('/ /', '', $userName);
        $userName = strtolower($userName);

        parent::__construct($userName);
    }
}
