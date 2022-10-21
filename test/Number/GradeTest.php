<?php

declare(strict_types=1);

namespace Test\Number;

use Phant\DataStructure\Number\Grade;

use Phant\Error\NotCompliant;

final class GradeTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $grade = new Grade(8, 10);

        $this->assertEquals('8/10', (string)$grade);

        $this->assertIsInt($grade->position);
        $this->assertEquals(8, $grade->position);

        $this->assertIsInt($grade->scale);
        $this->assertEquals(10, $grade->scale);
    }
    
    public function testMake(): void
    {
        $grade = Grade::make(' 8 / 10 ');
    
        $this->assertInstanceOf(Grade::class, $grade);
        
        $this->assertIsInt($grade->position);
        $this->assertEquals(8, $grade->position);
        
        $this->assertIsInt($grade->scale);
        $this->assertEquals(10, $grade->scale);
    }

    public function testNotCompliantGrade(): void
    {
        $this->expectException(NotCompliant::class);

        new Grade(-2, 10);
    }

    public function testNotCompliantUnit(): void
    {
        $this->expectException(NotCompliant::class);

        new Grade(2, -3);
    }
}
