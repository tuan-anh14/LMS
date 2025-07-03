<?php

namespace App\Providers;

use App\Models\Language;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        Schema::defaultStringLength(191);

        if (Schema::hasTable('languages')) {

            $activeLanguages = Language::active()->get();

            $this->setSupportedLocale($activeLanguages);

            View::share('activeLanguages', $activeLanguages);

        }

        ResponseFactory::macro('api', function ($data = null, $error = 0, $message = '') {
            return response()->json([
                'data' => $data,
                'error' => $error, //1 or 0
                'message' => $message,
            ]);
        });

    }//end of boot

    private function setSupportedLocale($activeLanguages)
    {
        $supportedLocales = [];
        $translatableLocales = [];

        foreach ($activeLanguages as $activeLanguage) {

            $supportedLocales[$activeLanguage->code] = [
                'name' => $activeLanguage->name,
                'native' => $activeLanguage->name,
                'country_flag_code' => $activeLanguage->country_flag_code,
                'script' => $activeLanguage->code == 'ar' ? 'Arab' : 'qwe',
            ];

            $translatableLocales[] = $activeLanguage->code;

        }//end of for each

        config(['localization.supportedLocales' => $supportedLocales]);

        config(['translatable.locales' => $translatableLocales]);

    }// end of setSupportedLocale

}//end of app service provider
