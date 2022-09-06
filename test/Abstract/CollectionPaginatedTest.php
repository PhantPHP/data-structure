<?php
declare(strict_types=1);

namespace Test\Abstract;

use Test\Abstract\Fixture\{
	CollectionPaginated,
	Value,
};

final class CollectionPaginatedTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$collection = new CollectionPaginated(
			1,
			2,
			3
		);
		
		$this->assertIsBool($collection->isEmpty());
		$this->assertEquals(true, $collection->isEmpty());
		
		$this->assertIsInt($collection->getNbItems());
		$this->assertEquals(0, $collection->getNbItems());
		
		$collection->addValue(
			new Value('Foo')
		);
		
		$this->assertEquals(false, $collection->isEmpty());
		$this->assertEquals(1, $collection->getNbItems());
		
		$collection->addValue(
			new Value('Bar')
		);
		
		$this->assertEquals(false, $collection->isEmpty());
		$this->assertEquals(2, $collection->getNbItems());
		
		$this->assertIsObject($collection->getByKey(0));
		
		foreach ($collection->itemsIterator() as $item) {
			$this->assertIsObject($item);
		}
		
		$collection->removeValue(
			new Value('Foo')
		);
		
		$this->assertEquals(false, $collection->isEmpty());
		$this->assertEquals(1, $collection->getNbItems());
		
		$collection->addValue(
			new Value('Foo')
		);
		
		$this->assertEquals(false, $collection->isEmpty());
		$this->assertEquals(2, $collection->getNbItems());
		
		$serialized = $collection->serialize();
		
		$this->assertIsArray($serialized);
		$this->assertEquals([
			'items' => [
				'Bar',
				'Foo',
			],
			'pagination' => [
				'item' => [
					'page'		=> 2,
					'by_page'	=> 2,
					'total'		=> 3,
				],
				'page' => [
					'current'	=> 1,
					'total'		=> 2,
				],
			]
		], $serialized);
		
		$unserialized = CollectionPaginated::unserialize($serialized);
		
		$this->assertEquals($collection, $unserialized);
	}
}
