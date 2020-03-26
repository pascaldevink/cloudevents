<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents\Test\V03;

use InvalidArgumentException;
use PascalDeVink\CloudEvents\V03\EventType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PascalDeVink\CloudEvents\V03\EventType
 */
class EventTypeTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_be_possible_to_create_an_event_type()
    {
        $eventType = new EventType('com.github.pull.create');

        $this->assertSame('com.github.pull.create', $eventType->__toString());
    }

    /**
     * @test
     */
    public function it_should_not_be_possible_to_create_an_event_type_with_an_empty_value()
    {
        $this->expectException(InvalidArgumentException::class);

        new EventType('');
    }
}
