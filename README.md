Sportradar SDK
==============

![CI](https://github.com/axl-media-org/sportradar-sdk/workflows/CI/badge.svg?branch=master)
[![codecov](https://codecov.io/gh/axl-media-org/sportradar-sdk/branch/master/graph/badge.svg)](https://codecov.io/gh/axl-media-org/sportradar-sdk/branch/master)
[![StyleCI](https://github.styleci.io/repos/329301580/shield?branch=master)](https://github.styleci.io/repos/329301580)
[![Latest Stable Version](https://poser.pugx.org/axl-media-org/sportradar-sdk/v/stable)](https://packagist.org/packages/axl-media-org/sportradar-sdk)
[![Total Downloads](https://poser.pugx.org/axl-media-org/sportradar-sdk/downloads)](https://packagist.org/packages/axl-media-org/sportradar-sdk)
[![Monthly Downloads](https://poser.pugx.org/axl-media-org/sportradar-sdk/d/monthly)](https://packagist.org/packages/axl-media-org/sportradar-sdk)
[![License](https://poser.pugx.org/axl-media-org/sportradar-sdk/license)](https://packagist.org/packages/axl-media-org/sportradar-sdk)

Sportradar SDK is a PHP-based SDK to work with the Sportradar API & live events.

## 🚀 Installation

You can install the package via composer:

```bash
composer require axl-media-org/sportradar-sdk
```

Publish the config:

```bash
$ php artisan vendor:publish --provider="AxlMedia\SportradarSdk\SportradarSdkServiceProvider" --tag="config"
```

## 🙌 Usage

```php
use AxlMedia\SportradarSdk\Facades\Facade as Sportradar;

$summaries = Sportradar::sport('soccer')
    ->sportEvents()
    ->from('summaries')
    ->getLiveSummaries();

foreach ($summaries as $match) {
    foreach ($match['sport_event']['competitors'] as $team) {
        //
    }
}
```

## 🐛 Testing

``` bash
vendor/bin/phpunit
```

## 🤝 Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## 🎉 Credits

- [All Contributors](../../contributors)
