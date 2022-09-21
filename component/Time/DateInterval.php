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
	protected ?Date $from;
	protected ?Date $to;
	protected ?Duration $duration;
	
	public function __construct(
		null|int|string|Date $from,
		null|int|string|Date $to
	)
	{
		if (!$from && !$to) {
			throw new NotCompliant('Date intervals: from ' . $from . ' to' . $to);
		}
		
		if (is_string($from) || is_int($from)) {
			$from = new Date($from);
		}
		
		if (is_string($to) || is_int($to)) {
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
	
	public function isDuring(string|int|Date $date): bool
	{
		if (is_string($date) || is_int($date)) {
			$date = new Date($date);
		}
		
		if ($this->from && $date->getTime() < $this->from->getTime()) {
			return false;
		}
		
		if ($this->to && $date->getTime() > $this->to->getTime()) {
			return false;
		}
		
		return true;
	}
}
