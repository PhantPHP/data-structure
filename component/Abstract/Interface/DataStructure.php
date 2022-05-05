<?php
declare(strict_types=1);

namespace Phant\DataStructure\Abstract\Interface;

interface DataStructure
{
	public function serialize(): mixed;
	public static function unserialize(array $array): self;
}
