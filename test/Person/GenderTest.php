<?php

declare(strict_types=1);

namespace Test\Person;

use Phant\DataStructure\Person\Gender;

final class GenderTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $gender = Gender::Female;

        $this->assertIsString($gender->value);
        $this->assertEquals('female', $gender->value);

        $this->assertIsString($gender->getLabel());
        $this->assertEquals('Female', $gender->getLabel());
    }
}
