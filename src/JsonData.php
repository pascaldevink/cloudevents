<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents;

final class JsonData implements Data
{
    /**
     * @var mixed
     */
    private $data;

    private ContentEncoding $contentEncoding;

    private function __construct($data, ContentEncoding $contentEncoding)
    {
        $this->data            = $data;
        $this->contentEncoding = $contentEncoding;
    }

    public static function fromString(string $data, ContentEncoding $contentEncoding) : self
    {
        return new self($data, $contentEncoding);
    }

    public static function fromInteger(int $data, ContentEncoding $contentEncoding) : self
    {
        return new self($data, $contentEncoding);
    }

    public static function fromBoolean(bool $data, ContentEncoding $contentEncoding) : self
    {
        return new self($data, $contentEncoding);
    }

    public static function fromArray(array $data, ContentEncoding $contentEncoding) : self
    {
        return new self($data, $contentEncoding);
    }

    public function getContentType() : ContentType
    {
        return new ContentType('application/json');
    }

    public function getContentEncoding() : ContentEncoding
    {
        return $this->contentEncoding;
    }

    public function getData()
    {
        return $this->data;
    }
}
