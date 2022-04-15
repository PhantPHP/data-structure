<?php
declare(strict_types=1);

namespace Test\Abstract\Fixture\Value;

class Varchar extends \Phant\DataStructure\Abstract\Value\Varchar
{
	public const PATTERN = '/^[a-zA-Z !]{2,}$/';
}
