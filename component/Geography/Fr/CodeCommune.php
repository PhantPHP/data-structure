<?php

declare(strict_types=1);

namespace Phant\DataStructure\Geography\Fr;

class CodeCommune extends \Phant\DataStructure\Abstract\Value\Varchar
{
    public const PATTERN = '/^[0-9][0-9AB][0-9]{3}$/';

    public function __construct(
        string $code
    ) {
        $code = trim($code);
        if (strlen($code) == 4) {
            $code = str_pad($code, 5, '0', STR_PAD_LEFT);
        }

        parent::__construct($code);
    }

    public function getNumeroDepartement(
    ): NumeroDepartement {
        $numeroDepartement = substr($this->value, 0, 2);
        if (in_array($numeroDepartement, ['97', '98'])) {
            $numeroDepartement = substr($this->value, 0, 3);
        }

        return new NumeroDepartement($numeroDepartement);
    }
}
