<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents;

class CloudEvent
{
    private EventId     $eventId;

    private Source      $source;

    private SpecVersion $specVersion;

    private EventType   $eventType;

    private ?SchemaUrl  $schemaUrl;

    private ?Subject    $subject;

    private ?EventTime  $eventTime;

    private ?Extensions $extensions;

    private ?Data       $data;

    public function __construct(
        EventId $eventId,
        Source $source,
        SpecVersion $specVersion,
        EventType $eventType,
        ?SchemaUrl $schemaUrl = null,
        ?Subject $subject = null,
        ?EventTime $eventTime = null,
        ?Extensions $extensions = null,
        ?Data $data = null
    ) {
        $this->eventId     = $eventId;
        $this->source      = $source;
        $this->specVersion = $specVersion;
        $this->eventType   = $eventType;
        $this->subject     = $subject;
        $this->eventTime   = $eventTime;
        $this->schemaUrl   = $schemaUrl;
        $this->extensions  = $extensions;
        $this->data        = $data;
    }

    public function getEventId() : EventId
    {
        return $this->eventId;
    }

    public function getSource() : Source
    {
        return $this->source;
    }

    public function getSpecVersion() : SpecVersion
    {
        return $this->specVersion;
    }

    public function getEventType() : EventType
    {
        return $this->eventType;
    }

    public function getSchemaUrl() : ?SchemaUrl
    {
        return $this->schemaUrl;
    }

    public function getSubject() : ?Subject
    {
        return $this->subject;
    }

    public function getEventTime() : ?EventTime
    {
        return $this->eventTime;
    }

    public function getExtensions() : ?Extensions
    {
        return $this->extensions;
    }

    public function getData() : ?Data
    {
        return $this->data;
    }

    public function toArray() : array
    {
        return [
            'specversion'     => (string)$this->specVersion,
            'type'            => (string)$this->eventType,
            'source'          => (string)$this->source,
            'subject'         => $this->subject ? (string)$this->subject : null,
            'id'              => (string)$this->eventId,
            'time'            => $this->data ? (string)$this->eventTime : null,
            'datacontenttype' => $this->data ? (string)$this->data->getContentType() : null,
            'extensions'      => $this->extensions ? $this->extensions->getKeyValuePairs() : null,
            'data'            => $this->data ? $this->data->getData() : null,
        ];
    }
}
