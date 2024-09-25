<?php

namespace DigiNotification\FcmHelper;

use Illuminate\Support\ServiceProvider;

class FcmServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Merge package config with user's config
        $this->mergeConfigFrom(__DIR__.'/../config/fcm.php', 'fcm');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations/2024_09_20_124557_create_push_notifications_table.php');
    }

    public function boot()
    {
        // Publish the config file to the Laravel app
        $this->publishes([
            __DIR__.'/../config/fcm.php' => config_path('fcm.php'),
        ], 'config');
    }
}
