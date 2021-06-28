@if ($paginator->hasPages())
    <div class="flex justify-between mt-4">
        <!-- Prev -->
        @if ($paginator->onFirstPage())
            <span class="w-16 px-2 py-1 text-center rounded border shadow bg-gray-200 cursor-not-allowed">
                Prev
            </span>
        @else
            <button class="w-16 px-2 py-1 text-center rounded border shadow bg-white cursor-pointer focus:outline-none"
            wire:click="previousPage">
                Prev
            </button>
        @endif
        <!-- End Prev -->

        <!-- Numbers -->
        @foreach ($elements as $element)
            <div class="flex">
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page === $paginator->currentPage())
                            <button class="mx-2 w-10 px-2 py-1 text-center rounded border shadow bg-blue-500 text-white cursor-pointer focus:outline-none"
                            wire:click='gotoPage({{ $page }})'>
                                {{ $page }}
                            </button>
                        @else
                            <button class="mx-2 w-10 px-2 py-1 text-center rounded border shadow bg-white cursor-pointer focus:outline-none"
                            wire:click='gotoPage({{ $page }})'>
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                @endif
            </div>
        @endforeach
        <!-- End Numbers -->

        <!-- Next -->
        @if ($paginator->hasMorePages())
            <button class="w-16 px-2 py-1 text-center rounded border shadow bg-white cursor-pointer focus:outline-none" 
            wire:click="nextPage">
                Next
            </button>
        @else
            <span class="w-16 px-2 py-1 text-center rounded border shadow bg-gray-200 cursor-not-allowed">
                Next
            </span>
        @endif
        <!-- End Next -->
        </div>
@endif