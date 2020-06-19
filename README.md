# LaravelStupidPassword

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

A laravel package wrapper for northox/stupid-password.

## Installation

Via Composer

``` bash
$ composer require woodynadobhar/laravelstupidpassword
```
Add config

``` bash
$ artisan vendor:publish
```

## Usage

```php

use WoodyNaDobhar\LaravelStupidPassword\LaravelStupidPassword;

$stupidPass = new LaravelStupidPassword(40, Config::get('laravelstupidpassword.environmentals'), null, null, config('laravelstupidpassword.options'));
if($stupidPass->validate($input['password']) === false) {
	$errors = '';
	foreach($stupidPass->getErrors() as $error) {
		$errors .= $error . '<br />';
	}
	Flash::error('Your password is weak:<br \>' . substr($errors, 0, -6));
	return redirect(URL::previous());
}
```

## Package dependencies

This is a laravel wrapper for [Northox Stupid Password](https://github.com/northox/stupid-password)

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Source

[https://github.com/WoodyNaDobhar/laravel-stupid-password](https://github.com/WoodyNaDobhar/laravel-stupid-password)

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please contact northox instead of using the issue tracker.

## Version

Versioning is for chumps.

## Credits

- [Danny Fullerton](https://github.com/northox) Stupid Password library
- [Krisjanis Ozolins](https://github.com/woodynadobhar) Package template
- [All Contributors][link-contributors]

## License

BSD license. In other words, it's free software, almost free as in free beer.

[ico-version]: https://img.shields.io/packagist/v/woodynadobhar/laravel-stupid-password.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/woodynadobhar/laravel-stupid-password.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/woodynadobhar/laravel-stupid-password
[link-downloads]: https://packagist.org/packages/woodynadobhar/laravel-stupid-password
[link-contributors]: ../../contributors