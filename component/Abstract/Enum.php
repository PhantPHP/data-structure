<?php
declare(strict_types=1);

namespace Phant\DataStructure\Abstract;

use Phant\Error\NotCompliant;

abstract class Enum
{
	public const VALUES = [];

	protected mixed $value;
	protected string $label;

	public function __construct(mixed $value)
	{
		if (!isset(static::VALUES[$value])) {
			throw new NotCompliant();
		}
		$this->value = $value;
		$this->label = static::VALUES[$value];
	}

	public function __toString()
	{
		return (string) $this->label;
	}
		
	public function getValue(): mixed
	{
		return $this->value;
	}
	
	public function getLabel(): mixed
	{
		return $this->label;
	}
}
