@props([
    'name',
    'class' => null
])

<svg class="{{ $class ?? 'w-6 h-6 text-blue-500' }}">
    <use xlink:href="{{ asset('svg/icons-heroicons.svg') }}#{{ $name }}"></use>
</svg>



{{-- <x-partials.icons name="adjustments-horizontal" class="w-16 h-16 text-green-600" /> --}}