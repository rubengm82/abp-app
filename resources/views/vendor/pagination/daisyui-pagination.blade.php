@if ($paginator->hasPages())
    <nav role="navigation" aria-label="pagination" class="flex items-center justify-center mt-6">
        <div class="join">
            {{-- Previous link --}}
            @if ($paginator->onFirstPage())
                <button class="join-item btn btn-sm btn-disabled">
                    « Anterior
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="join-item btn btn-sm">
                    « Anterior
                </a>
            @endif

            {{-- Page numbers --}}
            @foreach ($elements as $element)
                {{-- Punts suspensius --}}
                @if (is_string($element))
                    <button class="join-item btn btn-sm btn-disabled">
                        {{ $element }}
                    </button>
                @endif

                {{-- Page list --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button class="join-item btn btn-sm btn-primary">
                                {{ $page }}
                            </button>
                        @else
                            <a href="{{ $url }}" class="join-item btn btn-sm">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

             {{-- Next link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="join-item btn btn-sm">
                    Següent »
                </a>
            @else
                <button class="join-item btn btn-sm btn-disabled">
                    Següent »
                </button>
            @endif
        </div>
    </nav>
@endif
