<?php
declare(strict_types=1);

namespace Test\Geography\Fr;

use Phant\DataStructure\Geography\Fr\CodePostal;

use Phant\Error\NotCompliant;

final class CodePostalTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$codePostal = new CodePostal('69001');
		
		$this->assertEquals('69001', (string)$codePostal);
		
		$this->assertIsString($codePostal->get());
		$this->assertEquals('69001', $codePostal->get());
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new CodePostal('690I');
	}
}
