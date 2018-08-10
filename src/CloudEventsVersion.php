<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents;

use Webmozart\Assert\Assert;

class CloudEventsVersion
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        Assert::notWhitespaceOnly($value);

        $this->value = $value;
    }

    public function __toString() : string
    {
        return $this->value;
    }
}
