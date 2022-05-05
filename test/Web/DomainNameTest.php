<?php
declare(strict_types=1);

namespace Test\Web;

use Phant\DataStructure\Web\DomainName;

use Phant\Error\NotCompliant;

final class DomainNameTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$domainName = new DomainName('www.domain.ext');
		
		$this->assertEquals('www.domain.ext', (string)$domainName);
		
		$this->assertIsString($domainName->get());
		$this->assertEquals('www.domain.ext', $domainName->get());
		
		$this->assertIsString($domainName->getName());
		$this->assertEquals('www.domain', $domainName->getName());
		
		$this->assertIsObject($domainName->getPretty());
		$this->assertEquals('domain.ext', $domainName->getPretty()->get());
		
		$this->assertIsString($domainName->getExtension());
		$this->assertEquals('ext', $domainName->getExtension());
		
		$serialized = $domainName->serialize();
		
		$this->assertIsString($serialized);
		$this->assertEquals('www.domain.ext', $serialized);
		
		$unserialized = DomainName::unserialize($serialized);
		
		$this->assertEquals($domainName, $unserialized);
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new DomainName('domain');
	}
}
