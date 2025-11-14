<?php

declare(strict_types=1);

namespace Phant\DataStructure\Web\UserAgent;

class Browser
{
    public function __construct(
        public readonly BrowserFamily $familiy,
        public readonly Version $version
    ) {
    }
}
