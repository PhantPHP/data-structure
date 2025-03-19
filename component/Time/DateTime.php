<?php

declare(strict_types=1);

namespace Phant\DataStructure\Time;

use Phant\Error\NotCompliant;

class DateTime extends \Phant\DataStructure\Time\Date
{
    public function __construct(
        int|string $date,
        string $format = 'Y-m-d H:i:s'
    ) {
        if (is_string($date) && strtolower($date) == 'now') {
            $date = strtotime('now');
        }

        parent::__construct($date, $format);
    }

    public function getUtc(
    ): string {
        return gmdate('Y-m-d\TH:i:s\Z', $this->time + date('Z', $this->time));
    }
}
