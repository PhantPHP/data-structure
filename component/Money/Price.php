<?php
declare(strict_types=1);

namespace Phant\DataStructure\Money;

class Price extends \Phant\DataStructure\Abstract\Aggregate
{
	protected float $price;
	protected ?Currency $currency;
	
	public function __construct(float $price, ?Currency $currency = null)
	{
		$this->price = $price;
		$this->currency = $currency;
	}
	
	public function get(): float
	{
		return $this->price;
	}
	
	public function getCurrency(): ?Currency
	{
		return $this->currency;
	}
	
	public function __toString(): string
	{
		return ((string) $this->price) . ' ' . ((string)$this->currency);
	}
	
	public function serialize(): array
	{
		return [
			'price'	=> $this->price,
			'currency'	=> $this->currency ? $this->currency->serialize() : null,
		];
	}
}
