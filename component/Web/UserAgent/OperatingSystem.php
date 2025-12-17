<?php

declare(strict_types=1);

namespace Phant\DataStructure\Web\UserAgent;

readonly class OperatingSystem
{
    public function __construct(
        public OperatingSystemFamily $family,
        public Version $version
    ) {
    }
}
