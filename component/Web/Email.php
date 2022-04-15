<?php
declare(strict_types=1);

namespace Phant\DataStructure\Web;

use Phant\DataStructure\Web\{
	EmailAddressAndName,
};

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
		EmailAddressAndName $from,
		EmailAddressAndName $to,
		?EmailAddressAndName $replyTo = null
	)
	{
		$this->subject = $subject;
		$this->messageTxt = $messageTxt;
		$this->messageHtml = $messageHtml;
		$this->from = $from;
		$this->to = $to;
		$this->replyTo = $replyTo;
	}
	
	public function serialize(): array
	{
		return [
			'subject'	=> $this->subject,
			'message'	=> [
				'txt'	=> $this->messageTxt,
				'html'	=> $this->messageHtml,
			],
			'from'		=> $this->from->serialize(),
			'to'		=> $this->to->serialize(),
			'reply_to'	=> $this->replyTo ? $this->replyTo->serialize() : null,
		];
	}
}
