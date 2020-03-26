<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents;

use Webmozart\Assert\Assert;

final class Subject
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
