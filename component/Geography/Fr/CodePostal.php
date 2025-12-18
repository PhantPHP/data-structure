<?php

declare(strict_types=1);

namespace Phant\DataStructure\Geography\Fr;

readonly class CodePostal extends \Phant\DataStructure\Abstract\Value\Varchar
{
    public const PATTERN = '/^\d{5}$/';

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
        $numeroDepartement = match($numeroDepartement) {
            '20' => match (substr($this->value, 0, 3)) {
                '201' => '2A',
                '202' => '2B',
            },
            '97' => substr($this->value, 0, 3),
            '98' => substr($this->value, 0, 3),
            default => $numeroDepartement,
        };

        return new NumeroDepartement($numeroDepartement);
    }
}
