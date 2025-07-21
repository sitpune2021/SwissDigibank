@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <h2 class="h2">Manage Company Profile</h2>
        <!-- <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button> -->
    </div>

    <!-- Latest Transactions -->
    <div class="box col-span-12 lg:col-span-6">
        <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
            <h4 class="h4">Company Profile</h4>
            <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                <form
                    class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                    <input type="text" id="transaction-search" placeholder="Search"
                        class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                    <button
                        class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                        <i class="las la-search text-lg"></i>
                    </button>
                </form>
                <!-- <div class="flex items-center gap-3 whitespace-nowrap">
                        <span>Sort By : </span>
                        <select name="sort" class="nc-select green !rounded-3xl">
                            <option value="day">Last 15 Days</option>
                            <option value="week">Last 1 Month</option>
                            <option value="year">Last 6 Month</option>
                        </select>
                    </div> -->
            </div>
        </div>
        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Sr No
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Company Name
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px]" data-sortable="false">Email</th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Contact
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                City
                            </div>
                        </th>
                        <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center gap-1">
                                State
                            </div>
                        </th>
                        <th class="text-center !py-5" data-sortable="false">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <tr class="even:bg-secondary/5 dark:even:bg-bg3"> -->
                    @php
                    $s=0;
                    @endphp
                    @foreach($companies as $company)
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="py-2">{{$s=$s+1}}</td>
                        <td class="py-2">
                            <div>
                                <p class="font-medium mb-1">{{ $company->company_name }}</p>
                                <!-- <span class="text-xs">{{ \Carbon\Carbon::parse($company->created_at)->format('d M, y h:i A') }}</span> -->
                            </div>
                        </td>
                        <td class="py-2">{{ $company->contact_email }}</td>
                        <td class="py-2">{{ $company->mobile_no }}</td>
                        <td class="py-2">{{ $company->city }}</td>
                        <td class="py-2"> {{  $company->stateData->name ?? ''  }}</td>
                        <td class="py-2">
                            <div class="flex justify-center">
                                <a href="{{ route('company.view', $company->id) }}" class="border-green-500 text-green-500 hover:bg-green-500 hover:text-white rounded-full transition duration-150"><i class="las la-eye"></i></a>
                                <a href="{{ route('company.edit', $company->id) }}" class="border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white rounded-full transition duration-150"><i class="las la-edit"></i></a>
                                <form action="{{ route('company.delete', $company->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="border-red-500 text-red-500 hover:bg-red-500 hover:text-white rounded-full transition duration-150" onclick="return confirm('Are you sure?')"><i class="las la-trash-alt"></i></button>
                                </form>
                            </div>
                        </td>
                        <!-- <td class="py-2">
                            <div class="flex justify-center">
                                @include('partials._horizontal-options-two')
                            </div>
                        </td> -->
                    </tr>
                    @endforeach
                    <!-- </tr> -->
                </tbody>
            </table>
        </div>
        {{-- Pagination Control --}}
        @if ($companies->lastPage() > 1)
        <div class="flex col-span-12 gap-4 sm:justify-between justify-center items-center flex-wrap">
            <ul class="flex gap-2 md:gap-3 flex-wrap md:font-semibold items-center">

                {{-- Previous Page Link --}}
                @if ($companies->onFirstPage())
                <li>
                    <button
                        class="border md:w-10 md:h-10 w-8 h-8 flex items-center justify-center rounded-full text-gray-400 border-gray-300"
                        disabled>
                        <i class="las la-angle-left text-lg"></i>
                    </button>
                </li>
                @else
                <li>
                    <a href="{{ $companies->previousPageUrl() }}"
                        class="hover:bg-primary text-primary rtl:rotate-180 hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                        <i class="las la-angle-left text-lg"></i>
                    </a>
                </li>
                @endif

                {{-- Page Number Links --}}
                @for ($i = 1; $i <= $companies->lastPage(); $i++)
                    @if ($i == $companies->currentPage())
                    <li>
                        <button
                            class="hover:bg-primary text-n0 bg-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                            {{ $i }}
                        </button>
                    </li>
                    @else
                    <li>
                        <a href="{{ $companies->url($i) }}"
                            class="hover:bg-primary text-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                            {{ $i }}
                        </a>
                    </li>
                    @endif
                    @endfor

                    {{-- Next Page Link --}}
                    @if ($companies->hasMorePages())
                    <li>
                        <a href="{{ $companies->nextPageUrl() }}"
                            class="hover:bg-primary text-primary hover:text-n0 rtl:rotate-180 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                            <i class="las la-angle-right text-lg"></i>
                        </a>
                    </li>
                    @else
                    <li>
                        <button
                            class="border md:w-10 md:h-10 w-8 h-8 flex items-center justify-center rounded-full text-gray-400 border-gray-300"
                            disabled>
                            <i class="las la-angle-right text-lg"></i>
                        </button>
                    </li>
                    @endif

            </ul>
        </div>
        @endif

        <!-- <div class="flex col-span-12 gap-4 sm:justify-between justify-center items-center flex-wrap">
            <ul class="flex gap-2 md:gap-3 flex-wrap md:font-semibold items-center">
                <li>
                    <button
                        class="hover:bg-primary text-primary rtl:rotate-180 hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                        <i class="las la-angle-left text-lg"></i>
                    </button>
                </li>
                <li>
                    <button
                        class="hover:bg-primary text-n0 bg-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                        1
                    </button>
                </li>
                <li>
                    <button
                        class="hover:bg-primary text-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                        2
                    </button>
                </li>
                <li>
                    <button
                        class="hover:bg-primary text-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                        3
                    </button>
                </li>
                <li>
                    <button
                        class="hover:bg-primary text-primary hover:text-n0 rtl:rotate-180 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                        <i class="las la-angle-right text-lg"></i>
                    </button>
                </li>
            </ul>
        </div> -->
    </div>
</div>
@endsection