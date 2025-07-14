@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Trading Style 02</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            <!-- Statistics -->
            <div class="col-span-12 lg:col-span-6 xxl:col-span-7 xxxl:col-span-6">
                <div class="grid grid-cols-2 gap-4 xxl:gap-6">
                    <div class="col-span-2 sm:col-span-1 lg:col-span-2 xxl:col-span-1 box p-3 md:p-4 xxxl:px-8 xxxl:py-6">
                        <div class="flex items-center justify-between bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                            <div class="flex items-center gap-3">
                                <span class="font-medium">USD</span>
                            </div>
                            @include('partials._horizontal-options')

                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="h4 mb-3">
                                    $72,245.00
                                </h4>
                                <span class="flex items-center gap-1">
                                    <i class="las la-arrow-up text-lg"></i> 21%
                                </span>
                            </div>
                            <div class="trading-stat-chart"></div>
                        </div>
                    </div>
                    <div class="col-span-2 sm:col-span-1 lg:col-span-2 xxl:col-span-1 box p-3 md:p-4 xxxl:px-8 xxxl:py-6">
                        <div class="flex items-center justify-between bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                            <div class="flex items-center gap-3">
                                <span class="font-medium">EUR</span>
                            </div>
                            @include('partials._horizontal-options')

                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="h4 mb-3">
                                    $72,245.00
                                </h4>
                                <span class="flex items-center gap-1">
                                    <i class="las la-arrow-up text-lg"></i> 21%
                                </span>
                            </div>
                            <div class="trading-stat-chart"></div>
                        </div>
                    </div>
                    <div class="col-span-2 sm:col-span-1 lg:col-span-2 xxl:col-span-1 box p-3 md:p-4 xxxl:px-8 xxxl:py-6">
                        <div class="flex items-center justify-between bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                            <div class="flex items-center gap-3">
                                <span class="font-medium">GBP</span>
                            </div>
                            @include('partials._horizontal-options')

                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="h4 mb-3">
                                    $72,245.00
                                </h4>
                                <span class="flex items-center gap-1">
                                    <i class="las la-arrow-up text-lg"></i> 21%
                                </span>
                            </div>
                            <div class="trading-stat-chart"></div>
                        </div>
                    </div>
                    <div class="col-span-2 sm:col-span-1 lg:col-span-2 xxl:col-span-1 box p-3 md:p-4 xxxl:px-8 xxxl:py-6">
                        <div class="flex items-center justify-between bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                            <div class="flex items-center gap-3">
                                <span class="font-medium">JPY</span>
                            </div>
                            @include('partials._horizontal-options')

                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="h4 mb-3">
                                    $72,245.00
                                </h4>
                                <span class="flex items-center gap-1">
                                    <i class="las la-arrow-up text-lg"></i> 21%
                                </span>
                            </div>
                            <div class="trading-stat-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- USD to EUR chart -->
            <div class="col-span-12 lg:col-span-6 xxl:col-span-5 xxxl:col-span-6">
                <div class="col-span-12 md:col-span-7 lg:col-span-8 box overflow-x-hidden">
                    <div class="flex flex-wrap justify-between items-center gap-3 pb-4 lg:pb-6 bb-dashed">
                        <h4 class="h4">USD vs EUR</h4>
                        <div class="flex items-center gap-2">
                            <p class="text-xs sm:text-sm md:text-base">Sort By : </p>
                            <select name="sort" class="nc-select green !rounded-3xl">
                                <option value="day">Last 15 Days</option>
                                <option value="week">Last 1 Month</option>
                                <option value="year">Last 6 Month</option>
                            </select>
                        </div>
                    </div>
                    <div class="usd-vs-eur"></div>
                </div>
            </div>

            <!-- markets overview -->
            <div class="box col-span-12">
                <div class="flex justify-between items-center gap-4 flex-wrap bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                    <h4 class="h4">Markets Overview</h4>
                    <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                        <form
                            class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                            <input type="text" placeholder="Search"
                                class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                            <button
                                class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                                <i class="las la-search text-lg"></i>
                            </button>
                        </form>
                        <div class="flex items-center gap-3 whitespace-nowrap">
                            <span>Sort By : </span>
                            <select name="sort" class="nc-select green !rounded-3xl">
                                <option value="day">Last 15 Days</option>
                                <option value="week">Last 1 Month</option>
                                <option value="year">Last 6 Month</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto mb-4 lg:mb-6">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-secondary/5 dark:bg-bg3">
                                <th class="text-start py-5 px-6 min-w-[200px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Titile
                                    </div>
                                </th>
                                <th class="text-start py-5 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Amount
                                    </div>
                                </th>
                                <th class="text-start py-5 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Charge
                                    </div>
                                </th>
                                <th class="text-start py-5 min-w-[150px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Highlight
                                    </div>
                                </th>
                                <th class="text-start py-5 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Change
                                    </div>
                                </th>
                                <th class="text-start py-5 min-w-[130px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Status
                                    </div>
                                </th>
                                <th class="text-center p-5 ">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-primary/5 duration-300 border-b border-n30 dark:border-n500">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex shrink-0">
                                            <img src="{{ asset('assets/images/euro-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon">
                                            <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32"
                                                class="rounded-full ltr:-ml-3 rtl:-mr-3" alt="payment medium icon">
                                        </div>
                                        <p class="font-medium mb-1">EUR/USD</p>
                                    </div>
                                </td>
                                <td class="py-4">475.22</td>
                                <td class="py-4">11%</td>
                                <td class="py-4">
                                    <div class="trading-stat-chart-table"></div>
                                </td>
                                <td class="py-4">
                                    <span class="text-primary">+3</span>
                                </td>
                                <td class="py-4">
                                    <span
                                        class="block max-w-[100px] text-xs text-center rounded-[30px] dark:border-n500 border border-n30 py-2 bg-primary/10 dark:bg-bg3 text-primary">
                                        Successful
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-primary/5 duration-300 border-b border-n30 dark:border-n500">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex shrink-0">
                                            <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon">
                                            <img src="{{ asset('assets/images/jp-sm.png') }}" width="32" height="32"
                                                class="rounded-full ltr:-ml-3 rtl:-mr-3" alt="payment medium icon">
                                        </div>
                                        <p class="font-medium mb-1">USD/JPY</p>
                                    </div>
                                </td>
                                <td class="py-4">785.22</td>
                                <td class="py-4">21%</td>
                                <td class="py-4">
                                    <div class="trading-stat-chart-table"></div>
                                </td>
                                <td class="py-4">
                                    <span class="text-primary">+25</span>
                                </td>
                                <td class="py-4">
                                    <span
                                        class="block max-w-[100px] text-xs text-center rounded-[30px] dark:border-n500 border border-n30 py-2 bg-error/10 dark:bg-bg3 text-error">
                                        Cancelled
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-primary/5 duration-300 border-b border-n30 dark:border-n500">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex shrink-0">
                                            <img src="{{ asset('assets/images/euro-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon">
                                            <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32"
                                                class="rounded-full ltr:-ml-3 rtl:-mr-3" alt="payment medium icon">
                                        </div>
                                        <p class="font-medium mb-1">EUR/USD</p>
                                    </div>
                                </td>
                                <td class="py-4">255.22</td>
                                <td class="py-4">21%</td>
                                <td class="py-4">
                                    <div class="trading-stat-chart-table"></div>
                                </td>
                                <td class="py-4">
                                    <span class="text-error">-4</span>
                                </td>
                                <td class="py-4">
                                    <span
                                        class="block max-w-[100px] text-xs text-center rounded-[30px] dark:border-n500 border border-n30 py-2 bg-warning/10 dark:bg-bg3 text-warning">
                                        Pending
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-primary/5 duration-300 border-b border-n30 dark:border-n500">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex shrink-0">
                                            <img src="{{ asset('assets/images/uk-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon">
                                            <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32"
                                                class="rounded-full ltr:-ml-3 rtl:-mr-3" alt="payment medium icon">
                                        </div>
                                        <p class="font-medium mb-1">GBP/USD</p>
                                    </div>
                                </td>
                                <td class="py-4">448.22</td>
                                <td class="py-4">21%</td>
                                <td class="py-4">
                                    <div class="trading-stat-chart-table"></div>
                                </td>
                                <td class="py-4">
                                    <span class="text-error">-1</span>
                                </td>
                                <td class="py-4">
                                    <span
                                        class="block max-w-[100px] text-xs text-center rounded-[30px] dark:border-n500 border border-n30 py-2 bg-primary/10 dark:bg-bg3 text-primary">
                                        Successful
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-primary/5 duration-300 border-b border-n30 dark:border-n500">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex shrink-0">
                                            <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon">
                                            <img src="{{ asset('assets/images/rs-sm.png') }}" width="32" height="32"
                                                class="rounded-full ltr:-ml-3 rtl:-mr-3" alt="payment medium icon">
                                        </div>
                                        <p class="font-medium mb-1">USD/RSA</p>
                                    </div>
                                </td>
                                <td class="py-4">456.22</td>
                                <td class="py-4">21%</td>
                                <td class="py-4">
                                    <div class="trading-stat-chart-table"></div>
                                </td>
                                <td class="py-4">
                                    <span class="text-primary">+10</span>
                                </td>
                                <td class="py-4">
                                    <span
                                        class="block max-w-[100px] text-xs text-center rounded-[30px] dark:border-n500 border border-n30 py-2 bg-warning/10 dark:bg-bg3 text-warning">
                                        Pending
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-primary/5 duration-300 border-b border-n30 dark:border-n500">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex shrink-0">
                                            <img src="{{ asset('assets/images/rs-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon">
                                            <img src="{{ asset('assets/images/euro-sm.png') }}" width="32" height="32"
                                                class="rounded-full ltr:-ml-3 rtl:-mr-3" alt="payment medium icon">
                                        </div>
                                        <p class="font-medium mb-1">RSA/EUR</p>
                                    </div>
                                </td>
                                <td class="py-4">365.22</td>
                                <td class="py-4">21%</td>
                                <td class="py-4">
                                    <div class="trading-stat-chart-table"></div>
                                </td>
                                <td class="py-4">
                                    <span class="text-error">-4</span>
                                </td>
                                <td class="py-4">
                                    <span
                                        class="block max-w-[100px] text-xs text-center rounded-[30px] dark:border-n500 border border-n30 py-2 bg-primary/10 dark:bg-bg3 text-primary">
                                        Successful
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-primary/5 duration-300 border-b border-n30 dark:border-n500">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex shrink-0">
                                            <img src="{{ asset('assets/images/euro-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon">
                                            <img src="{{ asset('assets/images/uk-sm.png') }}" width="32" height="32"
                                                class="rounded-full ltr:-ml-3 rtl:-mr-3" alt="payment medium icon">
                                        </div>
                                        <p class="font-medium mb-1">EUR/GBP</p>
                                    </div>
                                </td>
                                <td class="py-4">425.22</td>
                                <td class="py-4">21%</td>
                                <td class="py-4">
                                    <div class="trading-stat-chart-table"></div>
                                </td>
                                <td class="py-4">
                                    <span class="text-error">-5</span>
                                </td>
                                <td class="py-4">
                                    <span
                                        class="block max-w-[100px] text-xs text-center rounded-[30px] dark:border-n500 border border-n30 py-2 bg-error/10 dark:bg-bg3 text-error">
                                        Cancelled
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-primary/5 duration-300 border-b border-n30 dark:border-n500">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex shrink-0">
                                            <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon">
                                            <img src="{{ asset('assets/images/euro-sm.png') }}" width="32" height="32"
                                                class="rounded-full ltr:-ml-3 rtl:-mr-3" alt="payment medium icon">
                                        </div>
                                        <p class="font-medium mb-1">USD/EUR</p>
                                    </div>
                                </td>
                                <td class="py-4">775.22</td>
                                <td class="py-4">21%</td>
                                <td class="py-4">
                                    <div class="trading-stat-chart-table"></div>
                                </td>
                                <td class="py-4">
                                    <span class="text-primary">+18</span>
                                </td>
                                <td class="py-4">
                                    <span
                                        class="block max-w-[100px] text-xs text-center rounded-[30px] dark:border-n500 border border-n30 py-2 bg-primary/10 dark:bg-bg3 text-primary">
                                        Successful
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-primary/5 duration-300 border-b border-n30 dark:border-n500">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex shrink-0">
                                            <img src="{{ asset('assets/images/euro-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon">
                                            <img src="{{ asset('assets/images/rs-sm.png') }}" width="32" height="32"
                                                class="rounded-full ltr:-ml-3 rtl:-mr-3" alt="payment medium icon">
                                        </div>
                                        <p class="font-medium mb-1">EUR/RSA</p>
                                    </div>
                                </td>
                                <td class="py-4">555.22</td>
                                <td class="py-4">21%</td>
                                <td class="py-4">
                                    <div class="trading-stat-chart-table"></div>
                                </td>
                                <td class="py-4">
                                    <span class="text-error">-12</span>
                                </td>
                                <td class="py-4">
                                    <span
                                        class="block max-w-[100px] text-xs text-center rounded-[30px] dark:border-n500 border border-n30 py-2 bg-primary/10 dark:bg-bg3 text-primary">
                                        Successful
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-primary/5 duration-300 border-b border-n30 dark:border-n500">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex shrink-0">
                                            <img src="{{ asset('assets/images/uk-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon">
                                            <img src="{{ asset('assets/images/euro-sm.png') }}" width="32" height="32"
                                                class="rounded-full ltr:-ml-3 rtl:-mr-3" alt="payment medium icon">
                                        </div>
                                        <p class="font-medium mb-1">USD/EUR</p>
                                    </div>
                                </td>
                                <td class="py-4">875.22</td>
                                <td class="py-4">7%</td>
                                <td class="py-4">
                                    <div class="trading-stat-chart-table"></div>
                                </td>
                                <td class="py-4">
                                    <span class="text-primary">+5</span>
                                </td>
                                <td class="py-4">
                                    <span
                                        class="block max-w-[100px] text-xs text-center rounded-[30px] dark:border-n500 border border-n30 py-2 bg-primary/10 dark:bg-bg3 text-primary">
                                        Successful
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-primary/5 duration-300 border-b border-n30 dark:border-n500">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex shrink-0">
                                            <img src="{{ asset('assets/images/euro-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon">
                                            <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32"
                                                class="rounded-full ltr:-ml-3 rtl:-mr-3" alt="payment medium icon">
                                        </div>
                                        <p class="font-medium mb-1">EUR/USD</p>
                                    </div>
                                </td>
                                <td class="py-4">335.22</td>
                                <td class="py-4">11%</td>
                                <td class="py-4">
                                    <div class="trading-stat-chart-table"></div>
                                </td>
                                <td class="py-4">
                                    <span class="text-primary">+3</span>
                                </td>
                                <td class="py-4">
                                    <span
                                        class="block max-w-[100px] text-xs text-center rounded-[30px] dark:border-n500 border border-n30 py-2 bg-primary/10 dark:bg-bg3 text-primary">
                                        Successful
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-primary/5 duration-300 border-b border-n30 dark:border-n500">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex shrink-0">
                                            <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon">
                                            <img src="{{ asset('assets/images/jp-sm.png') }}" width="32" height="32"
                                                class="rounded-full ltr:-ml-3 rtl:-mr-3" alt="payment medium icon">
                                        </div>
                                        <p class="font-medium mb-1">USD/JPY</p>
                                    </div>
                                </td>
                                <td class="py-4">225.22</td>
                                <td class="py-4">21%</td>
                                <td class="py-4">
                                    <div class="trading-stat-chart-table"></div>
                                </td>
                                <td class="py-4">
                                    <span class="text-primary">+25</span>
                                </td>
                                <td class="py-4">
                                    <span
                                        class="block max-w-[100px] text-xs text-center rounded-[30px] dark:border-n500 border border-n30 py-2 bg-error/10 dark:bg-bg3 text-error">
                                        Cancelled
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex col-span-12 gap-4 sm:justify-between justify-center items-center flex-wrap">
                    <p>
                        Showing 1 to 8 of 18 entries
                    </p>

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
                </div>

            </div>
        </div>
    </div>
@endsection
