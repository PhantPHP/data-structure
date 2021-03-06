<?php
declare(strict_types=1);

namespace Test\Web;

use Phant\DataStructure\Web\EmailAddressAndName;

use Phant\Error\NotCompliant;

final class EmailAddressAndNameTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$emailAddressAndName = new EmailAddressAndName(
			'john.doe@domain.ext',
			'John DOE'
		);
		
		$this->assertIsObject($emailAddressAndName->getEmailAddress());
		$this->assertEquals('john.doe@domain.ext', (string)$emailAddressAndName->getEmailAddress());
		
		$this->assertIsString($emailAddressAndName->getName());
		$this->assertEquals('John DOE', $emailAddressAndName->getName());
		
		$serialized = $emailAddressAndName->serialize();
		
		$this->assertIsArray($serialized);
		$this->assertEquals([
				'email_address' => 'john.doe@domain.ext',
				'name' => 'John DOE',
			], $serialized);
		
		$unserialized = EmailAddressAndName::unserialize($serialized);
		
		$this->assertEquals($emailAddressAndName, $unserialized);
	}
	
	public function testUnserializeNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		EmailAddressAndName::unserialize([ 'foo' => 'bar' ]);
	}
}
