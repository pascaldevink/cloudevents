<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents\Test;

use DateTimeImmutable;
use League\Uri\Uri;
use PascalDeVink\CloudEvents\CloudEvent;
use PascalDeVink\CloudEvents\CloudEventsVersion;
use PascalDeVink\CloudEvents\ContentType;
use PascalDeVink\CloudEvents\EventId;
use PascalDeVink\CloudEvents\EventType;
use PascalDeVink\CloudEvents\Extension\DistributedTracing;
use PascalDeVink\CloudEvents\Extensions;
use PascalDeVink\CloudEvents\JsonData;
use PascalDeVink\CloudEvents\SchemaUrl;
use PascalDeVink\CloudEvents\Source;
use PascalDeVink\CloudEvents\EventTime;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PascalDeVink\CloudEvents\CloudEvent
 */
class CloudEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_be_possible_to_create_a_basic_cloud_event()
    {
        $cloudEvent = new CloudEvent(
            new EventType('com.github.pull.create'),
            new CloudEventsVersion('0.1'),
            new Source(Uri::createFromString('github://pull')),
            new EventId('89328232-6202-4758-8050-C9E4690431CA')
        );

        $this->assertNotNull($cloudEvent->getEventType());
        $this->assertNotNull($cloudEvent->getCloudEventsVersion());
        $this->assertNotNull($cloudEvent->getSource());
        $this->assertNotNull($cloudEvent->getEventId());
    }
    
    /**
     * @test
     */
    public function it_should_be_possible_to_pass_an_event_time()
    {
        $cloudEvent = new CloudEvent(
            new EventType('com.github.pull.create'),
            new CloudEventsVersion('0.1'),
            new Source(Uri::createFromString('github://pull')),
            new EventId('89328232-6202-4758-8050-C9E4690431CA'),
            new EventTime(new DateTimeImmutable())
        );

        $this->assertNotNull($cloudEvent->getEventTime());
    }

    /**
     * @test
     */
    public function it_should_be_possible_to_pass_a_schema_url()
    {
        $cloudEvent = new CloudEvent(
            new EventType('com.github.pull.create'),
            new CloudEventsVersion('0.1'),
            new Source(Uri::createFromString('github://pull')),
            new EventId('89328232-6202-4758-8050-C9E4690431CA'),
            null,
            new SchemaUrl(Uri::createFromString('http://github.com/schema/pull'))
        );

        $this->assertNotNull($cloudEvent->getSchemaUrl());
    }

    /**
     * @test
     */
    public function it_should_be_possible_to_pass_extensions()
    {
        $cloudEvent = new CloudEvent(
            new EventType('com.github.pull.create'),
            new CloudEventsVersion('0.1'),
            new Source(Uri::createFromString('github://pull')),
            new EventId('89328232-6202-4758-8050-C9E4690431CA'),
            null,
            null,
            new Extensions(
                [
                    new DistributedTracing('00-F84CED4E37CB429D8ADA2D503CB9E111-44F11A993769-00'),
                ]
            )
        );

        $this->assertNotNull($cloudEvent->getExtensions());
    }

    /**
     * @test
     */
    public function it_should_be_possible_to_pass_data()
    {
        $cloudEvent = new CloudEvent(
            new EventType('com.github.pull.create'),
            new CloudEventsVersion('0.1'),
            new Source(Uri::createFromString('github://pull')),
            new EventId('89328232-6202-4758-8050-C9E4690431CA'),
            null,
            null,
            null,
            JsonData::fromArray([])
        );

        $this->assertNotNull($cloudEvent->getData());
    }

    /**
     * @test
     */
    public function it_should_convert_a_cloud_event_to_an_array()
    {
        $cloudEvent = new CloudEvent(
            new EventType('com.github.pull.create', '1.0.0'),
            new CloudEventsVersion('0.1'),
            new Source(Uri::createFromString('github://pull')),
            new EventId('89328232-6202-4758-8050-C9E4690431CA'),
            new EventTime(new DateTimeImmutable('2018-08-09T21:55:16+00:00')),
            new SchemaUrl(Uri::createFromString('http://github.com/schema/pull')),
            new Extensions(
                [
                    new DistributedTracing('00-F84CED4E37CB429D8ADA2D503CB9E111-44F11A993769-00', 'foo=bar'),
                ]
            ),
            JsonData::fromArray([])
        );

        $cloudEventArray = $cloudEvent->toArray();

        $this->assertSame(
            [
                'eventType' => 'com.github.pull.create',
                'eventTypeVersion' => '1.0.0',
                'cloudEventsVersion' => '0.1',
                'source' => 'github://pull',
                'eventID' => '89328232-6202-4758-8050-C9E4690431CA',
                'eventTime' => '2018-08-09T21:55:16+00:00',
                'schemaURL' => 'http://github.com/schema/pull',
                'contentType' => 'application/json',
                'extensions' => [
                    'traceparent' => '00-F84CED4E37CB429D8ADA2D503CB9E111-44F11A993769-00',
                    'tracestate' => 'foo=bar',
                ],
                'data' => [],
            ],
            $cloudEventArray
        );
    }
}
