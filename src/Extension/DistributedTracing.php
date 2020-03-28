<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents\Extension;

class DistributedTracing implements Extension
{
    private string $traceParent;

    private ?string $traceState;

    public function __construct(string $traceParent, ?string $traceState = null)
    {
        $this->traceParent = $traceParent;
        $this->traceState  = $traceState;
    }

    public function toArray() : array
    {
        return [
            'DistributedTracingExtension' => [
                'traceparent' => $this->traceParent,
                'tracestate'  => $this->traceState,
            ],
        ];
    }

    public function getName() : string
    {
        return 'DistributedTracingExtension';
    }

    public function getTraceParent() : string
    {
        return $this->traceParent;
    }

    public function getTraceState() : ?string
    {
        return $this->traceState;
    }
}
