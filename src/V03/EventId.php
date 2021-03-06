<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents\V03;

use Webmozart\Assert\Assert;

class EventId
{
    private string $value;

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
