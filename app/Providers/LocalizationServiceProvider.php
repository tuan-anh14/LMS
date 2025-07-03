<?php

namespace App\Providers;

use App\Models\Language;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LocalizationServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        if (\Schema::hasTable('languages')) {

            $selectedLanguage = Language::where('code', app()->getLocale())->first();

            View::share('selectedLanguage', $selectedLanguage);
        }

    }//end of boot

}//end of app service provider
