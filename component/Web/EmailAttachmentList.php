<?php

declare(strict_types=1);

namespace Phant\DataStructure\Web;

use Phant\DataStructure\Web\EmailAttachment;

class EmailAttachmentList extends \Phant\DataStructure\Abstract\Collection
{
    final public function add(
        EmailAttachment $attachment
    ): self {
        return $this->addItem($attachment);
    }
}
