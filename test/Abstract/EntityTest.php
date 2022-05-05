<?php
declare(strict_types=1);

namespace Test\Abstract;

use Test\Abstract\Fixture\{
	Enum,
	Entity,
	Value,
};

use Phant\Error\NotCompliant;

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
		
		$serialized = $entity->serialize();
		
		$this->assertIsArray($serialized);
		$this->assertArrayHasKey('foo', $serialized);
		$this->assertArrayHasKey('bar', $serialized);
		
		$unserialized = Entity::unserialize($serialized);
		
		$this->assertEquals($entity, $unserialized);
	}
	
	public function testUnserializeNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		Entity::unserialize([ 'foo' => 'bar' ]);
	}
}
