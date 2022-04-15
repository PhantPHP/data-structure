<?php
declare(strict_types=1);

namespace Test\Abstract\Fixture;

use Phant\Error\NotCompliant;

class Enum extends \Phant\DataStructure\Abstract\Enum
{
	const FOO = 'foo';
	const BAR = 'bar';
	
	const VALUES = [
		self::FOO => 'Foo',
		self::BAR => 'Bar',
	];
}
