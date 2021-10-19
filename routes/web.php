<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ArticleController::class, 'index'])
    ->name('root');

Route::resource('articles', ArticleController::class)
    ->middleware(['auth'])
    ->only(['create', 'store', 'edit', 'update', 'destroy']);

Route::resource('articles', ArticleController::class)
    ->only(['index', 'show']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('/github', [OAuthController::class, 'redirectToProvider'])
    ->name('redirectToProvider');
    Route::get('/github/callback', [OAuthController::class, 'OauthCallback'])
    ->name('oauthCallback');
});
