# LaravelStupidPassword

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

A Laravel package wrapper for [Northox Stupid Password](https://github.com/northox/stupid-password).

## Installation

Install the package via Composer:

```bash
composer require woodynadobhar/laravelstupidpassword
```

Publish the configuration file:

```bash
php artisan vendor:publish --provider="WoodyNaDobhar\\LaravelStupidPassword\\LaravelStupidPasswordServiceProvider" --tag=config
```

This will create a configuration file at `config/laravelstupidpassword.php`.

## Usage

### Automatically

To enforce password strength validation, simply add `stupidpassword` to your validation rules:

```php
'password' => 'min:6|required_with:password_confirmation|same:password_confirmation|stupidpassword',
```

### Manually

You can also validate passwords manually by using the `LaravelStupidPassword` class:

```php
use WoodyNaDobhar\LaravelStupidPassword\LaravelStupidPassword;

$stupidPass = new LaravelStupidPassword(
    config('laravelstupidpassword.max'),
    config('laravelstupidpassword.environmentals'),
    null,
    null,
    config('laravelstupidpassword.options')
);

if (!$stupidPass->validate($input['password'])) {
    $errors = implode(' ', $stupidPass->getErrors());
    throw new \Exception("Your password is too weak: $errors");
}
```

## Configuration

The configuration file `laravelstupidpassword.php` allows customization of the following options:
- **max:** Maximum number of passwords to evaluate.
- **environmentals:** An array of additional weak passwords to consider.
- **options:** Advanced configuration options specific to the [Northox Stupid Password](https://github.com/northox/stupid-password) library.

## Dependencies

This package is a Laravel wrapper for [Northox Stupid Password](https://github.com/northox/stupid-password).

## Change Log

Please see the [CHANGELOG](changelog.md) for details on recent changes.

## Contributing

See [CONTRIBUTING](contributing.md) for guidelines and a to-do list.

## Security

If you discover any security-related issues, please contact the [Northox Stupid Password](https://github.com/northox/stupid-password) repository owner.

## Versioning

This package follows Semantic Versioning (SemVer). Updates are published to [Packagist](https://packagist.org/packages/woodynadobhar/laravel-stupid-password).

## Credits

- [Danny Fullerton](https://github.com/northox) for the Stupid Password library.
- [Krisjanis Ozolins](https://github.com/woodynadobhar) for the Laravel package template.
- [All Contributors][link-contributors]

## License

This package is licensed under the BSD License. In other words, it is free software.

[ico-version]: https://img.shields.io/packagist/v/woodynadobhar/laravel-stupid-password.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/woodynadobhar/laravel-stupid-password.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/woodynadobhar/laravel-stupid-password
[link-downloads]: https://packagist.org/packages/woodynadobhar/laravel-stupid-password
[link-contributors]: ../../contributors
