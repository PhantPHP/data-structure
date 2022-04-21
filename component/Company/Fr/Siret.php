<?php
declare(strict_types=1);

namespace Phant\DataStructure\Company\Fr;

use Phant\DataStructure\Company\Fr\Siren;

use Phant\Error\NotCompliant;

class Siret extends \Phant\DataStructure\Abstract\Value\Varchar
{
	const PATTERN = '/^(\d{14})$/';
	
	public function __construct(string $siret, bool $check = true)
	{
		$siret = preg_replace('/\D/', '', $siret);
		
		if ($check && !self::luhnCheck($siret)) {
			throw new NotCompliant('Siret : ' . $siret);
		}
		
		parent::__construct($siret);
	}
	
	public function getSiren(): Siren
	{
		return new Siren(substr($this->value, 0, 9));
	}
	
	public static function luhnCheck(string $value): bool
	{
		$sum = 0;
		$flag = 0;
		
		for ($i = strlen($value) - 1; $i >= 0; $i--) {
			$add = $flag++ & 1 ? $value[$i] * 2 : $value[$i];
			$sum += $add > 9 ? $add - 9 : $add;
		}
		
		return $sum % 10 === 0;
	}
}
