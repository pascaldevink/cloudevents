<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents\Test\V03;

use DateTimeImmutable;
use League\Uri\Uri;
use PascalDeVink\CloudEvents\V03\CloudEvent;
use PascalDeVink\CloudEvents\V03\ContentEncoding;
use PascalDeVink\CloudEvents\V03\SpecVersion;
use PascalDeVink\CloudEvents\V03\EventId;
use PascalDeVink\CloudEvents\V03\EventType;
use PascalDeVink\CloudEvents\Extension\DistributedTracing;
use PascalDeVink\CloudEvents\V03\Extensions;
use PascalDeVink\CloudEvents\V03\JsonData;
use PascalDeVink\CloudEvents\V03\SchemaUrl;
use PascalDeVink\CloudEvents\V03\Source;
use PascalDeVink\CloudEvents\V03\EventTime;
use PascalDeVink\CloudEvents\V03\Subject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PascalDeVink\CloudEvents\V03\CloudEvent
 */
class CloudEventTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_be_possible_to_create_a_basic_cloud_event()
    {
        $cloudEvent = new CloudEvent(
            new EventId('89328232-6202-4758-8050-C9E4690431CA'),
            new Source(Uri::createFromString('github://pull')),
            new EventType('com.github.pull.create')
        );

        $this->assertNotNull($cloudEvent->getEventType());
        $this->assertNotNull($cloudEvent->getSpecVersion());
        $this->assertNotNull($cloudEvent->getSource());
        $this->assertNotNull($cloudEvent->getEventId());
    }

    /**
     * @test
     */
    public function it_should_be_possible_to_pass_a_subject()
    {
        $cloudEvent = new CloudEvent(
            new EventId('89328232-6202-4758-8050-C9E4690431CA'),
            new Source(Uri::createFromString('github://pull')),
            new EventType('com.github.pull.create'),
            null,
            new Subject('1234'),
        );

        $this->assertNotNull($cloudEvent->getSubject());
    }

    /**
     * @test
     */
    public function it_should_be_possible_to_pass_an_event_time()
    {
        $cloudEvent = new CloudEvent(
            new EventId('89328232-6202-4758-8050-C9E4690431CA'),
            new Source(Uri::createFromString('github://pull')),
            new EventType('com.github.pull.create'),
            null,
            null,
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
            new EventId('89328232-6202-4758-8050-C9E4690431CA'),
            new Source(Uri::createFromString('github://pull')),
            new EventType('com.github.pull.create'),
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
            new EventId('89328232-6202-4758-8050-C9E4690431CA'),
            new Source(Uri::createFromString('github://pull')),
            new EventType('com.github.pull.create'),
            null,
            null,
            null,
            new Extensions(
                new DistributedTracing('00-F84CED4E37CB429D8ADA2D503CB9E111-44F11A993769-00'),
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
            new EventId('89328232-6202-4758-8050-C9E4690431CA'),
            new Source(Uri::createFromString('github://pull')),
            new EventType('com.github.pull.create'),
            null,
            null,
            null,
            null,
            JsonData::fromArray([], new ContentEncoding('base64'))
        );

        $this->assertNotNull($cloudEvent->getData());
    }

    /**
     * @test
     */
    public function it_should_convert_a_cloud_event_to_an_array()
    {
        $cloudEvent = new CloudEvent(
            new EventId('89328232-6202-4758-8050-C9E4690431CA'),
            new Source(Uri::createFromString('github://pull')),
            new EventType('com.github.pull.create'),
            new SchemaUrl(Uri::createFromString('http://github.com/schema/pull')),
            new Subject('123'),
            new EventTime(new DateTimeImmutable('2018-08-09T21:55:16+00:00')),
            new Extensions(
                new DistributedTracing('00-F84CED4E37CB429D8ADA2D503CB9E111-44F11A993769-00', 'foo=bar'),
            ),
            JsonData::fromArray([], new ContentEncoding('base64'))
        );

        $cloudEventArray = $cloudEvent->toArray();

        $this->assertSame(
            [
                'specversion'                 => '0.3',
                'type'                        => 'com.github.pull.create',
                'source'                      => 'github://pull',
                'subject'                     => '123',
                'id'                          => '89328232-6202-4758-8050-C9E4690431CA',
                'schemaurl'                   => 'http://github.com/schema/pull',
                'time'                        => '2018-08-09T21:55:16+00:00',
                'datacontenttype'             => 'application/json',
                'datacontentencoding'         => 'base64',
                'data'                        => [],
                'DistributedTracingExtension' => [
                    'traceparent' => '00-F84CED4E37CB429D8ADA2D503CB9E111-44F11A993769-00',
                    'tracestate'  => 'foo=bar',
                ],
            ],
            $cloudEventArray
        );
    }

    /**
     * @test
     */
    public function it_should_convert_an_array_to_a_cloud_event() : void
    {
        $array = [
            'specversion'                 => '0.3',
            'type'                        => 'com.github.pull.create',
            'source'                      => 'github://pull',
            'subject'                     => '123',
            'id'                          => '89328232-6202-4758-8050-C9E4690431CA',
            'schemaurl'                   => 'http://github.com/schema/pull',
            'time'                        => '2018-08-09T21:55:16+00:00',
            'datacontenttype'             => 'application/json',
            'datacontentencoding'         => 'base64',
            'data'                        => [],
            'DistributedTracingExtension' => [
                'traceparent' => '00-F84CED4E37CB429D8ADA2D503CB9E111-44F11A993769-00',
                'tracestate'  => 'foo=bar',
            ],
        ];

        $cloudEvent = CloudEvent::fromArray($array);

        $this->assertNotNull($cloudEvent->getEventType());
        $this->assertNotNull($cloudEvent->getSpecVersion());
        $this->assertNotNull($cloudEvent->getSource());
        $this->assertNotNull($cloudEvent->getEventId());
    }
}
