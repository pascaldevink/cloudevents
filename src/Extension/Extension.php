<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents\Extension;

interface Extension
{
    public function getName() : string;

    public function toArray() : array;
}
