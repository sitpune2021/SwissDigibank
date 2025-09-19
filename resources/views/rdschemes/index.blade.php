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
    <!-- Table -->
    <div class="col-span-12 box lg:col-span-6">
        <x-searchbox />
        <!-- <div class="pb-4 overflow-x-auto lg:pb-6"> -->
        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
            <x-alert />
        </div>
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
                    <td class="px-6 py-4 uppercase">
                        <a href="{{route('rdschemes.show', $scheme->id)}}" class="text-primary underline hover:text-primary/80">
                            {{ $scheme->scheme_code }}
                        </a>
                    </td>
                    <td class="px-6 py-4">{{ $scheme->scheme_name }}</td>
                    <td class="px-6 py-4">{{ $scheme->min_rd_dd_amount }}</td>
                    <td class="px-6 py-4">{{ $scheme->tenure_of_rd_dd_value }} {{ $scheme->tenure_of_rd_dd_type }}</td>
                    <td class="px-6 py-4">{{ ucfirst($scheme->rd_dd_frequency) }}</td>
                    <td class="px-6 py-4">{{ $scheme->anuual_interest_rate }}%</td>
                    <td class="px-6 py-4">{{ ucfirst($scheme->interest_compounding_interval) }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($scheme->active === 'yes')
                        <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Approved
                        </span>
                        @else
                        <span class="block w-28 rounded-[30px] border border-n30 bg-warning/20 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Pending
                        </span>
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


        <!-- </div> -->
    </div>
</div>
@endsection