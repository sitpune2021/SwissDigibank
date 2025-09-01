@extends('layout.main')

@section('content')
<div class="main-inner">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
        <h2 class="h2">RD/ DD Schemes</h2>
        <a class="btn-primary flex items-center gap-2" href="{{route('rdschemes.create')}}">
            Add
        </a>
    </div>
   

    <!-- Alpine.js for toggle -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
{{-- 
    <div class="mt-6" x-data="{ open: false }">
        <!-- Header -->
        <div class="bg-primary text-white font-semibold px-4 py-3 rounded-10 flex justify-between items-center cursor-pointer"
            @click="open = !open">
            <span>Search Box</span>
            <button type="button" class="text-white text-xl font-bold focus:outline-none"
                x-text="open ? '-' : '+'"></button>
        </div>

        <!-- Collapsible Body -->
        <div class="bg-white dark:bg-bg3 border border-gray-200 rounded-10 shadow-md overflow-hidden transition-all duration-500"
            x-show="open"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="max-h-0 opacity-0"
            x-transition:enter-end="max-h-screen opacity-100"
            x-transition:leave="transition ease-in duration-500"
            x-transition:leave-start="max-h-screen opacity-100"
            x-transition:leave-end="max-h-0 opacity-0">

            <!-- Search Form -->
            <form class="grid grid-cols-2 gap-6 p-6">
                <!-- Field 1 -->
                <div>
                    <label class="md:text-lg font-medium block mb-2">
                        Scheme Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="scheme_name"
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-xl px-4 py-3"
                        placeholder="Enter Scheme Name">
                </div>

                <!-- Field 2 -->
                <div>
                    <label class="md:text-lg font-medium block mb-2">
                        Scheme Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="scheme_code"
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-xl px-4 py-3"
                        placeholder="Enter Scheme Code">
                </div>
            </form>


            <!-- Buttons -->
            <div class="flex justify-center gap-4 pb-6">
                <button class="btn-primary px-6 py-2 rounded-full" type="submit">
                    Save Scheme
                </button>
                <button class="btn-outline px-6 py-2 rounded-full " type="reset">
                    Cancel
                </button>
            </div>
        </div>
    </div> --}}



    <!-- Table -->
    <div class="col-span-12 box lg:col-span-6">
        <div class="pb-4 overflow-x-auto lg:pb-6">
             {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success text-primary">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="alert alert-danger text-error">
            {{ session('error') }}
        </div>
    @endif
            <table class="w-full border border-n30 rounded-lg overflow-hidden">
                <!-- <table class="w-full whitespace-nowrap border border-n30 rounded-lg overflow-hidden"> -->
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3 text-sm font-semibold">
                        <th class="px-6 py-3 text-start">SCHEME CODE</th>
                        <th class="px-6 py-3 text-start">SCHEME NAME</th>
                        <th class="px-6 py-3 text-start">MIN. AMOUNT</th>
                        <th class="px-6 py-3 text-start">TENURE</th>
                        <th class="px-6 py-3 text-start">DEPOSIT FREQ.</th>
                        <th class="px-6 py-3 text-start">INT. RATE (%)</th>
                        <th class="px-6 py-3 text-start">COMPOUNDING</th>
                        <th class="px-6 py-3 text-start">ACTIVE</th>
                        <th class="px-6 py-3 text-start">ACTION</th>
                    </tr>
                </thead>
              <tbody>
    @foreach($schemes as $scheme)
    <tr class="border-t text-start">
        <td class="px-6 py-4 uppercase">{{ $scheme->scheme_code }}</td>
        <td class="px-6 py-4">{{ $scheme->scheme_name }}</td>
        <td class="px-6 py-4">{{ $scheme->min_rd_dd_amount }}</td>
        <td class="px-6 py-4">{{ $scheme->tenure_of_rd_dd_value }} {{ $scheme->tenure_of_rd_dd_type }}</td>
        <td class="px-6 py-4">{{ ucfirst($scheme->rd_dd_frequency) }}</td>
        <td class="px-6 py-4">{{ $scheme->anuual_interest_rate }}%</td>
        <td class="px-6 py-4">{{ ucfirst($scheme->interest_compounding_interval) }}</td>
        <td class="px-6 py-4 text-center">
            @if($scheme->active === 'yes')
                <span class="px-3 py-1 text-xs font-semibold text-white bg-green-500 rounded-full">Yes</span>
            @else
                <span class="px-3 py-1 text-xs font-semibold text-white bg-red-500 rounded-full">No</span>
            @endif
        </td>
        <td class="px-6 py-2">
            <div class="flex justify-center">
                <div class="relative">
                    <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                    <ul class="horiz-option popover-content">
                        <li><a href="{{ route('rdschemes.show', $scheme->id) }}" class="single-option">View</a></li>
                        <li><a href="{{ route('rdschemes.edit', $scheme->id) }}" class="single-option">Edit</a></li>
                    </ul>
                </div>
            </div>
        </td>
    </tr>
    @endforeach
              </tbody>
            </table>

            <!-- pagination -->
           

        </div>
    </div>
</div>
@endsection