<!-- resources/views/components/pagination.blade.php -->

@if ($paginator->lastPage() > 1)
    <div class="flex col-span-12 gap-4 sm:justify-between justify-center items-center flex-wrap">
        <ul class="flex gap-2 md:gap-3 flex-wrap md:font-semibold items-center">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li><button class="border md:w-10 md:h-10 w-8 h-8 flex items-center justify-center rounded-full text-gray-400 border-gray-300" disabled><i class="las la-angle-left text-lg"></i></button></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" class="hover:bg-primary text-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary"><i class="las la-angle-left text-lg"></i></a></li>
            @endif

            {{-- Page Numbers --}}
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                @if ($i == $paginator->currentPage())
                    <li><button class="hover:bg-primary text-n0 bg-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">{{ $i }}</button></li>
                @else
                    <li><a href="{{ $paginator->url($i) }}" class="hover:bg-primary text-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">{{ $i }}</a></li>
                @endif
            @endfor

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" class="hover:bg-primary text-primary hover:text-n0 rtl:rotate-180 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary"><i class="las la-angle-right text-lg"></i></a></li>
            @else
                <li><button class="border md:w-10 md:h-10 w-8 h-8 flex items-center justify-center rounded-full text-gray-400 border-gray-300" disabled><i class="las la-angle-right text-lg"></i></button></li>
            @endif
        </ul>
    </div>
@endif
