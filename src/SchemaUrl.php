<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents;

use League\Uri\Interfaces\Uri;

class SchemaUrl
{
    /**
     * @var Uri
     */
    private $uri;

    public function __construct(Uri $uri)
    {
        $this->uri = $uri;
    }

    public function __toString() : string
    {
        return (string) $this->uri;
    }
}
