<?php
declare(strict_types=1);

namespace Phant\DataStructure\Abstract;

abstract class Entity implements \Phant\DataStructure\Abstract\Interface\DataStructure
{
	abstract public function serialize(): array;
	abstract public static function unserialize(array $array): self;
}
