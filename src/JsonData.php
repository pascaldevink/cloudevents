<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents;

final class JsonData implements Data
{
    /**
     * @var mixed
     */
    private $data;

    private function __construct($data)
    {
        $this->data = $data;
    }

    public static function fromString(string $data) : self
    {
        return new self($data);
    }

    public static function fromInteger(int $data) : self
    {
        return new self($data);
    }

    public static function fromBoolean(bool $data) : self
    {
        return new self($data);
    }

    public static function fromArray(array $data) : self
    {
        return new self($data);
    }

    public function getContentType() : ContentType
    {
        return new ContentType('application/json');
    }

    public function getData()
    {
        return $this->data;
    }
}
