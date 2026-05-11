# :package_description

[![run-tests](https://github.com/manchester-unity/:package_slug/actions/workflows/run-tests.yml/badge.svg)](https://github.com/manchester-unity/:package_slug/actions/workflows/run-tests.yml)
[![lint-test](https://github.com/manchester-unity/:package_slug/actions/workflows/lint-test.yml/badge.svg)](https://github.com/manchester-unity/:package_slug/actions/workflows/lint-test.yml)
[![PHPStan](https://github.com/manchester-unity/:package_slug/actions/workflows/phpstan.yml/badge.svg)](https://github.com/manchester-unity/:package_slug/actions/workflows/phpstan.yml)

---
This repo can be used to scaffold a Laravel package. Follow these steps to get started:

1. Press the "Use this template" button at the top of this repo to create a new repo with the contents of this skeleton.
2. Run "php ./configure.php" to run a script that will replace all placeholders throughout all the files.
3. Have fun creating your package.
4. If you need help creating a package, consider picking up our <a href="https://laravelpackage.training">Laravel Package Training</a> video course.
---
<!--/delete-->
This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require manchester-unity/:package_slug
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag=":package_slug-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag=":package_slug-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag=":package_slug-views"
```

## Usage

```php
$:variable = new VendorName\PackageNamespace\Skeleton();
echo $:variable->echoPhrase('Hello, VendorName!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.


## Versioning

The package follows [Semantic Versioning 2.0.0](https://semver.org). Pin a major version in `composer.json` (`"manchester-unity/:package_slug": "^1.0"`) to receive bug fixes and minor features without breaking changes.

## License

Copyright (c) The Oddfellows. All rights reserved. Please see [License File](LICENSE.md) for more information.
