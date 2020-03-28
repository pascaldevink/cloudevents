<?php

declare(strict_types=1);

namespace PascalDeVink\CloudEvents\V03;

use PascalDeVink\CloudEvents\Extension\Extension;

class Extensions
{
    private array $listOfExtensions;

    public function __construct(Extension ...$listOfExtensions)
    {
        $this->listOfExtensions = $listOfExtensions;
    }

    /**
     * @return Extension[]
     */
    public function getListOfExtensions() : array
    {
        return $this->listOfExtensions;
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
