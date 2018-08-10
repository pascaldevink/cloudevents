<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents;

class CloudEvent
{
    /**
     * @var EventType
     */
    private $eventType;

    /**
     * @var CloudEventsVersion
     */
    private $cloudEventsVersion;

    /**
     * @var Source
     */
    private $source;

    /**
     * @var EventId
     */
    private $eventId;

    /**
     * @var null|EventTime
     */
    private $eventTime;

    /**
     * @var null|SchemaUrl
     */
    private $schemaUrl;

    /**
     * @var null|Data
     */
    private $data;

    public function __construct(
        EventType $eventType,
        CloudEventsVersion $cloudEventsVersion,
        Source $source,
        EventId $eventId,
        ?EventTime $eventTime = null,
        ?SchemaUrl $schemaUrl = null,
        ?Data $data = null
    ) {
        $this->eventType          = $eventType;
        $this->cloudEventsVersion = $cloudEventsVersion;
        $this->source             = $source;
        $this->eventId            = $eventId;
        $this->eventTime          = $eventTime;
        $this->schemaUrl          = $schemaUrl;
        $this->data               = $data;
    }

    public function getEventType() : EventType
    {
        return $this->eventType;
    }

    public function getCloudEventsVersion() : CloudEventsVersion
    {
        return $this->cloudEventsVersion;
    }

    public function getSource() : Source
    {
        return $this->source;
    }

    public function getEventId() : EventId
    {
        return $this->eventId;
    }

    public function getEventTime() : ?EventTime
    {
        return $this->eventTime;
    }

    public function getSchemaUrl() : ?SchemaUrl
    {
        return $this->schemaUrl;
    }

    public function getData() : ?Data
    {
        return $this->data;
    }

    public function toArray() : array
    {
        return [
            'eventType' => $this->eventType->getValue(),
            'eventTypeVersion' => $this->eventType->getVersion(),
            'cloudEventsVersion' => (string) $this->cloudEventsVersion,
            'source' => (string) $this->source,
            'eventID' => (string) $this->eventId,
            'eventTime' => $this->data ? (string) $this->eventTime : null,
            'schemaURL' => $this->data ? (string) $this->schemaUrl : null,
            'contentType' => $this->data ? (string) $this->data->getContentType() : null,
            'data' => $this->data ? $this->data->getData() : null,
        ];
    }
}
