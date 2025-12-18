<?php

declare(strict_types=1);

namespace Phant\DataStructure\Key;

use Phant\Error\NotCompliant;

final readonly class Ssl
{
    public function __construct(
        public string $private,
        public string $public
    ) {
    }

    public function encrypt(
        string $data
    ): string {
        try {
            $success = openssl_private_encrypt(
                $data,
                $encryptedData,
                $this->private
            );
        } catch (\Exception $e) {
            $success = false;
        }

        if (!$success) {
            throw new NotCompliant('Encryption invalid, verify private key');
        }

        return $encryptedData;
    }

    public function decrypt(
        string $encryptedData
    ): string {
        try {
            $success = openssl_public_decrypt(
                $encryptedData,
                $data,
                $this->public
            );
        } catch (\Exception $e) {
            $success = false;
        }

        if (!$success) {
            throw new NotCompliant('Decryption invalid, verify encrypted data or public key');
        }

        return $data;
    }
}
