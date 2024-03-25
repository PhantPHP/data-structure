<?php

declare(strict_types=1);

namespace Test\Web;

use Phant\DataStructure\Web\{
    EmailAddress,
    EmailAddressAndName,
    EmailAddressAndNameList,
};

final class EmailAddressAndNameListTest extends \PHPUnit\Framework\TestCase
{
    protected EmailAddressAndNameList $fixture;

    public function setUp(): void
    {
        $this->fixture = new EmailAddressAndNameList();
    }

    public function testAdd(): void
    {
        $this->assertEquals(0, $this->fixture->getNbItems());

        $this->fixture->add(
            new EmailAddressAndName(
                new EmailAddress('john.doe@domain.ext'),
                'John DOE'
            )
        );

        $this->assertEquals(1, $this->fixture->getNbItems());
    }
}
