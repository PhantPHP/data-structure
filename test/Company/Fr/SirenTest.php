<?php
declare(strict_types=1);

namespace Test\Company\Fr;

use Phant\DataStructure\Company\Fr\Siren;

use Phant\Error\NotCompliant;

final class SirenTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$siren = new Siren('512747395');
		
		$this->assertEquals('512747395', (string)$siren);
		
		$this->assertIsString($siren->get());
		$this->assertEquals('512747395', $siren->get());
		
		$this->assertIsString($siren->getFormatted());
		$this->assertEquals('512 747 395', $siren->getFormatted());
		
		$this->assertIsString($siren->serialize());
		$this->assertEquals('512747395', $siren->serialize());
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new Siren('123456789');
	}
}
