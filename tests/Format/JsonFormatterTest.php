<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents\Format\Test;

use DateTimeImmutable;
use League\Uri\Uri;
use PascalDeVink\CloudEvents\CloudEvent;
use PascalDeVink\CloudEvents\CloudEventsVersion;
use PascalDeVink\CloudEvents\EventId;
use PascalDeVink\CloudEvents\EventTime;
use PascalDeVink\CloudEvents\EventType;
use PascalDeVink\CloudEvents\Extension\DistributedTracing;
use PascalDeVink\CloudEvents\Extensions;
use PascalDeVink\CloudEvents\Format\JsonFormatter;
use PascalDeVink\CloudEvents\JsonData;
use PascalDeVink\CloudEvents\SchemaUrl;
use PascalDeVink\CloudEvents\Source;
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

        $formatter = new JsonFormatter();
        $formattedCloudEvent = $formatter->format($cloudEvent);

        $this->assertEquals(
            '{"eventType":"com.github.pull.create","eventTypeVersion":"1.0.0","cloudEventsVersion":"0.1",'
            . '"source":"github:\/\/pull","eventID":"89328232-6202-4758-8050-C9E4690431CA",'
            . '"eventTime":"2018-08-09T21:55:16+00:00","schemaURL":"http:\/\/github.com\/schema\/pull",'
            . '"contentType":"application\/json",'
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
            new EventType('com.github.pull.create'),
            new CloudEventsVersion('0.1'),
            new Source(Uri::createFromString('github://pull')),
            new EventId('89328232-6202-4758-8050-C9E4690431CA')
        );

        $formatter = new JsonFormatter();
        $formattedCloudEvent = $formatter->format($cloudEvent);

        $this->assertEquals(
            '{"eventType":"com.github.pull.create","cloudEventsVersion":"0.1","source":"github:\/\/pull",'
            .'"eventID":"89328232-6202-4758-8050-C9E4690431CA"}',
            $formattedCloudEvent
        );
    }
}
