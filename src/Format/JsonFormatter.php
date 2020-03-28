<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents\Format;

use PascalDeVink\CloudEvents\V03\CloudEvent;

class JsonFormatter
{
    public function encode(CloudEvent $cloudEvent) : string
    {
        return json_encode(
            array_filter(
                $cloudEvent->toArray(),
                function ($value) {
                    return null !== $value;
                }
            ),
            JSON_THROW_ON_ERROR
        );
    }

    public function decode(string $json) : CloudEvent
    {
        $eventData = json_decode($json, true);

        return CloudEvent::fromArray($eventData);
    }
}
