<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Notifications\OtpCodeNotification;
use App\Rules\ValidMobile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

class SmsLogin extends Component
{
    /**
     * User-entered phone number.
     */
    public string $phone = '';

    /**
     * One-time password code.
     */
    public string $code = '';

    /**
     * Whether an OTP was already sent.
     */
    public bool $otpSent = false;

    /**
     * Expiration timestamp for the current OTP.
     */
    public ?int $otpExpiresAt = null;

    /**
     * Informational status message.
     */
    public ?string $status = null;

    /**
     * Prevent recursive auto-verification loops when updating the code.
     */
    protected bool $autoVerifying = false;

    public function render(): View
    {
        return view('livewire.auth.sms-login')->layout('layouts.app');
    }

    /**
     * Send an OTP to the provided phone number.
     */
    public function sendOtp(): void
    {
        $this->ensurePersianLocale();
        $this->resetErrorBag();
        $this->status = null;

        $this->phone = $this->normalizePhone($this->phone);

        $this->validateOnly('phone', [
            'phone' => ['required', new ValidMobile()],
        ]);

        $cacheKey = $this->cacheKey($this->phone);
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

            Notification::route('kavenegar', $this->phone)
                ->notify(new OtpCodeNotification($code, $this->phone));
        }

        $this->otpSent = true;
        $this->otpExpiresAt = $payload['expires_at'];
        $this->status = __('auth.otp.sent');
        $this->code = '';
    }

    /**
     * Normalize user input as they type and auto-verify when the code is complete.
     */
    public function updatedCode(string $value): void
    {
        $normalized = substr($this->digitsOnly($this->normalizeDigits($value)), 0, $this->otpLength());

        $this->code = $normalized;

        if ($this->autoVerifying || ! $this->otpSent) {
            return;
        }

        if (strlen($normalized) === $this->otpLength()) {
            $this->verifyOtp();
        }
    }

    /**
     * Verify the submitted OTP and create/login the user.
     */
    public function verifyOtp(): void
    {
        if ($this->autoVerifying) {
            return;
        }

        $this->autoVerifying = true;

        $this->ensurePersianLocale();

        if (! $this->otpSent) {
            $this->sendOtp();

            return;
        }

        try {
            $this->resetErrorBag();
            $this->status = null;

            $this->phone = $this->normalizePhone($this->phone);
            $this->code = $this->digitsOnly($this->normalizeDigits($this->code));

            $length = $this->otpLength();

            $validated = $this->validate([
                'phone' => ['required', new ValidMobile()],
                'code' => ['required', 'digits:' . (string) $length],
            ]);

            $cacheKey = $this->cacheKey($this->phone);
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
                $this->addError('code', __('auth.otp.expired'));
                $this->otpExpiresAt = null;

                return;
            }

            if ($expectedCode !== $validated['code']) {
                $this->addError('code', __('auth.otp.invalid'));
                $this->otpExpiresAt = $expiresAt;

                return;
            }

            Cache::forget($cacheKey);

            $user = User::firstOrNew(['phone' => $this->phone]);
            $user->name = $user->name ?: __('auth.otp.default_name', ['phone' => $this->phone]);
            $user->phone_verified_at = $user->phone_verified_at ?: now();
            $user->save();

            Auth::login($user, true);

            $home = route('home', ['locale' => app()->getLocale()]);

            if (! $user->email) {
                session()->put('url.intended', session('url.intended', $home));
                $this->redirect(route('auth.email-onboarding', ['locale' => app()->getLocale()]));

                return;
            }

            $this->redirectIntended($home);
        } finally {
            $this->autoVerifying = false;
        }
    }

    /**
     * Allow the user to edit the phone number.
     */
    public function editPhone(): void
    {
        $this->otpSent = false;
        $this->otpExpiresAt = null;
        $this->code = '';
        $this->status = null;
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

        if ($digits && ! str_starts_with($digits, '0')) {
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
        $length = $this->otpLength();
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
     * Ensure OTP actions only run for the Persian locale.
     */
    protected function ensurePersianLocale(): void
    {
        abort_if(app()->getLocale() !== 'fa', 404);
    }

    /**
     * Get the configured OTP length with a sensible minimum.
     */
    protected function otpLength(): int
    {
        return max(4, (int) config('otp.length', 4));
    }
}
