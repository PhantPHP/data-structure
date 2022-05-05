<?php
declare(strict_types=1);

namespace Test\Web;

use Phant\DataStructure\Web\{
	DomainName,
	EmailAddress,
	UserName,
};

use Phant\Error\NotCompliant;

final class EmailAddressTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$emailAddress = new EmailAddress('username@domain.ext');
		
		$this->assertEquals('username@domain.ext', (string)$emailAddress);
		
		$this->assertIsString($emailAddress->get());
		$this->assertEquals('username@domain.ext', $emailAddress->get());
		
		$this->assertIsObject($emailAddress->getUserName());
		$this->assertEquals('username', (string)$emailAddress->getUserName());
		
		$this->assertIsObject($emailAddress->getDomainName());
		$this->assertEquals('domain.ext', (string)$emailAddress->getDomainName());
		
		$serialized = $emailAddress->serialize();
		
		$this->assertIsString($serialized);
		$this->assertEquals('username@domain.ext', $serialized);
		
		$unserialized = EmailAddress::unserialize($serialized);
		
		$this->assertEquals($emailAddress, $unserialized);
	}
	
	public function testBuild(): void
	{
		$emailAddress = EmailAddress::build(
			new UserName('username'),
			new DomainName('domain.ext')
		);
		
		$this->assertIsObject($emailAddress);
		$this->assertEquals('username@domain.ext', (string)$emailAddress);
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new EmailAddress('username@domain-ext');
	}
}
