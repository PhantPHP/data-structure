<?php

declare(strict_types=1);

namespace Phant\DataStructure\Company\Fr;

use Phant\DataStructure\Company\Fr\Siren;
use Phant\Error\NotCompliant;

class Siret extends \Phant\DataStructure\Abstract\Value\Varchar
{
    public const PATTERN = '/^(\d{14})$/';
    public const SIREN_LA_POSTE = '356000000';

    public function __construct(string $siret, bool $check = true)
    {
        $siret = preg_replace('/\D/', '', $siret);

        if ($check && !self::isValid($siret)) {
            throw new NotCompliant('Siret : ' . $siret);
        }

        parent::__construct($siret);
    }

    public function getSiren(): Siren
    {
        return new Siren(substr($this->value, 0, 9));
    }

    public function getFormatted(bool $espaceInsecable = true): string
    {
        $siret = $this->value;
        $siret = preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{5})$/', '$1 $2 $3 $4', $siret);
        if ($espaceInsecable) {
            $siret = str_replace(' ', "\xC2\xA0", $siret); // Espace insécable
        }

        return $siret;
    }

    public static function isValid(string $siret): bool
    {
        if (substr($siret, 0, 9) == self::SIREN_LA_POSTE) {
            return self::checkLaPoste($siret);
        }

        return self::luhnCheck($siret);
    }

    private static function luhnCheck(string $value): bool
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

    private static function checkLaPoste(string $value): bool
    {
        $sum = 0;

        for ($i = strlen($value) - 1; $i >= 0; $i--) {
            $sum += $value[$i];
        }

        return $sum % 5 === 0;
    }
}
