@props([
    'titleFa',
    'titleEn',
    'subtitleFa' => null,
    'subtitleEn' => null,
])

<section {{ $attributes->class(['mt-10']) }}>
    <div class="flex items-center justify-between">
        <div>
            <div class="text-base font-black text-gray-50" x-text="lang === 'fa' ? @json($titleFa) : @json($titleEn)"></div>
            @if ($subtitleFa || $subtitleEn)
                <div class="text-sm text-gray-400" x-text="lang === 'fa' ? @json($subtitleFa) : @json($subtitleEn)"></div>
            @endif
        </div>
        {{ $action ?? '' }}
    </div>
    <div class="mt-4">
        {{ $slot }}
    </div>
</section>
