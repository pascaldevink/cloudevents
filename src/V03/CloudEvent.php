<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents\V03;

use DateTimeImmutable;
use League\Uri\Uri;
use PascalDeVink\CloudEvents\Extension\DistributedTracing;
use Webmozart\Assert\Assert;

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
        EventType $eventType,
        ?SchemaUrl $schemaUrl = null,
        ?Subject $subject = null,
        ?EventTime $eventTime = null,
        ?Extensions $extensions = null,
        ?Data $data = null
    ) {
        $this->eventId     = $eventId;
        $this->source      = $source;
        $this->specVersion = new SpecVersion('0.3');
        $this->eventType   = $eventType;
        $this->subject     = $subject;
        $this->eventTime   = $eventTime;
        $this->schemaUrl   = $schemaUrl;
        $this->extensions  = $extensions;
        $this->data        = $data;
    }

    public static function fromArray(array $eventData) : self
    {
        Assert::keyExists($eventData, 'type');
        Assert::keyExists($eventData, 'source');
        Assert::keyExists($eventData, 'id');

        $data = null;

        if (isset($eventData['data']) === true) {
            Assert::keyExists($eventData, 'datacontenttype');
            Assert::keyExists($eventData, 'datacontentencoding');

            $data = JsonData::fromArray(
                $eventData['data'],
                new ContentEncoding($eventData['datacontentencoding'])
            );
        }

        $extensions = null;

        if (isset($eventData['DistributedTracingExtension']) === true) {
            $extensions = new Extensions(
                new DistributedTracing(
                    $eventData['DistributedTracingExtension']['traceparent'],
                    $eventData['DistributedTracingExtension']['tracestate'],
                )
            );
        }

        return new self(
            new EventId($eventData['id']),
            new Source(Uri::createFromString($eventData['source'])),
            new EventType($eventData['type']),
            isset($eventData['schemaurl']) ? new SchemaUrl(Uri::createFromString($eventData['schemaurl'])) : null,
            isset($eventData['subject']) ? new Subject($eventData['subject']) : null,
            isset($eventData['time']) ? new EventTime(new DateTimeImmutable($eventData['time'])) : null,
            $extensions,
            $data
        );
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
        $extensions = [];

        if ($this->extensions !== null) {
            $extensions = $this->extensions->getKeyValuePairs();
        }

        return array_merge(
            [
                'specversion'         => (string)$this->specVersion,
                'type'                => (string)$this->eventType,
                'source'              => (string)$this->source,
                'subject'             => $this->subject ? (string)$this->subject : null,
                'id'                  => (string)$this->eventId,
                'schemaurl'           => $this->schemaUrl ? (string)$this->schemaUrl : null,
                'time'                => $this->data ? (string)$this->eventTime : null,
                'datacontenttype'     => $this->data ? (string)$this->data->getContentType() : null,
                'datacontentencoding' => $this->data ? (string)$this->data->getContentEncoding() : null,
                'data'                => $this->data ? $this->data->getData() : null,
            ],
            $extensions
        );
    }
}
