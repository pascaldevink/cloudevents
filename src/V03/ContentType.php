<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents\V03;

class ContentType
{
    private string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function __toString() : string
    {
        return $this->type;
    }
}
