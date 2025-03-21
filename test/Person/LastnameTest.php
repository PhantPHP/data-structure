<?php

declare(strict_types=1);

namespace Test\Person;

use Phant\DataStructure\Person\Lastname;
use Phant\Error\NotCompliant;

final class LastnameTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $lastname = new Lastname(' doe ');

        $this->assertEquals('DOE', (string)$lastname);

        $this->assertIsString($lastname->value);
        $this->assertEquals('DOE', $lastname->value);
    }

    public function testNotCompliant(): void
    {
        $this->expectException(NotCompliant::class);

        new Lastname('');
    }
}
