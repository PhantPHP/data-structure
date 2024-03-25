<?php

declare(strict_types=1);

namespace Test\Web;

use Phant\DataStructure\Web\EmailAddressAndName;
use Phant\DataStructure\Web\EmailAddress;

final class EmailAddressAndNameTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $emailAddressAndName = new EmailAddressAndName(
            new EmailAddress('john.doe@domain.ext'),
            'John DOE'
        );

        $this->assertIsObject($emailAddressAndName->emailAddress);
        $this->assertEquals('john.doe@domain.ext', (string)$emailAddressAndName->emailAddress);

        $this->assertIsString($emailAddressAndName->name);
        $this->assertEquals('John DOE', $emailAddressAndName->name);
    }

    public function testMake(): void
    {
        $emailAddressAndName = EmailAddressAndName::make(
            'john.doe@domain.ext',
            'John DOE'
        );

        $this->assertInstanceOf(EmailAddressAndName::class, $emailAddressAndName);

        $this->assertIsObject($emailAddressAndName->emailAddress);
        $this->assertEquals('john.doe@domain.ext', (string)$emailAddressAndName->emailAddress);

        $this->assertIsString($emailAddressAndName->name);
        $this->assertEquals('John DOE', $emailAddressAndName->name);
    }
}
