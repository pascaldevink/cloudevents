<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents\Test;

use DateTimeImmutable;
use League\Uri\Uri;
use PascalDeVink\CloudEvents\CloudEvent;
use PascalDeVink\CloudEvents\ContentEncoding;
use PascalDeVink\CloudEvents\SpecVersion;
use PascalDeVink\CloudEvents\EventId;
use PascalDeVink\CloudEvents\EventType;
use PascalDeVink\CloudEvents\Extension\DistributedTracing;
use PascalDeVink\CloudEvents\Extensions;
use PascalDeVink\CloudEvents\JsonData;
use PascalDeVink\CloudEvents\SchemaUrl;
use PascalDeVink\CloudEvents\Source;
use PascalDeVink\CloudEvents\EventTime;
use PascalDeVink\CloudEvents\Subject;
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
            new EventId('89328232-6202-4758-8050-C9E4690431CA'),
            new Source(Uri::createFromString('github://pull')),
            new SpecVersion('0.1'),
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
    public function it_should_be_possible_to_pass_an_event_time()
    {
        $cloudEvent = new CloudEvent(
            new EventId('89328232-6202-4758-8050-C9E4690431CA'),
            new Source(Uri::createFromString('github://pull')),
            new SpecVersion('0.1'),
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
            new SpecVersion('0.1'),
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
            new SpecVersion('0.1'),
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
            new SpecVersion('0.1'),
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
            new SpecVersion('0.3'),
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
                'specversion'     => '0.3',
                'type'            => 'com.github.pull.create',
                'source'          => 'github://pull',
                'subject'         => '123',
                'id'              => '89328232-6202-4758-8050-C9E4690431CA',
                'time'            => '2018-08-09T21:55:16+00:00',
                'datacontenttype' => 'application/json',
                'extensions'      => [
                    'traceparent' => '00-F84CED4E37CB429D8ADA2D503CB9E111-44F11A993769-00',
                    'tracestate'  => 'foo=bar',
                ],
                'data'            => [],
            ],
            $cloudEventArray
        );
    }
}
