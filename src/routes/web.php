<?php

use App\Http\Controllers\Auth\EmailOnboardingController;
use App\Http\Controllers\Auth\LocalizedAuthController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Livewire\Auth\SmsLogin;
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

$supportedLocales = implode('|', array_keys(config('app.supported_locales', ['en' => 'English'])));

Route::get('/', function () {
    $preferredLocale = session('locale', config('app.locale'));

    return redirect()->route('home', ['locale' => $preferredLocale]);
})->name('root');

Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => $supportedLocales],
], function () {
    Route::view('/', 'welcome')->name('home');

    Route::middleware('guest')->group(function () {
        Route::get('login-or-register', SmsLogin::class)->name('auth.login');
        Route::get('login', fn ($locale) => redirect()->route('auth.login', ['locale' => $locale]))->name('login');
        Route::get('register', fn ($locale) => redirect()->route('auth.login', ['locale' => $locale]))->name('auth.register');

        Route::get('auth/google/redirect', [SocialAuthController::class, 'redirect'])->name('auth.google.redirect');
        Route::get('auth/google/callback', [SocialAuthController::class, 'callback'])->name('auth.google.callback');
    });

    Route::middleware('auth')->group(function () {
        Route::get('onboarding/email', [EmailOnboardingController::class, 'show'])
            ->name('auth.email-onboarding');
        Route::post('onboarding/email', [EmailOnboardingController::class, 'store'])
            ->name('auth.email-onboarding.store');
    });

    Route::post('logout', [LocalizedAuthController::class, 'logout'])
        ->middleware('auth')
        ->name('auth.logout');
});
