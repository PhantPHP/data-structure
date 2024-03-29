<?php

declare(strict_types=1);

namespace Test\Abstract\Fixture;

use Test\Abstract\Fixture\Value\Varchar as Value;

class Collection extends \Phant\DataStructure\Abstract\Collection
{
    public function add(Value $item)
    {
        parent::addItem($item);
    }

    public function remove(Value $item): self
    {
        return parent::removeItem($item);
    }
}
