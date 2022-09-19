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
}
