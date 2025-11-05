@props(['color' => 'sand'])

@php
    $classes = match($color) {
        'sand' => 'bg-sand text-dark',
        'white' => 'bg-white text-dark',
        'graylight' => 'bg-graylight text-dark',
        'graydark' => 'bg-graydark text-white',
        'dark' => 'bg-dark text-white',
        default => 'bg-sand text-dark',
    };
    
    // Check if button is disabled
    $isDisabled = $attributes->has('disabled') || $attributes->get('disabled') === true;
    
    // Add disabled styles if disabled
    if ($isDisabled) {
        $classes .= ' opacity-50 cursor-not-allowed';
    } else {
        $classes .= ' hover:shadow-lg transition';
    }
@endphp

<button {{ $attributes->merge([
    'class' => "$classes rounded-xl shadow-soft px-5 py-2 font-semibold"
]) }}>
    {{ $slot }}
</button>

