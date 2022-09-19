<?php
declare(strict_types=1);

namespace Test\Token;

use Phant\DataStructure\Token\Jwt;

use Phant\Error\NotCompliant;

final class JwtTest extends \PHPUnit\Framework\TestCase
{
	const PRIVATE_KEY = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQCNkaa6vpc3P3eQfHERkX+1DpNdKbInq7klDyP5xH/G61UCyuqY
sglqmaepCZcmdZYeCPT6YYQ+llxAImeg1fAuKP/v0GXwK2nbi4/65grTVcqzO1dv
MF0rHPC1h2ViW6MPrn3Tnxt8WqJhrbSRzudzJ37xqAAnwnSnIS9PZM7B+wIDAQAB
AoGAOJLyPEKaD3wPffAdB1ZL4MEYZuyYw32+mW65g8DhB09YQ6tvoOHVHYKWG9k3
TClFem895yk9Pf28k+yr2Pxl5JJVW6bTpAJjo5KpK1JesFNHZOrwAajz8pPley2D
pB51eGZ6/ekyKiLZnWlpfimtuP38DryvrMO+0//AqyLxbjECQQDgAN3YlM7sSRPL
lMLVzODuLSt9Wcdy7o4uPUuvVLbGf5q18ShLAWMeGj09l38ewSDG1xTwqdlpeUFY
+lzGFoo9AkEAocpndLmpkIkOsSLTi3FG5dROTXmIw6cTj1uMOMSqY5quO1EZJ81a
npMgZpWKdMJ0551law0ZRskUbl7fYxuYlwJBAIGKfsEdbXzf1f7JjNMvpHSY0qmv
HdSteLPs5rQCfaDVcpb9W5vktXlXG0tfLTiP33CeOZHj58NDSDM4tiYoKtECQBfG
peN6cVfDPHx9kLb6Q5/8zjEGfjm6cN5tZrLk++E9VwNyjI7T19Bb8LQCn+E+vm1X
LRNJToCfhjgeCxgGcysCQHSYXTw/iRNQcjaOPzKjLtUEGlwsYreWz9yyHNVjvs8G
gKFMM7KcZQoToXVQtcyKv839TI0Z+44R6f0AE2Ly1gk=
-----END RSA PRIVATE KEY-----
EOD;
	
	const PUBLIC_KEY = <<<EOD
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCNkaa6vpc3P3eQfHERkX+1DpNd
KbInq7klDyP5xH/G61UCyuqYsglqmaepCZcmdZYeCPT6YYQ+llxAImeg1fAuKP/v
0GXwK2nbi4/65grTVcqzO1dvMF0rHPC1h2ViW6MPrn3Tnxt8WqJhrbSRzudzJ37x
qAAnwnSnIS9PZM7B+wIDAQAB
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
		$this->assertIsString($jwt->get());
		
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
