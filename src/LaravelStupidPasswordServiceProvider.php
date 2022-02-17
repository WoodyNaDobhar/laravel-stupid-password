<?php

namespace WoodyNaDobhar\LaravelStupidPassword;

use Validator;
use Illuminate\Support\ServiceProvider;
use WoodyNaDobhar\LaravelStupidPassword\Exceptions\InvalidConfiguration;

class LaravelStupidPasswordServiceProvider extends ServiceProvider
{
	/**
	 * This will be used to register config in package namespace.
	 *
	 * @var  string
	 */
	protected $vendorName = 'woodynadobhar';
	protected $packageName = 'laravelstupidpassword';

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
			__DIR__.'/../config/'.$this->packageName.'.php' => config_path($this->packageName . '.php'),
		]);
		$message = ':custom_message';
		Validator::extend('stupidpassword', function ($attribute, $value, $parameters, $validator) use($message) {

			$stupidPass = new LaravelStupidPassword(config('laravelstupidpassword.max'), config('laravelstupidpassword.environmentals'), null, null, config('laravelstupidpassword.options'));
			if($stupidPass->validate($value) === false) {
				$errors = '';
				foreach($stupidPass->getErrors() as $error) {
					$errors .= $error . '<br />';
				}
				$customMessage = 'Your password is weak:<br \>' . substr($errors, 0, -6);
				$validator->addReplacer('stupidpassword', 
					function($message, $attribute, $rule, $parameters) use ($customMessage) {
						return \str_replace(':custom_message', $customMessage, $message);
					}
				);
				return false;
			}
			return true;
		}, $message);
	}

	/**
	 * Register any package services and bindings in the container.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(__DIR__.'/../config/'.$this->packageName.'.php', $this->packageName);

		$config = config($this->packageName);

		// Register the service the package provides.
		$this->app->singleton(LaravelStupidPassword::class, function ($app) use ($config) {
			// Checks if configuration is valid
			$this->guardAgainstInvalidConfiguration($config);
			return new LaravelStupidPassword;
		});

		// Make alias for use with package name
		$this->app->alias(LaravelStupidPassword::class, $this->packageName);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [$this->packageName];
	}

	/**
	 * Checks if the config is valid.
	 *
	 * @param  array|null $config the package configuration
	 * @throws InvalidConfiguration exception or null
	 * @see  \WoodyNaDobhar\LaravelStupidPassword\Exceptions\InvalidConfiguration
	 */
	protected function guardAgainstInvalidConfiguration(array $config = null)
	{
		if (!is_array($config['environmentals'])) {
			throw InvalidConfiguration::noEnvironmentals(); //super lazy
		}
	}
}
