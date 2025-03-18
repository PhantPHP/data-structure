<?php

declare(strict_types=1);

namespace Phant\DataStructure\Web;

class Url extends \Phant\DataStructure\Abstract\Value\Varchar
{
    public const PATTERN = '%\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))%s';

    protected ?string $scheme;
    protected ?string $user;
    protected ?string $pass;
    protected ?string $host;
    protected ?int $port;
    protected ?string $path;
    protected ?array $query;
    protected ?string $fragment;

    public function __construct(
        string $url
    ) {
        parent::__construct($url);

        $this->decompose();
    }

    public function getScheme(
    ): ?string {
        return $this->scheme;
    }

    public function setScheme(
        ?string $scheme
    ): self {
        $url = clone $this;

        $scheme = trim($scheme);

        $url->scheme = $scheme;

        return self::compose($url);
    }

    public function getUser(
    ): ?string {
        return $this->user;
    }

    public function setUser(
        ?string $user
    ): self {
        $url = clone $this;

        $user = trim($user);

        $url->user = $user;

        return self::compose($url);
    }

    public function getPass(
    ): ?string {
        return $this->pass;
    }

    public function setPass(
        ?string $pass
    ): self {
        $url = clone $this;

        $pass = trim($pass);

        $url->pass = $pass;

        return self::compose($url);
    }

    public function getHost(
    ): ?string {
        return $this->host;
    }

    public function setHost(
        ?string $host
    ): self {
        $url = clone $this;

        $host = trim($host);

        $url->host = $host;

        return self::compose($url);
    }

    public function getPort(
    ): ?int {
        return $this->port;
    }

    public function setPort(
        ?int $port
    ): self {
        $url = clone $this;

        $url->port = $port;

        return self::compose($url);
    }

    public function getPath(
    ): ?string {
        return $this->path;
    }

    public function setPath(
        ?string $path
    ): self {
        $url = clone $this;

        $path = trim($path);

        if (substr($path, 0, 1) != '/') {
            $path = '/' . $path;
        }

        $url->path = $path;

        return self::compose($url);
    }

    public function getQuery(
    ): ?array {
        return $this->query;
    }

    public function addQueryParameter(
        string $key,
        string $value
    ): self {
        $url = clone $this;

        $key = trim($key);

        if (!$url->query) {
            $url->query = [];
        }

        $url->query[ $key ] = $value;

        return self::compose($url);
    }

    public function removeQueryParameter(
        string $key
    ): self {
        $url = clone $this;

        $key = trim($key);

        unset($url->query[ $key ]);

        if (!$this->query) {
            $url->query = null;
        }

        return self::compose($url);
    }

    public function getFragment(
    ): ?string {
        return $this->fragment;
    }

    public function setFragment(
        ?string $fragment
    ): self {
        $url = clone $this;

        $fragment = trim($fragment);

        $url->fragment = $fragment;

        return self::compose($url);
    }

    protected function decompose(
    ): void {
        $urlParts = parse_url($this->value);

        $this->scheme	= $urlParts[ 'scheme' ] ?? null;
        $this->user		= $urlParts[ 'user' ] ?? null;
        $this->pass		= $urlParts[ 'pass' ] ?? null;
        $this->host		= $urlParts[ 'host' ] ?? null;
        $this->port		= $urlParts[ 'port' ] ?? null;
        $this->path		= $urlParts[ 'path' ] ?? null;
        if (isset($urlParts[ 'query' ]) && is_string($urlParts[ 'query' ])) {
            parse_str($urlParts[ 'query' ], $this->query);
        } else {
            $this->query = null;
        }
        $this->fragment	= $urlParts[ 'fragment' ] ?? null;
    }

    public static function compose(
        self $url
    ): self {
        $urlString = '';

        $urlString .= $url->getScheme();

        $urlString .= '://';

        if ($url->getUser()) {
            $urlString .= $url->getUser();
            if ($url->getPass()) {
                $urlString .= ':';
                $urlString .= $url->getPass();
            }
            $urlString .= '@';
        }

        $urlString .= $url->getHost();

        if ($url->getPort()) {
            $urlString .= ':' . $url->getPort();
        }

        if ($url->getPath()) {
            $urlString .= $url->getPath();
        }

        if ($url->getQuery()) {
            $urlString .= '?' . http_build_query($url->getQuery());
        }

        if ($url->getFragment()) {
            $urlString .= '#' . $url->getFragment();
        }

        return new self($urlString);
    }
}
