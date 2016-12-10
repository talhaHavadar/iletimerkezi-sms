<?php

namespace IletimerkeziSms;

use Illuminate\Support\ServiceProvider;

class IletimerkeziSmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->publishes([
            __DIR__.'/config/iletimerkezi.php' => config_path('iletimerkezi.php'),
        ], 'config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
