<?php
declare(strict_types=1);

namespace Phant\DataStructure\Geography\Fr;

final class NumeroDepartement extends \Phant\DataStructure\Abstract\Value\Varchar
{
	const PATTERN = '/^(9[7-8][0-9])|([0-9]{2})|(2[AB])$/';
	
	public function __construct(string $numero)
	{
		$numero = trim($numero);
		if (strlen($numero) == 1) {
			$numero = str_pad($numero, 2, '0', STR_PAD_LEFT);
		}
		$numero = strtoupper($numero);
		
		parent::__construct($numero);
	}
}
