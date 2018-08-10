<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents;

class ContentType
{
    /**
     * @var string
     */
    private $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function __toString() : string
    {
        return $this->type;
    }
}
