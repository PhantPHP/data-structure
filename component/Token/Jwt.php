<?php

declare(strict_types=1);

namespace Phant\DataStructure\Token;

use Phant\Error\NotCompliant;
use Firebase\JWT\JWT as FirebaseJwt;
use Firebase\JWT\Key as FirebaseKey;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

class Jwt extends \Phant\DataStructure\Abstract\Value\Varchar
{
    public const PAYLOAD_CREATION_TIME = 'iat';
    public const PAYLOAD_LIFE_TIME = 'exp';

    public const ALGORITHM = 'RS256';

    final public function __construct(
        string $value
    ) {
        parent::__construct($value);
    }

    public function decode(
        string $publicKey
    ): array {
        try {
            return (array) FirebaseJwt::decode($this->value, new FirebaseKey($publicKey, self::ALGORITHM));
        } catch (ExpiredException | SignatureInvalidException $e) {
            throw new NotCompliant();
        }
    }

    public static function encode(
        string $privateKey,
        array $payload,
        int $lifetime = 3600
    ): self {
        $payload[ self::PAYLOAD_CREATION_TIME ] = time();
        $payload[ self::PAYLOAD_LIFE_TIME ] = $payload[ self::PAYLOAD_CREATION_TIME ] + $lifetime;

        return new static(FirebaseJwt::encode($payload, $privateKey, self::ALGORITHM));
    }
}
