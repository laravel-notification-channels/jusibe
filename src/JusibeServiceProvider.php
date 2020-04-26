<?php

namespace NotificationChannels\Jusibe;

use Illuminate\Support\ServiceProvider;
use NotificationChannels\Jusibe\Exceptions\InvalidConfiguration;
use Unicodeveloper\Jusibe\Jusibe as JusibeClient;

class JusibeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(JusibeChannel::class)
            ->needs(JusibeClient::class)
            ->give(function () {
                $config = config('services.jusibe');

                if (is_null($config)) {
                    throw InvalidConfiguration::configurationNotSet();
                }

                return new JusibeClient(
                    $config['key'],
                    $config['token']
                );
            });
    }
}
