<?php

declare(strict_types=1);

namespace Phant\DataStructure\Token;

class ApiKey extends \Phant\DataStructure\Abstract\Value\Varchar
{
    public const PATTERN = '/^[0-9a-zA-Z]{8}\.[0-9a-zA-Z]{64}$/';
    
    final public static function generate(): static
    {
        return new static(self::generateRandomString(8) . '.' . self::generateRandomString(64));
    }

    public function check(string|self $apiKey): bool
    {
        return $this->value === (string)$apiKey;
    }

    private static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
