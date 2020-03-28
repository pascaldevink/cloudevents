# PascalDeVink\CloudEvents

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

PHP Implementation of [CloudEvents][link-cloudevents]. Supports version 0.3 of the specification.

## Install

Via Composer

``` bash
$ composer require pascaldevink/cloudevents
```

## Usage

``` php
$cloudEvent = new \PascalDeVink\CloudEvents\V03\CloudEvent(
    new EventId('89328232-6202-4758-8050-C9E4690431CA'),
    new Source(Uri::createFromString('github://pull')),
    new EventType('com.github.pull.create'),
    new SchemaUrl(Uri::createFromString('http://github.com/schema/pull')),
    new Subject('1234'),
    new EventTime(new DateTimeImmutable('2018-08-09T21:55:16+00:00')),
    null,
    JsonData::fromArray([])
);

$formatter = new \PascalDeVink\Format\JsonFormatter();
$jsonCloudEvent = $formatter->encode($cloudEvent);

echo $jsonCloudEvent;

$newCloudEvent = $formatter->decode($jsonCloudEvent);
```

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Credits

- [Pascal de Vink][link-author]
- [All Contributors][link-contributors]
    
## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/pascaldevink/cloudevents.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/pascaldevink/cloudevents/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/pascaldevink/cloudevents.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/pascaldevink/cloudevents.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/pascaldevink/cloudevents.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/pascaldevink/cloudevents
[link-travis]: https://travis-ci.org/pascaldevink/cloudevents
[link-scrutinizer]: https://scrutinizer-ci.com/g/pascaldevink/cloudevents/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/pascaldevink/cloudevents
[link-downloads]: https://packagist.org/packages/pascaldevink/cloudevents
[link-author]: https://github.com/pascaldevink
[link-contributors]: ../../contributors
[link-cloudevents]: https://cloudevents.io/
