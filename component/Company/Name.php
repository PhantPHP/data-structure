<?php
declare(strict_types=1);

namespace Phant\DataStructure\Company;

class Name extends \Phant\DataStructure\Abstract\Value\Varchar
{
	public function __construct(string $name)
	{
		$name = strtoupper($name);
		
		parent::__construct($name);
	}
}
