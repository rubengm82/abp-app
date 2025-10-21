@props(['items' => []])

<div class="breadcrumbs text-sm mb-4 text-gray-500">
    <ul>
        @foreach($items as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ul>
</div>
