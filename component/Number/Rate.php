<?php
declare(strict_types=1);

namespace Phant\DataStructure\Number;

class Rate extends \Phant\DataStructure\Abstract\Value\Decimal
{
	public function __toString()
	{
		return (string) self::addNonBreakingSpace($this->get() . ' %');
	}
}
