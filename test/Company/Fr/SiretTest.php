<?php
declare(strict_types=1);

namespace Test\Company\Fr;

use Phant\DataStructure\Company\Fr\Siret;

use Phant\Error\NotCompliant;

final class SiretTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$siret = new Siret('51274739500022');
		
		$this->assertEquals('51274739500022', (string)$siret);
		
		$this->assertIsString($siret->get());
		$this->assertEquals('51274739500022', $siret->get());
		
		$this->assertIsObject($siret->getSiren());
		$this->assertEquals('512747395', (string)$siret->getSiren());
		
		$this->assertIsString($siret->getFormatted());
		$this->assertEquals('512 747 395 00022', $siret->getFormatted());
	}
	
	public function testCheckLaPoste(): void
	{
		$siret = new Siret('35600000000074');
		$this->assertEquals('35600000000074', (string)$siret);
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new Siret('12345678901234');
	}
}
