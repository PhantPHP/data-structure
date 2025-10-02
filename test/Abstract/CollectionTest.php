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

    public function testMerge(): void
    {
        $value1 = new Value('Foo');
        $value2 = new Value('Bar');

        $collection1 = new Collection();
        $collection1->add($value1);

        $collection2 = new Collection();
        $collection2->add($value2);

        $collection1->merge($collection2);

        $this->assertEquals(true, $collection1->contains($value1));
        $this->assertEquals(true, $collection1->contains($value2));
    }

    public function testMap(): void
    {
        $value1 = new Value('Foo');
        $value2 = new Value('Bar');

        $collection = new Collection();
        $collection->add($value1);
        $collection->add($value2);

        $result = $collection->map(fn(Value $item) => (string)$item . '!');

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals('Foo!', $result[0]);
        $this->assertEquals('Bar!', $result[1]);
    }
}
