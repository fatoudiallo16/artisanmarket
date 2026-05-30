@props(['icon' => 'craft'])

@php
    $paths = match ($icon) {
        'gem' => 'M12 2 15 9l7 1-5 5 1 7-8-4-8 4 1-7-5-5 7-1z',
        'fabric' => 'M4 4h16v3H4zm0 6h16v10H4z M8 4v16 M16 4v16',
        'pot' => 'M8 21h8M12 3c-4 0-6 3-6 7h12c0-4-2-7-6-7zm-7 7h14v4a7 7 0 0 1-14 0z',
        'mask' => 'M12 3c4 0 7 2 9 5-2 8-7 13-9 13S6 16 3 8c2-3 5-5 9-5z M9 10h.01M15 10h.01',
        'leather' => 'M6 7h12l2 10H4zm2-4h8l2 4H6z',
        'music' => 'M9 18V5l12-2v13M9 9l12-2M9 18a3 3 0 1 0 0-6M21 16a3 3 0 1 0 0-6',
        'bag' => 'M6 8h12l1 12H5zm3-4h6l1 4H8z',
        'frame' => 'M5 5h14v14H5z M9 9h6v6H9z',
        'basket' => 'M4 10h16l-2 10H6zm4-6h8l2 6H6z',
        'leaf' => 'M11 20A7 7 0 0 1 9.8 6.2C15 2 20 4 20 10c0 6-5 10-9 10z M12 20c-2-4-2-8 0-12',
        default => 'M12 2 4 7v5c0 5 3.5 9 8 10 4.5-1 8-5 8-10V7z M12 22V12',
    };
@endphp

<svg class="am-product-icon-svg" viewBox="0 0 24 24" aria-hidden="true">
    <path d="{{ $paths }}" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
