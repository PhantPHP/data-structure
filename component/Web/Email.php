<?php

declare(strict_types=1);

namespace Phant\DataStructure\Web;

use Phant\DataStructure\Web\EmailAddressAndName;
use Phant\DataStructure\Web\EmailAttachmentList;

class Email
{
    final public function __construct(
        public string $subject,
        public string $messageTxt,
        public string $messageHtml,
        public EmailAddressAndName $from,
        public EmailAddressAndName $to,
        public ?EmailAddressAndName $replyTo = null,
        public ?EmailAttachmentList $attachmentList = null
    ) {
    }

    public static function make(
        string $subject,
        string $messageTxt,
        string $messageHtml,
        string $fromEmailAddress,
        ?string $fromName,
        string $toEmailAddress,
        ?string $toName,
        ?string $replyToEmailAddress = null,
        ?string $replyToName = null,
        ?EmailAttachmentList $attachmentList = null
    ): self {
        return new static(
            $subject,
            $messageTxt,
            $messageHtml,
            EmailAddressAndName::make(
                $fromEmailAddress,
                $fromName
            ),
            EmailAddressAndName::make(
                $toEmailAddress,
                $toName
            ),
            $replyToEmailAddress ? EmailAddressAndName::make(
                $replyToEmailAddress,
                $replyToName
            ) : null,
            $attachmentList
        );
    }
}
