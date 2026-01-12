@extends('layout.main')

@section('content')
<div class="main-inner">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
        <h4 class="h3 text-lg">RD/ DD SCHEMES</h4>
        <a class="btn-primary flex items-center  uppercase gap-2" href="{{route('rdschemes.create')}}">
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
       <div class=" overflow-x-auto whitespace-nowrap">
         <table class="w-full  border-n30 rounded-lg overflow-x-hidden whitespace-nowrap">
            <!-- <table class="w-full whitespace-nowrap border border-n30 rounded-lg overflow-hidden"> -->
            <thead>
                <tr class="bg-secondary/5 dark:bg-bg3  font-semibold">
                    <th class="px-6 py-3 text-start uppercase">SCHEME CODE</th>
                    <th class="px-6 py-3 text-start uppercase">SCHEME NAME</th>
                    <th class="px-6 py-3 text-start uppercase">MIN. AMOUNT</th>
                    <th class="px-6 py-3 text-start uppercase">TENURE</th>
                    <th class="px-6 py-3 text-start uppercase">DEPOSIT FREQ.</th>
                    <th class="px-6 py-3 text-start uppercase">INT. RATE (%)</th>
                    <th class="px-6 py-3 text-start uppercase">COMPOUNDING</th>
                    <th class="px-6 py-3 text-start uppercase">ACTIVE</th>
                    <th class="px-6 py-3 text-start uppercase">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schemes as $scheme)
                <tr class="border-t text-start">
                    <td class="px-6 py-4 text-start  uppercase">
                        <a href="{{route('rdschemes.show', $scheme->id)}}" class="text-primary underline hover:text-primary/80">
                            {{ $scheme->scheme_code }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-start ">{{ $scheme->scheme_name }}</td>
                    <td class="px-6 py-4 text-start ">{{ $scheme->min_rd_dd_amount }}</td>
                    <td class="px-6 py-4 text-start ">{{ $scheme->tenure_of_rd_dd_value }} {{ $scheme->tenure_of_rd_dd_type }}</td>
                    <td class="px-6 py-4 text-start ">{{ ucfirst($scheme->rd_dd_frequency) }}</td>
                    <td class="px-6 py-4 text-start ">{{ $scheme->anuual_interest_rate }}%</td>
                    <td class="px-6 py-4 text-start ">{{ ucfirst($scheme->interest_compounding_interval) }}</td>
                    <td class="px-6 py-4 text-start  text-center">
                        @if($scheme->active === 'yes')
                        <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Yes
                        </span>
                        @else
                        <span class="block w-28 rounded-[30px] border border-n30 bg-warning/20 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            No
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-2">
                        <div class="flex justify-center">
                            <div class="relative">
                                <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                <ul class="horiz-option popover-content">
                                    <li><a href="{{ route('rdschemes.show', $scheme->id) }}" class="single-option uppercase">View</a></li>
                                    <li><a href="{{ route('rdschemes.edit', $scheme->id) }}" class="single-option uppercase">Edit</a></li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
       </div>

        <!-- pagination -->


        <!-- </div> -->
    </div>
</div>
@endsection