<div class="flex items-center justify-center w-full space-x-2">
    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span class="px-3 py-2 text-gray-400 bg-gray-200 rounded-lg cursor-not-allowed shadow">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}"
            class="px-3 py-2 text-gray-700 bg-white rounded-lg shadow hover:bg-gray-100 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
    @endif

    {{-- Pages --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded shadow">...</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span
                        class="px-3 py-2 text-white bg-blue-600 rounded-lg shadow font-semibold">{{ $page }}</span>
                @else
                    <a href="{{ $url }}"
                        class="px-3 py-2 text-gray-700 bg-white rounded-lg shadow hover:bg-blue-50 transition">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
            class="px-3 py-2 text-gray-700 bg-white rounded-lg shadow hover:bg-gray-100 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    @else
        <span class="px-3 py-2 text-gray-400 bg-gray-200 rounded-lg cursor-not-allowed shadow">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </span>
    @endif
</div>
