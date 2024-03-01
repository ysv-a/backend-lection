<?php

namespace App\Providers;

use App\Services\Sms\Sms;
use App\Services\Sms\SmsLog;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Sms::class, function (Application $app) {
            return new SmsLog();
        });

//        $this->app->bind(Sms::class, function (Application $app) {
//            return new SmsLog();
//        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
