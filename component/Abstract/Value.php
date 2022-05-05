<?php
declare(strict_types=1);

namespace Phant\DataStructure\Abstract;

abstract class Value implements \Phant\DataStructure\Abstract\Interface\DataStructure
{
	//protected $value;

	public function __construct($value)
	{
		if (property_exists($this, 'value')) {
			$this->value = $value;
		}
	}

	public function __toString(): string
	{
		return (string) $this->get();
	}

	public function get(): mixed
	{
		return property_exists($this, 'value') ? $this->value : null;
	}

	public function serialize(): mixed
	{
		return $this->get();
	}
	
	public static function unserialize(mixed $value): self
	{
		return new static($value);
	}
	
	protected static function addNonBreakingSpace(string $value): string
	{
		return str_replace(' ', "\xC2\xA0", $value);
	}
}
