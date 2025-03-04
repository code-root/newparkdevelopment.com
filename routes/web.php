<?php

use Illuminate\Http\Request;
use App\Helpers\TranslationHelper;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ImageItemController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\dashboard\AdminController;
use App\Http\Controllers\dashboard\site\FaqController;
use App\Http\Controllers\dashboard\site\PageController;
use App\Http\Controllers\dashboard\roles\RoleController;
use App\Http\Controllers\dashboard\roles\UserController;
use App\Http\Controllers\dashboard\site\SectionController;
use App\Http\Controllers\dashboard\site\ProjectController;
use App\Http\Controllers\dashboard\site\CategoryController;
use App\Http\Controllers\dashboard\site\HomeController;
use App\Http\Controllers\dashboard\site\SettingsController;
use App\Http\Controllers\dashboard\site\TranslationController;
use App\Http\Controllers\dashboard\BlogController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

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
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');



Route::post('storeText', function (Request $request) {
    $data = $request->all();
    return response()->json(TranslationHelper::storeText($data));
})->name('storeText');

    Route::get('getText', function (Request $request) {
        $languageId = $request->input('language_id');
        $token = $request->input('token');
        return response()->json(TranslationHelper::getText($languageId, $token));
    })->name('getText');



    Route::get('/clear', function () {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');
        return "Cleared cach , config , view , optimize !";
    });

    Route::get('/view-image/{m}', [SiteController::class, 'viewImage'])->name('view-image');
    Route::get('/service/{id}', [ProjectController::class, 'showServiceDetails'])->name('project.details');
    Route::get('service', [SiteController::class, 'indexService'])->name('project.home');
    Route::post('/service/subscribe', [SubscriberController::class, 'subscribe'])->name('project.subscribe');
    Route::group(['prefix' => 'dashboard'], function () {

        Route::get('/', function () {
          return 'OK';
        })->name('site');


    Route::get('/login', function () {
        return view('dashboard.auth.login');
    })->name('login');

    Route::post('/login', [AdminController::class, 'customLogin'])->name('login.custom');




    Route::middleware('auth:web')->group(function () {

        Route::get('/logout', [AdminController::class, 'logout'])->name('login.logout');
        Route::get('/', [HomeController::class, 'index'])->name('dashboard.index');

        Route::get('translations', [TranslationController::class, 'index'])->name('translations.index');
        Route::post('translations/update', [TranslationController::class, 'update'])->name('translations.update');


        Route::group(['prefix' => 'admin'], function () {
            Route::post('/dashboard/profile/update-password', [AdminController::class, 'updatePassword'])->name('admin.profile.updatePassword');

        Route::post('/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
            Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
            Route::post('profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
        });

        Route::get('contact', [ContactController::class, 'index'])->name('contacts.index');
        Route::delete('contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');



        Route::prefix('blog')->group(function () {
            Route::get('/', [BlogController::class, 'index'])->name('blog.index');
            Route::get('/getData', [BlogController::class, 'getData'])->name('blog.data');
            Route::post('/create', [BlogController::class, 'create'])->name('blog.create');
            Route::get('/create', [BlogController::class, 'createPage'])->name('blog.create.page');
            Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
            Route::post('/update/{id}', [BlogController::class, 'update'])->name('blog.update');
            Route::delete('/destroy/{id}', [BlogController::class, 'destroy'])->name('blog.destroy'); // تم تعديل المسار
            Route::post('/toggle-status', [BlogController::class, 'toggleStatus'])->name('blog.toggleStatus');
            Route::post('get-translations', [BlogController::class, 'getTranslations'])->name('blog.getTranslations');
        });


        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);


        Route::group(['prefix' => 'pages'], function () {
            Route::get('add', [PageController::class, 'create'])->name('pages.create');
            Route::post('create', [PageController::class, 'createPage'])->name('pages.save');
            Route::post('store', [PageController::class, 'store'])->name('pages.store');
            Route::get('/edit/{id}', [PageController::class, 'edit'])->name('pages.edit');
            Route::get('/', [PageController::class, 'index'])->name('pages.index');
            Route::get('/pages/id', [PageController::class, 'show'])->name('pages.show');
            Route::post('/pages/update', [PageController::class, 'update'])->name('pages.update');
            Route::delete('/pages/destroy/{id}', [PageController::class, 'destroy'])->name('pages.destroy');
            Route::get('translations', [PageController::class, 'getTranslations'])->name('pages.getTranslations');
        });

        Route::prefix('project')->group(function () {
            Route::get('/', [ProjectController::class, 'index'])->name('project.index');
            Route::get('/getData', [ProjectController::class, 'getData'])->name('project.data');
            Route::post('/create', [ProjectController::class, 'create'])->name('project.create');
            Route::get('/create', [ProjectController::class, 'createPage'])->name('project.create.page');
            Route::get('/edit/{id}', [ProjectController::class, 'edit'])->name('project.edit');
            Route::post('/update/{id}', [ProjectController::class, 'update'])->name('project.update');
            Route::delete('/destroy', [ProjectController::class, 'destroy'])->name('project.destroy');
            Route::post('/toggle-status', [ProjectController::class, 'toggleStatus'])->name('project.toggleStatus');
            Route::post('get-translations', [ProjectController::class, 'getTranslations'])->name('project.getTranslations');
        });





        Route::group(['prefix' => 'image'], function () {
            Route::post('/upload', [ImageItemController::class, 'store'])->name('image.upload');
            Route::post('delete', [ImageItemController::class, 'delete'])->name('image.delete');
        });


        Route::prefix('faq')->group(function () {
            Route::get('/', [FaqController::class, 'index'])->name('faq.index');
            Route::get('/getData', [FaqController::class, 'getData'])->name('faq.data');
            Route::post('/create', [FaqController::class, 'create'])->name('faq.create');
            Route::get('/create', [FaqController::class, 'createPage'])->name('faq.create.page');
            Route::get('/edit/{id}', [FaqController::class, 'edit'])->name('faq.edit');
            Route::post('/update/{id}', [FaqController::class, 'update'])->name('faq.update');
            Route::delete('/destroy', [FaqController::class, 'destroy'])->name('faq.destroy');
            Route::post('/toggle-status', [FaqController::class, 'toggleStatus'])->name('faq.toggleStatus');
            Route::post('get-translations', [FaqController::class, 'getTranslations'])->name('faq.getTranslations');
        });


        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('category.index');
            Route::get('/getData', [CategoryController::class, 'getData'])->name('category.data');

            Route::post('/create', [CategoryController::class, 'create'])->name('category.create');
            Route::get('/create', [CategoryController::class, 'createPage'])->name('category.create.page');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');

            Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
            Route::delete('/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');
            Route::post('/toggle-status', [CategoryController::class, 'toggleStatus'])->name('category.toggleStatus');
            Route::post('get-translations', [CategoryController::class, 'getTranslations'])->name('category.getTranslations');

        });
        Route::prefix('sections')->group(function () {
            Route::get('/', [SectionController::class, 'index'])->name('section.index');
            Route::get('/getData', [SectionController::class, 'getData'])->name('section.data');
            Route::post('/create', [SectionController::class, 'create'])->name('section.create');
            Route::get('/edit/{id}', [SectionController::class, 'edit'])->name('section.edit');
            Route::post('/update/{id}', [SectionController::class, 'update'])->name('section.update');
            Route::delete('/destroy', [SectionController::class, 'destroy'])->name('section.destroy');
            Route::post('/toggle-status', [SectionController::class, 'toggleStatus'])->name('section.toggleStatus');
            Route::get('/{section_id}/pages/create', [SectionController::class, 'createPages'])->name('page.create');
            Route::post('/{section_id}/pages/save', [SectionController::class, 'savePage'])->name('page.save');
        });


        Route::group(['prefix' => 'settings'], function () {
            Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
            Route::get('get-fields', [SettingsController::class, 'getFields'])->name('settings.getFields');
            Route::post('update', [SettingsController::class, 'update'])->name('settings.update');
        });

    });
});

