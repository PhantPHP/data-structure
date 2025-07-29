<?php

declare(strict_types=1);

namespace Phant\DataStructure\Web;

class DomainName extends \Phant\DataStructure\Abstract\Value\Varchar
{
    public const PATTERN = '/^((?!-))(xn--)?[a-z0-9][a-z0-9-_]{0,61}[a-z0-9]{0,1}\.(xn--)?([a-z0-9\-]{1,61}|[a-z0-9-]{1,30}\.[a-z]{2,})|localhost$/';

    public function __construct(
        string $domainName
    ) {
        $domainName = preg_replace('/ /', '', $domainName);
        $domainName = strtolower($domainName);

        parent::__construct($domainName);
    }

    public function getName(
    ): ?string {
        return preg_split('/(?=\.[^.]+$)/', $this->value)[0] ?? null;
    }

    public function getPretty(
    ): self {
        return new self(
            preg_replace('#^www\d?\.(.+\.)#i', '$1', $this->value)
        );
    }

    public function getExtension(
    ): ?string {
        $parts = explode('.', $this->value);

        return $parts ? end($parts) : null;
    }
}
