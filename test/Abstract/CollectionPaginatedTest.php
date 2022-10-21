<?php

declare(strict_types=1);

namespace Test\Abstract;

use Test\Abstract\Fixture\CollectionPaginated;
use Test\Abstract\Fixture\Value\Varchar as Value;

use Phant\Error\NotCompliant;

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

        $this->assertIsInt($collection->getItemByPage());
        $this->assertEquals(2, $collection->getItemByPage());

        $this->assertIsInt($collection->getItemTotal());
        $this->assertEquals(3, $collection->getItemTotal());

        $this->assertIsInt($collection->getItemPage());
        $this->assertEquals(2, $collection->getItemPage());

        $this->assertIsInt($collection->getPageCurrent());
        $this->assertEquals(1, $collection->getPageCurrent());

        $this->assertIsInt($collection->getPageTotal());
        $this->assertEquals(2, $collection->getPageTotal());

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
    }
}
