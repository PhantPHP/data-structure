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
	
	public static function unserialize(array $array): self
	{
		if (!isset(
			$array[ 'lastname' ],
			$array[ 'firstname' ],
			$array[ 'gender' ],
			$array[ 'birthday' ]
		)) {
			throw new NotCompliant();
		}
		
		return new self(
			!is_null($array[ 'lastname' ]) ? Lastname::unserialize($array[ 'lastname' ]) : null,
			!is_null($array[ 'firstname' ]) ? Firstname::unserialize($array[ 'firstname' ]) : null,
			!is_null($array[ 'gender' ]) ? Gender::unserialize($array[ 'gender' ]) : null,
			!is_null($array[ 'birthday' ]) ? Date::unserialize($array[ 'birthday' ]) : null
		);
	}
}
