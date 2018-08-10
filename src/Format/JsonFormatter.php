<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents\Format;

use PascalDeVink\CloudEvents\CloudEvent;

class JsonFormatter
{
    public function format(CloudEvent $cloudEvent) : string
    {
        return json_encode(
            array_filter(
                $cloudEvent->toArray(),
                function ($value) {
                    return null !== $value;
                }
            )
        );
    }
}
