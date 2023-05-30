<?php

declare(strict_types=1);

namespace Test\Token;

use Phant\DataStructure\Token\ApiKey;

final class ApiKeyTest extends \PHPUnit\Framework\TestCase
{
    public function testGenerate(): void
    {
        $value = ApiKey::generate();

        $this->assertIsObject($value);
        $this->assertInstanceOf(ApiKey::class, $value);
    }

    public function testCheck(): void
    {
        $value = ApiKey::generate();
        $result = $value->check($value);

        $this->assertIsBool($result);
        $this->assertEquals(true, $result);
    }

    public function testCheckInvalid(): void
    {
        $value = ApiKey::generate();
        $result = $value->check(ApiKey::generate());

        $this->assertIsBool($result);
        $this->assertEquals(false, $result);
    }
}
