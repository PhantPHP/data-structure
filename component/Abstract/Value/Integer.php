<?php
declare(strict_types=1);

namespace Phant\DataStructure\Abstract\Value;

abstract class Integer extends \Phant\DataStructure\Abstract\Value
{
	protected int $value;
	
	public function __construct(int $value)
	{
		parent::__construct($value);
	}

	public function get(): int
	{
		return parent::get();
	}
}
