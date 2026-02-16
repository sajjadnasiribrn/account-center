<div class="fixed inset-x-0 bottom-0 z-40 md:hidden">
    <div class="mx-auto max-w-screen-2xl px-3 pb-3">
        <div class="grid h-16 grid-cols-4 rounded-2xl border border-dark-600/70 bg-dark-900/92 text-[11px] text-gray-300 shadow-[0_18px_35px_-18px_rgba(0,0,0,0.95)] backdrop-blur-xl">
            <button class="flex flex-col items-center justify-center gap-1 rounded-l-2xl text-brand-300" type="button">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5 12 3l9 7.5V20a1 1 0 0 1-1 1h-5.5V14h-5v7H4a1 1 0 0 1-1-1v-9.5Z" />
                </svg>
                <span x-text="t('home')"></span>
            </button>

            <button class="flex flex-col items-center justify-center gap-1" type="button" @click="drawerCartOpen = true">
                <span class="relative inline-flex">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l2.2 11.5a2 2 0 0 0 2 1.5h8.5a2 2 0 0 0 2-1.6L22 8H7" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 20a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm8 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" />
                    </svg>
                    <span
                        class="absolute -top-1 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-brand-500 px-1 text-[10px] font-bold leading-none text-dark-950"
                        :class="dir === 'rtl' ? '-left-2' : '-right-2'"
                        x-text="cart.length"
                    ></span>
                </span>
                <span x-text="t('cart')"></span>
            </button>

            <button class="flex flex-col items-center justify-center gap-1" type="button">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8Z" />
                </svg>
                <span x-text="lang === 'fa' ? 'پشتیبانی' : 'Support'"></span>
            </button>

            <button class="flex flex-col items-center justify-center gap-1 rounded-r-2xl" type="button">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0 1 16 0" />
                </svg>
                <span x-text="lang === 'fa' ? 'ناحیه کاربری' : 'Account'"></span>
            </button>
        </div>
    </div>
</div>
