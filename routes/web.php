<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\dashboard\AdminController;
use App\Http\Controllers\dashboard\site\PageController;
use App\Http\Controllers\dashboard\roles\UserController;
use App\Http\Controllers\dashboard\site\ProjectController;
use App\Http\Controllers\dashboard\site\HomeController;
use App\Http\Controllers\dashboard\site\SettingsController;
use App\Http\Controllers\dashboard\BlogController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


    Route::get('/clear', function () {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');
        return "Cleared cach , config , view , optimize !";
    });


    Route::group(['prefix' => 'dashboard'], function () {


    Route::get('/login', function () {
        return view('dashboard.auth.login');
    })->name('login');

    Route::post('/login', [AdminController::class, 'customLogin'])->name('login.custom');




    Route::middleware('auth:web')->group(function () {

        Route::get('/logout', [AdminController::class, 'logout'])->name('login.logout');
        Route::get('/', [HomeController::class, 'index'])->name('dashboard.index');



        Route::group(['prefix' => 'admin'], function () {
            Route::post('/dashboard/profile/update-password', [AdminController::class, 'updatePassword'])->name('admin.profile.updatePassword');

        Route::post('/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
            Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
            Route::post('profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
        });




        Route::resource('/pages', PageController::class);
        // pages.check-slug
        Route::post('/pages/check-slug', [PageController::class, 'checkSlug'])->name('pages.check-slug');



        Route::group(['prefix' => 'settings'], function () {
            Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
            Route::get('get-fields', [SettingsController::class, 'getFields'])->name('settings.getFields');
            Route::post('update', [SettingsController::class, 'update'])->name('settings.update');
        });

});
});

