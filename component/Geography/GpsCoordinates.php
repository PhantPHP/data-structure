<?php

declare(strict_types=1);

namespace Phant\DataStructure\Geography;

use Phant\Error\NotCompliant;

class GpsCoordinates
{
    // Format : WGS84 (https://en.wikipedia.org/wiki/World_Geodetic_System)
    final public function __construct(
        public readonly float $latitude,
        public readonly float $longitude
    ) {
        if ($latitude > 90 || $latitude < -90 || $longitude > 180 || $longitude < -180) {
            throw new NotCompliant('GPS coordinates: ' . $latitude . ';' . $longitude);
        }
    }

    public function __toString(): string
    {
        return (string) $this->latitude . ';' . $this->longitude;
    }

    public static function make(string $coordinates): self
    {
        $parts = explode(';', str_replace(',', '.', $coordinates));

        return new static(
            (float) $parts[0],
            (float) $parts[1]
        );
    }

    public static function makeFromLambert93(float $x, float $y): static
    {
        $x = number_format($x, 10, '.', '');
        $y = number_format($y, 10, '.', '');
        $b6  = 6378137.0000;
        $b7  = 298.257222101;
        $b8  = 1 / $b7;
        $b9  = 2 * $b8 - $b8 * $b8;
        $b10 = sqrt($b9);
        $b13 = 3.000000000;
        $b14 = 700000.0000;
        $b15 = 12655612.0499;
        $b16 = 0.7256077650532670;
        $b17 = 11754255.426096;
        $delx = $x - $b14;
        $dely = $y - $b15;
        $gamma = atan(-($delx) / $dely);
        $r = sqrt(($delx * $delx) + ($dely * $dely));
        $latiso = log($b17 / $r) / $b16;
        $sinphiit0 = tanh($latiso + $b10 * atanh($b10 * sin(1)));
        $sinphiit1 = tanh($latiso + $b10 * atanh($b10 * $sinphiit0));
        $sinphiit2 = tanh($latiso + $b10 * atanh($b10 * $sinphiit1));
        $sinphiit3 = tanh($latiso + $b10 * atanh($b10 * $sinphiit2));
        $sinphiit4 = tanh($latiso + $b10 * atanh($b10 * $sinphiit3));
        $sinphiit5 = tanh($latiso + $b10 * atanh($b10 * $sinphiit4));
        $sinphiit6 = tanh($latiso + $b10 * atanh($b10 * $sinphiit5));
        $longrad = $gamma / $b16 + $b13 / 180 * pi();
        $latrad = asin($sinphiit6);
        $longitude = ($longrad / pi() * 180);
        $latitude  = ($latrad / pi() * 180);

        $longitude = round($longitude, 7);
        $latitude = round($latitude, 7);

        return new static($latitude, $longitude);
    }

