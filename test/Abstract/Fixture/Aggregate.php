<?php
declare(strict_types=1);

namespace Test\Abstract\Fixture;

use Phant\Error\NotCompliant;

class Aggregate extends \Phant\DataStructure\Abstract\Aggregate
{
	private string $foo;
	private bool $bar;
	
	public function __construct(string $foo, bool $bar)
	{
		if (!$foo) {
			throw new NotCompliant();
		}
		
		$this->foo = $foo;
		$this->bar = $bar;
	}
	
	public function getFoo(): string
	{
		return $this->foo;
	}
	
	public function getBar(): bool
	{
		return $this->bar;
	}

	public function __toString(): string
	{
		return (string) $this->foo . ' : ' . ($this->bar ? 'OK' : 'KO');
	}
	
	public function serialize(): array
	{
		return [
			'foo'	=> $this->foo,
			'bar'	=> $this->bar,
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
			$serialized[ 'foo' ],
			$serialized[ 'bar' ]
		);
	}
}
