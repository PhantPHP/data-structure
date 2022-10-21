<?php

declare(strict_types=1);

namespace Test\Web;

use Phant\DataStructure\Web\{
    Email,
    EmailAddress,
    EmailAddressAndName,
};

use Phant\Error\NotCompliant;

final class EmailTest extends \PHPUnit\Framework\TestCase
{
    public function testInterface(): void
    {
        $email = new Email(
            'Subject',
            'Message',
            '<p>Message</p>',
            new EmailAddressAndName(
                new EmailAddress('contact@acme.ext'),
                'Acme'
            ),
            new EmailAddressAndName(
                new EmailAddress('john.doe@domain.ext'),
                'John DOE'
            ),
            new EmailAddressAndName(
                new EmailAddress('no-reply@acme.ext'),
                'No reply'
            )
        );

        $this->assertIsString($email->subject);
        $this->assertEquals('Subject', $email->subject);

        $this->assertIsString($email->messageTxt);
        $this->assertEquals('Message', $email->messageTxt);

        $this->assertIsString($email->messageHtml);
        $this->assertEquals('<p>Message</p>', $email->messageHtml);

        $this->assertIsObject($email->from);
        $this->assertEquals('contact@acme.ext', (string)$email->from->emailAddress);
        $this->assertEquals('Acme', $email->from->name);

        $this->assertIsObject($email->to);
        $this->assertEquals('john.doe@domain.ext', (string)$email->to->emailAddress);
        $this->assertEquals('John DOE', $email->to->name);

        $this->assertIsObject($email->replyTo);
        $this->assertEquals('no-reply@acme.ext', (string)$email->replyTo->emailAddress);
        $this->assertEquals('No reply', $email->replyTo->name);
    }

    public function testMake(): void
    {
        $email = Email::make(
            'Subject',
            'Message',
            '<p>Message</p>',
            'contact@acme.ext',
            'Acme',
            'john.doe@domain.ext',
            'John DOE',
            'no-reply@acme.ext',
            'No reply'
        );

        $this->assertInstanceOf(Email::class, $email);

        $this->assertIsString($email->subject);
        $this->assertEquals('Subject', $email->subject);

        $this->assertIsString($email->messageTxt);
        $this->assertEquals('Message', $email->messageTxt);

        $this->assertIsString($email->messageHtml);
        $this->assertEquals('<p>Message</p>', $email->messageHtml);

        $this->assertIsObject($email->from);
        $this->assertEquals('contact@acme.ext', (string)$email->from->emailAddress);
        $this->assertEquals('Acme', $email->from->name);

        $this->assertIsObject($email->to);
        $this->assertEquals('john.doe@domain.ext', (string)$email->to->emailAddress);
        $this->assertEquals('John DOE', $email->to->name);

        $this->assertIsObject($email->replyTo);
        $this->assertEquals('no-reply@acme.ext', (string)$email->replyTo->emailAddress);
        $this->assertEquals('No reply', $email->replyTo->name);
    }
}
