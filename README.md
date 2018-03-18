![file-config](https://user-images.githubusercontent.com/11269635/35174536-129cc67e-fd70-11e7-8b87-d2ba8cc24ec8.jpg)

# File Config

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-circleci]][link-circleci]
[![StyleCI][ico-styleci]][link-styleci]

This package provides a persistent config store as flat files with an easy
to use and understand API. This is perfect if the config file should be 
stored in userland, or somewhere the user is allowed to edit it manually.

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
        "sven/file-config": "^2.0"
    }
}
```

## Usage
To get started, create a new store object with an instance of `\Sven\FileConfig\File`. 
This file is where your configuration will live:

```php
use Sven\FileConfig\File;
use Sven\FileConfig\Stores\Json;

$file = new File('path/to/file.json');
$config = new Json($file);
```

As you can see in `\Sven\FileConfig\Stores\Store`, all stores provide `->get($key)`,
`->set($key, $value)`, and `->delete($key)` methods. These methods allow you to interact
with the file on disk.

### Example
Let's take a look at some examples:

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

```php
$config->set('database.user', 'admin');
// ~> true (file was changed)

$config->set('does.not', 'exist');
// ~> true (file was changed)
```

```json
{
    "database": {
        ...
        "user": "admin"
    },
    "does": {
        "not": "exist"
    }
}
```

```php
$config->delete('database.user');
// ~> true (file was changed)

$config->delete('does.not');
// ~> true (file was changed)
```

```json
{
    "database": {
        "name": "test",
        "host": "localhost",
        "password": "root"
    }
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
[ico-styleci]: https://styleci.io/repos/117891803/shield

[link-packagist]: https://packagist.org/packages/sven/file-config
[link-downloads]: https://packagist.org/packages/sven/file-config
[link-circleci]: https://circleci.com/gh/svenluijten/file-config
[link-styleci]: https://styleci.io/repos/117891803
