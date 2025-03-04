<?php

use App\Models\Language;
use App\Models\Translation;
use App\Models\site\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Lang;

     function getTranslations($token ,  $key ) {
        return Translation::select('value')->where('token', $token)->where('language_id', getLanguageId())->where('key', $key)->first()['value'] ?? 'value' ;
    }

    function getLanguageId (){
        return Language::where('code', session('locale', 'ar'))->first()['id'] ?? 2;
    }

    /**
     * Clear all cache, config, view, and optimize.
     *
     * @return string
     */
    function cacheClear() {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');
        return "Cleared cache , config , view , optimize !";
    }
    /**
     * Return the default language
     *
     * @return int
     */
    function defaultLanguage() {
        return Setting::select('value')->where('slug', 'default_language')->first()['value'] ?? 2;
     }
