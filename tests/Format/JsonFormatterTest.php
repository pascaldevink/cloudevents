<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents\Test\Format;

use DateTimeImmutable;
use League\Uri\Uri;
use PascalDeVink\CloudEvents\V03\CloudEvent;
use PascalDeVink\CloudEvents\V03\ContentEncoding;
use PascalDeVink\CloudEvents\V03\SpecVersion;
use PascalDeVink\CloudEvents\V03\EventId;
use PascalDeVink\CloudEvents\V03\EventTime;
use PascalDeVink\CloudEvents\V03\EventType;
use PascalDeVink\CloudEvents\Extension\DistributedTracing;
use PascalDeVink\CloudEvents\V03\Extensions;
use PascalDeVink\CloudEvents\Format\JsonFormatter;
use PascalDeVink\CloudEvents\V03\JsonData;
use PascalDeVink\CloudEvents\V03\SchemaUrl;
use PascalDeVink\CloudEvents\V03\Source;
use PascalDeVink\CloudEvents\V03\Subject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PascalDeVink\CloudEvents\Format\JsonFormatter
 */
class JsonFormatterTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_encode_an_entire_cloud_event_as_json()
    {
        $cloudEvent = new CloudEvent(
            new EventId('89328232-6202-4758-8050-C9E4690431CA'),
            new Source(Uri::createFromString('github://pull')),
            new EventType('com.github.pull.create'),
            new SchemaUrl(Uri::createFromString('http://github.com/schema/pull')),
            new Subject('1234'),
            new EventTime(new DateTimeImmutable('2018-08-09T21:55:16+00:00')),
            new Extensions(
                new DistributedTracing('00-F84CED4E37CB429D8ADA2D503CB9E111-44F11A993769-00', 'foo=bar'),
            ),
            JsonData::fromArray([], new ContentEncoding('base64'))
        );

        $formatter = new JsonFormatter();
        $formattedCloudEvent = $formatter->encode($cloudEvent);

        $this->assertEquals(
            '{"specversion":"0.3","type":"com.github.pull.create",'
            . '"source":"github:\/\/pull","subject":"1234","id":"89328232-6202-4758-8050-C9E4690431CA",'
            . '"schemaurl":"http:\/\/github.com\/schema\/pull","time":"2018-08-09T21:55:16+00:00",'
            . '"datacontenttype":"application\/json","datacontentencoding":"base64","data":[],'
            . '"DistributedTracingExtension":{"traceparent":"00-F84CED4E37CB429D8ADA2D503CB9E111-44F11A993769-00",'
            . '"tracestate":"foo=bar"}}',
            $formattedCloudEvent
        );
    }

    /**
     * @test
     */
    public function it_should_filter_out_null_values()
    {
        $cloudEvent = new CloudEvent(
            new EventId('89328232-6202-4758-8050-C9E4690431CA'),
            new Source(Uri::createFromString('github://pull')),
            new EventType('com.github.pull.create'),
        );

        $formatter = new JsonFormatter();
        $formattedCloudEvent = $formatter->encode($cloudEvent);

        $this->assertEquals(
            '{"specversion":"0.3","type":"com.github.pull.create","source":"github:\/\/pull",'
            .'"id":"89328232-6202-4758-8050-C9E4690431CA"}',
            $formattedCloudEvent
        );
    }

    /**
     * @test
     */
    public function it_should_decode_an_json_object_to_a_cloud_event() : void
    {
        $json = '{"specversion":"0.3","type":"com.github.pull.create",'
            . '"source":"github:\/\/pull","subject":"1234","id":"89328232-6202-4758-8050-C9E4690431CA",'
            . '"schemaurl":"http:\/\/github.com\/schema\/pull","time":"2018-08-09T21:55:16+00:00",'
            . '"datacontenttype":"application\/json","datacontentencoding":"base64","data":[],'
            . '"DistributedTracingExtension":{"traceparent":"00-F84CED4E37CB429D8ADA2D503CB9E111-44F11A993769-00",'
            . '"tracestate":"foo=bar"}}';

        $formatter = new JsonFormatter();
        $cloudEvent = $formatter->decode($json);

        $this->assertEquals('com.github.pull.create', $cloudEvent->getEventType());
        $this->assertEquals('89328232-6202-4758-8050-C9E4690431CA', $cloudEvent->getEventId());
        $this->assertEquals('github://pull', $cloudEvent->getSource());
        $this->assertEquals('0.3', $cloudEvent->getSpecVersion());
        $this->assertEquals('http://github.com/schema/pull', $cloudEvent->getSchemaUrl());
        $this->assertEquals('1234', $cloudEvent->getSubject());
        $this->assertEquals('2018-08-09T21:55:16+00:00', $cloudEvent->getEventTime());
        $this->assertEquals('application/json', $cloudEvent->getData()->getContentType());
        $this->assertEquals('base64', $cloudEvent->getData()->getContentEncoding());
        $this->assertEquals([], $cloudEvent->getData()->getData());
        $this->assertCount(1, $cloudEvent->getExtensions()->getListOfExtensions());
        $this->assertEquals(
            '00-F84CED4E37CB429D8ADA2D503CB9E111-44F11A993769-00',
            $cloudEvent->getExtensions()->getListOfExtensions()[0]->getTraceParent()
        );
        $this->assertEquals('foo=bar', $cloudEvent->getExtensions()->getListOfExtensions()[0]->getTraceState());
    }
}
