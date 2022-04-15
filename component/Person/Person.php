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

class Person extends \Phant\DataStructure\Abstract\Entity
{
	public ?Lastname $lastname;
	public ?Firstname $firstname;
	public ?Gender $gender;
	public ?Date $birthday;
	
	public function __construct(
		?Lastname $lastname,
		?Firstname $firstname,
		?Gender $gender = null,
		?Date $birthday = null
	)
	{
		$this->lastname = $lastname;
		$this->firstname = $firstname;
		$this->gender = $gender;
		$this->birthday = $birthday;
	}
	
	public function serialize(): array
	{
		return [
			'lastname'	=> $this->lastname ? $this->lastname->serialize() : null,
			'firstname'	=> $this->firstname ? $this->firstname->serialize() : null,
			'gender'	=> $this->gender ? $this->gender->serialize() : null,
			'birthday'	=> $this->birthday ? $this->birthday->serialize() : null,
		];
	}
}
