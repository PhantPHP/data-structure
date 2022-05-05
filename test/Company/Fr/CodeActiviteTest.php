<?php
declare(strict_types=1);

namespace Test\Company\Fr;

use Phant\DataStructure\Company\Fr\CodeActivite;

use Phant\Error\NotCompliant;

final class CodeActiviteTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$codeActivite = new CodeActivite('62.01Z');
		
		$this->assertEquals('62.01Z', (string)$codeActivite);
		
		$this->assertIsString($codeActivite->get());
		$this->assertEquals('62.01Z', $codeActivite->get());
		
		$serialized = $codeActivite->serialize();
		
		$this->assertIsString($serialized);
		$this->assertEquals('62.01Z', $serialized);
		
		$unserialized = CodeActivite::unserialize($serialized);
		
		$this->assertEquals($codeActivite, $unserialized);
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new CodeActivite('A0A0A');
	}
}
