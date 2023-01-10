<?php

declare(strict_types=1);

namespace Test\Abstract\Value;

use Test\Abstract\Fixture\Value\Varchar;

use Phant\Error\NotCompliant;

final class VarcharTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $varchar = new Varchar('Hello world!');

        $this->assertEquals('Hello world!', (string)$varchar);

        $this->assertIsString($varchar->value);
        $this->assertEquals('Hello world!', $varchar->value);
    }

    public function testNotCompliant(): void
    {
        $this->expectException(NotCompliant::class);

        new Varchar('');
    }
    
    public function testAddNonBreakingSpace(): void
    {
        $string = (new Varchar('Hello world!'))->addNonBreakingSpace();
        
        $this->assertEquals('Hello' . "\xC2\xA0" . 'world!', $string);
    }
}
