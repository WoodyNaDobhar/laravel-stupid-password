<?php

namespace WoodyNaDobhar\LaravelStupidPassword;

use Illuminate\Support\ServiceProvider;
use WoodyNaDobhar\LaravelStupidPassword\Exceptions;

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
    // protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {

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
