<?php

declare(strict_types=1);

namespace Test\Web;

use Phant\DataStructure\Web\UserName;

use Phant\Error\NotCompliant;

final class UserNameTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $userName = new UserName('john.doe');

        $this->assertEquals('john.doe', (string)$userName);

        $this->assertIsString($userName->value);
        $this->assertEquals('john.doe', $userName->value);
    }

    public function testNotCompliant(): void
    {
        $this->expectException(NotCompliant::class);

        new UserName('user@name');
    }
}
