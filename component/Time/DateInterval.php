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
	
	public function __construct(
		null|string|Date $from,
		null|string|Date $to
	)
	{
		if (!$from && !$to) {
			throw new NotCompliant('Date intervals: from ' . $from . ' to' . $to);
		}
		
		if (is_string($from)) {
			$from = new Date($from);
		}
		
		if (is_string($to)) {
			$to = new Date($to);
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
	
	public function isDuring(string|Date $date): bool
	{
		if (is_string($date)) {
			$date = new Date($date);
		}
		
		if ($date->getTime() < $this->from->getTime()) {
			return false;
		}
		
		if ($date->getTime() > $this->to->getTime()) {
			return false;
		}
		
		return true;
	}
	
	public function serialize(): array
	{
		return [
			static::FROM_KEY		=> $this->from ? $this->from->serialize() : null,
			static::TO_KEY			=> $this->to ? $this->to->serialize() : null,
			static::DURATION_KEY	=> $this->duration ? $this->duration->serialize() : null,
		];
	}
	
	public static function unserialize(array $serialized): self
	{
		if (!( array_key_exists(static::FROM_KEY, $serialized)
			&& array_key_exists(static::TO_KEY, $serialized)
		)) {
			throw new NotCompliant();
		}
		
		return new static(
			$serialized[ static::FROM_KEY ],
			$serialized[ static::TO_KEY ]
		);
	}
}
