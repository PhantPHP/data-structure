<?php

declare(strict_types=1);

namespace Test\Key;

use Phant\Error\NotCompliant;
use Phant\DataStructure\Key\Ssl;

final class SslTest extends \PHPUnit\Framework\TestCase
{
    private const PRIVATE = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQDSuaKgYq3rUx+kfmH/SAoiji7p9xRqSs+9D/3XA9FX4KVq0LFo
7H7CMbkbw/FXz7zvS+GaobF+P/U52oqC9s3ATagm7uewI6kGT64V6smtU2UqRP3f
JxleahDmuCoBr/pnZu/5MBN8uHo3t4ABNpccHohpdEMfkL84vMtl9UObUwIDAQAB
AoGBAIlfg2lTa1YSJnqx+WjWqeTFFEhqTuDMTIlQN4dIcdz8ElqEGmPwaOJoT+iN
4HQCdYT6zuRjrLZFM7S3h7zA8HfRJlu4nnFS+aLiGdcrJodDLBTM6zwMF243koS7
xF0aaTlMYsfC0ic4xW8S+bqOPeOe7sVVoIxUQKsb5vdhubJhAkEA/amrRanrjNgu
wQb5mZv0WlRPiv0N3EsJ/j7hquHKgD5zLD2QLCa1HxmsDOwh6GNHWEPIMF0Z/4aF
IRZvnHQNNwJBANSqr7mrk6Nt2AnFX9QUnSLYe3j6ddXMX+I9qEJEr+VGurJqYtiU
Ze/TNVsYehb0O8JY1UwDJ6UJcODjtCruEMUCQQD8ilIw/hW72HLbzDTtoJ2q3KuA
haWp/69IR5Rmi3sPKJ2DmxsRScwi1W08RE8RzN1326vPsrEye9vI8ExYKBYLAkBe
WEKQ6g8bR5W57/ftTB/R35wXNXWlHX/EDHpiu7oUyuX0VMH5Nwxp8pcPDLLNEBia
xXIKwLOLwb5z5lB9YxPJAkAiJmO9buLWVeJvrQB6HR638pctMaXkuNUDMpA+PPOl
tXqe6pq1w3XUZ61GuxlrIR+c/IMWtBPuqS4K4Po2/CSU
-----END RSA PRIVATE KEY-----
EOD;

    private const PUBLIC = <<<EOD
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDSuaKgYq3rUx+kfmH/SAoiji7p
9xRqSs+9D/3XA9FX4KVq0LFo7H7CMbkbw/FXz7zvS+GaobF+P/U52oqC9s3ATagm
7uewI6kGT64V6smtU2UqRP3fJxleahDmuCoBr/pnZu/5MBN8uHo3t4ABNpccHohp
dEMfkL84vMtl9UObUwIDAQAB
-----END PUBLIC KEY-----
EOD;

    private const INVALID_PRIVATE = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICWgIBAAKBgHhmJkqMdk57FRHT5Al5WdgisuHMkbH1PKl7l/jqxdAQyTqXGYJ0
2U8IZhwDH0gNZ0fZVdiqyDsUMJz0S3WqcTtDJlsBxyKpAC3Qj24+uazDaIzo832W
yg0wgopKwoKOsLcoKe1pV/LAQd6JinhFje8m2DBY6UOf3LozcSRC+gXlAgMBAAEC
gYAmpqxePE9yjGLMMVjAjduA3krM4C5Zkd/ijNHR0BSm4eynyYAf+EEW9RxKm9n7
+ImScDv17YWQKcAdcvOSl5/3sGsioBTfFis8vTyPPZrzelyNIS8m1s4jF1A5+v/A
gVBUndgDLOIKr7bogjBwtf94yWhwl0VuE6jRsMRwPYHZlQJBAOcTzhzehqhuXAOe
H/mGvRBeBH8ZgqAORWJlwV6IesEQ8T2to1x4OtUhNi3noYL0CI0DDzpzcl5MWFw
XeUZKZMCQQCFYnGyQocofQzSOEZxwWJ5pRhviunFZ7z7fqjhyja1p8fJph9IDknQ
oRRSCVbtBq4/aMYj7lw1+ACt0G6KJN2nAkAQAfM5VMEHUf3V0lJsusTGKX0uQNon
tFViJ6JpphK65S2RFEJI2Zth8IzzZmT47ECS3gArCBdVaaveECaxBDk5AkBR30pQ
k9toc9GB278Jph0u87KbDNZPMEzkxisdZMTOHe1ZDhnXXcXbRHQ3ornzhY1BKKuu
dGmvSsoH5o9jRhuzAkB2JQo8P8KhHZcg/LYaISee28fRdEW8QFFMaFn7CgT08cpj
gNHVwFqtj3IET23k7CpeI9GcmLfjQG05wUwoVl46
-----END RSA PRIVATE KEY-----
EOD;

    private const INVALID_PUBLIC = <<<EOD
-----BEGIN PUBLIC KEY-----
MIGeMA0GCSqGSIb3DQEBAQUAA4GMADCBiAKBgHhmJkqMdk57FRHT5Al5WdgisuHM
kbH1PKl7l/jqxdAQyTqXGYJ02U8IZhwDH0gNZ0fZVdiqyDsUMJz0S3WqcTtDJlsB
xyKpAC3Qj24+uazDaIzo832Wyg0wgopKwoKOsLcoKe1pV/LAQd6JinhFje8m2DBY
6UOf3LozcSRC+gXlAgMBAAE=X
-----END PUBLIC KEY-----
EOD;

    protected Ssl $fixture;
    protected Ssl $fixtureInvalid;

    public function setUp(): void
    {
        $this->fixture = new Ssl(
            self::PRIVATE,
            self::PUBLIC
        );
        $this->fixtureInvalid = new Ssl(
            self::INVALID_PRIVATE,
            self::INVALID_PUBLIC
        );
    }

    public function testGetPrivate(): void
    {
        $result = $this->fixture->private;

        $this->assertIsString($result);
    }

    public function testGetPublic(): void
    {
        $result = $this->fixture->public;

        $this->assertIsString($result);
    }

    public function testEncrypt(): void
    {
        $result = $this->fixture->encrypt('Foo bar');

        $this->assertIsString($result);
    }

    public function testEncryptInvalid(): void
    {
        $this->expectException(NotCompliant::class);

        $result = $this->fixtureInvalid->encrypt('Foo bar');
    }

    public function testEncryptInvalidBis(): void
    {
        $this->expectException(NotCompliant::class);

        $result = $this->fixtureInvalid->encrypt('');
    }

    public function testDecrypt(): void
    {
        $result = $this->fixture->decrypt(
            $this->fixture->encrypt('Foo bar')
        );

        $this->assertIsString($result);
    }

    public function testDecryptInvalid(): void
    {
        $this->expectException(NotCompliant::class);

        $result = $this->fixtureInvalid->decrypt(
            $this->fixture->encrypt('Foo bar')
        );
    }
}
