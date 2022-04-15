<?php
declare(strict_types=1);

namespace Phant\DataStructure\Web;

class EmailAddressAndName extends \Phant\DataStructure\Abstract\Aggregate
{
	protected EmailAddress $emailAddress;
	protected ?string $name;
	
	public function __construct(
		EmailAddress $emailAddress,
		?string $name = null
	)
	{
		$this->emailAddress = $emailAddress;
		$this->name = trim($name) ?? null;
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
}
