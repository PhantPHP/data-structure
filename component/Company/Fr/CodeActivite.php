<?php

declare(strict_types=1);

namespace Phant\DataStructure\Company\Fr;

class CodeActivite extends \Phant\DataStructure\Abstract\Value\Varchar
{
    public const PATTERN = '/^(\d{2})(\.)?(\d{1,2})?(\w{1})?$/';

    public function __construct(string $code)
    {
        $code = strtoupper($code);
        $code = trim($code);

        parent::__construct($code);
    }
}
