<?php

declare(strict_types=1);

namespace Test\Web;

use Phant\DataStructure\Web\{
    DomainName,
    EmailAddress,
    UserName,
};

use Phant\Error\NotCompliant;

final class EmailAddressTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $emailAddress = new EmailAddress('username@domain.ext');

        $this->assertEquals('username@domain.ext', (string)$emailAddress);

        $this->assertIsString($emailAddress->value);
        $this->assertEquals('username@domain.ext', $emailAddress->value);

        $this->assertIsObject($emailAddress->getUserName());
        $this->assertEquals('username', (string)$emailAddress->getUserName());

        $this->assertIsObject($emailAddress->getDomainName());
        $this->assertEquals('domain.ext', (string)$emailAddress->getDomainName());
    }

    public function testMake(): void
    {
        $emailAddress = EmailAddress::make(
            new UserName('username'),
            new DomainName('domain.ext')
        );
        
        $this->assertInstanceOf(EmailAddress::class, $emailAddress);

        $this->assertIsObject($emailAddress);
        $this->assertEquals('username@domain.ext', (string)$emailAddress);
    }

    public function testNotCompliant(): void
    {
        $this->expectException(NotCompliant::class);

        new EmailAddress('username@domain-ext');
    }
}
