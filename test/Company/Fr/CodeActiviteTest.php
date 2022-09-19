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
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new CodeActivite('A0A0A');
	}
}
