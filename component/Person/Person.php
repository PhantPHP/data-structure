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
	
	public function serialize(): array
	{
		return [
			'lastname'	=> $this->lastname ? $this->lastname->serialize() : null,
			'firstname'	=> $this->firstname ? $this->firstname->serialize() : null,
			'gender'	=> $this->gender ? $this->gender->serialize() : null,
			'birthday'	=> $this->birthday ? $this->birthday->serialize() : null,
		];
	}
	
	public static function unserialize(array $serialized): self
	{
		if (!isset(
			$serialized[ 'lastname' ],
			$serialized[ 'firstname' ],
			$serialized[ 'gender' ],
			$serialized[ 'birthday' ]
		)) {
			throw new NotCompliant();
		}
		
		return new self(
			!is_null($serialized[ 'lastname' ]) ? Lastname::unserialize($serialized[ 'lastname' ]) : null,
			!is_null($serialized[ 'firstname' ]) ? Firstname::unserialize($serialized[ 'firstname' ]) : null,
			!is_null($serialized[ 'gender' ]) ? Gender::unserialize($serialized[ 'gender' ]) : null,
			!is_null($serialized[ 'birthday' ]) ? Date::unserialize($serialized[ 'birthday' ]) : null
		);
	}
}
