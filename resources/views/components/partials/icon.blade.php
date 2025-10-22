@props([
    'name',
    'class' => null
])

<svg class="{{ $class ?? 'w-6 h-6 text-black' }}">
    <use xlink:href="{{ asset('svg/icons-solid-heroicons.svg') }}?v={{ filemtime(public_path('svg/icons-solid-heroicons.svg')) }}#{{ $name }}"></use>
</svg>
