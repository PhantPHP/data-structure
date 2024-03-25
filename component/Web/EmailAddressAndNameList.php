<?php

declare(strict_types=1);

namespace Phant\DataStructure\Web;

use Phant\DataStructure\Web\EmailAddressAndName;

class EmailAddressAndNameList extends \Phant\DataStructure\Abstract\Collection
{
    final public function add(
        EmailAddressAndName $emailAddressAndName
    ): self {
        return $this->addItem($emailAddressAndName);
    }
}
