<?php

declare(strict_types=1);

namespace Phant\DataStructure\Web;

readonly class EmailAttachment
{
    final public function __construct(
        public string $name,
        public string $content,
        public string $type
    ) {
    }
}
