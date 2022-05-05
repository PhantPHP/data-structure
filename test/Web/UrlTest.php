<?php
declare(strict_types=1);

namespace Test\Web;

use Phant\DataStructure\Web\Url;

use Phant\Error\NotCompliant;

final class UrlTest extends \PHPUnit\Framework\TestCase
{
	public function testInterface(): void
	{
		$url = new Url('http://username:password@hostname:9090/path?arg=value#anchor');
		
		$this->assertEquals('http://username:password@hostname:9090/path?arg=value#anchor', (string)$url);
		
		$this->assertIsString($url->get());
		$this->assertEquals('http://username:password@hostname:9090/path?arg=value#anchor', $url->get());
		
		$this->assertIsString($url->getScheme());
		$this->assertEquals('http', $url->getScheme());
		$url = $url->setScheme('https');
		$this->assertEquals('https', $url->getScheme());
		
		$this->assertIsString($url->getUser());
		$this->assertEquals('username', $url->getUser());
		$url = $url->setUser('john.doe');
		$this->assertEquals('john.doe', $url->getUser());
		
		$this->assertIsString($url->getPass());
		$this->assertEquals('password', $url->getPass());
		$url = $url->setPass('qwerty');
		$this->assertEquals('qwerty', $url->getPass());
		
		$this->assertIsString($url->getHost());
		$this->assertEquals('hostname', $url->getHost());
		$url = $url->setHost('acme');
		$this->assertEquals('acme', $url->getHost());
		
		$this->assertIsInt($url->getPort());
		$this->assertEquals(9090, $url->getPort());
		$url = $url->setPort(8080);
		$this->assertEquals(8080, $url->getPort());
		
		$this->assertIsString($url->getPath());
		$this->assertEquals('/path', $url->getPath());
		$url = $url->setPath('home');
		$this->assertEquals('/home', $url->getPath());
		
		$this->assertIsArray($url->getQuery());
		$this->assertEquals(['arg' => 'value'], $url->getQuery());
		$url = $url->removeQueryParameter('arg');
		$url = $url->addQueryParameter('foo', 'bar');
		$this->assertEquals(['foo' => 'bar'], $url->getQuery());
		
		$this->assertIsString($url->getFragment());
		$this->assertEquals('anchor', $url->getFragment());
		$url = $url->setFragment('title');
		$this->assertEquals('title', $url->getFragment());
		
		$this->assertEquals('https://john.doe:qwerty@acme:8080/home?foo=bar#title', (string)$url);
		
		$serialized = $url->serialize();
		
		$this->assertIsString($serialized);
		$this->assertEquals('https://john.doe:qwerty@acme:8080/home?foo=bar#title', $serialized);
		
		$unserialized = Url::unserialize($serialized);
		
		$this->assertEquals($url, $unserialized);
		
	}
	
	public function testNotCompliant(): void
	{
		$this->expectException(NotCompliant::class);
		
		new Url('http//username:password@hostname:9090/path?arg=value#anchor');
	}
}
