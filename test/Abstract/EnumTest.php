<?php
declare(strict_types=1);

namespace Test\Abstract;

use Test\Abstract\Fixture\Enum;

use Phant\Error\NotCompliant;

final class EnumTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$enum = new Enum(Enum::BAR);
		
		$this->assertEquals(Enum::VALUES[ Enum::BAR ], (string)$enum);
		
		$this->assertIsString($enum->getValue());
		$this->assertEquals(Enum::BAR, $enum->getValue());
		
		$this->assertIsString($enum->getLabel());
		$this->assertEquals(Enum::VALUES[ Enum::BAR ], $enum->getLabel());
		
		$serialized = $enum->serialize();
		
		$this->assertIsArray($serialized);
		$this->assertEquals([
				'value'	=> Enum::BAR,
				'label'	=> Enum::VALUES[ Enum::BAR ],
			], $serialized);
		
		$unserialized = Enum::unserialize($serialized);
		
		$this->assertEquals($enum, $unserialized);
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new Enum('unknown');
	}
	
	public function testUnserializeNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		Enum::unserialize([ 'foo' => 'bar' ]);
	}
}
