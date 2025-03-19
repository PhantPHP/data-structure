<?php

declare(strict_types=1);

namespace Test\Web;

use Phant\DataStructure\Web\EmailAttachment;
use Phant\DataStructure\Web\EmailAttachmentList;
use Test\Web\EmailAttachmentTest;

final class EmailAttachmentListTest extends \PHPUnit\Framework\TestCase
{
    protected EmailAttachmentList $fixture;

    public function setUp(): void
    {
        $this->fixture = new EmailAttachmentList();
    }

    public function testAdd(): void
    {
        $this->assertEquals(0, $this->fixture->getNbItems());

        $this->fixture->add(
            new EmailAttachment(
                'file.pdf',
                EmailAttachmentTest::Content,
                'application/pdf'
            )
        );

        $this->assertEquals(1, $this->fixture->getNbItems());
    }
}
