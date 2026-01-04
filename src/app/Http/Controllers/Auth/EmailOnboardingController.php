<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EmailOnboardingController extends Controller
{
    /**
     * Show the email onboarding form for users who signed in via SMS.
     */
    public function show(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user?->email) {
            return redirect()->intended(route('home', ['locale' => app()->getLocale()]));
        }

        return view('auth.email-onboarding', [
            'user' => $user,
        ]);
    }

    /**
     * Persist the email address and continue to the intended destination.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
        ]);

        $user->forceFill([
            'email' => $validated['email'],
            'email_verified_at' => $user->email === $validated['email']
                ? $user->email_verified_at
                : null,
        ])->save();

        return redirect()->intended(route('home', ['locale' => app()->getLocale()]));
    }
}
