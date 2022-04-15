<?php
declare(strict_types=1);

namespace Phant\DataStructure\Abstract\Value;

abstract class Boolean extends \Phant\DataStructure\Abstract\Value
{
	protected bool $value;
	
	public function __construct(bool $value)
	{
		parent::__construct($value);
	}

	public function get(): bool
	{
		return parent::get();
	}
}
