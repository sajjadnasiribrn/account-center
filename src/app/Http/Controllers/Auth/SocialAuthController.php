<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to Google's OAuth consent screen.
     */
    public function redirect(): RedirectResponse
    {
        abort_if(app()->getLocale() === 'fa', 404);

        return Socialite::driver('google')
            ->redirectUrl(route('auth.google.callback', ['locale' => app()->getLocale()]))
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    /**
     * Handle the OAuth callback from Google.
     */
    public function callback(): RedirectResponse
    {
        abort_if(app()->getLocale() === 'fa', 404);

        $googleUser = Socialite::driver('google')
            ->stateless()
            ->user();

        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if (! $user) {
            $user = new User();
        }

        $email = $googleUser->getEmail() ?: $user->email;

        $user->google_id = $googleUser->getId();
        $user->name = $googleUser->getName() ?: $googleUser->getNickname() ?: $user->name;
        $user->email = $email;
        $user->password = $user->password ?: Hash::make(Str::random(32));
        $user->email_verified_at = $email ? ($user->email_verified_at ?: now()) : null;
        $user->save();

        Auth::login($user, true);

        $home = route('home', ['locale' => app()->getLocale()]);

        if (! $user->email) {
            session()->put('url.intended', session('url.intended', $home));

            return redirect()->route('auth.email-onboarding', ['locale' => app()->getLocale()]);
        }

        return redirect()->intended($home);
    }
}
