<?php
declare(strict_types=1);

namespace App\Domain\Fr\Organisation\DataStructure\Value;

class Note extends \Phant\DataStructure\Abstract\Aggregate
{
	private int $note;
	private int $unit;
	
	public function __construct(int $note, int $unit)
	{
		$this->note = $note;
		$this->unit = $unit;
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
}
