<?php
declare(strict_types=1);

namespace Test\Abstract\Fixture;

use Test\Abstract\Fixture\Value;

class Collection extends \Phant\DataStructure\Abstract\Collection
{
	public function addValue(Value $item)
	{
		parent::addItem($item);
	}
	
	public function removeValue(Value $item): self
	{
		return parent::removeItem($item);
	}
	
	public static function unserialize(array $array): self
	{
		$collection = new self();
		
		foreach ($array as $item) {
			$collection->addValue(
				Value::unserialize($item)
			);
		}
		
		return $collection;
	}
}
