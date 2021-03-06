<?php
declare(strict_types=1);

namespace Test\Abstract;

use Test\Abstract\Fixture\Aggregate;

use Phant\Error\NotCompliant;

final class AggregateTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$aggregate = new Aggregate('foo', true);
		
		$this->assertEquals('foo : OK', (string)$aggregate);
		
		$this->assertIsString($aggregate->getFoo());
		$this->assertEquals('foo', $aggregate->getFoo());
		
		$this->assertIsBool($aggregate->getBar());
		$this->assertEquals(true, $aggregate->getBar());
		
		$serialized = $aggregate->serialize();
		
		$this->assertIsArray($serialized);
		$this->assertEquals([
				'foo'	=> 'foo',
				'bar'	=> true,
			], $serialized);
		
		$unserialized = Aggregate::unserialize($serialized);
		
		$this->assertEquals($aggregate, $unserialized);
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new Aggregate('', true);
	}
	
	public function testUnserializeNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		Aggregate::unserialize([ 'foo' => 'bar' ]);
	}
}
