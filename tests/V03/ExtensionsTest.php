<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents\Test\V03;

use PascalDeVink\CloudEvents\Extension\DistributedTracing;
use PascalDeVink\CloudEvents\V03\Extensions;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PascalDeVink\CloudEvents\V03\Extensions
 */
class ExtensionsTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_return_a_flattened_list_of_key_value_pairs_for_all_extensions()
    {
        $extensions = new Extensions(
            new DistributedTracing('foo', 'bar'),
        );

        $flattenedMap = $extensions->getKeyValuePairs();

        $this->assertSame(
            [
                'DistributedTracingExtension' => [
                    'traceparent' => 'foo',
                    'tracestate'  => 'bar',
                ],
            ],
            $flattenedMap
        );
    }
}
