<header class="sticky top-0 z-50 border-b border-dark-600/70 bg-dark-900/92 shadow-[0_12px_24px_-20px_rgba(0,0,0,0.9)] backdrop-blur-xl">
    <div class="mx-auto flex h-[72px] max-w-screen-2xl items-center justify-between gap-3 px-3 sm:px-4 lg:px-6">
        <div class="flex items-center gap-2" :class="dir === 'rtl' ? 'flex-row-reverse' : ''">
            <button
                class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-dark-600/80 bg-dark-800/80 text-gray-200 shadow-[inset_0_1px_0_rgba(255,255,255,0.04)] transition hover:bg-dark-700/80 hover:text-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-500/35"
                type="button"
                @click="drawerNavOpen = true"
                aria-label="Open navigation"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M3 12h18M3 18h18" />
                </svg>
            </button>

            <div class="flex items-center gap-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-500/20 text-sm font-black text-brand-300 ring-1 ring-brand-500/35">AC</div>
                <div class="hidden sm:block">
                    <div class="text-[15px] font-semibold tracking-tight text-gray-50">Account Center</div>
                    <div class="text-[11px] text-gray-400" x-text="lang === 'fa' ? 'مدیریت سرویس ها' : 'Service Marketplace'"></div>
                </div>
            </div>
        </div>

        <div class="relative flex-1 md:flex-[0_1_560px] lg:flex-[0_1_700px]">
            <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" :class="dir === 'rtl' ? 'right-3 left-auto' : ''">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M11 18a7 7 0 1 1 0-14 7 7 0 0 1 0 14Z" />
                </svg>
            </span>

            <input
                class="h-11 w-full rounded-xl border border-dark-600/80 bg-dark-800/80 pl-11 pr-4 text-sm text-gray-100 shadow-[inset_0_1px_0_rgba(255,255,255,0.04)] transition placeholder:text-gray-500 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/30"
                :class="dir === 'rtl' ? 'pl-4 pr-11 text-right' : ''"
                type="text"
                :placeholder="t('searchPlaceholder')"
                x-model="query"
            />
        </div>

        <div class="hidden items-center gap-1 md:flex" :class="dir === 'rtl' ? 'flex-row-reverse' : ''">
            <button class="inline-flex h-11 items-center gap-2 rounded-xl border border-transparent px-3 text-sm font-medium text-gray-300 transition hover:border-dark-600/70 hover:bg-dark-800/75 hover:text-gray-50" type="button" aria-label="Chat">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8Z" />
                </svg>
                <span x-text="lang === 'fa' ? 'پشتیبانی' : 'Support'"></span>
            </button>

            <button class="inline-flex h-11 items-center gap-2 rounded-xl border border-transparent px-3 text-sm font-medium text-gray-300 transition hover:border-dark-600/70 hover:bg-dark-800/75 hover:text-gray-50" type="button" aria-label="Account">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0 1 16 0" />
                </svg>
                <span x-text="lang === 'fa' ? 'ناحیه کاربری' : 'Account'"></span>
            </button>

            <button
                class="relative inline-flex h-11 items-center gap-2 rounded-xl border border-dark-600/80 bg-dark-800/80 px-3 text-sm font-medium text-gray-100 shadow-[inset_0_1px_0_rgba(255,255,255,0.04)] transition hover:bg-dark-700/80"
                type="button"
                @click="drawerCartOpen = true"
                aria-label="Cart"
            >
                <span class="absolute -right-1 -top-1 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-brand-500 px-1 text-[10px] font-bold leading-none text-dark-950" x-text="cart.length"></span>
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l2.2 11.5a2 2 0 0 0 2 1.5h8.5a2 2 0 0 0 2-1.6L22 8H7" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 20a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm8 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" />
                </svg>
                <span x-text="t('cart')"></span>
            </button>
        </div>
    </div>
</header>
