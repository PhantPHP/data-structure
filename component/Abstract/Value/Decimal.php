<?php
declare(strict_types=1);

namespace Phant\DataStructure\Abstract\Value;

abstract class Decimal extends \Phant\DataStructure\Abstract\Value
{
	protected float $value;
	
	public function __construct(float $value)
	{
		parent::__construct($value);
	}

	public function get(): float
	{
		return parent::get();
	}
}
