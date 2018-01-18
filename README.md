![file-config](:hero)

# File Config

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-circleci]][link-circleci]
[![StyleCI][ico-styleci]][link-styleci]

This package provides a persistent config store as flat files with an easy
to use and understand interface. Writing your own stores is also made simple
due to its driver-based infrastructure.

## Index
- [Installation](#installation)
  - [Downloading](#downloading)
- [Usage](#usage)
  - [Retrieving config values](#retrieving-config-values)
  - [Setting config values](#setting-config-values)
  - [Deleting config values](#deleting-config-values)
- [Contributing](#contributing)
- [License](#license)

## Installation
You'll have to follow a couple of simple steps to install this package.

### Downloading
Via [composer](http://getcomposer.org):

```bash
$ composer require sven/file-config
```

Or add the package to your dependencies in `composer.json` and run
`composer update sven/file-config` on the command line to download
the package:

```json
{
    "require": {
        "sven/file-config": "^1.0"
    }
}
```

## Usage
To get started, create a new store object with an instance of `\League\Flysystem\File`. 
This file is where your configuration will live:

```php
$adapter = new \League\Flysystem\Adapter\Local(__DIR__);
$filesystem = new \League\Flysystem\Filesystem($adapter);
$file = new \League\Flysystem\File($filesystem, 'path/to/file.json');

$config = new \Sven\FileConfig\Json($file);
```

### Retrieving config values
As you can see in `\Sven\FileConfig\Store`, all stores provide a `->get($key)` method.
This method will retrieve a configuration value by its key.

```json
{
    "database": {
        "name": "test",
        "host": "localhost",
        "user": "admin",
        "password": "root"
    }
}
```

```php
$config->get('database'); 
// ~> ['name' => 'test', 'host' => 'localhost', 'user' => 'admin', 'password' => root']

$config->get('database.host'); 
// ~> 'localhost'
```

### Setting config values
The `\Sven\FileConfig\Store` interface also provides a `->set($key, $value)` method:

```json
{
    "database": {}
}
```

```php
$config->set('database.user', 'admin');
// ~> true (file was changed)

$config->set('does.not', 'exist');
// ~> true (file was changed)
```

```json
{
    "database": {
        "user": "admin"
    },
    "does": {
        "not": "exist"
    }
}
```

### Deleting config values
Another method the interface provides is `->delete($key)`:

```json
{
    "database": {
        "user": "admin",
        "host": "localhost"
    },
    "deeply": {
        "nested": [
            "value"
        ]
    }
}
```

```php
$config->delete('database.user');
// ~> true (file was changed)

$config->delete('deeply.nested');
// ~> true (file was changed)
```

```json
{
    "database": {
        "host": "localhost"
    },
    "deeply": {}
}
```

> **NOTE:** It is up to the developer to make sure this value should immediately be
persisted, this package is "destructive" by default.

## Contributing
All contributions (pull requests, issues and feature requests) are
welcome. Make sure to read through the [CONTRIBUTING.md](CONTRIBUTING.md) first,
though. See the [contributors page](../../graphs/contributors) for all contributors.

## License
`sven/file-config` is licensed under the MIT License (MIT). Please see the
[license file](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sven/file-config.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-green.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sven/file-config.svg?style=flat-square
[ico-circleci]: https://img.shields.io/circleci/project/github/svenluijten/file-config.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/:styleci/shield

[link-packagist]: https://packagist.org/packages/sven/file-config
[link-downloads]: https://packagist.org/packages/sven/file-config
[link-circleci]: https://circleci.com/gh/svenluijten/file-config
[link-styleci]: https://styleci.io/repos/:styleci
