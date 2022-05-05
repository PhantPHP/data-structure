<?php
declare(strict_types=1);

namespace Phant\DataStructure\Number;

use Phant\Error\NotCompliant;

class Note extends \Phant\DataStructure\Abstract\Aggregate
{
	private int $note;
	private int $unit;
	
	public function __construct(int $note, int $unit)
	{
		if ($note < 0) {
			throw new NotCompliant('Note : ' . $note);
		}
		
		if ($unit < 0) {
			throw new NotCompliant('Unit : ' . $unit);
		}
		
		$this->note = $note;
		$this->unit = $unit;
	}
	
	public function __toString(): string
	{
		return $this->note . '/' . $this->unit;
	}

	public function getNote(): int
	{
		return $this->note;
	}

	public function getUnit(): int
	{
		return $this->unit;
	}
	
	public function serialize(): array
	{
		return [
			'note'	=> $this->note,
			'unit'	=> $this->unit,
		];
	}
	
	public static function unserialize(array $serialized): self
	{
		if (!( array_key_exists('note', $serialized)
			&& array_key_exists('unit', $serialized)
		)) {
			throw new NotCompliant();
		}
		
		return new static($serialized[ 'note' ], $serialized[ 'unit' ]);
	}
}
