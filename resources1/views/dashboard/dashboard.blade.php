@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Dashboard</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            <!-- Statistics -->
            <div class="box col-span-12 bg-n0 dark:bg-bg4 min-[650px]:col-span-6 xxxl:col-span-3">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 lg:mb-6 lg:pb-6">
                    <span class="font-medium">Total Income</span>
                    @include('partials._horizontal-options')
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="h4 mb-4">$8500 USD</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-primary">
                            <i class="las la-arrow-up text-lg"></i> 35.7 AVG
                        </span>
                    </div>
                    <div
                        class="-my-3 shrink-0 ltr:translate-x-3 xl:ltr:translate-x-7 xxxl:ltr:translate-x-2 4xl:ltr:translate-x-9 rtl:-translate-x-3 xl:rtl:-translate-x-7 xxxl:rtl:-translate-x-2 4xl:rtl:-translate-x-9">
                        <div class="progress-chart"></div>
                    </div>
                </div>
            </div>
            <div class="box col-span-12 bg-n0 dark:bg-bg4 min-[650px]:col-span-6 xxxl:col-span-3">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 lg:mb-6 lg:pb-6">
                    <span class="font-medium">Total Spending</span>
                    @include('partials._horizontal-options')

                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="h4 mb-4">$2540 USD</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-primary">
                            <i class="las la-arrow-up text-lg"></i> 35.7 AVG
                        </span>
                    </div>
                    <div
                        class="-my-3 shrink-0 ltr:translate-x-3 xl:ltr:translate-x-7 xxxl:ltr:translate-x-2 4xl:ltr:translate-x-9 rtl:-translate-x-3 xl:rtl:-translate-x-7 xxxl:rtl:-translate-x-2 4xl:rtl:-translate-x-9">
                        <div class="progress-chart"></div>
                    </div>
                </div>
            </div>
            <div class="box col-span-12 bg-n0 dark:bg-bg4 min-[650px]:col-span-6 xxxl:col-span-3">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 lg:mb-6 lg:pb-6">
                    <span class="font-medium">Spending Goal</span>
                    @include('partials._horizontal-options')

                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="h4 mb-4">$1250 USD</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-primary">
                            <i class="las la-arrow-up text-lg"></i> 35.7 AVG
                        </span>
                    </div>
                    <div
                        class="-my-3 shrink-0 ltr:translate-x-3 xl:ltr:translate-x-7 xxxl:ltr:translate-x-2 4xl:ltr:translate-x-9 rtl:-translate-x-3 xl:rtl:-translate-x-7 xxxl:rtl:-translate-x-2 4xl:rtl:-translate-x-9">
                        <div class="progress-chart"></div>
                    </div>
                </div>
            </div>
            <div class="box col-span-12 bg-n0 dark:bg-bg4 min-[650px]:col-span-6 xxxl:col-span-3">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 lg:mb-6 lg:pb-6">
                    <span class="font-medium">Total Transactions</span>
                    @include('partials._horizontal-options')

                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="h4 mb-4">$9000 USD</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-primary">
                            <i class="las la-arrow-up text-lg"></i> 35.7 AVG
                        </span>
                    </div>
                    <div
                        class="-my-3 shrink-0 ltr:translate-x-3 xl:ltr:translate-x-7 xxxl:ltr:translate-x-2 4xl:ltr:translate-x-9 rtl:-translate-x-3 xl:rtl:-translate-x-7 xxxl:rtl:-translate-x-2 4xl:rtl:-translate-x-9">
                        <div class="progress-chart"></div>
                    </div>
                </div>
            </div>
            <!-- Assetchart -->
            <div class="box col-span-12 overflow-x-hidden">
                <div class="bb-dashed mb-4 flex flex-wrap items-center justify-between gap-3 pb-4">
                    <h4 class="h4">Your Assets</h4>
                    <div class="rounded-lg border border-n30 bg-primary/5 dark:border-n500">
                        <button id="one_month"
                            class="asset-btn px-4 py-2 text-xs font-medium first:rounded-s-lg last:rounded-e-lg">
                            1M
                        </button>
                        <button id="six_months"
                            class="asset-btn px-4 py-2 text-xs font-medium first:rounded-s-lg last:rounded-e-lg">
                            6M
                        </button>
                        <button id="one_year"
                            class="asset-btn active px-4 py-2 text-xs font-medium first:rounded-s-lg last:rounded-e-lg">
                            1Y
                        </button>
                        <button id="ytd"
                            class="asset-btn px-4 py-2 text-xs font-medium first:rounded-s-lg last:rounded-e-lg">
                            YTD
                        </button>
                        <button id="all"
                            class="asset-btn px-4 py-2 text-xs font-medium first:rounded-s-lg last:rounded-e-lg">
                            all
                        </button>
                    </div>
                </div>
                <div id="asset-chart"></div>
            </div>
            <!-- Latest Transactions -->
            <div class="box col-span-12 lg:col-span-6">
                <div class="bb-dashed mb-4 flex flex-wrap items-center justify-between gap-4 pb-4 lg:mb-6 lg:pb-6">
                    <h4 class="h4">Latest Transaction</h4>
                   @include('partials._horizontal-options')

                </div>
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-secondary/5 dark:bg-bg3">
                                <th class="flex min-w-[300px] cursor-pointer items-center gap-1 px-6 py-5 text-start">
                                    Title
                                </th>
                                <th class="min-w-[120px] cursor-pointer px-6 py-5 text-start">
                                    <div class="flex items-center gap-1">Medium</div>
                                </th>
                                <th class="min-w-[120px] cursor-pointer px-6 py-5 text-start">
                                    <div class="flex items-center gap-1">Amount</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Transactions Data -->
                            <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">Hooli INV-79820</p>
                                            <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">Paypal</td>
                                <td class="px-6 py-2">$1,121,212</td>
                            </tr>
                            <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">Initech INV-24792</p>
                                            <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">Paypal</td>
                                <td class="px-6 py-2">$8,921,212</td>
                            </tr>
                            <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">
                                                Bluth Company INV-84732
                                            </p>
                                            <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">Paypal</td>
                                <td class="px-6 py-2">$2,141,212</td>
                            </tr>
                            <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">Salaries</p>
                                            <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">Paypal</td>
                                <td class="px-6 py-2">$2,521,212</td>
                            </tr>
                            <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/visa.png') }}" width="32" height="32" class="rounded-full"
                                            alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">
                                                Massive Dynamic INV-90874
                                            </p>
                                            <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">Visa</td>
                                <td class="px-6 py-2">$554,100</td>
                            </tr>
                            <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/payoneer.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">
                                                Jack Collingwood Card reload
                                            </p>
                                            <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">Payoneer</td>
                                <td class="px-6 py-2">$1,420,012</td>
                            </tr>
                            <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/payoneer.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">
                                                DOGE Yearly Return Invest.
                                            </p>
                                            <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">Payoneer</td>
                                <td class="px-6 py-2">$782,332</td>
                            </tr>
                            <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">
                                                Globex Corporation INV-24398
                                            </p>
                                            <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">Paypal</td>
                                <td class="px-6 py-2">$8,521,212</td>
                            </tr>
                            <!-- Add more rows for the remaining data items -->
                        </tbody>
                    </table>
                </div>
                <a class="group mt-6 inline-flex items-center gap-1 font-semibold text-primary" href="#">
                    See More
                    <i class="las la-arrow-right duration-300 group-hover:pl-2"></i>
                </a>
            </div>
            <!-- Transaction account -->
            <div class="box col-span-12 lg:col-span-6">
                <div class="bb-dashed mb-4 flex flex-wrap items-center justify-between gap-4 pb-4 lg:mb-6 lg:pb-6">
                    <h4 class="h4">Transaction Account</h4>
                   @include('partials._horizontal-options')

                </div>
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-secondary/5 dark:bg-bg3">
                                <th class="min-w-[280px] cursor-pointer px-6 py-5 text-start">
                                    <div class="flex items-center gap-1">Title</div>
                                </th>
                                <th class="w-[20%] cursor-pointer px-6 py-5 text-start">
                                    <div class="flex items-center gap-1">Amount</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Transactions Data -->
                            <tr key="John Snow - Metal" class="even:bg-secondary/5 dark:even:bg-bg3">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/card-sm-1.png') }}" width="60" height="40" class="rounded"
                                            alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">John Snow - Metal</p>
                                            <span class="text-xs">**4291 - Exp: 12/26</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">
                                    <div>
                                        <p class="font-medium">$95,200.00</p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                            </tr>
                            <tr key="John Snow - Virtual" class="even:bg-secondary/5 dark:even:bg-bg3">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/card-sm-2.png') }}" width="60" height="40" class="rounded"
                                            alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">John Snow - Virtual</p>
                                            <span class="text-xs">**4291 - Exp: 12/26</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">
                                    <div>
                                        <p class="font-medium">€54,448.54</p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                            </tr>
                            <tr key="Ben Abramov - Metal" class="even:bg-secondary/5 dark:even:bg-bg3">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/card-sm-3.png') }}" width="60" height="40" class="rounded"
                                            alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">Ben Abramov - Metal</p>
                                            <span class="text-xs">**4291 - Exp: 12/26</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">
                                    <div>
                                        <p class="font-medium">£74,215.32</p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                            </tr>
                            <tr key="John Cina - Virtual" class="even:bg-secondary/5 dark:even:bg-bg3">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/card-sm-8.png') }}" width="60" height="40" class="rounded"
                                            alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">John Cina - Virtual</p>
                                            <span class="text-xs">**4291 - Exp: 12/26</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">
                                    <div>
                                        <p class="font-medium">د.ك 67,511.21</p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                            </tr>
                            <tr key="Kane Methew - Metal" class="even:bg-secondary/5 dark:even:bg-bg3">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/card-sm-4.png') }}" width="60" height="40" class="rounded"
                                            alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">Kane Methew - Metal</p>
                                            <span class="text-xs">**4291 - Exp: 12/26</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">
                                    <div>
                                        <p class="font-medium">¥36,122,54</p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                            </tr>
                            <tr key="Jane Alam - Virtual" class="even:bg-secondary/5 dark:even:bg-bg3">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/card-sm-5.png') }}" width="60" height="40" class="rounded"
                                            alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">Jane Alam - Virtual</p>
                                            <span class="text-xs">**4291 - Exp: 12/26</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">
                                    <div>
                                        <p class="font-medium">₹75,121,36</p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                            </tr>
                            <tr key="Jabed Miah - Metal" class="even:bg-secondary/5 dark:even:bg-bg3">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/card-sm-6.png') }}" width="60" height="40" class="rounded"
                                            alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">Jabed Miah - Metal</p>
                                            <span class="text-xs">**4291 - Exp: 12/26</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">
                                    <div>
                                        <p class="font-medium">₽88,125.00</p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                            </tr>
                            <tr key="Bablu Sheikh - Virtual" class="even:bg-secondary/5 dark:even:bg-bg3">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/card-sm-7.png') }}" width="60" height="40" class="rounded"
                                            alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">Bablu Sheikh - Virtual</p>
                                            <span class="text-xs">**4291 - Exp: 12/26</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">
                                    <div>
                                        <p class="font-medium">¢96,214.03</p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a class="group mt-6 inline-flex items-center gap-1 font-semibold text-primary" href="#">
                    See More
                    <i class="las la-arrow-right duration-300 group-hover:pl-2"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
