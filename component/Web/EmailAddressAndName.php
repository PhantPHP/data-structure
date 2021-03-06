<?php
declare(strict_types=1);

namespace Phant\DataStructure\Web;

use Phant\Error\NotCompliant;

class EmailAddressAndName extends \Phant\DataStructure\Abstract\Aggregate
{
	protected EmailAddress $emailAddress;
	protected ?string $name;
	
	public function __construct(
		string|EmailAddress $emailAddress,
		?string $name = null
	)
	{
		if (is_string($emailAddress)) {
			$emailAddress = new EmailAddress($emailAddress);
		}
		
		$this->emailAddress = $emailAddress;
		$this->name = !is_null($name) ? trim($name) : null;
	}
	
	public function getEmailAddress(): EmailAddress
	{
		return $this->emailAddress;
	}
	
	public function getName(): ?string
	{
		return $this->name;
	}
	
	public function serialize(): array
	{
		return [
			'email_address' => $this->emailAddress->serialize(),
			'name' => $this->name,
		];
	}
	
	public static function unserialize(array $serialized): self
	{
		if (!( array_key_exists('email_address', $serialized)
			&& array_key_exists('name', $serialized)
		)) {
			throw new NotCompliant();
		}
		
		return new static($serialized[ 'email_address' ], $serialized[ 'name' ]);
	}
}
