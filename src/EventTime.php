<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents;

use DateTimeImmutable;

class EventTime
{
    private DateTimeImmutable $value;

    public function __construct(DateTimeImmutable $value)
    {
        $this->value = $value;
    }

    public function __toString() : string
    {
        return $this->value->format(DateTimeImmutable::RFC3339);
    }
}
