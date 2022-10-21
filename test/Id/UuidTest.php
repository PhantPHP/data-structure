<?php

declare(strict_types=1);

namespace Test\Id;

use Phant\DataStructure\Id\Uuid;

use Phant\Error\NotCompliant;

final class UuidTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $uuid = new Uuid('1a55e96e-7a47-465b-887b-2f517068065c');

        $this->assertEquals('1a55e96e-7a47-465b-887b-2f517068065c', (string)$uuid);

        $this->assertIsString($uuid->value);
        $this->assertEquals('1a55e96e-7a47-465b-887b-2f517068065c', $uuid->value);
    }

    public function testGenerate(): void
    {
        $uuid = Uuid::generate();

        $this->assertIsString($uuid->value);
    }

    public function testNotCompliant(): void
    {
        $this->expectException(NotCompliant::class);

        new Uuid('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
    }
}
