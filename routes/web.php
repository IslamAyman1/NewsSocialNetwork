<?php

use App\Http\Controllers\frontend\ContactController;
use App\Http\Controllers\frontend\dashboard\SettingController;
use App\Http\Controllers\frontend\SearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\NewsSubscriberController;
use App\Http\Controllers\frontend\CategroyController;
use App\Http\Controllers\frontend\PostController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\frontend\Dashboard\ProfileController;
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
Route::redirect('/', '/home');
Route::group(['as' => 'frontend.'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('index');
    Route::post('news-subscribe', [NewsSubscriberController::class, 'store'])->name('news.subscribe');
    Route::get('category/{slug}', CategroyController::class)->name('category.posts');
    Route::controller(PostController::class)->name('post.')->prefix('post')->group(function () {
        Route::get('/{slug}','show')->name('show');
        Route::get('/comments/{slug}','getAllPosts')->name('getAlComments');
        Route::post('/comments/store','saveComment')->name('comments.store');
    });
    Route::controller(ContactController::class)->name('contact.')->prefix('contact')->group(function () {
        Route::get('/','index')->name('index');
        Route::post('/store','store')->name('store');
    });

    Route::match(['get','post'],'search', SearchController::class)->name('search');
//    manage profile page
    Route::prefix('account/')->name('dashboard.')->middleware(['auth:web','verified'])->group(function () {
         Route::controller(ProfileController::class)->group(function () {
             Route::get('profile','index')->name('profile');
             Route::post('post/store','storePost')->name('post.store');
             Route::get('post/edit/{slug}','editPost')->name('post.edit');
             Route::delete('post/delete','deletePost')->name('post.delete');
             Route::get('post/get-comments/{id}','getComments')->name('post.getComments');
         });

        Route::controller(SettingController::class)->group(function () {
            Route::get('setting', 'index')->name('setting');
        });
    });


});
Route::prefix('email')->name('verification.')->controller(VerificationController::class)->group(function () {
    Route::get('/verify', 'show')->name('notice');
    Route::get('/verify/{id}/{hash}',  'verify')->name('verify');
    Route::post('/resend', 'resend')->name('resend');

});


Auth::routes();

