<?php

declare(strict_types=1);

namespace Phant\DataStructure\Web;

use Phant\DataStructure\Web\EmailAddressAndName;

class Email
{
    final public function __construct(
        public string $subject,
        public string $messageTxt,
        public string $messageHtml,
        public EmailAddressAndName $from,
        public EmailAddressAndName $to,
        public ?EmailAddressAndName $replyTo
    ) {
    }

    public static function make(
        string $subject,
        string $messageTxt,
        string $messageHtml,
        string $fromEmailAddress,
        string $fromName,
        string $toEmailAddress,
        string $toName,
        ?string $replyToEmailAddress = null,
        ?string $replyToName = null
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
            ) : null
        );
    }
}
