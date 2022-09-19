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
		$this->assertEquals('contact@acme.ext', (string)$email->from->getEmailAddress());
		$this->assertEquals('Acme', $email->from->getName());
		
		$this->assertIsObject($email->to);
		$this->assertEquals('john.doe@domain.ext', (string)$email->to->getEmailAddress());
		$this->assertEquals('John DOE', $email->to->getName());
		
		$this->assertIsObject($email->replyTo);
		$this->assertEquals('no-reply@acme.ext', (string)$email->replyTo->getEmailAddress());
		$this->assertEquals('No reply', $email->replyTo->getName());
	}
	
	public function testConstructAlt(): void
	{
		$email = new Email(
			'Subject',
			'Message',
			'<p>Message</p>',
			'contact@acme.ext',
			'john.doe@domain.ext',
			'no-reply@acme.ext'
		);
		
		$this->assertIsObject($email->from);
		$this->assertEquals('contact@acme.ext', (string)$email->from->getEmailAddress());
		$this->assertEquals(null, $email->from->getName());
		
		$this->assertIsObject($email->to);
		$this->assertEquals('john.doe@domain.ext', (string)$email->to->getEmailAddress());
		$this->assertEquals(null, $email->to->getName());
		
		$this->assertIsObject($email->replyTo);
		$this->assertEquals('no-reply@acme.ext', (string)$email->replyTo->getEmailAddress());
		$this->assertEquals(null, $email->replyTo->getName());
	}
}