    public static function makeFromUtm(float $x, float $y, int $zone, bool $southernHemisphere = false): static
    {
        $UTMCentralMeridian = function (int $zone): float {
            $degree2radian = function (float $deg): float {
                return $deg / 180.0 * pi();
            };

            return $degree2radian(-183.0 + ($zone * 6.0));
        };

        $FootpointLatitude = function (float $y): float {
            $sm_b = 6356752.314;
            $sm_a = 6378137.0;
            $UTMScaleFactor = 0.9996;
            $sm_EccSquared = .00669437999013;
            $n = ($sm_a - $sm_b) / ($sm_a + $sm_b);
            $alpha_ = (($sm_a + $sm_b) / 2.0)* (1 + (pow($n, 2.0) / 4) + (pow($n, 4.0) / 64));
            $y_ = $y / $alpha_;
            $beta_ = (3.0 * $n / 2.0) + (-27.0 * pow($n, 3.0) / 32.0)+ (269.0 * pow($n, 5.0) / 512.0);
            $gamma_ = (21.0 * pow($n, 2.0) / 16.0)+ (-55.0 * pow($n, 4.0) / 32.0);
            $delta_ = (151.0 * pow($n, 3.0) / 96.0)+ (-417.0 * pow($n, 5.0) / 128.0);
            $epsilon_ = (1097.0 * pow($n, 4.0) / 512.0);
            $result = $y_ + ($beta_ * sin(2.0 * $y_))
                + ($gamma_ * sin(4.0 * $y_))
                + ($delta_ * sin(6.0 * $y_))
                + ($epsilon_ * sin(8.0 * $y_));

            return $result;
        };

        $radian2degree = function (float $rad): float {
            return $rad / pi() * 180.0;
        };

        $UTMScaleFactor = 0.9996;
        $x -= 500000.0;
        $x /= $UTMScaleFactor;
        /* If in southern hemisphere, adjust y accordingly. */
        if ($southernHemisphere) {
            $y -= 10000000.0;
        }
        $y /= $UTMScaleFactor;
        $cmeridian = $UTMCentralMeridian($zone);

        $philambda = [];
        $sm_b = 6356752.314;
        $sm_a = 6378137.0;
        $UTMScaleFactor = 0.9996;
        $sm_EccSquared = .00669437999013;
        $phif = $FootpointLatitude($y);
        $ep2 = (pow($sm_a, 2.0) - pow($sm_b, 2.0)) / pow($sm_b, 2.0);
        $cf = cos($phif);
        $nuf2 = $ep2 * pow($cf, 2.0);
        $Nf = pow($sm_a, 2.0) / ($sm_b * sqrt(1 + $nuf2));
        $Nfpow = $Nf;
        $tf = tan($phif);
        $tf2 = $tf * $tf;
        $tf4 = $tf2 * $tf2;
        $x1frac = 1.0 / ($Nfpow * $cf);
        $Nfpow *= $Nf;
        $x2frac = $tf / (2.0 * $Nfpow);
        $Nfpow *= $Nf;
        $x3frac = 1.0 / (6.0 * $Nfpow * $cf);
        $Nfpow *= $Nf;
        $x4frac = $tf / (24.0 * $Nfpow);
        $Nfpow *= $Nf;
        $x5frac = 1.0 / (120.0 * $Nfpow * $cf);
        $Nfpow *= $Nf;
        $x6frac = $tf / (720.0 * $Nfpow);
        $Nfpow *= $Nf;
        $x7frac = 1.0 / (5040.0 * $Nfpow * $cf);
        $Nfpow *= $Nf;
        $x8frac = $tf / (40320.0 * $Nfpow);
        $x2poly = -1.0 - $nuf2;
        $x3poly = -1.0 - 2 * $tf2 - $nuf2;
        $x4poly = 5.0 + 3.0 * $tf2 + 6.0 * $nuf2 - 6.0 * $tf2 * $nuf2- 3.0 * ($nuf2 *$nuf2) - 9.0 * $tf2 * ($nuf2 * $nuf2);
        $x5poly = 5.0 + 28.0 * $tf2 + 24.0 * $tf4 + 6.0 * $nuf2 + 8.0 * $tf2 * $nuf2;
        $x6poly = -61.0 - 90.0 * $tf2 - 45.0 * $tf4 - 107.0 * $nuf2	+ 162.0 * $tf2 * $nuf2;
        $x7poly = -61.0 - 662.0 * $tf2 - 1320.0 * $tf4 - 720.0 * ($tf4 * $tf2);
        $x8poly = 1385.0 + 3633.0 * $tf2 + 4095.0 * $tf4 + 1575 * ($tf4 * $tf2);

        $latitude = $radian2degree(
            $phif + $x2frac * $x2poly * ($x * $x)
            + $x4frac * $x4poly * pow($x, 4.0)
            + $x6frac * $x6poly * pow($x, 6.0)
            + $x8frac * $x8poly * pow($x, 8.0)
        );

        $longitude = $radian2degree(
            $cmeridian + $x1frac * $x
            + $x3frac * $x3poly * pow($x, 3.0)
            + $x5frac * $x5poly * pow($x, 5.0)
            + $x7frac * $x7poly * pow($x, 7.0)
        );

        $longitude = round($longitude, 7);
        $latitude = round($latitude, 7);

        return new static($latitude, $longitude);
    }
}
