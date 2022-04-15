<?php
declare(strict_types=1);

namespace Test\Person;

use Phant\DataStructure\Person\Person;

use Phant\DataStructure\Person\{
	Firstname,
	Gender,
	Lastname,
};

use Phant\DataStructure\Time\{
	Date,
	DateTime,
};

final class PersonTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$person = new Person(
			new Lastname('DOE'),
			new Firstname('John'),
			new Gender(Gender::MALE),
			new Date('1970-01-01')
		);
		
		$this->assertIsObject($person->lastname);
		$this->assertEquals('DOE', (string)$person->lastname);
		
		$this->assertIsObject($person->firstname);
		$this->assertEquals('John', (string)$person->firstname);
		
		$this->assertIsObject($person->gender);
		$this->assertEquals('Male', (string)$person->gender);
		
		$this->assertIsObject($person->birthday);
		$this->assertEquals('1970-01-01', (string)$person->birthday);
		
		$serialized = $person->serialize();
		$this->assertIsArray($serialized);
		$this->assertArrayHasKey('lastname', $serialized);
		$this->assertArrayHasKey('firstname', $serialized);
		$this->assertArrayHasKey('gender', $serialized);
		$this->assertArrayHasKey('birthday', $serialized);
	}
}
