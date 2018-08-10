<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents;

use PascalDeVink\CloudEvents\Extension\Extension;
use Webmozart\Assert\Assert;

class Extensions
{
    /**
     * @var array
     */
    private $listOfExtensions;

    public function __construct(array $listOfExtensions = [])
    {
        Assert::allIsInstanceOf($listOfExtensions, Extension::class);

        $this->listOfExtensions = $listOfExtensions;
    }

    public function getKeyValuePairs() : array
    {
        return array_merge(
            ...array_map(
                function (Extension $extension) : array {
                        return $extension->toArray();
                },
                $this->listOfExtensions
            )
        );
    }
}
