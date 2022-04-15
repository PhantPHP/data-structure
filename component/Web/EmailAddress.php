<?php
declare(strict_types=1);

namespace Phant\DataStructure\Web;

use Phant\DataStructure\Web\{
	DomainName,
	UserName,
};

final class EmailAddress extends \Phant\DataStructure\Abstract\Value\Varchar
{
	public const PATTERN = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
	
	public function __construct(string $emailAddress)
	{
		$emailAddress = preg_replace('/ /', '', $emailAddress);
		$emailAddress = strtolower($emailAddress);
		
		parent::__construct($emailAddress);
	}
	
	public function getUserName(): UserName
	{
		return new UserName(
			strstr($this->value, '@', true)
		);
	}
	
	public function getDomainName(): DomainName
	{
		return new DomainName(
			substr(strrchr($this->value, '@'), 1)
		);
	}
	
	public static function build(UserName $userName, DomainName $domainName): self
	{
		return new self($userName . '@' . $domainName);
	}
}
