@php
    $locale = app()->getLocale();
    $isSmsFlow = $locale === 'fa';
    $isRtl = in_array($locale, config('app.rtl_locales', []), true);
    $alignment = $isRtl ? 'text-right' : 'text-left';
    $title = $isSmsFlow
        ? ($otpSent ? __('auth.sms.verify_title') : __('auth.sms.title'))
        : __('auth.google.title');
    $description = $isSmsFlow
        ? ($otpSent
            ? __('auth.sms.verify_description', ['phone' => $phone])
            : __('auth.sms.description'))
        : __('auth.google.description');
@endphp

@section('title', $title)

<div class="min-h-screen bg-slate-950 text-slate-100">
    <div class="absolute inset-0 overflow-hidden" aria-hidden="true">
        <div class="absolute -top-40 left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-orange-500/10 blur-[140px]"></div>
        <div class="absolute bottom-0 right-0 h-80 w-80 translate-x-1/3 rounded-full bg-amber-400/10 blur-[120px]"></div>
        <div class="absolute left-0 top-1/3 h-72 w-72 -translate-x-1/3 rounded-full bg-slate-700/40 blur-[130px]"></div>
    </div>

    <div class="relative mx-auto flex min-h-screen max-w-3xl items-center px-4 py-12">
        <div class="w-full rounded-3xl border border-slate-800/80 bg-slate-900/80 p-6 shadow-2xl shadow-black/40 backdrop-blur sm:p-10">
            <div class="flex flex-col gap-2 {{ $alignment }} {{ $isSmsFlow ? '' : 'items-center text-center' }}">
                <span class="w-fit rounded-full border border-orange-500/40 bg-orange-500/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-orange-300">
                    {{ $isSmsFlow ? __('auth.sms.badge') : 'google oauth' }}
                </span>
                <h1 class="text-3xl font-extrabold text-white sm:text-4xl">
                    {{ $title }}
                </h1>
                <p class="text-sm text-slate-300 sm:text-base">
                    {{ $description }}
                </p>
            </div>

            @if ($isSmsFlow)
                @if ($status)
                    <div class="mt-6 rounded-2xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-sm font-semibold text-emerald-200 {{ $alignment }}">
                        {{ $status }}
                    </div>
                @endif

                <form wire:submit.prevent="{{ $otpSent ? 'verifyOtp' : 'sendOtp' }}" class="mt-8 space-y-6">
                    <div class="space-y-2 {{ $alignment }}">
                        <label class="block text-sm font-semibold text-slate-200" for="otp-phone">
                            {{ __('auth.sms.phone_label') }}
                        </label>
                        <div class="flex flex-wrap items-center gap-3">
                            <input
                                wire:model.defer="phone"
                                id="otp-phone"
                                name="phone"
                                type="tel"
                                inputmode="tel"
                                autocomplete="tel"
                                dir="ltr"
                                @if($otpSent) readonly @endif
                                class="flex-1 rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-3 text-center text-base font-semibold tracking-widest text-white shadow-inner focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/40 disabled:cursor-not-allowed disabled:opacity-70"
                                placeholder="{{ __('auth.sms.phone_placeholder') }}"
                            >
                            @if ($otpSent)
                                <button
                                    type="button"
                                    wire:click="editPhone"
                                    class="shrink-0 rounded-xl border border-orange-400/50 bg-orange-500/10 px-3 py-2 text-sm font-semibold text-orange-200 hover:bg-orange-500/20 focus:outline-none focus:ring-2 focus:ring-orange-500/40"
                                >
                                    {{ __('auth.sms.change_phone') }}
                                </button>
                            @endif
                        </div>
                        @error('phone')
                            <p class="text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    @if ($otpSent)
                        <div class="space-y-3 {{ $alignment }}">
                            <label class="block text-sm font-semibold text-slate-200" for="otp-code">
                                {{ __('auth.sms.code_label') }}
                            </label>
                            <div class="rounded-2xl border border-orange-500/40 bg-gradient-to-r from-orange-500/10 via-slate-950 to-orange-500/10 shadow-inner">
                                <input
                                    wire:model.live="code"
                                    id="otp-code"
                                    name="code"
                                    type="text"
                                    inputmode="numeric"
                                    maxlength="{{ config('otp.length', 4) }}"
                                    class="w-full bg-transparent px-6 py-4 text-center text-2xl font-extrabold tracking-[0.6em] text-white placeholder:text-slate-600 focus:outline-none"
                                    placeholder="{{ __('auth.sms.code_placeholder') }}"
                                >
                            </div>
                            @error('code')
                                <p class="text-sm text-red-400">{{ $message }}</p>
                            @enderror

                            @if ($otpExpiresAt)
                                <div
                                    wire:key="otp-countdown-{{ $otpExpiresAt }}"
                                    x-data="otpCountdown({{ $otpExpiresAt }}, {{ now()->getTimestamp() }})"
                                    x-init="start()"
                                    class="space-y-3 text-center"
                                >
                                    <div class="text-sm font-semibold text-orange-200">
                                        <span x-text="label"></span>
                                    </div>

                                    <button
                                        x-show="done"
                                        x-cloak
                                        type="button"
                                        wire:click="sendOtp"
                                        wire:loading.attr="disabled"
                                        wire:target="sendOtp"
                                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-orange-500/40 bg-orange-500/10 px-3 py-2 text-sm font-semibold text-orange-200 hover:bg-orange-500/20 disabled:cursor-not-allowed disabled:opacity-60"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 4.5v5h5M19.5 19.5v-5h-5M19.5 9.5c-1.5-2.5-4-4-7.5-4-3.5 0-6.5 2-8 5m0 5c1.5 2.5 4 4 8 4 3.5 0 6.5-2 8-5" />
                                        </svg>
                                        <span>{{ __('auth.otp.resend') }}</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="space-y-3">
                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-3 rounded-xl bg-orange-500 px-4 py-3 text-base font-semibold text-slate-950 shadow-lg shadow-orange-500/30 transition hover:bg-orange-400 focus:outline-none focus:ring-4 focus:ring-orange-500/40"
                            wire:loading.attr="disabled"
                            wire:target="{{ $otpSent ? 'verifyOtp' : 'sendOtp' }}"
                        >
                            <svg wire:loading wire:target="{{ $otpSent ? 'verifyOtp' : 'sendOtp' }}" class="h-5 w-5 animate-spin text-slate-950" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="{{ $otpSent ? 'verifyOtp' : 'sendOtp' }}">
                                {{ $otpSent ? __('auth.sms.verify') : __('auth.sms.send') }}
                            </span>
                            <span wire:loading wire:target="{{ $otpSent ? 'verifyOtp' : 'sendOtp' }}">
                                {{ $otpSent ? __('auth.sms.verify') : __('auth.sms.send') }}
                            </span>
                        </button>

                        @php $privacyNote = trim(__('auth.sms.privacy_note')); @endphp
                        @if ($privacyNote !== '')
                            <p class="text-xs text-slate-400 {{ $alignment }}">
                                {{ $privacyNote }}
                            </p>
                        @endif
                    </div>
                </form>
            @else
                <div class="mt-8 flex flex-col items-center gap-4 text-center">
                    <a
                        href="{{ route('auth.google.redirect') }}"
                        class="inline-flex w-full max-w-sm items-center justify-center gap-3 rounded-xl bg-orange-500 px-5 py-3 text-base font-semibold text-slate-950 shadow-lg shadow-orange-500/30 transition hover:bg-orange-400 focus:outline-none focus:ring-4 focus:ring-orange-500/40"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 text-slate-950" aria-hidden="true" fill="currentColor">
                            <path d="M21 12.17C21 17.2 17.2 21 12.17 21C7.14 21 3.34 17.2 3.34 12.17C3.34 7.14 7.14 3.34 12.17 3.34C14.55 3.34 16.61 4.21 18.17 5.69L15.46 8.28C14.65 7.5 13.5 7.09 12.17 7.09C9.26 7.09 6.91 9.45 6.91 12.35C6.91 15.26 9.26 17.61 12.17 17.61C15.12 17.61 16.62 15.9 16.86 14.18H12.17V10.82H20.86C20.95 11.29 21 11.72 21 12.17Z" />
                        </svg>
                        <span>{{ __('auth.google.cta') }}</span>
                    </a>

                    @php $helperText = trim(__('auth.google.helper_text')); @endphp
                    @if ($helperText !== '')
                        <p class="text-sm text-slate-400">
                            {{ $helperText }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('otpCountdown', (expiry, serverNow) => ({
                expiryMs: expiry * 1000,
                serverNowMs: serverNow * 1000,
                offset: 0,
                label: '',
                done: false,
                timer: null,
                start() {
                    this.offset = Date.now() - this.serverNowMs;
                    this.tick();
                    this.timer = setInterval(() => this.tick(), 1000);
                },
                tick() {
                    const serverTime = Date.now() - this.offset;
                    const remainingMs = Math.max(0, this.expiryMs - serverTime);
                    const remainingSeconds = Math.round(remainingMs / 1000);
                    const minutes = String(Math.floor(remainingSeconds / 60)).padStart(2, '0');
                    const seconds = String(remainingSeconds % 60).padStart(2, '0');
                    this.label = '{{ __('auth.otp.expires_in', ['time' => ':time']) }}'.replace(':time', `${minutes}:${seconds}`);

                    if (remainingSeconds <= 0) {
                        this.done = true;
                        clearInterval(this.timer);
                    }
                },
                cleanup() {
                    if (this.timer) {
                        clearInterval(this.timer);
                        this.timer = null;
                    }
                },
            }));
        });
    </script>
@endpush
