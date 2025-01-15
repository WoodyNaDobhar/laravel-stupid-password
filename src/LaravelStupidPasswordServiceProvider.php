<?php

namespace WoodyNaDobhar\LaravelStupidPassword;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use WoodyNaDobhar\LaravelStupidPassword\Exceptions\InvalidConfiguration;

class LaravelStupidPasswordServiceProvider extends ServiceProvider
{
	/**
	 * This will be used to register config in package namespace.
	 *
	 * @var  string
	 */
	protected $vendorName = 'woodynadobhar';
	protected const PACKAGE_NAME = 'laravelstupidpassword';
	protected $packageName = self::PACKAGE_NAME;

	/**
	 * The package name for configuration.
	 */

	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Publish the configuration file
		$this->publishes([
			__DIR__ . '/../config/' . self::PACKAGE_NAME . '.php' => config_path(self::PACKAGE_NAME . '.php'),
		], 'config');

		// Register the validation rule
		Validator::extend('stupidpassword', function ($attribute, $value, $parameters, $validator) {
			$config = config(self::PACKAGE_NAME);

			// Ensure configuration is valid
			$this->validateConfig($config);

			// Create instance of LaravelStupidPassword with configured options
			$stupidPass = new LaravelStupidPassword(
				$config['max'] ?? 100,
				$config['environmentals'] ?? [],
				null,
				null,
				$config['options'] ?? []
			);

			// Validate password
			if (!$stupidPass->validate($value)) {
				$errors = implode(' ', $stupidPass->getErrors());
				$validator->addReplacer('stupidpassword', function () use ($errors) {
					return "The password is too weak: $errors";
				});

				return false;
			}

			return true;
		}, 'The :attribute is invalid.');
	}

	/**
	 * Register any package services and bindings in the container.
	 *
	 * @return void
	 */
	public function register()
	{
		// Merge default configuration
		$this->mergeConfigFrom(
			__DIR__ . '/../config/' . self::PACKAGE_NAME . '.php',
			self::PACKAGE_NAME
		);

		// Bind the main class into the service container
		$this->app->singleton(LaravelStupidPassword::class, function ($app) {
			$config = $app['config'][self::PACKAGE_NAME];
			$this->validateConfig($config);

			return new LaravelStupidPassword(
				$config['max'] ?? 100,
				$config['environmentals'] ?? [],
				null,
				null,
				$config['options'] ?? []
			);
		});

		// Alias the binding
		$this->app->alias(LaravelStupidPassword::class, 'laravelstupidpassword');
	}

	/**
	 * Validate the package configuration.
	 *
	 * @param array $config
	 * @throws InvalidConfiguration
	 * @return void
	 */
	protected function validateConfig(array $config): void
	{
		if (!isset($config['environmentals']) || !is_array($config['environmentals'])) {
			throw InvalidConfiguration::noEnvironmentals();
		}
	}
}
