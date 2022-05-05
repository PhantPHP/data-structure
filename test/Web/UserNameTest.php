<?php
declare(strict_types=1);

namespace Test\Web;

use Phant\DataStructure\Web\UserName;

use Phant\Error\NotCompliant;

final class UserNameTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$userName = new UserName('username');
		
		$this->assertEquals('username', (string)$userName);
		
		$this->assertIsString($userName->get());
		$this->assertEquals('username', $userName->get());
		
		$serialized = $userName->serialize();
		
		$this->assertIsString($serialized);
		$this->assertEquals('username', $serialized);
		
		$unserialized = UserName::unserialize($serialized);
		
		$this->assertEquals($userName, $unserialized);
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new UserName('user@name');
	}
}
