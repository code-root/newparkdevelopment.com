<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;
use App\Models\Language;
use App\Models\Section;
use App\Models\site\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        view()->composer('*', function ($view) {
            $locale = session('locale', 'ar');
            $languages = Language::all();
            $view->with('locale', $locale);
            $view->with('languages', $languages);
        });

        view()->composer('dashboard.layouts.navbar', function ($view) {
            $view->with('loginUser', Auth::user());
        });




        $this->shareSettingsAndBasicFields('dashboard.layouts.navbar');
    }

    private function shareSettingsAndBasicFields(string $viewName)
    {
        view()->composer($viewName, function ($view) {
            $locale = session('locale', 'ar');
            $settings = Setting::where('type', $locale)->pluck('value', 'slug')->toArray();
            $basicFields = Setting::where('type', null)->pluck('value', 'slug')->toArray();
            $languages = Language::all();
            $sections = Section::get();
            $category = Category::get();
            $view->with('basicFields', $basicFields);
            $view->with('settings', $settings);
            $view->with('languages', $languages);
            $view->with('locale', $locale);
            $view->with('sections', $sections);
            $view->with('category', $category);
        });
    }
}
