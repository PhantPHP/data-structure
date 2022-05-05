<?php
declare(strict_types=1);

namespace Test\Abstract\Fixture;

use Test\Abstract\Fixture\{
	Enum,
	Value,
};

use Phant\Error\NotCompliant;

class Entity extends \Phant\DataStructure\Abstract\Entity
{
	public Value $foo;
	public ?Enum $bar;
	
	public function __construct(Value $foo, ?Enum $bar = null)
	{
		$this->foo = $foo;
		$this->bar = $bar;
	}
	
	public function serialize(): array
	{
		return [
			'foo'	=> $this->foo->serialize(),
			'bar'	=> $this->bar ? $this->bar->serialize() : null,
		];
	}
	
	public static function unserialize(array $serialized): self
	{
		if (!isset(
			$serialized[ 'foo' ],
			$serialized[ 'bar' ]
		)) {
			throw new NotCompliant();
		}
		
		return new self(
			Value::unserialize($serialized[ 'foo' ]),
			!is_null($serialized[ 'bar' ]) ? Enum::unserialize($serialized[ 'bar' ]) : null
		);
	}
}
