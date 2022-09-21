<?php
declare(strict_types=1);

namespace Phant\DataStructure\Time;

use Phant\Error\NotCompliant;

class DateTime extends \Phant\DataStructure\Time\Date
{
	public function __construct(string $date, string $format = 'Y-m-d H:i:s')
	{
		if (strtolower($date) == 'now') {
			$date = 'now';
		}
		
		parent::__construct($date, $format);
	}
}
