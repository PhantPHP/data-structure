<?php

declare(strict_types=1);

namespace Phant\DataStructure\Number;

class Rate extends \Phant\DataStructure\Abstract\Value\Decimal
{
    public function __toString(
    ) {
        return str_replace(' ', "\xC2\xA0", $this->value . ' %');
    }
}
