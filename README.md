![file-config](https://user-images.githubusercontent.com/11269635/35174536-129cc67e-fd70-11e7-8b87-d2ba8cc24ec8.jpg)

# File Config

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-build]][link-build]
[![StyleCI][ico-styleci]][link-styleci]

This package provides a persistent config store as flat files with an easy
to use and understand API. This is perfect if the config file should be 
stored in userland, or somewhere the user is allowed to edit it manually.

## Installation
You'll have to follow a couple of simple steps to install this package.

### Downloading
Via [composer](http://getcomposer.org):

```bash
$ composer require sven/file-config:^3.1
```

Or add the package to your dependencies in `composer.json` and run
`composer update sven/file-config` on the command line to download
the package:

```json
{
    "require": {
        "sven/file-config": "^3.1"
    }
}
```

## Available drivers
- [`Json`](./src/Drivers/Json.php) - For `.json` files.
- [`DotEnv`](./src/Drivers/DotEnv.php) - For `.env` files.
- [`Env` (deprecated)](./src/Drivers/Env.php)

You can also write your own driver to use in your own applications. To write your
own, read [writing your own driver](#writing-your-own-driver) in this document.

## Usage
To get started, construct a new instance of `\Sven\FileConfig\Store`, providing it with a `\Sven\FileConfig\File`
object, and an implementation of the `\Sven\FileConfig\Drivers\Driver` interface. We'll use the pre-installed 
`Json` driver in the examples.

```php
use Sven\FileConfig\File;
use Sven\FileConfig\Store;
use Sven\FileConfig\Drivers\Json;

$file = new File('/path/to/file.json');
$config = new Store($file, new Json());
```

You can interact with your newly created `$config` object via the `get`, `set`, and `delete` 
methods.

### Examples
Let's take a look at some examples.

#### Getting a value from the file
To retrieve a value from the configuration file, use the `get` method. Let's assume our (prettified)
JSON configuration file looks like this:

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

We can get the entire `database` array:

```php
$config->get('database'); 
// ~> ['name' => 'test', 'host' => 'localhost', 'user' => 'admin', 'password' => root']
```

... or get only the `database.host` property using dot-notation:

```php
$config->get('database.host'); 
// ~> 'localhost'
```

If the given key can not be found, `null` is returned by default. You may override this by
passing a second argument to `get`:

```php
$config->get('database.does_not_exist', 'default');
// ~> 'default'
```

#### Setting a value in the file
To add or change a value in the configuration file, you may use the `set` method. Note that
you have to call the `persist` method to write the changes you made to the file. You may also
use the `fresh` method to retrieve a "fresh" instance of the `Store`, where the values will be
read from the file again.

```php
$config->set('database.user', 'new-username');
$config->persist();

$freshConfig = $config->fresh();
$freshConfig->get('database.user');
// ~> 'new-username'
```

The file will end up looking like this after you've called the `persist` method:

```json
{
    "database": {
        "name": "test",
        "host": "localhost",
        "user": "new-username",
        "password": "root"
    }
}
```

#### Deleting an entry from the file
To remove one of the configuration options from the file, use the `delete` method. Again, don't forget
to call `persist` to write the new contents to the file!

```php
$config->delete('database.user');
$config->persist();
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

## Writing your own driver
You may want to use a file format for your configuration that's not (yet) included in
this package. Thankfully, writing a driver is as straightforward as turning your file's
contents into a PHP array.

To create a driver, create a class that implements the `\Sven\FileConfig\Drivers\Driver`
interface. Then add 2 methods to your class: `import` and `export`. The `import` method
will receive the contents of the file as an argument, and expects a PHP array to be returned.

The `export` method is the exact reverse: it receives a PHP array, and expects the new contents
of the file to be returned (as a string). To see how this works in more detail, take a look at 
[the pre-installed `json` driver](src/Drivers/Json.php).

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
[ico-build]: https://img.shields.io/github/workflow/status/svenluijten/file-config/Tests%20(PHP)?style=flat-square
[ico-styleci]: https://styleci.io/repos/117891803/shield

[link-packagist]: https://packagist.org/packages/sven/file-config
[link-downloads]: https://packagist.org/packages/sven/file-config
[link-build]: https://github.com/svenluijten/file-config/actions?query=workflow%3A%22Tests+%28PHP%29%22
[link-styleci]: https://styleci.io/repos/117891803
