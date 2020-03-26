<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents;

use League\Uri\Contracts\UriInterface;

class SchemaUrl
{
    private UriInterface $uri;

    public function __construct(UriInterface $uri)
    {
        $this->uri = $uri;
    }

    public function __toString() : string
    {
        return (string) $this->uri;
    }
}
