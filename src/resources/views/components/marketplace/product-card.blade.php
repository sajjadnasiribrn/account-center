@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'group relative overflow-hidden rounded-2xl border border-dark-600/80 bg-dark-800/95 shadow-[0_10px_24px_-14px_rgba(0,0,0,0.9)] transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_20px_34px_-16px_rgba(0,0,0,0.95)] ' . $class]) }}>
    <div class="pointer-events-none absolute inset-0 rounded-2xl ring-1 ring-white/8"></div>

    <div class="relative aspect-[4/3] w-full overflow-hidden border-b border-white/10 bg-dark-700">
        <img
            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
            :src="item.image"
            :alt="lang === 'fa' ? item.title_fa : item.title_en"
            loading="lazy"
        >
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.16),_transparent_62%)]"></div>
        <div class="absolute inset-0 bg-[linear-gradient(175deg,_transparent_38%,_rgba(11,14,20,0.72)_100%)]"></div>

        <div class="absolute inset-x-3 top-3 flex items-center justify-between">
            <span class="inline-flex items-center rounded-full border border-info/35 bg-info/15 px-2.5 py-1 text-[11px] font-semibold text-info" x-text="lang === 'fa' ? 'پیشنهادی' : 'Featured'"></span>
            <button class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-white/15 bg-dark-900/75 text-gray-100 transition hover:bg-dark-700/90" type="button" aria-label="Favorite">
                <span class="mdi mdi-heart-outline text-[18px] leading-none" aria-hidden="true"></span>
            </button>
        </div>

        <div class="absolute bottom-3 left-3 inline-flex items-center rounded-full border border-white/15 bg-dark-900/80 px-3 py-1 text-xs font-semibold text-gray-100" x-text="lang === 'fa' ? item.region_fa : item.region_en"></div>
    </div>

    <div class="relative p-5">
        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
                <div class="truncate text-lg font-black tracking-tight text-gray-50" x-text="lang === 'fa' ? item.title_fa : item.title_en"></div>
            </div>
            <div class="inline-flex items-center gap-1 rounded-full border border-amber-300/25 bg-amber-300/15 px-2.5 py-1 text-xs font-semibold text-amber-200">
                <span class="mdi mdi-star text-[14px] leading-none" aria-hidden="true"></span>
                <span x-text="item.rating"></span>
            </div>
        </div>

        <div class="mt-4 flex items-end justify-between gap-3 border-t border-white/5 pt-4">
            <div>
                <div class="text-[11px] font-semibold uppercase tracking-[0.08em] text-gray-500" x-text="lang === 'fa' ? 'شروع از' : 'Starting at'"></div>
                <div class="mt-1 text-2xl font-black leading-none text-brand-300" x-text="item.price"></div>
            </div>
        </div>

        @if (isset($badges))
            <div class="mt-4 flex flex-wrap gap-2">
                {{ $badges }}
            </div>
        @endif

        @if (isset($meta))
            <div class="mt-4 text-sm text-gray-400">
                {{ $meta }}
            </div>
        @endif

        @if (isset($actions))
            <div class="mt-5 flex items-center justify-between gap-3 border-t border-white/5 pt-5">
                {{ $actions }}
            </div>
        @else
            <div class="mt-5 flex items-center justify-between gap-3 border-t border-white/10 pt-5">
                <button class="inline-flex flex-1 items-center justify-center rounded-lg bg-brand-500 px-4 py-3 text-sm font-bold text-dark-950 shadow-[0_10px_22px_-14px_rgba(255,122,0,0.9)] transition hover:bg-brand-400 whitespace-nowrap" type="button" x-text="t('buyNow')"></button>
                <button class="inline-flex h-12 w-12 items-center justify-center rounded-lg border border-white/15 bg-dark-900/70 text-gray-100 transition hover:bg-dark-700/85" type="button" aria-label="Add to cart" @click="addToCart(item)">
                    <span class="mdi mdi-plus text-[18px] leading-none" aria-hidden="true"></span>
                </button>
            </div>
        @endif
    </div>
</div>
