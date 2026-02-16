<div class="mt-6 grid gap-4 md:grid-cols-3">
    <div class="rounded-2xl border border-dark-600/70 bg-dark-700/70 p-5 shadow-lg shadow-black/30">
        <div class="text-sm font-black uppercase tracking-wide text-gray-400">Marketplace</div>
        <div class="mt-2 text-2xl font-black text-gray-50" x-text="lang === 'fa' ? 'بازارچه حساب و اشتراک' : 'Accounts & Subscriptions'"></div>
        <p class="mt-2 text-base text-gray-300" x-text="lang === 'fa' ? 'تراکم بالا، تحویل سریع، فروشندگان تایید شده.' : 'Dense listings, instant delivery, verified sellers.'"></p>
        <div class="mt-4 flex flex-wrap gap-2">
            <span class="inline-flex items-center rounded-full border border-success/35 bg-success/15 px-3 py-1 text-sm font-semibold text-success" x-text="t('buyerProtection')"></span>
            <span class="inline-flex items-center rounded-full border border-brand-500/35 bg-brand-500/15 px-3 py-1 text-sm font-semibold text-brand-300" x-text="t('instantDelivery')"></span>
            <span class="inline-flex items-center rounded-full border border-dark-600/70 bg-dark-800/70 px-3 py-1 text-sm font-semibold text-gray-200" x-text="t('verifiedSeller')"></span>
        </div>
    </div>
    <div class="rounded-2xl border border-dark-600/70 bg-dark-700/70 p-5 shadow-lg shadow-black/30">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-sm font-black uppercase tracking-wide text-gray-400">Deals</div>
                <div class="mt-2 text-xl font-black text-gray-50" x-text="lang === 'fa' ? 'فروش فوری امروز' : 'Today Fast Deals'"></div>
                <div class="mt-1 text-base text-gray-300" x-text="lang === 'fa' ? 'تحویل زیر 15 دقیقه' : 'Delivery under 15 minutes'"></div>
            </div>
            <div class="rounded-2xl bg-brand-500/20 px-3 py-2 text-sm font-black text-brand-300">-25%</div>
        </div>
        <div class="mt-4 grid grid-cols-3 gap-2 text-center text-sm text-gray-200">
            <div class="rounded-xl border border-dark-600/70 bg-dark-900/60 p-2">Netflix</div>
            <div class="rounded-xl border border-dark-600/70 bg-dark-900/60 p-2">Steam</div>
            <div class="rounded-xl border border-dark-600/70 bg-dark-900/60 p-2">ChatGPT</div>
        </div>
    </div>
    <div class="rounded-2xl border border-dark-600/70 bg-dark-700/70 p-5 shadow-lg shadow-black/30">
        <div class="text-sm font-black uppercase tracking-wide text-gray-400">Support</div>
        <div class="mt-2 text-xl font-black text-gray-50" x-text="lang === 'fa' ? 'تضمین بازگشت وجه' : 'Refund Protection'"></div>
        <p class="mt-2 text-base text-gray-300" x-text="lang === 'fa' ? 'گارانتی و بازگشت وجه برای آفرهای منتخب.' : 'Warranty and refund on selected offers.'"></p>
        <button class="mt-4 inline-flex items-center gap-2 rounded-xl border border-dark-600/70 bg-dark-800/70 px-4 py-2.5 text-base font-semibold text-gray-50 transition hover:bg-white/5" type="button">
            <span x-text="t('faq')"></span>
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M7.21 5.23a.75.75 0 0 1 1.06-.02l4.5 4.24a.75.75 0 0 1 0 1.08l-4.5 4.24a.75.75 0 0 1-1.04-1.08L11.168 10 7.23 6.29a.75.75 0 0 1-.02-1.06Z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
</div>
