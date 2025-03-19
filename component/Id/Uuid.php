<?php

declare(strict_types=1);

namespace Phant\DataStructure\Id;

use Phant\Error\NotCompliant;
use Ramsey\Uuid\Uuid as UuidBuilder;
use Ramsey\Uuid\Exception\InvalidUuidStringException;

class Uuid extends \Phant\DataStructure\Abstract\Value\Varchar
{
    public const PATTERN = '/[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}/';

    final public function __construct(
        string $uuid
    ) {
        try {
            $uuid = UuidBuilder::fromString($uuid)->ToString();
        } catch (InvalidUuidStringException $e) {
            throw new NotCompliant();
        }

        parent::__construct($uuid);
    }

    public static function generate(
    ): self {
        return new static(UuidBuilder::Uuid4()->ToString());
    }
}
