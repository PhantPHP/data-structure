<?php
declare(strict_types=1);

namespace Test\Web;

use Phant\DataStructure\Web\{
	EmailAddressAndName,
	EmailAddress,
};

final class EmailAddressAndNameTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$emailAddressAndName = new EmailAddressAndName(
			new EmailAddress('john.doe@domain.ext'),
			'John DOE'
		);
		
		$this->assertIsObject($emailAddressAndName->getEmailAddress());
		$this->assertEquals('john.doe@domain.ext', (string)$emailAddressAndName->getEmailAddress());
		
		$this->assertIsString($emailAddressAndName->getName());
		$this->assertEquals('John DOE', $emailAddressAndName->getName());
		
		$this->assertIsArray($emailAddressAndName->serialize());
		$this->assertEquals([
				'email_address' => 'john.doe@domain.ext',
				'name' => 'John DOE',
			], $emailAddressAndName->serialize());
	}
}
