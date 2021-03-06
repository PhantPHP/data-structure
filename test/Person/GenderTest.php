<?php
declare(strict_types=1);

namespace Test\Person;

use Phant\DataStructure\Person\Gender;

use Phant\Error\NotCompliant;

final class GenderTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$gender = new Gender(Gender::FEMALE);
		
		$this->assertEquals('Female', (string)$gender);
		
		$this->assertIsString($gender->getValue());
		$this->assertEquals('female', $gender->getValue());
		
		$this->assertIsString($gender->getLabel());
		$this->assertEquals('Female', $gender->getLabel());
			
		$serialized = $gender->serialize();
		
		$this->assertIsArray($serialized);
		$this->assertEquals([
				'value' => 'female',
				'label' => 'Female',
			], $serialized);
		
		$unserialized = Gender::unserialize($serialized);
		
		$this->assertEquals($gender, $unserialized);
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new Gender('alien');
	}
}
