<div
    class="fixed inset-0 z-[70] bg-black/55 backdrop-blur-[1px]"
    x-cloak
    x-show="drawerNavOpen || drawerCartOpen"
    x-transition.opacity
    @click="drawerNavOpen = false; drawerCartOpen = false"
></div>

<aside
    class="fixed top-0 z-[80] h-screen w-[336px] max-w-[calc(100vw-32px)] border border-dark-600/80 bg-dark-900/96 shadow-2xl shadow-black/55 transition-transform duration-300 ease-out"
    :class="drawerNavOpen ? 'translate-x-0' : (dir === 'rtl' ? 'translate-x-full' : '-translate-x-full')"
    :style="dir === 'rtl' ? 'right:0' : 'left:0'"
>
    <div class="flex h-16 items-center justify-between border-b border-dark-600/80 px-4">
        <div class="flex items-center gap-2">
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-500/15 text-brand-300 ring-1 ring-brand-500/35">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h9" />
                </svg>
            </div>
            <div class="text-base font-bold text-gray-50" x-text="t('catalog')"></div>
        </div>
        <button class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-gray-300 transition hover:bg-dark-700/80 hover:text-gray-50" type="button" @click="drawerNavOpen = false">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="space-y-1 p-2 text-sm text-gray-200">
        <a class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition hover:bg-dark-700/80" href="#">
            <span class="inline-flex h-7 w-7 items-center justify-center rounded-md bg-dark-800 text-gray-300">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5 12 3l9 7.5V20a1 1 0 0 1-1 1h-5.5V14h-5v7H4a1 1 0 0 1-1-1v-9.5Z" />
                </svg>
            </span>
            <span x-text="t('home')"></span>
        </a>
        <a class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition hover:bg-dark-700/80" href="#">
            <span class="inline-flex h-7 w-7 items-center justify-center rounded-md bg-dark-800 text-gray-300">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h10" />
                </svg>
            </span>
            <span x-text="t('catalog')"></span>
        </a>
        <a class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition hover:bg-dark-700/80" href="#">
            <span class="inline-flex h-7 w-7 items-center justify-center rounded-md bg-dark-800 text-gray-300">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h10M7 12h10M7 17h6" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5h.01M4 10h.01M4 15h.01" />
                </svg>
            </span>
            <span x-text="t('purchases')"></span>
        </a>
        <a class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition hover:bg-dark-700/80" href="#">
            <span class="inline-flex h-7 w-7 items-center justify-center rounded-md bg-dark-800 text-gray-300">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.5c0 5-9 11-9 11S3 13.5 3 8.5a4.5 4.5 0 0 1 8-2.5 4.5 4.5 0 0 1 8 2.5Z" />
                </svg>
            </span>
            <span x-text="t('favorites')"></span>
        </a>
        <a class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition hover:bg-dark-700/80" href="#">
            <span class="inline-flex h-7 w-7 items-center justify-center rounded-md bg-dark-800 text-gray-300">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8Z" />
                </svg>
            </span>
            <span x-text="t('chat')"></span>
        </a>
    </div>
</aside>

<aside
    class="fixed top-0 z-[80] h-screen w-[336px] max-w-[calc(100vw-32px)] border border-dark-600/80 bg-dark-900/96 shadow-2xl shadow-black/55 transition-transform duration-300 ease-out"
    :class="drawerCartOpen ? 'translate-x-0' : (dir === 'rtl' ? '-translate-x-full' : 'translate-x-full')"
    :style="dir === 'rtl' ? 'left:0' : 'right:0'"
>
    <div class="flex h-16 items-center justify-between border-b border-dark-600/80 px-4">
        <div class="flex items-center gap-2">
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-500/15 text-brand-300 ring-1 ring-brand-500/35">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l2.2 11.5a2 2 0 0 0 2 1.5h8.5a2 2 0 0 0 2-1.6L22 8H7" />
                </svg>
            </div>
            <div class="text-base font-bold text-gray-50" x-text="t('cart')"></div>
        </div>
        <button class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-gray-300 transition hover:bg-dark-700/80 hover:text-gray-50" type="button" @click="drawerCartOpen = false">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="max-h-[calc(100vh-145px)] space-y-3 overflow-y-auto p-4">
        <template x-for="item in cart" :key="item.id">
            <div class="rounded-xl border border-dark-600/80 bg-dark-800/80 p-4 shadow-[inset_0_1px_0_rgba(255,255,255,0.04)]">
                <div class="text-sm font-semibold text-gray-50" x-text="lang === 'fa' ? item.title_fa : item.title_en"></div>
                <div class="mt-3 flex items-center justify-between text-sm">
                    <span class="font-medium text-brand-300" x-text="item.price"></span>
                    <button class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-400 transition hover:bg-dark-700/80 hover:text-error" type="button" @click="removeFromCart(item.id)" aria-label="Remove">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12m-9 0v12m6-12v12m-8-12h10l-1 13a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2L6 7Z" />
                        </svg>
                    </button>
                </div>
            </div>
        </template>

        <div
            class="rounded-xl border border-dashed border-dark-600/80 bg-dark-800/55 p-4 text-center text-sm text-gray-400"
            x-show="cart.length === 0"
            x-cloak
            x-text="lang === 'fa' ? 'سبد خرید خالی است.' : 'Your cart is empty.'"
        ></div>
    </div>

    <div class="border-t border-dark-600/80 bg-dark-900/95 p-4">
        <div class="flex items-center justify-between text-sm text-gray-300">
            <span x-text="lang === 'fa' ? 'مجموع' : 'Total'"></span>
            <span class="text-base font-bold text-brand-300" x-text="cartTotal"></span>
        </div>
        <button class="mt-3 inline-flex h-11 w-full items-center justify-center rounded-xl bg-brand-500 px-4 text-sm font-bold text-dark-950 transition hover:bg-brand-400" type="button" x-text="t('checkout')"></button>
    </div>
</aside>
