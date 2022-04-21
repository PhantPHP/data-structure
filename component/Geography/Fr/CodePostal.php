<?php
declare(strict_types=1);

namespace Phant\DataStructure\Geography\Fr;

class CodePostal extends \Phant\DataStructure\Abstract\Value\Varchar
{
	const PATTERN = '/^(\d{5})$/';
	
	public function __construct(string $code)
	{
		$code = trim($code);
		if (strlen($code) == 4) {
			$code = str_pad($code, 5, '0', STR_PAD_LEFT);
		}
		
		parent::__construct($code);
	}
}
