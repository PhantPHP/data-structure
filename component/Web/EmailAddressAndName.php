<?php

declare(strict_types=1);

namespace Phant\DataStructure\Web;

readonly class EmailAddressAndName
{
    public function __construct(
        public EmailAddress $emailAddress,
        public ?string $name
    ) {
    }

    public static function make(
        string $emailAddress,
        ?string $name = null
    ): self {
        return new static(
            new EmailAddress($emailAddress),
            !is_null($name) ? trim($name) : null
        );
    }
}
