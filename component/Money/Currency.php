<?php
declare(strict_types=1);

namespace Phant\DataStructure\Money;

class Currency extends \Phant\DataStructure\Abstract\Enum
{
	const AUD = 'AUD';
	const CAD = 'CAD';
	const CHF = 'CHF';
	const DKK = 'DKK';
	const EUR = 'EUR';
	const GBP = 'GBP';
	const SEK = 'SEK';
	const USD = 'USD';
	const ZSD = 'ZSD';
	
	const VALUES = [
		self::AUD => 'AUD',
		self::CAD => 'CAD',
		self::CHF => 'CHF',
		self::DKK => 'DKK',
		self::EUR => '€',
		self::GBP => '£',
		self::SEK => 'SEK',
		self::USD => 'USD',
		self::ZSD => 'ZSD',
	];
}
