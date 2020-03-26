<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents\V03;

interface Data
{
    public function getContentEncoding() : ContentEncoding;

    public function getContentType() : ContentType;

    public function getData();
}
