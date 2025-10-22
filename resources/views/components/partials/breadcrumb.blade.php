@props(['items' => [], 'current' => null])

<div class="breadcrumbs text-sm mb-4">
    <ul>
        @foreach($items as $name => $route)
            <li><a href="{{ $route }}" class="link link-hover text-gray-400 ">{{ $name }}</a></li>
        @endforeach
        <li class="text-primary font-medium">{{ $current }}</li>
    </ul>
</div>
