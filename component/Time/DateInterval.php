<?php
declare(strict_types=1);

namespace Phant\DataStructure\Time;

use Phant\DataStructure\Time\{
	Date,
	Duration,
};

use Phant\Error\NotCompliant;

class DateInterval extends \Phant\DataStructure\Abstract\Aggregate
{
	public const FROM_KEY = 'from';
	public const TO_KEY = 'to';
	public const DURATION_KEY = 'duration';
	
	protected ?Date $from;
	protected ?Date $to;
	protected ?Duration $duration;
	
	public function __construct(?Date $from, ?Date $to)
	{
		if (!$from && !$to) {
			throw new NotCompliant('Date intervals: from ' . $from . ' to' . $to);
		}
		
		$this->from = $from;
		$this->to = $to;
		$this->duration = ($this->from && $this->to) ? new Duration($this->to->getTime() - $this->from->getTime()) : null;
	}
	
	public function getFrom(): ?Date
	{
		return $this->from;
	}
	
	public function getTo(): ?Date
	{
		return $this->to;
	}
	
	public function getDuration(): ?Duration
	{
		return $this->duration;
	}
	
	public function serialize(): array
	{
		return [
			static::FROM_KEY		=> $this->from ? $this->from->serialize() : null,
			static::TO_KEY			=> $this->to ? $this->to->serialize() : null,
			static::DURATION_KEY	=> $this->duration ? $this->duration->serialize() : null,
		];
	}
}
