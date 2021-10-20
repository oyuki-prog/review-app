<?php

use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\ReviewController;
use App\Models\Review;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ReviewController::class, 'index'])
    ->name('root');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('reviews', ReviewController::class)
    ->middleware('auth')
    ->only(['create', 'edit', 'store', 'update', 'destroy']);

Route::resource('reviews', ReviewController::class)
    ->only(['index', 'show']);

Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('/{provider}', [OAuthController::class, 'redirectToProvider'])
        ->where('provider', 'google|github')
        ->name('redirectToProvider');

    Route::get('/{provider}/callback', [OAuthController::class, 'oauthCallback'])
        ->where('provider', 'google|github')
        ->name('oauthCallback');
});

require __DIR__.'/auth.php';
