<?php
declare(strict_types=1);

namespace Phant\DataStructure\Time;

use Phant\DataStructure\Time\{
	DateTime,
	Duration,
};

use Phant\Error\NotCompliant;

class DateTimeInterval extends \Phant\DataStructure\Abstract\Aggregate
{
	protected ?DateTime $from;
	protected ?DateTime $to;
	protected ?Duration $duration;
	
	public function __construct(
		null|string|DateTime $from,
		null|string|DateTime $to
	)
	{
		if (!$from && !$to) {
			throw new NotCompliant('Date time intervals: from ' . $from . ' to' . $to);
		}
		
		if (is_string($from)) {
			$from = new DateTime($from);
		}
		
		if (is_string($to)) {
			$to = new DateTime($to);
		}
		
		$this->from = $from;
		$this->to = $to;
		$this->duration = ($this->from && $this->to) ? new Duration($this->to->getTime() - $this->from->getTime()) : null;
	}
	
	public function getFrom(): ?DateTime
	{
		return $this->from;
	}
	
	public function getTo(): ?DateTime
	{
		return $this->to;
	}
	
	public function getDuration(): ?Duration
	{
		return $this->duration;
	}
	
	public function isDuring(string|DateTime $dateTime): bool
	{
		if (is_string($dateTime)) {
			$dateTime = new DateTime($dateTime);
		}
		
		if ($this->from && $dateTime->getTime() < $this->from->getTime()) {
			return false;
		}
		
		if ($this->to && $dateTime->getTime() > $this->to->getTime()) {
			return false;
		}
		
		return true;
	}
}
