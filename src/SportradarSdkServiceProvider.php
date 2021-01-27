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

        $this->configureClients();
        $this->bindFacade();
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

    /**
     * Configure the static clients with config details.
     *
     * @return void
     */
    protected function configureClients(): void
    {
        foreach (config('sportradar.sports') as $sport => $details) {
            if (! $details['enabled']) {
                continue;
            }

            $client = $details['client'];

            $client::keys($details['keys']);
        }
    }

    /**
     * Bind the Laravel facade to the Sportradar class.
     *
     * @return void
     */
    protected function bindFacade(): void
    {
        $this->app->bind('sportradar', function () {
            return new Sportradar;
        });
    }
}
