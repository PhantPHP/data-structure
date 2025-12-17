<?php

declare(strict_types=1);

namespace Test\Time;

use Phant\DataStructure\Time\Unit;

final class UnitTest extends \PHPUnit\Framework\TestCase
{
    public function testEnumCases(): void
    {
        $cases = Unit::cases();

        $this->assertCount(6, $cases);
        $this->assertContains(Unit::Second, $cases);
        $this->assertContains(Unit::Minute, $cases);
        $this->assertContains(Unit::Hour, $cases);
        $this->assertContains(Unit::Day, $cases);
        $this->assertContains(Unit::Month, $cases);
        $this->assertContains(Unit::Year, $cases);
    }

    public function testGetLabelSingular(): void
    {
        $this->assertEquals('s', Unit::Second->getLabel());
        $this->assertEquals('min', Unit::Minute->getLabel());
        $this->assertEquals('h', Unit::Hour->getLabel());
        $this->assertEquals('day', Unit::Day->getLabel());
        $this->assertEquals('month', Unit::Month->getLabel());
        $this->assertEquals('year', Unit::Year->getLabel());
    }

    public function testGetLabelPlural(): void
    {
        $this->assertEquals('s', Unit::Second->getLabelPlural());
        $this->assertEquals('min', Unit::Minute->getLabelPlural());
        $this->assertEquals('h', Unit::Hour->getLabelPlural());
        $this->assertEquals('days', Unit::Day->getLabelPlural());
        $this->assertEquals('months', Unit::Month->getLabelPlural());
        $this->assertEquals('years', Unit::Year->getLabelPlural());
    }
}
