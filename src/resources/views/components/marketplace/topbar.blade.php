<div class="border-b border-dark-600/70 bg-dark-900/75">
    <div class="mx-auto hidden h-11 max-w-screen-2xl items-center justify-between px-3 sm:px-4 lg:px-6 md:flex">
        <div class="flex items-center gap-1" :class="dir === 'rtl' ? 'flex-row-reverse' : ''">
            <button class="inline-flex h-8 items-center rounded-lg px-3 text-[13px] font-medium text-gray-300 transition hover:bg-dark-700/80 hover:text-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-500/35" type="button" x-text="t('buyers')"></button>
            <button class="inline-flex h-8 items-center rounded-lg px-3 text-[13px] font-medium text-gray-300 transition hover:bg-dark-700/80 hover:text-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-500/35" type="button" x-text="t('sellers')"></button>
            <button class="inline-flex h-8 items-center rounded-lg px-3 text-[13px] font-medium text-gray-300 transition hover:bg-dark-700/80 hover:text-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-500/35" type="button" x-text="t('affiliates')"></button>
        </div>

        <div class="flex shrink-0 items-center gap-2" :class="dir === 'rtl' ? 'flex-row-reverse' : ''">
            <div class="relative" x-data="{ open: false }">
                <button
                    class="inline-flex h-9 items-center gap-2 whitespace-nowrap rounded-lg border border-dark-600/80 bg-dark-800/80 px-3 text-[13px] font-medium text-gray-200 shadow-[inset_0_1px_0_rgba(255,255,255,0.04)] transition hover:bg-dark-700/80 focus:outline-none focus:ring-2 focus:ring-brand-500/35"
                    type="button"
                    @click="open = !open"
                    :aria-expanded="open.toString()"
                >
                    <span class="mdi mdi-translate text-[18px] leading-none text-gray-400" aria-hidden="true"></span>
                    <span x-text="lang === 'fa' ? 'فارسی' : 'EN'"></span>
                    <span class="mdi mdi-chevron-down text-[18px] leading-none text-gray-500" aria-hidden="true"></span>
                </button>

                <div
                    class="absolute z-50 mt-2 w-36 rounded-xl border border-dark-600/80 bg-dark-900/95 p-1.5 shadow-xl shadow-black/45"
                    :class="dir === 'rtl' ? 'left-0 right-auto' : 'right-0 left-auto'"
                    x-cloak
                    x-show="open"
                    x-transition
                    @click.outside="open = false"
                >
                    <button
                        class="flex w-full items-center rounded-lg px-3 py-2 text-sm text-gray-100 transition hover:bg-dark-700/80"
                        :class="dir === 'rtl' ? 'justify-end text-right' : 'justify-start text-left'"
                        type="button"
                        @click="setLang('fa'); open = false"
                    >
                        فارسی
                    </button>
                    <button
                        class="flex w-full items-center rounded-lg px-3 py-2 text-sm text-gray-100 transition hover:bg-dark-700/80"
                        :class="dir === 'rtl' ? 'justify-end text-right' : 'justify-start text-left'"
                        type="button"
                        @click="setLang('en'); open = false"
                    >
                        EN
                    </button>
                </div>
            </div>

            <button class="inline-flex h-9 items-center gap-2 whitespace-nowrap rounded-lg border border-dark-600/80 bg-dark-800/80 px-3 text-[13px] font-medium text-gray-200 shadow-[inset_0_1px_0_rgba(255,255,255,0.04)] transition hover:bg-dark-700/80 focus:outline-none focus:ring-2 focus:ring-brand-500/35" type="button">
                <span class="mdi mdi-currency-usd text-[18px] leading-none text-gray-400" aria-hidden="true"></span>
                <span x-text="lang === 'fa' ? 'ارز' : 'Currency'"></span>
                <span class="inline-flex items-center rounded-md bg-brand-500/20 px-1.5 py-0.5 text-[11px] font-semibold text-brand-300">USD</span>
            </button>
        </div>
    </div>

    <div class="mx-auto max-w-screen-2xl px-3 py-2 sm:px-4 md:hidden">
        <div
            class="flex items-center gap-1.5 overflow-x-auto overflow-y-visible whitespace-nowrap pb-1 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
            :class="dir === 'rtl' ? 'flex-row-reverse' : ''"
        >
            <button class="inline-flex h-8 items-center rounded-lg px-3 text-[13px] font-medium text-gray-300 transition hover:bg-dark-700/80 hover:text-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-500/35" type="button" x-text="t('buyers')"></button>
            <button class="inline-flex h-8 items-center rounded-lg px-3 text-[13px] font-medium text-gray-300 transition hover:bg-dark-700/80 hover:text-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-500/35" type="button" x-text="t('sellers')"></button>
            <button class="inline-flex h-8 items-center rounded-lg px-3 text-[13px] font-medium text-gray-300 transition hover:bg-dark-700/80 hover:text-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-500/35" type="button" x-text="t('affiliates')"></button>
            <div class="relative shrink-0" x-data="{ open: false }">
                <button
                    class="inline-flex h-9 items-center gap-2 whitespace-nowrap rounded-lg border border-dark-600/80 bg-dark-800/80 px-3 text-[13px] font-medium text-gray-200 shadow-[inset_0_1px_0_rgba(255,255,255,0.04)] transition hover:bg-dark-700/80 focus:outline-none focus:ring-2 focus:ring-brand-500/35"
                    type="button"
                    @click="open = !open"
                    :aria-expanded="open.toString()"
                >
                    <span class="mdi mdi-translate text-[18px] leading-none text-gray-400" aria-hidden="true"></span>
                    <span x-text="lang === 'fa' ? 'فارسی' : 'EN'"></span>
                    <span class="mdi mdi-chevron-down text-[18px] leading-none text-gray-500" aria-hidden="true"></span>
                </button>

                <div
                    class="absolute z-50 mt-2 w-36 rounded-xl border border-dark-600/80 bg-dark-900/95 p-1.5 shadow-xl shadow-black/45"
                    :class="dir === 'rtl' ? 'left-0 right-auto' : 'right-0 left-auto'"
                    x-cloak
                    x-show="open"
                    x-transition
                    @click.outside="open = false"
                >
                    <button
                        class="flex w-full items-center rounded-lg px-3 py-2 text-sm text-gray-100 transition hover:bg-dark-700/80"
                        :class="dir === 'rtl' ? 'justify-end text-right' : 'justify-start text-left'"
                        type="button"
                        @click="setLang('fa'); open = false"
                    >
                        فارسی
                    </button>
                    <button
                        class="flex w-full items-center rounded-lg px-3 py-2 text-sm text-gray-100 transition hover:bg-dark-700/80"
                        :class="dir === 'rtl' ? 'justify-end text-right' : 'justify-start text-left'"
                        type="button"
                        @click="setLang('en'); open = false"
                    >
                        EN
                    </button>
                </div>
            </div>

            <button class="inline-flex h-9 shrink-0 items-center gap-2 whitespace-nowrap rounded-lg border border-dark-600/80 bg-dark-800/80 px-3 text-[13px] font-medium text-gray-200 shadow-[inset_0_1px_0_rgba(255,255,255,0.04)] transition hover:bg-dark-700/80 focus:outline-none focus:ring-2 focus:ring-brand-500/35" type="button">
                <span class="mdi mdi-currency-usd text-[18px] leading-none text-gray-400" aria-hidden="true"></span>
                <span x-text="lang === 'fa' ? 'ارز' : 'Currency'"></span>
                <span class="inline-flex items-center rounded-md bg-brand-500/20 px-1.5 py-0.5 text-[11px] font-semibold text-brand-300">USD</span>
            </button>
        </div>
    </div>
</div>
