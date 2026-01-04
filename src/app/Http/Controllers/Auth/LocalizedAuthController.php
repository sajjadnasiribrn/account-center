<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\OtpCodeNotification;
use App\Rules\ValidMobile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LocalizedAuthController extends Controller
{
    /**
     * Show the appropriate login/register screen based on locale.
     */
    public function show(): View
    {
        $locale = app()->getLocale();

        if ($locale === 'fa') {
            return view('auth.sms-login');
        }

        return view('auth.google-login');
    }

    /**
     * Send an OTP to the provided phone number (FA locale only).
     */
    public function sendOtp(Request $request): RedirectResponse
    {
        $this->ensurePersianLocale();

        $request->merge([
            'phone' => $this->normalizeDigits($request->input('phone', '')),
        ]);

        $validated = $request->validate([
            'phone' => ['required', new ValidMobile()],
        ]);

        $phone = $this->normalizePhone($validated['phone']);
        $cacheKey = $this->cacheKey($phone);
        $cachedValue = Cache::get($cacheKey);
        $payload = null;

        if (is_array($cachedValue)) {
            $expiresAt = $cachedValue['expires_at'] ?? null;
            if (($cachedValue['code'] ?? null) && $expiresAt && $expiresAt > now()->getTimestamp()) {
                $payload = [
                    'code' => $cachedValue['code'],
                    'expires_at' => $expiresAt,
                ];
            }
        }

        if (! $payload) {
            $code = $this->generateOtpCode();
            $ttl = now()->addMinutes(config('otp.ttl', 5));
            $payload = [
                'code' => $code,
                'expires_at' => $ttl->getTimestamp(),
            ];

            Cache::put($cacheKey, $payload, $ttl);

            Notification::route('kavenegar', $phone)
                ->notify(new OtpCodeNotification($code, $phone));
        }

        return redirect()->route('auth.login', ['locale' => app()->getLocale()])
            ->with('phone', $phone)
            ->with('otp_sent', true)
            ->with('otp_expires_at', $payload['expires_at'])
            ->with('status', __('auth.otp.sent'));
    }

    /**
     * Verify the submitted OTP and create/login the user.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $this->ensurePersianLocale();

        $request->merge([
            'phone' => $this->normalizeDigits($request->input('phone', '')),
            'code' => $this->digitsOnly($this->normalizeDigits($request->input('code', ''))),
        ]);

        $validated = $request->validate([
            'phone' => ['required', new ValidMobile()],
            'code' => ['required', 'digits:' . (string) config('otp.length', 4)],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        $phone = $this->normalizePhone($validated['phone']);
        $cacheKey = $this->cacheKey($phone);
        $cachedValue = Cache::get($cacheKey);

        $expectedCode = null;
        $expiresAt = null;

        if (is_array($cachedValue)) {
            $expectedCode = $cachedValue['code'] ?? null;
            $expiresAt = $cachedValue['expires_at'] ?? null;
        } else {
            $expectedCode = $cachedValue;
            $expiresAt = now()->addMinutes(config('otp.ttl', 5))->getTimestamp();
        }

        if (! $expectedCode) {
            return back()
                ->withErrors(['code' => __('auth.otp.expired')])
                ->withInput([
                    'phone' => $phone,
                    'name' => $validated['name'] ?? null,
                    'otp_expires_at' => now()->getTimestamp(),
                    'otp_sent' => true,
                ])
                ->with('phone', $phone)
                ->with('otp_sent', true)
                ->with('otp_expires_at', now()->getTimestamp());
        }

        if ($expectedCode !== $validated['code']) {
            return back()
                ->withErrors(['code' => __('auth.otp.invalid')])
                ->withInput([
                    'phone' => $phone,
                    'name' => $validated['name'] ?? null,
                    'otp_expires_at' => $expiresAt,
                    'otp_sent' => true,
                ])
                ->with('phone', $phone)
                ->with('otp_sent', true)
                ->with('otp_expires_at', $expiresAt);
        }

        Cache::forget($cacheKey);

        $user = User::firstOrNew(['phone' => $phone]);
        $user->name = $validated['name'] ?: ($user->name ?: __('auth.otp.default_name', ['phone' => $phone]));
        $user->password = $user->password ?: Hash::make(Str::random(32));
        $user->phone_verified_at = $user->phone_verified_at ?: now();
        $user->save();

        Auth::login($user, true);

        $home = route('home', ['locale' => app()->getLocale()]);

        if (! $user->email) {
            session()->put('url.intended', session('url.intended', $home));

            return redirect()->route('auth.email-onboarding', ['locale' => app()->getLocale()]);
        }

        return redirect()->intended($home);
    }

    /**
     * Log the authenticated user out.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home', ['locale' => app()->getLocale()]);
    }

    /**
     * Normalize Iranian mobile numbers into 09********* format.
     */
    protected function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\\D+/', '', $this->normalizeDigits($phone)) ?? '';

        if (str_starts_with($digits, '98')) {
            $digits = '0' . substr($digits, 2);
        }

        if (! str_starts_with($digits, '0')) {
            $digits = '0' . $digits;
        }

        return $digits;
    }

    /**
     * Convert Persian/Arabic numerals to English ones.
     */
    protected function normalizeDigits(string $value): string
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace(
            array_merge($persian, $arabic),
            array_merge($western, $western),
            $value
        );
    }

    /**
     * Strip any non-digits from the given value.
     */
    protected function digitsOnly(string $value): string
    {
        return preg_replace('/\\D+/', '', $value) ?? '';
    }

    /**
     * Generate a numeric OTP of the configured length.
     */
    protected function generateOtpCode(): string
    {
        $length = max(4, (int) config('otp.length', 4));
        $max = (int) pow(10, $length) - 1;
        $code = (string) random_int(0, $max);

        return str_pad($code, $length, '0', STR_PAD_LEFT);
    }

    /**
     * Build a cache key for the phone number.
     */
    protected function cacheKey(string $phone): string
    {
        $normalized = $this->digitsOnly($this->normalizeDigits($phone));

        return sprintf('%s%s', config('otp.cache_prefix', 'auth_otp_'), $normalized);
    }

    /**
     * Ensure OTP endpoints are only reachable for FA locale.
     */
    protected function ensurePersianLocale(): void
    {
        abort_if(app()->getLocale() !== 'fa', 404);
    }
}
