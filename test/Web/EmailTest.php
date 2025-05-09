<?php

declare(strict_types=1);

namespace Test\Web;

use Phant\DataStructure\Web\Email;
use Phant\DataStructure\Web\EmailAddress;
use Phant\DataStructure\Web\EmailAddressAndName;
use Phant\DataStructure\Web\EmailAddressAndNameList;
use Phant\DataStructure\Web\EmailAttachment;
use Phant\DataStructure\Web\EmailAttachmentList;
use Test\Web\EmailAttachmentTest;

final class EmailTest extends \PHPUnit\Framework\TestCase
{
    protected EmailAttachmentList $attachmentList;

    public function setUp(): void
    {
        $this->attachmentList = (new EmailAttachmentList())
            ->add(
                new EmailAttachment(
                    'file.pdf',
                    EmailAttachmentTest::Content,
                    'application/pdf'
                )
            );
    }

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
            (new EmailAddressAndNameList())->add(
                new EmailAddressAndName(
                    new EmailAddress('john.doe@domain.ext'),
                    'John DOE'
                )
            ),
            (new EmailAddressAndNameList())->add(
                new EmailAddressAndName(
                    new EmailAddress('john.doe@domain.ext'),
                    'John DOE'
                )
            ),
            (new EmailAddressAndNameList())->add(
                new EmailAddressAndName(
                    new EmailAddress('john.doe@domain.ext'),
                    'John DOE'
                )
            ),
            new EmailAddressAndName(
                new EmailAddress('no-reply@acme.ext'),
                'No reply'
            ),
            $this->attachmentList
        );

        $this->assertIsString($email->subject);
        $this->assertEquals('Subject', $email->subject);

        $this->assertIsString($email->messageTxt);
        $this->assertEquals('Message', $email->messageTxt);

        $this->assertIsString($email->messageHtml);
        $this->assertEquals('<p>Message</p>', $email->messageHtml);

        $this->assertIsObject($email->from);
        $this->assertInstanceOf(EmailAddressAndName::class, $email->from);
        $this->assertEquals('contact@acme.ext', (string)$email->from->emailAddress);
        $this->assertEquals('Acme', $email->from->name);

        $this->assertIsObject($email->to);
        $this->assertInstanceOf(EmailAddressAndNameList::class, $email->to);
        $to = $email->to->iterate()->current();
        $this->assertEquals('john.doe@domain.ext', (string)$to->emailAddress);
        $this->assertEquals('John DOE', $to->name);

        $this->assertIsObject($email->cc);
        $this->assertInstanceOf(EmailAddressAndNameList::class, $email->cc);
        $cc = $email->cc->iterate()->current();
        $this->assertEquals('john.doe@domain.ext', (string)$cc->emailAddress);
        $this->assertEquals('John DOE', $cc->name);

        $this->assertIsObject($email->bcc);
        $this->assertInstanceOf(EmailAddressAndNameList::class, $email->bcc);
        $bcc = $email->bcc->iterate()->current();
        $this->assertEquals('john.doe@domain.ext', (string)$bcc->emailAddress);
        $this->assertEquals('John DOE', $bcc->name);

        $this->assertIsObject($email->replyTo);
        $this->assertInstanceOf(EmailAddressAndName::class, $email->replyTo);
        $this->assertEquals('no-reply@acme.ext', (string)$email->replyTo->emailAddress);
        $this->assertEquals('No reply', $email->replyTo->name);

        $this->assertIsObject($email->attachmentList);
        $this->assertInstanceOf(EmailAttachmentList::class, $email->attachmentList);
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
            'No reply',
            $this->attachmentList
        );

        $this->assertInstanceOf(Email::class, $email);

        $this->assertIsString($email->subject);
        $this->assertEquals('Subject', $email->subject);

        $this->assertIsString($email->messageTxt);
        $this->assertEquals('Message', $email->messageTxt);

        $this->assertIsString($email->messageHtml);
        $this->assertEquals('<p>Message</p>', $email->messageHtml);

        $this->assertIsObject($email->from);
        $this->assertInstanceOf(EmailAddressAndName::class, $email->from);
        $this->assertEquals('contact@acme.ext', (string)$email->from->emailAddress);
        $this->assertEquals('Acme', $email->from->name);

        $this->assertIsObject($email->to);
        $this->assertInstanceOf(EmailAddressAndNameList::class, $email->to);
        $to = $email->to->iterate()->current();
        $this->assertEquals('john.doe@domain.ext', (string)$to->emailAddress);
        $this->assertEquals('John DOE', $to->name);

        $this->assertIsObject($email->replyTo);
        $this->assertInstanceOf(EmailAddressAndName::class, $email->replyTo);
        $this->assertEquals('no-reply@acme.ext', (string)$email->replyTo->emailAddress);
        $this->assertEquals('No reply', $email->replyTo->name);

        $this->assertIsObject($email->attachmentList);
        $this->assertInstanceOf(EmailAttachmentList::class, $email->attachmentList);
    }

    public function testMakeBasic(): void
    {
        $email = Email::make(
            'Subject',
            'Message',
            '<p>Message</p>',
            'contact@acme.ext',
            null,
            'john.doe@domain.ext',
            null
        );

        $this->assertInstanceOf(Email::class, $email);

        $this->assertIsString($email->subject);
        $this->assertEquals('Subject', $email->subject);

        $this->assertIsString($email->messageTxt);
        $this->assertEquals('Message', $email->messageTxt);

        $this->assertIsString($email->messageHtml);
        $this->assertEquals('<p>Message</p>', $email->messageHtml);

        $this->assertIsObject($email->from);
        $this->assertInstanceOf(EmailAddressAndName::class, $email->from);
        $this->assertEquals('contact@acme.ext', (string)$email->from->emailAddress);
        $this->assertNull($email->from->name);

        $this->assertIsObject($email->to);
        $this->assertInstanceOf(EmailAddressAndNameList::class, $email->to);
        $to = $email->to->iterate()->current();
        $this->assertEquals('john.doe@domain.ext', (string)$to->emailAddress);
        $this->assertNull($to->name);

        $this->assertNull($email->replyTo);

        $this->assertNull($email->attachmentList);
    }
}
