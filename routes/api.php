<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriberController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/project', [ApiController::class, 'apiAllProject']);
Route::get('/project/{id}', [ApiController::class, 'getIdProject']);
Route::get('home', [ApiController::class, 'home'])->name('api.home');
Route::get('part-two/{locale}', [ApiController::class, 'categories'])->name('api.categories');
Route::post('contact-post', [ApiController::class, 'ContactStore'])->name('contact.store');
Route::get('page/{id}', [ApiController::class, 'showPage'])->name('api.showPage');
Route::get('/blogs', [APIController::class, 'getBlogs'])->name('blogs.get');
Route::get('/blog/{blog_id}', [APIController::class, 'getBlogId'])->name('blog.getById');
Route::get('getCategory', [APIController::class, 'getCategory'])->name('getCategory');


Route::post('/subscribe', [SubscriberController::class, 'subscribe']);
