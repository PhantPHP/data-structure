<?php

declare(strict_types=1);

namespace Phant\DataStructure\Web\UserAgent;

class Browser
{
    public function __construct(
        public readonly BrowserFamily $family,
        public readonly Version $version
    ) {
    }
}
