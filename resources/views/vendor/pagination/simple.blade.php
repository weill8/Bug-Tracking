@if ($paginator->hasPages())

    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-700 leading-5 dark:text-gray-400">
                {!! __('Showing') !!}
                @if ($paginator->firstItem())
                    <span class="font-semibold text-indigo-600 bg-blue-100 py-1 px-2 rounded-full">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="font-semibold text-indigo-600 bg-blue-100 py-1 px-2 rounded-full">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                {!! __('of') !!}
                <span class="font-semibold text-indigo-600 bg-blue-100 py-1 px-2 rounded-full">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>

        <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-4">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded-md cursor-not-allowed">&laquo;</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="px-3 py-1 bg-white border rounded-md hover:bg-gray-100">&laquo;</a>
            @endif

            {{-- Current Page --}}
            <span class="mx-2 px-3 py-1 bg-indigo-600 text-white rounded-md">
                {{ $paginator->currentPage() }}
            </span>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="px-3 py-1 bg-white border rounded-md hover:bg-gray-100">&raquo;</a>
            @else
                <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded-md cursor-not-allowed">&raquo;</span>
            @endif
        </nav>
@endif
