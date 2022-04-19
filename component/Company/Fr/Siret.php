<?php
declare(strict_types=1);

namespace Phant\DataStructure\Company\Fr;

final class Siret extends \Phant\DataStructure\Abstract\Value\Varchar
{
	const PATTERN = '/^(\d{14})$/';
	
	public function __construct(string $siret)
	{
		$siret = preg_replace('/\D/', '', $siret);
		
		parent::__construct($siret);
	}
	
	public function getSiren(): Siren
	{
		return new Siren(substr($this->value, 0, 9));
	}
}
