<?php
declare(strict_types=1);

namespace Phant\DataStructure\Time;

use Phant\Error\NotCompliant;

class Duration extends \Phant\DataStructure\Abstract\Aggregate
{
	// Duration in secondes
	const MINUTE	= 60;
	const HOUR		= 3600;
	const DAY		= 86400;
	const MONTH		= 2628000;
	const YEAR		= 31536000;
	
	const SECOND_LABEL = 's';
	const SECOND_LABEL_PLURAL = 's';
	const MINUTE_LABEL = 'min';
	const MINUTE_LABEL_PLURAL = 'min';
	const HOUR_LABEL = 'h';
	const HOUR_LABEL_PLURAL = 'h';
	const DAY_LABEL = 'day';
	const DAY_LABEL_PLURAL = 'days';
	const MONTH_LABEL = 'month';
	const MONTH_LABEL_PLURAL = 'months';
	const YEAR_LABEL = 'year';
	const YEAR_LABEL_PLURAL = 'years';
	
	protected int $time;
	protected string $label;
	
	public function __construct(int $time)
	{
		$this->time = $time;
		$this->label = $this->buildLabel();
	}
	
	public function __toString()
	{
		return (string) $this->getLabel();
	}
	
	public function get(): int
	{
		return $this->time;
	}
	
	public function getLabel(): string
	{
		return $this->label;
	}
	
	protected function buildLabel(): string
	{
		$remainingTime = $this->time;
		
		$labels = [];
		
		if ($remainingTime >= self::YEAR) {
			$years = intval($remainingTime / self::YEAR);
			if ($years) {
				$labels[] =  $years . ' ' . ($years > 1 ? self::YEAR_LABEL_PLURAL : self::YEAR_LABEL);
				$remainingTime = $remainingTime % self::YEAR;
			}
		}
		
		if ($remainingTime >= self::MONTH) {
			$months = intval($remainingTime / self::MONTH);
			if ($months) {
				$labels[] =  $months . ' ' . ($months > 1 ? self::MONTH_LABEL_PLURAL : self::MONTH_LABEL);
				$remainingTime = $remainingTime % self::MONTH;
			}
		}
		
		if ($remainingTime >= self::DAY) {
			$days = intval($remainingTime / self::DAY);
			if ($days) {
				$labels[] =  $days . ' ' . ($days > 1 ? self::DAY_LABEL_PLURAL : self::DAY_LABEL);
				$remainingTime = $remainingTime % self::DAY;
			}
		}
		
		if ($remainingTime >= self::HOUR) {
			$hours = intval($remainingTime / self::HOUR);
			if ($hours) {
				$labels[] =  $hours . ' ' . ($hours > 1 ? self::HOUR_LABEL_PLURAL : self::HOUR_LABEL);
				$remainingTime = $remainingTime % self::HOUR;
			}
		}
		
		if ($remainingTime >= self::MINUTE) {
			$minutes = intval($remainingTime / self::MINUTE);
			if ($minutes) {
				$labels[] =  $minutes . ' ' . ($minutes > 1 ? self::MINUTE_LABEL_PLURAL : self::MINUTE_LABEL);
				$remainingTime = $remainingTime % self::MINUTE;
			}
		}
		
		if ($remainingTime > 0) {
			$secondes = intval($remainingTime);
			if ($secondes) {
				$labels[] =  $secondes . ' ' . ($secondes > 1 ? self::SECOND_LABEL_PLURAL : self::SECOND_LABEL);
			}
		}
		
		return implode(', ', $labels);
	}
	
	public function serialize(): array
	{
		return [
			'value'	=> $this->time,
			'label'	=> $this->label
		];
	}
	
	public static function unserialize(array $serialized): self
	{
		if (!isset($serialized[ 'value' ])) {
			throw new NotCompliant();
		}
		
		return new self($serialized[ 'value' ]);
	}
}
