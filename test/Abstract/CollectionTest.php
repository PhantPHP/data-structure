<?php
declare(strict_types=1);

namespace Test\Abstract;

use Test\Abstract\Fixture\{
	Collection,
	Value,
};

final class CollectionTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$collection = new Collection();
		
		$this->assertIsBool($collection->isEmpty());
		$this->assertEquals(true, $collection->isEmpty());
		
		$this->assertIsInt($collection->getNbItems());
		$this->assertEquals(0, $collection->getNbItems());
		
		$collection->addValue(
			new Value('Foo')
		);
		
		$this->assertEquals(false, $collection->isEmpty());
		$this->assertEquals(1, $collection->getNbItems());
		
		$this->assertIsObject($collection->getByKey(0));
		
		foreach ($collection->itemsIterator() as $item) {
			$this->assertIsObject($item);
		}
		
		$collection->removeValue(
			new Value('Foo')
		);
		
		$this->assertEquals(true, $collection->isEmpty());
		$this->assertEquals(0, $collection->getNbItems());
		
		$collection->addValue(
			new Value('Bar')
		);
	}
}
