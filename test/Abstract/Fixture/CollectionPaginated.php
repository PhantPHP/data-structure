<?php
declare(strict_types=1);

namespace Test\Abstract\Fixture;

use Test\Abstract\Fixture\Value;

class CollectionPaginated extends \Phant\DataStructure\Abstract\CollectionPaginated
{
	public function addValue(Value $item)
	{
		parent::addItem($item);
	}
	
	public function removeValue(Value $item): self
	{
		return parent::removeItem($item);
	}
}
