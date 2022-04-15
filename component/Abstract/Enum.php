<?php
declare(strict_types=1);

namespace Phant\DataStructure\Abstract;

use Phant\Error\NotCompliant;

abstract class Enum implements \Phant\DataStructure\Abstract\Interface\DataStructure
{
	public const VALUE_KEY = 'value';
	public const LABEL_KEY = 'label';
	
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

	public function serialize(): array
	{
		return [
			static::VALUE_KEY => $this->value,
			static::LABEL_KEY => (string) $this->label,
		];
	}
}
