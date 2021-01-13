<?php

namespace AxlMedia\SportradarSdk;

use Illuminate\Support\ServiceProvider;

class SportradarSdkServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sportradar.php' => config_path('sportradar.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../config/sportradar.php', 'sportradar'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
