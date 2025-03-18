<?php

declare(strict_types=1);

namespace Test\Abstract;

use Test\Abstract\Fixture\Collection;
use Test\Abstract\Fixture\Value\Varchar as Value;

final class CollectionTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $value = new Value('Foo');

        $collection = new Collection();

        $this->assertIsBool($collection->isEmpty());
        $this->assertEquals(true, $collection->isEmpty());

        $this->assertIsInt($collection->getNbItems());
        $this->assertEquals(0, $collection->getNbItems());

        $this->assertEquals(false, $collection->contains($value));

        $collection->add(
            $value
        );

        $this->assertEquals(true, $collection->contains($value));

        $this->assertEquals(false, $collection->isEmpty());
        $this->assertEquals(1, $collection->getNbItems());

        $this->assertIsObject($collection->getByKey(0));

        foreach ($collection->iterate() as $item) {
            $this->assertIsObject($item);
        }

        $collection->remove(
            $value
        );

        $this->assertEquals(true, $collection->isEmpty());
        $this->assertEquals(0, $collection->getNbItems());

        $collection->add(
            $value
        );
    }
}
