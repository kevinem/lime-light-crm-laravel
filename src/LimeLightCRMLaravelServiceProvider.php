<?php


namespace KevinEm\LimeLightCRMLaravel;


use Illuminate\Support\ServiceProvider;
use KevinEm\AdobeSign\AdobeSign;
use KevinEm\LimeLightCRM\LimeLightCRM;

/**
 * Class LimeLightCRMLaravelAdobeSignLaravelServiceProvider
 * @package KevinEm\LimeLightCRMLaravel
 */
class LimeLightCRMLaravelServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $config = $this->app['path.config'] . '/lime-light-crm.php';

        $this->publishes([
            __DIR__ . '/../config/config.php' => $config
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'lime-light-crm');

        $this->app->bind('lime-light-crm-laravel', $this->createLimeLightCRMLaravelClosure());
    }

    /**
     * @return \Closure
     */
    protected function createLimeLightCRMLaravelClosure()
    {
        return function ($app) {
            return new LimeLightCRM($app['config']['lime-light-crm']);
        };
    }
}