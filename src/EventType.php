<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents;

use Webmozart\Assert\Assert;

class EventType
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var null|string
     */
    private $version;

    public function __construct(string $value, ?string $version = null)
    {
        Assert::notWhitespaceOnly($value);
        Assert::nullOrNotWhitespaceOnly($version);

        $this->value = $value;
        $this->version = $version;
    }

    public function getValue() : string
    {
        return $this->value;
    }

    public function getVersion() : ?string
    {
        return $this->version;
    }
}
