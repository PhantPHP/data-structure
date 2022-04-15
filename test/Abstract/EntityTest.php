<?php
declare(strict_types=1);

namespace Test\Abstract;

use Test\Abstract\Fixture\{
	Enum,
	Entity,
	Value,
};

final class EntityTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$entity = new Entity(
			new Value('foo'),
			new Enum(Enum::BAR)
		);
		
		$this->assertIsObject($entity->foo);
		$this->assertIsObject($entity->bar);
		
		$this->assertIsArray($entity->serialize());
		$this->assertArrayHasKey('foo', $entity->serialize());
		$this->assertArrayHasKey('bar', $entity->serialize());
	}
}
