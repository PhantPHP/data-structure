<?php
declare(strict_types=1);

namespace Phant\DataStructure\Web;

use Phant\DataStructure\Web\{
	EmailAddressAndName,
};

use Phant\Error\NotCompliant;

class Email extends \Phant\DataStructure\Abstract\Entity
{
	public string $subject;
	public string $messageTxt;
	public string $messageHtml;
	public EmailAddressAndName $from;
	public EmailAddressAndName $to;
	public ?EmailAddressAndName $replyTo;
	
	public function __construct(
		string $subject,
		string $messageTxt,
		string $messageHtml,
		string|EmailAddressAndName $from,
		string|EmailAddressAndName $to,
		null|string|EmailAddressAndName $replyTo = null
	)
	{
		if (is_string($from)) {
			$from = new EmailAddressAndName($from);
		}
		
		if (is_string($to)) {
			$to = new EmailAddressAndName($to);
		}
		
		if (is_string($replyTo)) {
			$replyTo = new EmailAddressAndName($replyTo);
		}
		
		$this->subject = $subject;
		$this->messageTxt = $messageTxt;
		$this->messageHtml = $messageHtml;
		$this->from = $from;
		$this->to = $to;
		$this->replyTo = $replyTo;
	}
}
