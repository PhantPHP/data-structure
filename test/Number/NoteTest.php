<?php
declare(strict_types=1);

namespace Test\Number;

use Phant\DataStructure\Number\Note;

use Phant\Error\NotCompliant;

final class NoteTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$note = new Note(8, 10);
		
		$this->assertEquals('8/10', (string)$note);
		
		$this->assertIsInt($note->getNote());
		$this->assertEquals(8, $note->getNote());
		
		$this->assertIsInt($note->getUnit());
		$this->assertEquals(10, $note->getUnit());
	}
	
	public function testNotCompliantNote(): void
	{
		$this->expectException(NotCompliant::class);
		
		new Note(-2, 10);
	}
	
	public function testNotCompliantUnit(): void
	{
		$this->expectException(NotCompliant::class);
		
		new Note(2, -3);
	}
}
