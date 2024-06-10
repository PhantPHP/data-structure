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

        if (preg_match('/^(\d{4})(\w{1})$/', $code)) {
            $code = substr($code, 0, 2) . '.' . substr($code, 2, 5);
        }

        parent::__construct($code);
    }
}
