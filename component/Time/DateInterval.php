<?php

declare(strict_types=1);

namespace Phant\DataStructure\Time;

use Phant\DataStructure\Time\Date;

class DateInterval extends DateTimeInterval
{
    public function __construct(
        ?Date $from,
        ?Date $to
    ) {
        parent::__construct(
            $from,
            $to
        );
    }

    public static function make(
        null|int|string $from,
        null|int|string $to
    ): static {
        if (is_string($from) || is_int($from)) {
            $from = new Date($from);
        }

        if (is_string($to) || is_int($to)) {
            $to = new Date($to);
        }

        return new static(
            $from,
            $to
        );
    }
}
