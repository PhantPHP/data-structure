<?php
declare(strict_types=1);

namespace Phant\DataStructure\Money;

use Phant\Error\NotCompliant;

class Price extends \Phant\DataStructure\Abstract\Aggregate
{
	protected float $price;
	protected ?Currency $currency;
	protected ?string $unit;
	
	public function __construct(
		float $price,
		null|string|Currency $currency = null,
		?string $unit = null
	)
	{
		if (is_string($currency)) {
			$currency = new Currency($currency);
		}
		
		$this->price = $price;
		$this->currency = $currency;
		$this->unit = $unit;
	}
	
	public function get(): float
	{
		return $this->price;
	}
	
	public function getCurrency(): ?Currency
	{
		return $this->currency;
	}
	
	public function getUnit(): ?string
	{
		return $this->unit;
	}
	
	public function __toString(): string
	{
		return $this->getFormatted();
	}
	
	public function getFormatted(bool $espaceInsecable = true): string
	{
		$price = number_format($this->price, 2, ',', ' ');
		
		if (!is_null($this->currency)) {
			$price.= ' ' . ((string)$this->currency);
		}
		
		if (!is_null($this->unit)) {
			$price.= '/' . ((string)$this->unit);
		}
		
		if ($espaceInsecable) {
			$price = str_replace(' ', "\xC2\xA0", $price); // Espace insécable
		}
		
		return $price;
	}
}
