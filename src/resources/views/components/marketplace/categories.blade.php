<div class="relative border-b border-dark-600/70 bg-dark-900/80">
    <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-brand-500/45 to-transparent"></div>
    <div class="mx-auto max-w-screen-2xl px-3 py-2 sm:px-4 lg:px-6">
        <div class="flex items-center gap-2 overflow-x-auto pb-0.5 text-sm text-gray-200">
            <template x-for="category in categories" :key="category.id">
                <button class="group inline-flex shrink-0 items-center gap-2 rounded-lg border border-dark-600/80 bg-dark-800/75 px-3.5 py-2 font-medium text-gray-200 shadow-[inset_0_1px_0_rgba(255,255,255,0.04)] transition hover:border-brand-500/35 hover:bg-dark-700/80 hover:text-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-500/30" type="button">
                    <span class="h-2 w-2 rounded-full bg-brand-400 transition group-hover:scale-110"></span>
                    <span class="whitespace-nowrap" x-text="lang === 'fa' ? category.name_fa : category.name_en"></span>
                </button>
            </template>
        </div>
    </div>
</div>
