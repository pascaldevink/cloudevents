<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents;

interface Data
{
    public function getContentType() : ContentType;

    public function getData();
}
