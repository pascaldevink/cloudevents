<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents;

use Webmozart\Assert\Assert;

final class ContentEncoding
{
    private string $encoding;

    public function __construct(string $encoding)
    {
        Assert::oneOf(
            $encoding,
            [
                "7bit",
                "8bit",
                "binary",
                "quoted-printable",
                "base64",
                "ietf-token",
                "x-token",
            ]
        );

        $this->encoding = $encoding;
    }

    public function __toString() : string
    {
        return $this->encoding;
    }
}
