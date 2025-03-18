<?php

declare(strict_types=1);

namespace Phant\DataStructure\Company\Fr;

use Phant\Error\NotCompliant;

class Siren extends \Phant\DataStructure\Abstract\Value\Varchar
{
    public const PATTERN = '/^(\d{9})$/';

    public function __construct(string $siren, bool $check = true)
    {
        $siren = preg_replace('/\D/', '', $siren);

        if ($check && !self::luhnCheck($siren)) {
            throw new NotCompliant('Siren : ' . $siren);
        }

        parent::__construct($siren);
    }

    public static function luhnCheck(string $value): bool
    {
        $sum = 0;
        $flag = 0;

        for ($i = strlen($value) - 1; $i >= 0; $i--) {
            $number = (int) $value[$i];
            $add = $flag++ & 1 ? $number * 2 : $number;
            $sum += $add > 9 ? $add - 9 : $add;
        }

        return $sum % 10 === 0;
    }

    public function getFormatted(bool $espaceInsecable = true): string
    {
        $siren = $this->value;
        $siren = preg_replace('/^(\d{3})(\d{3})(\d{3})$/', '$1 $2 $3', $siren);
        if ($espaceInsecable) {
            $siren = str_replace(' ', "\xC2\xA0", $siren); // Espace insécable
        }

        return $siren;
    }
}
