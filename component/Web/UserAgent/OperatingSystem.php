<?php

declare(strict_types=1);

namespace Phant\DataStructure\Web\UserAgent;

class OperatingSystem
{
    public function __construct(
        public readonly OperatingSystemFamily $family,
        public readonly Version $version
    ) {
    }
}
