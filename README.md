# Laravel Error Lab

Laravel Error Lab is a developer assistant package that:
- fetches runtime errors from external providers (Sentry, Bugsnag…)
- checks if failing code is already covered by tests
- generates missing PHPUnit tests
- suggests fixes using LLMs (e.g. Junie, Windsurf)

## Installation

> Not yet published – work in progress.

## Features

- 📦 Modular architecture (extensible providers and AI engines)
- ✅ Full TDD-oriented implementation
- 🧠 LLM-assisted fixes
- 🧪 Test generator for uncaught exceptions

## Planned Use Cases

- `php artisan error-lab:fetch-errors`
- `php artisan error-lab:generate-test`
- `php artisan error-lab:suggest-fix`

## Interfaces

```php
interface ErrorProviderInterface
interface LLMInterface
interface TestGeneratorInterface

# This is my package laravel-error-lab



[![Latest Version on Packagist](https://img.shields.io/packagist/v/fred/laravel-error-lab.svg?style=flat-square)](https://packagist.org/packages/fred/laravel-error-lab)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/fred/laravel-error-lab/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/fred/laravel-error-lab/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/fred/laravel-error-lab/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/fred/laravel-error-lab/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/fred/laravel-error-lab.svg?style=flat-square)](https://packagist.org/packages/fred/laravel-error-lab)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-error-lab.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-error-lab)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require fred/laravel-error-lab
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-error-lab-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-error-lab-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-error-lab-views"
```

## Usage

```php
$laravelErrorLab = new Hddev\LaravelErrorLab();
echo $laravelErrorLab->echoPhrase('Hello, Hddev!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [frederic moras](https://github.com/fred)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
