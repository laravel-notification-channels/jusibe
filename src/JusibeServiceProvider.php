<?php

namespace NotificationChannels\Jusibe;

use Unicodeveloper\Jusibe\Jusibe as JusibeClient;
use Illuminate\Support\ServiceProvider;

class JusibeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Bootstrap code here.
        $this->app->when(JusibeChannel::class)
            ->needs(JusibeClient::class)
            ->give(function () {

                $jusibeConfig = config('services.jusibe');

                if(is_null($jusibeConfig)) {
                    throw InvalidConfiguration::configurationNotSet();
                }

                return new JusibeClient(
                    $jusibeConfig['key'],
                    $jusibeConfig['token']
                );
            });
    }
}
