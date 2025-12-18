<?php

declare(strict_types=1);

namespace Phant\DataStructure\Web\UserAgent;

readonly class Browser
{
    public function __construct(
        public BrowserFamily $family,
        public Version $version
    ) {
    }
}
