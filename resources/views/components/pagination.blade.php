<!-- resources/views/components/pagination.blade.php -->

@if ($paginator->lastPage() > 1)

    @php
    $current = $paginator->currentPage();
    $last = $paginator->lastPage();
    @endphp

    <div class="flex col-span-12 gap-2 justify-center items-center flex-wrap">
        
        <ul class="flex gap-2 items-center">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li>
                <span class="border w-8 h-8 flex items-center justify-center rounded-full text-gray-400 border-gray-300">
                <i class="las la-angle-left"></i>
                </span>
                </li>
                @else
                <li>
                <a href="{{ $paginator->previousPageUrl() }}" class="border w-8 h-8 flex items-center justify-center rounded-full border-primary text-primary">
                <i class="las la-angle-left"></i>
                </a>
                </li>
            @endif


            {{-- First 5 Pages --}}
            @for ($i = 1; $i <= min(5,$last); $i++)
                <li>
                <a href="{{ $paginator->url($i) }}"
                class="border w-8 h-8 flex items-center justify-center rounded-full {{ $current==$i ? 'bg-primary text-white' : 'text-primary border-primary' }}">
                {{ $i }}
                </a>
                </li>
            @endfor


            {{-- Dots --}}
            @if ($last > 8)
                <li><span class="px-2">...</span></li>
            @endif


            {{-- Last 3 Pages --}}
            @for ($i = max($last-2,6); $i <= $last; $i++)
            <li>
                <a href="{{ $paginator->url($i) }}"
                class="border w-8 h-8 flex items-center justify-center rounded-full {{ $current==$i ? 'bg-primary text-white' : 'text-primary border-primary' }}">
                {{ $i }}
                </a>
            </li>
            @endfor


            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li>
                <a href="{{ $paginator->nextPageUrl() }}" class="border w-8 h-8 flex items-center justify-center rounded-full border-primary text-primary">
                <i class="las la-angle-right"></i>
                </a>
                </li>
            @else
                <li>
                <span class="border w-8 h-8 flex items-center justify-center rounded-full text-gray-400 border-gray-300">
                <i class="las la-angle-right"></i>
                </span>
                </li>
            @endif

        </ul>
    </div>

@endif