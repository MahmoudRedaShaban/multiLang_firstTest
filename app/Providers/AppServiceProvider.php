<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // set project for lang used And start use lang select in config\app
        //set default lng from route in project
        // app()->setlocale(request()->segment(1)); //not using this but work for dynamic
        $locale = config('locales.fallback_locale'); //getDefault Lng
        /* Start Add Defualt Lng To Core Lib In Laravel BootLoad */
        App::setLocale($locale);
        Lang::setLocale($locale);
        Session::put('locale',$locale);
        setlocale(LC_TIME, config('locales.languages')[$locale]['unicode']); //biult in PHP
        Carbon::setLocale($locale);
    }
}
