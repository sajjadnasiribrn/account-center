<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasEmail
{
    /**
     * Redirect authenticated users without an email to the onboarding screen.
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) {
            return $next($request);
        }

        $user = $request->user();

        if (! $user?->email) {
            if ($request->routeIs('auth.email-onboarding', 'auth.email-onboarding.store', 'auth.logout')) {
                return $next($request);
            }

            if ($request->isMethod('GET')) {
                $current = $request->fullUrl();
                $onboardingUrl = route('auth.email-onboarding', ['locale' => app()->getLocale()]);

                if (! session()->has('url.intended') || session('url.intended') === $onboardingUrl) {
                    session()->put('url.intended', $current);
                }
            }

            return redirect()->route('auth.email-onboarding', ['locale' => app()->getLocale()]);
        }

        return $next($request);
    }
}
