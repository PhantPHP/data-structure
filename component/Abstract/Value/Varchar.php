<?php
declare(strict_types=1);

namespace Phant\DataStructure\Abstract\Value;

use Phant\Error\NotCompliant;

abstract class Varchar extends \Phant\DataStructure\Abstract\Value
{
	const PATTERN = null;
	
	protected string $value;
	
	public function __construct(string $value)
	{
		if (defined(get_class($this) . '::PATTERN') && static::PATTERN && !preg_match(static::PATTERN, $value)) {
			throw new NotCompliant('Value : ' . $value);
		}
		
		parent::__construct($value);
	}

	public function get(): string
	{
		return parent::get();
	}
}
