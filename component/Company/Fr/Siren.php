<?php
declare(strict_types=1);

namespace Phant\DataStructure\Company\Fr;

final class Siren extends \Phant\DataStructure\Abstract\Value\Varchar
{
	const PATTERN = '/^(\d{9})$/';
	
	public function __construct(string $siren)
	{
		$siren = preg_replace('/\D/', '', $siren);
		
		parent::__construct($siren);
	}
}
