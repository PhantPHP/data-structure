<?php

declare(strict_types=1);

namespace Phant\DataStructure\Company;

use Phant\DataStructure\Company\Fr\Siren;
use Phant\Error\NotCompliant;

readonly class Euid extends \Phant\DataStructure\Abstract\Value\Varchar
{
    public const PATTERN = '/^(\D{2})(\w+)(\.)(\w+)$/';
    private const COUNTRY_CODES = ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK'];


    public function __construct(
        string $euid,
        bool $check = true
    ) {
        parent::__construct($euid);

        $parts = $this->extractParts();

        if (!$parts->countryCode || !in_array($parts->countryCode, self::COUNTRY_CODES)) {
            throw new NotCompliant('Not compliant country code');
        }

        if ($check) {
            match ($parts->countryCode) {
                'FR' => new Siren($parts->companyCode),
                default => null,
            };
        }
    }

    public function getFormatted(
        bool $nonBreakingSpace = true
    ): string {
        $parts = $this->extractParts();

        $euid = implode(' ', [
            $parts->countryCode,
            $parts->registryCode,
            $parts->separator,
            self::formatCompanyCode($parts->companyCode),
        ]);

        if ($nonBreakingSpace) {
            $euid = str_replace(' ', "\xC2\xA0", $euid); // non breaking space
        }

        return $euid;
    }

    public function extractParts(
    ): object {
        preg_match('/^(\D{2})(\w+)(\.)(\w+)$/', $this->value, $matches);

        return (object) [
            'countryCode' => $matches[1] ?? null,
            'registryCode' => $matches[2] ?? null,
            'separator' => $matches[3] ?? null,
            'companyCode' => $matches[4] ?? null,
        ];
    }

    private static function formatCompanyCode(
        string $companyCode
    ): string {
        return match (strlen($companyCode)) {
            5 => preg_replace('/^(\d{2})(\d{3})$/', '$1 $2', $companyCode),
            6 => preg_replace('/^(\d{3})(\d{3})$/', '$1 $2', $companyCode),
            7 => preg_replace('/^(\d{3})(\d{4})$/', '$1 $2', $companyCode),
            8 => preg_replace('/^(\d{2})(\d{3})(\d{3})$/', '$1 $2 $3', $companyCode),
            9 => preg_replace('/^(\d{3})(\d{3})(\d{3})$/', '$1 $2 $3', $companyCode),
            default => $companyCode,
        };
    }
}
