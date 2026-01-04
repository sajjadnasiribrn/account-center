@extends('layouts.app')

@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, config('app.rtl_locales', []), true);
    $alignment = $isRtl ? 'text-right' : 'text-left';
@endphp

@section('title', __('auth.onboarding.title'))

@section('content')
    <div class="min-h-screen bg-slate-950 text-slate-100">
        <div class="absolute inset-0 overflow-hidden" aria-hidden="true">
            <div class="absolute -top-32 left-1/3 h-72 w-72 -translate-x-1/2 rounded-full bg-orange-500/10 blur-[120px]"></div>
            <div class="absolute bottom-0 right-0 h-80 w-80 translate-x-1/3 rounded-full bg-amber-400/10 blur-[140px]"></div>
        </div>

        <div class="relative mx-auto flex min-h-screen max-w-3xl items-center px-4 py-12">
            <div class="w-full rounded-3xl border border-slate-800/80 bg-slate-900/80 p-6 shadow-2xl shadow-black/40 backdrop-blur sm:p-10">
                <div class="flex flex-col gap-2 {{ $alignment }}">
                    <span class="w-fit rounded-full border border-orange-500/40 bg-orange-500/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-orange-300">
                        {{ __('auth.onboarding.badge') }}
                    </span>
                    <h1 class="text-3xl font-extrabold text-white sm:text-4xl">
                        {{ __('auth.onboarding.title') }}
                    </h1>
                    <p class="text-sm text-slate-300 sm:text-base">
                        {{ __('auth.onboarding.description') }}
                    </p>
                    @if ($user?->phone)
                        <p class="text-xs text-slate-400">
                            {{ __('auth.onboarding.phone_hint', ['phone' => $user->phone]) }}
                        </p>
                    @endif
                </div>

                <form method="POST" action="{{ route('auth.email-onboarding.store', ['locale' => $locale]) }}" class="mt-8 space-y-6 {{ $alignment }}">
                    @csrf
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-200" for="email">
                            {{ __('auth.onboarding.email_label') }}
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            dir="ltr"
                            value="{{ old('email', $user?->email) }}"
                            class="w-full rounded-xl border border-slate-700 bg-slate-950/60 px-4 py-3 text-base font-semibold text-white shadow-inner focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/40"
                            placeholder="{{ __('auth.onboarding.email_placeholder') }}"
                            required
                        >
                        @error('email')
                            <p class="text-sm text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-slate-400">
                            {{ __('auth.onboarding.helper') }}
                        </p>
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-orange-500 px-4 py-3 text-base font-semibold text-slate-950 shadow-lg shadow-orange-500/30 transition hover:bg-orange-400 focus:outline-none focus:ring-4 focus:ring-orange-500/40"
                        >
                            {{ __('auth.onboarding.submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
