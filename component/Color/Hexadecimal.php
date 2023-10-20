<?php

declare(strict_types=1);

namespace Phant\DataStructure\Color;

use Phant\Error\NotCompliant;

class Hexadecimal extends \Phant\DataStructure\Abstract\Value\Varchar
{
    public const PATTERN = '/^#[0-9a-fA-F]{3}$|#[0-9a-fA-F]{6}$|#[0-9a-fA-F]{8}$/';
}
