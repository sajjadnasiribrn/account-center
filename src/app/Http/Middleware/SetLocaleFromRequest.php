<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class SetLocaleFromRequest
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $supportedLocales = array_keys(config('app.supported_locales', ['en' => 'English']));
        $locale = $request->route('locale') ?? session('locale', config('app.locale'));

        if (! in_array($locale, $supportedLocales, true)) {
            $locale = config('app.locale');
        }

        App::setLocale($locale);
        URL::defaults(['locale' => $locale]);
        session(['locale' => $locale]);

        return $next($request);
    }
}
