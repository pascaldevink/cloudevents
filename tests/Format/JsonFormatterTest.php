<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents\Format\Test;

use DateTimeImmutable;
use League\Uri\Uri;
use PascalDeVink\CloudEvents\CloudEvent;
use PascalDeVink\CloudEvents\ContentEncoding;
use PascalDeVink\CloudEvents\SpecVersion;
use PascalDeVink\CloudEvents\EventId;
use PascalDeVink\CloudEvents\EventTime;
use PascalDeVink\CloudEvents\EventType;
use PascalDeVink\CloudEvents\Extension\DistributedTracing;
use PascalDeVink\CloudEvents\Extensions;
use PascalDeVink\CloudEvents\Format\JsonFormatter;
use PascalDeVink\CloudEvents\JsonData;
use PascalDeVink\CloudEvents\SchemaUrl;
use PascalDeVink\CloudEvents\Source;
use PascalDeVink\CloudEvents\Subject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PascalDeVink\CloudEvents\Format\JsonFormatter
 */
class JsonFormatterTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_format_an_entire_cloud_event_as_json()
    {
        $cloudEvent = new CloudEvent(
            new EventId('89328232-6202-4758-8050-C9E4690431CA'),
            new Source(Uri::createFromString('github://pull')),
            new SpecVersion('0.3'),
            new EventType('com.github.pull.create', '1.0.0'),
            new SchemaUrl(Uri::createFromString('http://github.com/schema/pull')),
            new Subject('1234'),
            new EventTime(new DateTimeImmutable('2018-08-09T21:55:16+00:00')),
            new Extensions(
                new DistributedTracing('00-F84CED4E37CB429D8ADA2D503CB9E111-44F11A993769-00', 'foo=bar'),
            ),
            JsonData::fromArray([], new ContentEncoding('base64'))
        );

        $formatter = new JsonFormatter();
        $formattedCloudEvent = $formatter->format($cloudEvent);

        $this->assertEquals(
            '{"specversion":"0.3","type":"com.github.pull.create",'
            . '"source":"github:\/\/pull","subject":"1234","id":"89328232-6202-4758-8050-C9E4690431CA",'
            . '"time":"2018-08-09T21:55:16+00:00","datacontenttype":"application\/json",'
            . '"extensions":{"traceparent":"00-F84CED4E37CB429D8ADA2D503CB9E111-44F11A993769-00",'
            . '"tracestate":"foo=bar"},"data":[]}',
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
            new SpecVersion('0.3'),
            new EventType('com.github.pull.create'),
        );

        $formatter = new JsonFormatter();
        $formattedCloudEvent = $formatter->format($cloudEvent);

        $this->assertEquals(
            '{"specversion":"0.3","type":"com.github.pull.create","source":"github:\/\/pull",'
            .'"id":"89328232-6202-4758-8050-C9E4690431CA"}',
            $formattedCloudEvent
        );
    }
}
