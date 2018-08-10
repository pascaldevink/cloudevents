<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents\Extension;

class DistributedTracing implements Extension
{
    /**
     * @var string
     */
    private $traceparent;

    /**
     * @var null|string
     */
    private $tracestate;

    public function __construct(string $traceparent, ?string $tracestate = null)
    {
        $this->traceparent = $traceparent;
        $this->tracestate = $tracestate;
    }

    public function toArray() : array
    {
        return [
            'traceparent' => $this->traceparent,
            'tracestate' => $this->tracestate,
        ];
    }
}
