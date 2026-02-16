@extends('layouts.app')

@section('content')
    <div
        x-data="marketplaceApp()"
        x-init="init()"
        :dir="dir"
        :style="lang === 'fa' ? 'font-family: iranyekan, serif;' : 'font-family: Inter, ui-sans-serif, system-ui;'"
        class="min-h-screen bg-dark-950 text-[15px] text-gray-50 sm:text-base"
    >
        <div class="relative">
            <div class="pointer-events-none absolute inset-0">
                <div class="absolute -top-32 left-10 h-64 w-64 rounded-full bg-brand-500/12 blur-3xl"></div>
                <div class="absolute top-40 right-10 h-80 w-80 rounded-full bg-info/12 blur-3xl"></div>
                <div class="absolute bottom-0 left-1/2 h-48 w-96 -translate-x-1/2 bg-white/6 blur-3xl"></div>
            </div>

            <x-marketplace.topbar />

            <x-marketplace.header />

            <x-marketplace.categories />

            <div class="mx-auto max-w-screen-2xl px-3 pb-24 pt-6 sm:px-4 lg:px-6">
                <div class="flex flex-wrap items-center gap-2">
                    <template x-for="chip in popularChips" :key="chip">
                        <button class="inline-flex items-center gap-2 rounded-full border border-dark-600/70 bg-dark-800/70 px-3 py-1.5 text-sm font-semibold text-gray-200 transition hover:bg-white/5" type="button" x-text="chip"></button>
                    </template>
                </div>

                <x-marketplace.summary-cards />

                <x-marketplace.section
                    title-fa="پرفروش ها"
                    title-en="Best Sellers"
                    subtitle-fa="محبوب ترین اکانت ها"
                    subtitle-en="Top performing accounts"
                >
                    <x-slot name="action">
                        <button class="inline-flex items-center gap-2 rounded-xl border border-dark-600/70 bg-dark-800/70 px-3 py-2 text-sm font-semibold text-gray-50 transition hover:bg-white/5" type="button">
                            <span x-text="t('compareOffers')"></span>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h6M4 12h10M4 18h14" />
                            </svg>
                        </button>
                    </x-slot>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <template x-for="item in products.slice(0, 12)" :key="item.id">
                            <x-marketplace.product-card>
                                <x-slot name="badges">
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-brand-400/35 bg-brand-500/15 px-3 py-1 text-[11px] font-semibold text-brand-200 whitespace-nowrap" x-text="t('instantDelivery')"></span>
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-success/35 bg-success/15 px-3 py-1 text-[11px] font-semibold text-emerald-200 whitespace-nowrap" x-text="t('verifiedSeller')"></span>
                                </x-slot>
                                <x-slot name="actions">
                                    <button class="inline-flex flex-1 items-center justify-center rounded-lg bg-brand-500 px-4 py-3 text-sm font-bold text-dark-950 shadow-[0_10px_22px_-14px_rgba(255,122,0,0.9)] transition hover:bg-brand-400 whitespace-nowrap" type="button" x-text="t('buyNow')"></button>
                                    <div class="flex items-center gap-2">
                                        <button class="inline-flex h-12 w-12 items-center justify-center rounded-lg border border-white/15 bg-dark-900/70 text-gray-100 transition hover:bg-dark-700/85" type="button" aria-label="Favorite">
                                            <span class="mdi mdi-heart-outline text-[18px] leading-none" aria-hidden="true"></span>
                                        </button>
                                        <button class="inline-flex h-12 w-12 items-center justify-center rounded-lg border border-white/15 bg-dark-900/70 text-gray-100 transition hover:bg-dark-700/85" type="button" aria-label="Add to cart" @click="addToCart(item)">
                                            <span class="mdi mdi-plus text-[18px] leading-none" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </x-slot>
                            </x-marketplace.product-card>
                        </template>
                    </div>
                </x-marketplace.section>

                <x-marketplace.section
                    title-fa="فروشندگان برتر"
                    title-en="Top Sellers"
                    subtitle-fa="پروفایل فروشگاه ها"
                    subtitle-en="Storefronts you can trust"
                >
                    <x-slot name="action">
                        <button class="inline-flex items-center gap-2 rounded-xl border border-dark-600/70 bg-dark-800/70 px-3 py-2 text-sm font-semibold text-gray-50 transition hover:bg-white/5" type="button" x-text="t('sellers')"></button>
                    </x-slot>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        <template x-for="seller in sellers" :key="seller.id">
                            <div class="group relative overflow-hidden rounded-2xl border border-dark-600/80 bg-dark-800/95 p-4 shadow-[0_10px_24px_-14px_rgba(0,0,0,0.9)] transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_18px_32px_-16px_rgba(0,0,0,0.95)]">
                                <div class="pointer-events-none absolute inset-0 rounded-2xl ring-1 ring-white/8"></div>
                                <div class="absolute inset-x-0 top-0 h-14 bg-gradient-to-r from-brand-500/12 via-info/8 to-transparent"></div>

                                <div class="relative flex items-start justify-between gap-3">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="relative h-12 w-12 shrink-0 overflow-hidden rounded-xl border border-white/10">
                                            <img class="h-full w-full object-cover" :src="seller.avatar" :alt="seller.name" loading="lazy">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/35 to-transparent"></div>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="truncate whitespace-nowrap text-base font-black text-gray-50" x-text="seller.name"></div>
                                            <div class="truncate whitespace-nowrap text-xs font-medium text-gray-400" x-text="seller.meta"></div>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center rounded-full border border-white/10 bg-dark-900/70 px-2 py-1 text-[11px] font-semibold text-gray-300">#<span x-text="seller.rank"></span></span>
                                </div>

                                <div class="relative mt-4 grid grid-cols-2 gap-2 text-[11px] text-gray-300">
                                    <div class="rounded-xl border border-white/10 bg-dark-900/70 px-2.5 py-2">
                                        <div class="text-[10px] uppercase tracking-[0.08em] text-gray-500">Rating</div>
                                        <div class="mt-1 font-semibold text-amber-200" x-text="seller.rating"></div>
                                    </div>
                                    <div class="rounded-xl border border-white/10 bg-dark-900/70 px-2.5 py-2">
                                        <div class="text-[10px] uppercase tracking-[0.08em] text-gray-500">Response</div>
                                        <div class="mt-1 font-semibold text-info" x-text="seller.response"></div>
                                    </div>
                                </div>

                                <div class="relative mt-4">
                                    <div class="h-1.5 w-full rounded-full bg-dark-900/80 ring-1 ring-white/10">
                                        <div class="h-1.5 rounded-full bg-gradient-to-r from-success to-info" :style="`width:${seller.trust}%`"></div>
                                    </div>
                                </div>

                                <div class="relative mt-4 flex items-center justify-between gap-2">
                                    <span class="inline-flex items-center rounded-full border border-success/35 bg-success/15 px-2.5 py-1 text-xs font-semibold text-success whitespace-nowrap" x-text="t('verifiedSeller')"></span>
                                    <button class="inline-flex h-9 items-center justify-center rounded-lg border border-white/10 bg-dark-900/70 px-3 text-xs font-semibold text-gray-100 transition hover:bg-dark-800 whitespace-nowrap" type="button">
                                        <span x-text="lang === 'fa' ? 'مشاهده فروشگاه' : 'View Store'"></span>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </x-marketplace.section>

                <x-marketplace.section
                    title-fa="علاقه مندی ها"
                    title-en="Favorites"
                    subtitle-fa="انتخاب های ذخیره شده برای خرید سریع"
                    subtitle-en="Saved picks ready for quick checkout"
                >
                    <x-slot name="action">
                        <button class="inline-flex items-center gap-2 rounded-xl border border-dark-600/70 bg-dark-800/70 px-3 py-2 text-sm font-semibold text-gray-50 transition hover:bg-white/5" type="button">
                            <span x-text="t('favorites')"></span>
                        </button>
                    </x-slot>
                    <div class="flex gap-4 overflow-x-auto pb-2">
                        <template x-for="item in products.slice(0, 12)" :key="item.id + '-recent'">
                            <div class="group min-w-[270px] overflow-hidden rounded-2xl border border-dark-600/80 bg-dark-800/95 shadow-[0_10px_24px_-14px_rgba(0,0,0,0.9)] transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_18px_32px_-16px_rgba(0,0,0,0.95)]">
                                <div class="relative aspect-[4/3] w-full overflow-hidden border-b border-white/10 bg-dark-700">
                                    <img class="h-full w-full object-cover transition duration-500 group-hover:scale-105" :src="item.image" :alt="lang === 'fa' ? item.title_fa : item.title_en" loading="lazy">
                                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(59,130,246,0.16),_transparent_62%)]"></div>
                                    <div class="absolute inset-x-3 top-3 flex items-center justify-between">
                                        <span class="inline-flex items-center rounded-full border border-brand-400/35 bg-brand-500/15 px-2.5 py-1 text-[11px] font-semibold text-brand-200" x-text="lang === 'fa' ? 'ذخیره شده' : 'Saved'"></span>
                                        <button class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-white/15 bg-dark-900/70 text-gray-100 transition hover:bg-dark-700/85" type="button" aria-label="Favorite">
                                            <span class="mdi mdi-heart text-[15px] leading-none" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                    <div class="absolute bottom-3 left-3 inline-flex items-center rounded-full border border-white/15 bg-dark-900/80 px-2.5 py-1 text-xs font-semibold text-brand-300" x-text="item.price"></div>
                                </div>
                                <div class="p-4">
                                    <div class="truncate whitespace-nowrap text-base font-black tracking-tight text-gray-50" x-text="lang === 'fa' ? item.title_fa : item.title_en"></div>
                                    <div class="mt-3 flex items-center justify-between text-xs text-gray-400">
                                        <span class="inline-flex items-center gap-1 text-amber-200">
                                            <span class="mdi mdi-star text-[14px] leading-none" aria-hidden="true"></span>
                                            <span x-text="item.rating"></span>
                                        </span>
                                        <span class="rounded-full border border-white/10 bg-dark-900/80 px-2 py-1 font-semibold text-gray-300 whitespace-nowrap" x-text="lang === 'fa' ? item.region_fa : item.region_en"></span>
                                    </div>
                                    <div class="mt-4 flex items-center gap-2 border-t border-white/10 pt-4">
                                        <button class="inline-flex flex-1 items-center justify-center rounded-lg bg-brand-500 px-3 py-2 text-xs font-bold text-dark-950 transition hover:bg-brand-400 whitespace-nowrap" type="button" @click="addToCart(item)" x-text="t('addToCart')"></button>
                                        <button class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/15 bg-dark-900/70 text-gray-100 transition hover:bg-dark-700/85" type="button" aria-label="Open">
                                            <span class="mdi mdi-arrow-right text-[15px] leading-none" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </x-marketplace.section>
            </div>

            <x-marketplace.mobile-nav />
        </div>

        <x-marketplace.drawers />
    </div>


    <script>
        function marketplaceApp() {
            const productImages = [
                'https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1493711662062-fa541adb3fc8?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1487215078519-e21cc028cb29?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1526498460520-4c246339dccb?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1488590528505-98d2b5aba04b?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1613323593608-abc90fec84ff?auto=format&fit=crop&w=1200&q=80'
            ];

            return {
                lang: 'fa',
                dir: 'rtl',
                query: '',
                drawerNavOpen: false,
                drawerCartOpen: false,
                i18n: {
                    fa: {
                        buyers: 'خریداران',
                        sellers: 'فروشندگان',
                        affiliates: 'افیلیت',
                        currency: 'ارز',
                        language: 'زبان',
                        catalog: 'کاتالوگ',
                        searchPlaceholder: 'جستجو: اکانت، اشتراک، گیفت کارت…',
                        home: 'خانه',
                        chat: 'چت',
                        purchases: 'خریدها',
                        favorites: 'علاقه مندی ها',
                        cart: 'سبد خرید',
                        filters: 'فیلتر',
                        sort: 'مرتب سازی',
                        compareOffers: 'مقایسه آفرها',
                        instantDelivery: 'تحویل فوری',
                        buyerProtection: 'حمایت از خریدار',
                        verifiedSeller: 'فروشنده تایید شده',
                        warranty: 'گارانتی',
                        refundPolicy: 'قوانین بازگشت وجه',
                        buyNow: 'خرید فوری',
                        addToCart: 'افزودن به سبد خرید',
                        remove: 'حذف',
                        checkout: 'تسویه',
                        description: 'توضیحات',
                        specs: 'مشخصات',
                        reviews: 'نظرات',
                        faq: 'سوالات متداول'
                    },
                    en: {
                        buyers: 'Buyers',
                        sellers: 'Sellers',
                        affiliates: 'Affiliates',
                        currency: 'Currency',
                        language: 'Language',
                        catalog: 'Catalog',
                        searchPlaceholder: 'Search accounts, subscriptions, gift cards…',
                        home: 'Home',
                        chat: 'Chat',
                        purchases: 'Purchases',
                        favorites: 'Favorites',
                        cart: 'Cart',
                        filters: 'Filters',
                        sort: 'Sort',
                        compareOffers: 'Compare offers',
                        instantDelivery: 'Instant delivery',
                        buyerProtection: 'Buyer protection',
                        verifiedSeller: 'Verified seller',
                        warranty: 'Warranty',
                        refundPolicy: 'Refund policy',
                        buyNow: 'Buy now',
                        addToCart: 'Add to cart',
                        remove: 'Remove',
                        checkout: 'Checkout',
                        description: 'Description',
                        specs: 'Specs',
                        reviews: 'Reviews',
                        faq: 'FAQ'
                    }
                },
                categories: [
                    { id: 'c1', name_fa: 'هوش مصنوعی', name_en: 'AI Tools' },
                    { id: 'c2', name_fa: 'استریمینگ', name_en: 'Streaming' },
                    { id: 'c3', name_fa: 'گیمینگ', name_en: 'Gaming' },
                    { id: 'c4', name_fa: 'گیفت کارت', name_en: 'Gift Cards' },
                    { id: 'c5', name_fa: 'نرم افزار', name_en: 'Software' },
                    { id: 'c6', name_fa: 'کنسول', name_en: 'Console' },
                    { id: 'c7', name_fa: 'موزیک', name_en: 'Music' },
                    { id: 'c8', name_fa: 'امنیت', name_en: 'Security' },
                    { id: 'c9', name_fa: 'آموزش', name_en: 'Learning' },
                    { id: 'c10', name_fa: 'شبکه اجتماعی', name_en: 'Social' },
                    { id: 'c11', name_fa: 'VPN', name_en: 'VPN' },
                    { id: 'c12', name_fa: 'ابزارها', name_en: 'Tools' }
                ],
                popularChips: [
                    'ChatGPT Plus',
                    'Spotify Premium',
                    'Steam Wallet',
                    'PlayStation Store',
                    'Xbox Game Pass',
                    'Netflix',
                    'YouTube Premium',
                    'Apple Gift Card',
                    'Google Play',
                    'NordVPN',
                    'Adobe',
                    'Canva Pro',
                    'Disney+',
                    'Prime Video',
                    'Office 365',
                    'Battle.net',
                    'Epic Games',
                    'Roblox',
                    'Valorant',
                    'Fortnite',
                    'Telegram Premium',
                    'LinkedIn Premium',
                    'Coursera',
                    'Udemy'
                ],
                products: Array.from({ length: 48 }, (_, index) => {
                    const id = index + 1;
                    return {
                        id,
                        title_fa: `اکانت ویژه #${id}`,
                        title_en: `Premium Account #${id}`,
                        rating: `4.${(index % 9) + 1} (${120 + index})`,
                        region_fa: 'EU/US',
                        region_en: 'EU/US',
                        price: `$${(5 + index).toFixed(2)}`,
                        image: productImages[index % productImages.length]
                    };
                }),
                sellers: Array.from({ length: 18 }, (_, index) => ({
                    id: index + 1,
                    rank: index + 1,
                    name: `Vendor ${index + 1}`,
                    meta: `+${1200 + index * 20} ${index % 2 === 0 ? 'Sales' : 'Orders'}`,
                    rating: `4.${(index % 9) + 1} ★`,
                    response: `${91 + (index % 8)}%`,
                    trust: 88 + (index % 11),
                    avatar: `https://i.pravatar.cc/160?img=${(index % 70) + 1}`
                })),
                cart: [
                    { id: 1, title_fa: 'اکانت نتفلیکس یک ماهه', title_en: 'Netflix 1 Month', price: '$6.99' },
                    { id: 2, title_fa: 'اسپاتیفای پریمیوم', title_en: 'Spotify Premium', price: '$4.50' },
                    { id: 3, title_fa: 'گیفت کارت استیم', title_en: 'Steam Gift Card', price: '$10.00' }
                ],
                init() {
                    const savedLang = localStorage.getItem('app.lang');
                    if (savedLang) {
                        this.lang = savedLang;
                        this.dir = savedLang === 'fa' ? 'rtl' : 'ltr';
                    }
                    document.documentElement.dir = this.dir;
                },
                t(key) {
                    return this.i18n[this.lang][key] || key;
                },
                setLang(code) {
                    this.lang = code;
                    this.dir = code === 'fa' ? 'rtl' : 'ltr';
                    localStorage.setItem('app.lang', code);
                    localStorage.setItem('app.dir', this.dir);
                    document.documentElement.dir = this.dir;
                },
                addToCart(item) {
                    if (this.cart.length >= 6) return;
                    this.cart.push({
                        id: this.cart.length + 10,
                        title_fa: item.title_fa,
                        title_en: item.title_en,
                        price: item.price
                    });
                },
                removeFromCart(id) {
                    this.cart = this.cart.filter(item => item.id !== id);
                },
                get cartTotal() {
                    const total = this.cart.reduce((sum, item) => sum + parseFloat(item.price.replace('$', '')), 0);
                    return `$${total.toFixed(2)}`;
                }
            };
        }
    </script>
@endsection
