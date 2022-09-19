<?php
declare(strict_types=1);

namespace Phant\DataStructure\Person;

use Phant\DataStructure\Person\{
	Firstname,
	Gender,
	Lastname,
};

use Phant\DataStructure\Time\{
	Date,
	DateTime,
};

use Phant\Error\NotCompliant;

class Person extends \Phant\DataStructure\Abstract\Entity
{
	public ?Lastname $lastname;
	public ?Firstname $firstname;
	public ?Gender $gender;
	public ?Date $birthday;
	
	public function __construct(
		null|string|Lastname $lastname,
		null|string|Firstname $firstname,
		null|string|Gender $gender = null,
		null|string|Date $birthday = null
	)
	{
		if (is_string($lastname)) {
			$lastname = new Lastname($lastname);
		}
		
		if (is_string($firstname)) {
			$firstname = new Firstname($firstname);
		}
		
		if (is_string($gender)) {
			$gender = new Gender($gender);
		}
		
		if (is_string($birthday)) {
			$birthday = new Date($birthday);
		}
		
		$this->lastname = $lastname;
		$this->firstname = $firstname;
		$this->gender = $gender;
		$this->birthday = $birthday;
	}
}
