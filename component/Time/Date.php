<?php
declare(strict_types=1);

namespace Phant\DataStructure\Time;

use Phant\Error\NotCompliant;

class Date extends \Phant\DataStructure\Abstract\Value\Varchar
{
	protected int $time;

	public function __construct(string $date, string $format = 'Y-m-d')
	{
		if (strtolower($date) == 'now') {
			$date = 'today midnight';
		}
		
		$time = strtotime($date);
		if ($time === false) {
			throw new NotCompliant('Date: ' . $date);
		}
		$this->time = $time;
		$date = date($format, $this->time);
		
		parent::__construct($date);
	}
	
	public function getTime(): int
	{
		return $this->time;
	}
}
