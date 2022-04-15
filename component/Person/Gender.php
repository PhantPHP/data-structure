<?php
declare(strict_types=1);

namespace Phant\DataStructure\Person;

class Gender extends \Phant\DataStructure\Abstract\Enum
{
	const FEMALE = 'female';
	const MALE = 'male';
	
	const VALUES = [
		self::FEMALE	=> 'Female',
		self::MALE		=> 'Male',
	];
}
