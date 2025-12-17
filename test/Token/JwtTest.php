<?php

declare(strict_types=1);

namespace Test\Token;

use Phant\DataStructure\Token\Jwt;
use Phant\Error\NotCompliant;

final class JwtTest extends \PHPUnit\Framework\TestCase
{
    public const PRIVATE_KEY = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIIEpQIBAAKCAQEAx/jq0ObHk1R6l3PbjoSg1YKtUWp+dHDRBu76G5J08n5vIcB3
NiyrLtizw54Q8au+UQZ4B7G3IxBJ1SvWmUYgmZFRihaabd30JlmmweXUwLz9zYMj
NYt3oRnVNlD0qEvSSfoUtpYfmLh9SkJj23NvWfKtME3EHhYnxeoRdfUToQvLGZ2P
APOr+6BKrcIHFEJj3rvsgoTujckKeDl2GHQ4CGaS47tFmHtsK4KmCYxJviBwHW0b
PKHoooV2+63G8Jh4n9WU3Q7EytBwgFB/VnoKRAwpWAAIAkSw/22qw5waRkze8CA2
bpgu98HkR3eRnx5tU1e7p78+W2XSk8h3vzuA2QIDAQABAoIBAQCL/86VdhxfHxO8
mJYrztqy4AvrJf1mE92jVweu6fgKFU5EePR87wThhUFFQJJoP268VyUNbfPjDnJC
VbCmGhyUptJJNM3lATD+8GD4+qjaTvX5PUgXIo8cMHO+1SqT8JFGzVhXA/8W8oJ0
zMoQR167wFRTrv4Qej5aJycWR//4DIXzE99EU8mzouL/n8j2qM53QZ7KiRsQRnHr
1o8AWeWFwQ7p7XxXoIoc0MlGwgwKyzJkT7ndGLECQvtuHz4Mxb0ibQsOZ8QgLqJe
pc0KPqXLsySV6I3bGTQrBvC7VZJPNfkOsQ7UfjtL/fLzOI2/tJB4yKbWGZViaBVU
pKteUG8BAoGBAPO4p0O8QYHCx6s0iKsd4AxgHfwmgw9LmbkRwvDWGFM6EEDyOtQ7
bvD1HO0TpkC5jWoU86IACAGZHPBLymOFmrJHUmlVm/ghH89f17Mpo7wVG3A6dcuB
7CG4EpLB8UfGBntDc0wK+NHJ4RyCaNH7cftUWDKZO+6BnqwbSvfi9uHpAoGBANIM
BTNadh4saWWk+W/VkQ74tS7WjoMQ2nagExPVXQhfM2wHGnsh8gkoyhkFMLUKj0/o
qMxVanQdjOrjpr/CUsNA9z0B29Y0QkkY1o7HGgpplky13a9ixL1dRvbUP4qCdecz
4MNkB4vPyf/cHXCNu7AFk2UhqNe8EHd+F5KRlOFxAoGBAK4oIiYt7SV7eVCm3o5g
b8yIFoUrQ/X3EOcFgSa15nX6hMjUDyO/QJygmsXyh5eywBGw3RPDL/VsYxh3IC2T
uCJzArnQef6KNP/rvegB9kWdU5kTvT7qHUFPFr6WJgMix1jnrwkEwh6vQtQrgBmk
syNkdw3ZH9FkAG19p0mRfteZAoGBAK2bH8VFFHF19Zr8Uun7E4zTRTU0Qs/TYy0+
uuXeqKkdvmugJ2P0N48Ydoldf9dypea+/pz8UCMutWUCybSekTcuf+qdmayevtaZ
v+R8bWqDwKUgf9zQ/pkg+mFSJj59+6Mffrsf9xi4olVmAbMggitHQH8K5fmBR/7r
aeJLj0kRAoGAfXHGAWBmjMOYFRPN01kQnK4N0GBiCfujn+woyEi06lb8hAPuHjPm
5B+p/0Y+pDEFI3ZGKP5L3RnFBtexl6G43pIIQ6jIuINljXw90i0oONQUL2HYxs7E
MmXDjfdNI+q8vu7v9fQ+6bJqU1oGyj85wK7rdZ1VHebJG41nsgV0viQ=
-----END RSA PRIVATE KEY-----
EOD;

    public const PUBLIC_KEY = <<<EOD
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAx/jq0ObHk1R6l3PbjoSg
1YKtUWp+dHDRBu76G5J08n5vIcB3NiyrLtizw54Q8au+UQZ4B7G3IxBJ1SvWmUYg
mZFRihaabd30JlmmweXUwLz9zYMjNYt3oRnVNlD0qEvSSfoUtpYfmLh9SkJj23Nv
WfKtME3EHhYnxeoRdfUToQvLGZ2PAPOr+6BKrcIHFEJj3rvsgoTujckKeDl2GHQ4
CGaS47tFmHtsK4KmCYxJviBwHW0bPKHoooV2+63G8Jh4n9WU3Q7EytBwgFB/VnoK
RAwpWAAIAkSw/22qw5waRkze8CA2bpgu98HkR3eRnx5tU1e7p78+W2XSk8h3vzuA
2QIDAQAB
-----END PUBLIC KEY-----
EOD;

    public function testInterface(): void
    {
        $jwt = Jwt::encode(
            self::PRIVATE_KEY,
            [
                'foo' => 'bar',
            ],
            1
        );

        $this->assertIsString((string)$jwt);
        $this->assertIsString($jwt->value);

        $payload = $jwt->decode(self::PUBLIC_KEY);

        $this->assertIsArray($payload);
        $this->assertArrayHasKey('foo', $payload);
        $this->assertEquals('bar', $payload['foo']);
    }

    public function testNotCompliantExpiration(): void
    {
        $this->expectException(NotCompliant::class);

        (new Jwt('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJmb28iOiJiYXIiLCJpYXQiOjE2NTAwMTU2OTUsImV4cCI6MTY1MDAxNTY5Nn0.dAGjGeS5iCgYplBsp-ES2xu6fNwUyv3JAxSso6IpJlFSgx7r_d9mvkkPdeOAArMGVbcwCk6MUEqa32cyh_0TB8kse49DJ58m4-xfNazc7fkF9WwqrKA08CqBsDfALIsrqsaHkSqvRAgn-UZkWVKp1SoCN9xFLNiYl2_LUJvwwFQ'))
            ->decode(self::PUBLIC_KEY);
    }

    public function testNotCompliantSignature(): void
    {
        $this->expectException(NotCompliant::class);

        (new Jwt('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJmb28iOiJiYXIiLCJpYXQiOjE2NTAwMTYyOTgsImV4cCI6MTY1MDAxNjI5OX0.fiyJAOgDqx3t5825xyndVDj04j-REJh9JtvhMMS7bUpyX7MuKdekkzKVe65Vzo6U0rGkTiTAD3_q1G1OfhlXXlHPWtmYd3AHhGNMclP_uVszSx2XUK9_0kKF0rw5BU7I4JVVXDyAM9OovDlWJ9DZlXGLYRjadSvSzzroRhLGWEI'))
            ->decode(self::PUBLIC_KEY);
    }
}
