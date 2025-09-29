@extends('layout.main')
@section('content')

<style>
    input[type="checkbox"] {
        width: 28px;
        height: 28px;
        accent-color: green;
        /* For modern browsers */
    }

    /* Fallback for browsers without accent-color support */
    input[type="checkbox"]:checked {
        background-color: green;
        border: none;
    }

    input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: green;
        /* Modern browser support */
    }

    .tableWidth {
        width: 90%;
        margin: auto;
    }

    .bg-yellow {
        background-color: #e17100;
    }

    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    /* Container for the toggle background */
    .blocks {
        width: 56px;
        /* 14 * 4px */
        height: 32px;
        /* 8 * 4px */
        border-radius: 9999px;
        /* Fully rounded */
        background-color: #9CA3AF;
        /* Tailwind gray-400 default */
        transition: background-color 0.3s ease;
    }

    /* The small white dot */
    .dot {
        position: absolute;
        top: 4px;
        /* 1 * 4px */
        left: 4px;
        /* 1 * 4px */
        width: 24px;
        /* 6 * 4px */
        height: 24px;
        /* 6 * 4px */
        background-color: white;
        border-radius: 9999px;
        transition: transform 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
    }

    /* When the checkbox is checked, change bg color */
    input[type="checkbox"].slider-toggle:checked+div .blocks {
        background-color: #228cc5;
        /* Tailwind green-500 */
    }

    /* Move the dot to right when checked */
    input[type="checkbox"].slider-toggle:checked+div .dot {
        transform: translateX(24px);
        /* 6 * 4px */
    }
</style>

<div class="main-inner">

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-2xl font-semibold">RD - {{ $rdAccount->id }}</h1>
            <p class="text-gray-500">
                <a href="#" class="text-gray-500">Recurring Deposits</a> >
                <a href="#" class="text-gray-500"> {{ $rdAccount->id }}</a>
            </p>
        </div>
    </div>
    <!-- Menu Buttons -->
    <div class="flex flex-wrap gap-2">

        <a href="{{ route('installment.plan', $rdAccount->id) }}" class="btn-warning px-2 py-2 rounded-10">
            INSTALLMENT PLAN
        </a>

        <a href="{{ route('view.viewTransaction', $rdAccount->id) }}" class="btn-secondary px-2 py-2 rounded-10">
            VIEW TRANSACTIONS
        </a>

        @if($rdAccount->approve_status == 'Approved')
        <a href="{{route('rd-accounts.deposit.form',$rdAccount->id)}}" class="btn-primary px-2 py-2 rounded-10">
            DEPOSIT MONEY
        </a>
        @endif

        @if($rdAccount->approve_status == 'Approved')
        <a class="btn-error px-2 py-2 rounded-10">
            WITHDRAW MONEY
        </a>
        @endif

        <div x-data="{ open: false }" class="relative inline-block">

            <a @click="open = !open"
                class="btn-primary px-2 py-2 rounded-10 flex items-center justify-between space-x-2">
                <span>ACCOUNT DETAILS</span>
                <svg class="w-2 h-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </a>

            <!-- Dropdown -->
            <div x-show="open" @click.outside="open = false"
                class="absolute mt-2 w-48 bg-white border border-gray-300 rounded-lg shadow-lg z-50">
                <ul class="py-2">
                    <li>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">REMOVE ACCOUNT</a>
                    </li>

                </ul>
            </div>
        </div>

        <div x-data="{ open: false }" class="relative inline-block">

            <a @click="open = !open"
                class="btn-secondary px-2 py-2 rounded-10 flex items-center justify-between space-x-2">
                <i class="las la-print text-lg"></i><span>PRINT DOCUMENTS</span>
                <svg class="w-2 h-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </a>

            <!-- Dropdown -->
            <div x-show="open" @click.outside="open = false"
                class="absolute mt-2 w-48 bg-white border border-gray-300 rounded-lg shadow-lg z-50">
                <ul class="py-2">
                    <li>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="las la-print"></i>
                            ACCOUNT OPENING FORM</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="las la-print"></i>
                            CLOSING FORM</a>
                    </li>

                </ul>
            </div>
        </div>

        @if($rdAccount->approve_status == 'Approved')
        <a class="btn-warning px-2 py-2 rounded-10">
            CREDIT /REVERSE INTEREST
        </a>
        @endif

        <div x-data="{ open: false }" class="relative inline-block">
            <!-- Button -->
            <a @click="open = !open"
                class="btn-secondary px-2 py-2 rounded-10 flex items-center justify-between space-x-2">
                <span>DEBIT OTHER CHARGES</span>
                <svg class="w-2 h-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </a>

            <!-- Dropdown -->
            <div x-show="open" @click.outside="open = false"
                class="absolute mt-2 w-48 bg-white border border-gray-300 rounded-lg shadow-lg z-50">
                <ul class="py-2">
                    <li>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">OTHER DEBIT LIST</a>
                        @if($rdAccount->approve_status == 'Approved')
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 ">DEBIT OTHER CHARGES</a>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 ">CLEAR DUES </a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>

        @if($rdAccount->approve_status == 'Approved')
        <a class="btn-warning px-2 py-2 rounded-10">
            LINK SAVINF ACCOUNT (AUTO DEBIT )
        </a>
        @endif

        @if($rdAccount->approve_status == 'Approved')
        <a class="btn-error px-2 py-2 rounded-10">
            MAKE LIEN AGAINST LOAN
        </a>
        @endif
        <!-- 
        @if($rdAccount->approve_status !== 'Approved')
        <a class="btn-primary px-2 py-2 rounded-10">
            CHANGE STATUS TO ACTIVE
        </a>
        @endif -->



        <a class="btn-secondary px-2 py-2 rounded-10">
            SHOW AUDIT TRAIL
        </a>


    </div>
    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">

        <!-- Left: Details -->
        <div class="w-full overflow-hidden">
            <div class="overflow-x-auto border  rounded-lg dark:bg-bg3 bg-white shadow-md ">
                <table class="min-w-full whitespace-nowrap text-sm text-left ">
                    <tbody class="divide-y divide-gray-200">
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 w-1/3">Status</td>
                            <td class="px-4 py-2">
                                @if (strtolower($rdAccount->approve_status ?? '') === 'approved')
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                    ACTIVE
                                </span>
                                @elseif (strtolower($rdAccount->approve_status ?? '') === 'pending')
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16">
                                    PENDING
                                </span>
                                @else
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-error/10 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                    REJECTED
                                </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Member</td>
                            <td class="px-4 py-2">
                                {{ $rdAccount->member->id ?? 'N/A' }} -
                                {{ $rdAccount->member->member_info_first_name ?? '' }}
                                {{ $rdAccount->member->member_info_last_name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Created on</td>
                            <td class="px-4 py-2">-</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Created by</td>
                            <td class="px-4 py-2">-</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">RD No.</td>
                            <td class="px-4 py-2">{{ $rdAccount->id }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Old RD No.</td>
                            <td class="px-4 py-2">—</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Scheme</td>
                            <td class="px-4 py-2">{{$rdAccount->rdScheme->scheme_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Open Date</td>
                            <td class="px-4 py-2"> {{ $rdAccount->open_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $rdAccount->open_date)->format('d-m-Y') : '' }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Deposit Frequency</td>
                            <td class="px-4 py-2">{{ $rdAccount->rdScheme->rd_dd_frequency ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Installment Amount</td>
                            <td class="px-4 py-2">₹ {{ number_format($rdAccount->rd_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Installment Amount Received (C)</td>
                            <td class="px-4 py-2">₹ -</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Penalty / Other Charges Received</td>
                            <td class="px-4 py-2">₹ -</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Interest Credited (D)</td>
                            <td class="px-4 py-2">₹ -</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">TDS Deducted (E)</td>
                            <td class="px-4 py-2">₹ -</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Balance Available (C + D - E)</td>
                            <td class="px-4 py-2">₹ -</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Principal Amount Due (A)</td>
                            <td class="px-4 py-2">₹-</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Penalty / Other Charges Due (B)</td>
                            <td class="px-4 py-2">₹ -</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Total Amount Due (A + B)</td>
                            <td class="px-4 py-2">₹ -</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Maturity Date</td>
                            <td class="px-4 py-2">{{ optional($calc['maturity_date'])->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Close Date</td>
                            <td class="px-4 py-2">-</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Maturity Amount (approx.)</td>
                            <td class="px-4 py-2">₹ {{ number_format($calc['maturity_amount'], 2) }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Maturity Bonus Amount</td>
                            <td class="px-4 py-2">₹ -</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Annual Interest Rate (%)</td>
                            <td class="px-4 py-2">{{ $rdAccount->rdScheme->anuual_interest_rate ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Interest Compounding Interval</td>
                            <td class="px-4 py-2">{{ $rdAccount->rdScheme->interest_compounding_interval ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">TDS Deduction</td>
                            <td class="px-4 py-2">
                                @if($rdAccount->tds === 'yes')
                                <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                    Yes
                                </span>
                                @else
                                <span class="block w-28 rounded-[30px] border border-n30 bg-error/10 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                    No
                                </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Special Account</td>
                            <td class="px-4 py-2">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <!--MEMBER DETAILS-->
            <div class="bg-white shadow-md mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="border-b px-4 py-3 bg-red-100">
                    <h3 class="text-lg font-semibold text-black">MEMBER DETAILS</h3>
                </div>

                <!-- Body -->
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <tbody class="divide-y divide-gray-200">

                            <tr>
                                <td class="font-semibold px-4 py-2">Member Name</td>
                                <td class="px-4 py-2">
                                    {{ $rdAccount->member->member_info_first_name ?? '' }}
                                    {{ $rdAccount->member->member_info_last_name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Mobile No</td>
                                <td class="px-4 py-2">{{ $rdAccount->member->member_info_mobile_no ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Address</td>
                                <td class="px-4 py-2">
                                    @if($rdAccount->member && $rdAccount->member->address)
                                    {!! implode(', ', array_filter([
                                    $rdAccount->member->address->member_address_line_1,
                                    $rdAccount->member->address->member_address_line_2,
                                    $rdAccount->member->address->member_address_para,
                                    $rdAccount->member->address->member_address_ward,
                                    $rdAccount->member->address->member_address_panchayat,
                                    $rdAccount->member->address->member_address_area,
                                    $rdAccount->member->address->member_address_landmark,
                                    $rdAccount->member->address->member_address_city_district,
                                    $rdAccount->member->address->member_address_state,
                                    $rdAccount->member->address->member_address_pincode,
                                    $rdAccount->member->address->member_address_country,
                                    $rdAccount->member->address->member_address_address,
                                    $rdAccount->member->address->member_perm_address_city,
                                    $rdAccount->member->address->member_perm_address_state,
                                    $rdAccount->member->address->member_perm_address_pincode
                                    ])) !!}
                                    @else
                                    N/A
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            @if($rdAccount->approve_status == 'Pending')
            <div class="p-4 bg-white dark:bg-bg3 rounded-md shadow-md border mt-4 border-gray-200">

                <table class="w-full  whitespace-nowrap text-sm text-gray-700 rounded-b-md">
                    <thead>
                        <tr class="border-b border-gray-200 text-start">
                            <th class="px-3  text-start py-2">Status</th>
                            <th class="px-3  text-start   py-2">Remark</th>
                            <th class="px-3  text-start  py-2">Updated at</th>
                            <th class="px-3  text-start  py-2">Approved By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-start">
                            <td class="px-3 py-2">@if($rdAccount->approve_status == 'Pending') Pending for approvel @endif</td>
                            <td class="px-3 py-2">{{$rdAccount->remark ?? ""}}</td>
                            <td class="px-3 py-2">aprovel on date </td>
                            <td class="px-3 py-2">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif

            <div class="bg-white shadow-md mt-5 rounded-lg dark:bg-bg3 overflow-hidden">
                <!-- Header -->
                <div class="border-b px-4 py-3 flex items-center gap-4 justify-between bg-red-100">
                    <h3 class="text-lg font-semibold uppercase text-black">ALLOCATED PASSBOOK</h3>
                    <button class="btn-primary px-3 py-2 rounded-3xl text-white">
                        <i class="las la-plus"></i>
                        passbok
                    </button>
                </div>
            </div>


            <!--documents-->
            <div class="box bg-white dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between bg-primary text-white  rounded-t-lg px-4 py-3 cursor-pointer">
                    <h3 class="text-lg font-semibold">DOCUMENTS</h3>
                    <div class="flex items-center gap-2">
                        <button class=" bg-white px-3 py-2 rounded-3xl text-primary"><i class="las la-upload"></i></button>
                        <!-- Toggle Button -->
                        <button
                            class="p-1 rounded transition"
                            onclick="toggleSection(this)">
                            <span class="toggle-icon text-lg font-bold">+</span>
                        </button>
                    </div>
                </div>

                <!-- Body -->
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <p class="capitalize">No documents found</p>
                    </div>
                </div>
            </div>

            <!--COMMENTS-->
            <div class="box bg-white dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between bg-secondary/5 text-black px-4 py-3 cursor-pointer">
                    <h3 class="text-lg font-semibold">COMMENTS</h3>
                    <button
                        class="p-1 rounded transition"
                        onclick="toggleSection(this)">
                        <span class="toggle-icon text-lg font-bold">+</span>
                    </button>

                </div>

                <!-- Body -->
                <div class="p-4">
                    <div class="overflow-x-auto text-center mt-5">
                        <p class="capitalize">No comments found</p>
                        <button class="btn-primary px-3 py-2 rounded-3xl text-white">upload</button>
                    </div>
                </div>

            </div>

        </div>


        <!-- Right: Settings -->
        <div class=" w-full ">

            <!-- SETTINGS -->
            <div class="box dark:bg-bg3 border border-gray-200 shadow-md rounded-lg">
                <!-- Header -->
                <div class="px-4 py-3">
                    <h3 class="text-lg border-b font-semibold text-black">SETTINGS</h3>
                </div>

                <!-- Body -->
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <tbody class="divide-y divide-gray-200">

                            <!-- INTERNET BANKING / MOBILE ENABLE -->
                            <tr>
                                <td class="font-semibold text-center align-middle px-4 py-3 w-1/3">INTERNET BANKING / MOBILE ENABLE</td>
                                <td class="px-4 py-3">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="internetToggle" class="sr-only peer slider-toggle" data-label-id="internetLabel">
                                        <div class="relative">
                                            <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all"></div>
                                            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6"></div>
                                        </div>
                                    </label>
                                </td>
                            </tr>

                            <!-- MONEY TRANSFER -->
                            <tr>
                                <td class="font-semibold text-center align-middle px-4 py-3">MONEY TRANSFER</td>
                                <td class="px-4 py-3">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="transferToggle" class="sr-only peer slider-toggle" data-label-id="transferLabel">
                                        <div class="relative">
                                            <div class="blocks w-14 h-8 bg-gray-300 rounded-full peer-checked:bg-green-500 transition-all"></div>
                                            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6"></div>
                                        </div>
                                    </label>
                                </td>
                            </tr>

                            <!-- ACCOUNT LOCKED -->
                            <tr>
                                <td class="font-semibold text-center align-middle px-4 py-3">ACCOUNT LOCKED</td>
                                <td class="px-4 py-3">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="lockedToggle" class="sr-only peer slider-toggle" data-label-id="lockedLabel">
                                        <div class="relative">
                                            <div class="blocks w-14 h-8 bg-gray-300 rounded-full peer-checked:bg-green-500 transition-all"></div>
                                            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6"></div>
                                        </div>
                                    </label>
                                </td>
                            </tr>

                            <!-- SMS -->
                            <tr>
                                <td class="font-semibold text-center align-middle px-4 py-3">SMS</td>
                                <td class="px-4 py-3">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="smsToggle" class="sr-only peer slider-toggle" data-label-id="smsLabel">
                                        <div class="relative">
                                            <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all"></div>
                                            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6"></div>
                                        </div>
                                    </label>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Script -->
            <script>
                // Update labels ON/OFF when toggled
                document.querySelectorAll('.slider-toggle').forEach(toggle => {
                    toggle.addEventListener('change', function() {
                        const label = document.getElementById(this.dataset.labelId);
                        label.textContent = this.checked ? 'ON' : 'OFF';
                    });

                    // Initialize on page load
                    toggle.dispatchEvent(new Event('change'));
                });
            </script>


            <!-- Update Contariner-->
            <div class="bg-white dark:bg-bg3 shadow-md mt-4 rounded-xl border border-gray-200">
                <!--Old Rd No.-->
                <form action="" class="mt-3 p-3">
                    <label for="" class="block ">Old Rd No.</label>
                    <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                        <input type="text" name="" id="" class="block w-full rounded-10 bg-secondary/5 border py-3 dark:text-white"
                            placeholder="Enter Old Rd Number">
                        <input type="button" value="update" class="block  btn-primary">
                    </div>
                </form>


                <!--Member-->
                <form class="mt-2 px-3">
                    <label for="branch" class="block mb-2">Member</label>
                    <div class="flex flex-row items-center gap-3 justify-between">
                        <select name="member_id" id="member_id"
                            class="block w-full rounded-10 bg-secondary/5 border py-3 dark:text-white">
                            <option value="">Select member</option>
                            <option value="1">Vishaka-Pune</option>
                        </select>

                        <button type="submit" class="block btn-primary">Update</button>
                    </div>
                </form>

                <!--Branch-->
                <form class="mt-2 px-3">
                    <label for="branch" class="block mb-2">Branch</label>
                    <div class="flex flex-row items-center gap-3 justify-between">
                        <select name="branch_id" id="branch_id"
                            class="block w-full rounded-10 bg-secondary/5 border py-3 dark:text-white">
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"
                                {{ $rdAccount->branch_id == $branch->id ? 'selected' : '' }}>
                                {{ $branch->branch_name }}
                            </option>
                            @endforeach
                        </select>

                        <button type="submit" class="block btn-primary">Update</button>
                    </div>
                </form>

                <!--Advisor/ Staff-->
                <form action="" class="mt-2 px-3">
                    <label for="" class="block ">Advisor/ Staff</label>
                    <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                        <select class="w-full rounded-10 bg-secondary/5 border  px-3 py-3 
           dark:bg-bg3 dark:text-white">
                            <option>Select option</option>

                            <option>Option 2</option>
                        </select>

                        <input type="button" value="update" class="block  btn-primary">

                    </div>
                </form>

                <!--Advisor/ Staff-->
                <form action="" class="mt-2 px-3">
                    <label for="" class="block ">Collection Advisor/ Staff</label>
                    <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                        <select class="w-full rounded-10 bg-secondary/5 border  px-3 py-3 
           dark:bg-bg3 dark:text-white">
                            <option>Select option</option>

                            <option>Option 2</option>
                        </select>

                        <input type="button" value="update" class="block  btn-primary">

                    </div>
                </form>

                <div class=" px-6 flex py-4 flex-row items-center gap-6">
                    <p class="w-full text-lg  ">Current Chart</p>
                    <a href="#" class="text-primary w-full">none</a>
                </div>

                <!--Commission Chart-->
                <form action="" class="mt-2 px-3 pb-4">
                    <label for="" class="block ">Commission Chart</label>
                    <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                        <select class="w-full rounded-10 bg-secondary/5 border  px-3 py-3
                          dark:bg-bg3 dark:text-white">
                            <option>Select option</option>

                            <option>Option 2</option>
                        </select>

                        <input type="button" value="update" class="block  btn-primary">

                    </div>
                </form>

                        
            </div>


            <!-- AUTO DEBIT SAVING ACCOUNT INFO -->
            <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg mt-4">
                <!-- Header -->
                <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 rounded-t-lg">
                    <h3 class="text-black font-semibold text-lg">AUTO DEBIT SAVING ACCOUNT INFO</h3>

                    <!-- Toggle Button -->
                    <button
                        class="p-1 rounded transition"
                        onclick="toggleSection(this)">
                        <span class="toggle-icon text-lg font-bold">+</span>
                    </button>

                </div>

                <!-- Content (Initially Hidden) -->
                <div class="overflow-x-auto p-4 hidden">
                    <table class="w-full text-sm text-gray-700 rounded-md">
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2 w-1/3">Account No</td>
                                <td class="px-3 py-2">---</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Scheme Name</td>
                                <td class="px-3 py-2">---</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Available Balance</td>
                                <td class="px-3 py-2">--</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-3 py-2">Un-link Saving Account</td>
                                <td class="px-3 py-2">---</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Scheme Info -->
            <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg mt-4">
                <!-- Header -->
                <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 rounded-t-lg">
                    <h3 class="text-black font-semibold text-lg">SCHEME INFO</h3>

                    <!-- Toggle Button -->
                    <button
                        class="p-1 rounded transition"
                        onclick="toggleSection(this)">
                        <span class="toggle-icon text-lg font-bold">+</span>
                    </button>

                </div>

                <!-- Content (Initially Hidden) -->
                <div class="overflow-x-auto p-4 hidden">
                    <table class="w-full text-sm text-gray-700 rounded-md">
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2 w-1/3">Scheme Name</td>
                                <td class="px-3 py-2">{{ $rdAccount->rdScheme->scheme_name ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Scheme Code</td>
                                <td class="px-3 py-2">{{ $rdAccount->rdScheme->scheme_code ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Minimum Locking Period</td>
                                <td class="px-3 py-2">{{ $rdAccount->rdScheme->rd_dd_lock_in_period ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Interest Locking Period</td>
                                <td class="px-3 py-2">{{ $rdAccount->rdScheme->interest_lock_in_period ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Deposit Frequency</td>
                                <td class="px-3 py-2">{{ $rdAccount->rdScheme->rd_dd_frequency ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Annual Interest Rate (%)</td>
                                <td class="px-3 py-2">{{ $rdAccount->rdScheme->anuual_interest_rate ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Interest Compounding Interval</td>
                                <td class="px-3 py-2">{{ $rdAccount->rdScheme->interest_compounding_interval ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Tenure</td>
                                <td class="px-3 py-2">
                                    {{ $rdAccount->rdScheme->tenure_of_rd_dd_value ?? 'N/A' }}
                                    {{ $rdAccount->rdScheme->tenure_of_rd_dd_type ?? '' }}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Cancellation Charges</td>
                                <td class="px-3 py-2">
                                    {{ $rdAccount->rdScheme->cancellation_charges_value ?? 'N/A' }}
                                    {{ $rdAccount->rdScheme->cancellation_charges_type ?? '' }}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Penal Charges</td>
                                <td class="px-3 py-2">
                                    {{ $rdAccount->rdScheme->penalty_charges_value ?? 'N/A' }}
                                    {{ $rdAccount->rdScheme->penalty_charges_type ?? '' }}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Bonus Rate</td>
                                <td class="px-3 py-2">
                                    {{ $rdAccount->rdScheme->bonus_rate_value ?? 'N/A' }}
                                    {{ $rdAccount->rdScheme->bonus_rate_type ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-3 py-2">Minimum Amount</td>
                                <td class="px-3 py-2">₹ {{ number_format($rdAccount->rdScheme->min_rd_dd_amount ?? 0, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>


            <!-- RD Maturity Info -->
            <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg mt-4">
                <!-- Header -->
                <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 rounded-t-lg">
                    <h3 class="text-black font-semibold text-lg">RD MATURITY INFO</h3>

                    <!-- Toggle Button -->
                    <button
                        class="p-1 rounded transition"
                        onclick="toggleSection(this)">
                        <span class="toggle-icon text-lg font-bold">+</span>
                    </button>

                </div>

                <!-- Content (Initially Hidden) -->
                <div class="overflow-x-auto p-4 hidden">
                    <table class="w-full text-sm text-gray-700 rounded-md">
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2 w-1/3">Maturity Date</td>
                                <td class="px-3 py-2">{{ optional($calc['maturity_date'])->format('d-m-Y') }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Principal Amount (A)</td>
                                <td class="px-3 py-2">₹ {{ number_format($calc['principal'], 2) }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Total Interest (B)</td>
                                <td class="px-3 py-2">₹ {{ number_format($calc['total_interest'], 2) }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Bonus Amount (C)</td>
                                <td class="px-3 py-2">₹ {{ number_format($calc['bonus'], 2) }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-3 py-2">Maturity Amount (A + B + C)</td>
                                <td class="px-3 py-2 font-bold text-green-600">
                                    ₹ {{ number_format($calc['maturity_amount'], 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>


                </div>
            </div>

            <!-- NOMINEE INFO -->
            <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg mt-4">
                <!-- Header -->
                <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 rounded-t-lg">
                    <h3 class="text-black font-semibold text-lg">NOMINEE INFO</h3>

                    <!-- Toggle Button -->
                    <button
                        class="p-1 rounded transition"
                        onclick="toggleSection(this)">
                        <span class="toggle-icon text-lg font-bold">+</span>
                    </button>

                </div>
                <div class="overflow-x-auto p-4 hidden">
                    <table class="w-full text-sm text-center  text-gray-700 rounded-b-md">
                        <thead>
                            <tr class="border-b  border-gray-200">
                                <th class="px-3 py-2 w-1/3 text-left font-semibold">Name</th>
                                <th class="px-3 py-2 w-1/3 text-left font-semibold">Relation</th>
                                <th class="px-3 py-2 w-1/3 text-left font-semibold">Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($rdAccount->nominees->isNotEmpty())
                            @foreach($rdAccount->nominees as $nominee)
                            <tr>
                                <td class="px-3 py-2">{{ $nominee->nominee_name ?? '-' }}</td>
                                <td class="px-3 py-2">{{ $nominee->nominee_relation ?? '-' }}</td>
                                <td class="px-3 py-2">{{ $nominee->nominee_address ?? '-' }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td class="px-3 py-2 text-center" colspan="3">No nominees found</td>
                            </tr>
                            @endif
                        </tbody>

                    </table>
                </div>
            </div>

            <!-- Installment Summary Section -->
            <div class="p-4 bg-white dark:bg-bg3 rounded-md shadow-md border mt-4 border-gray-200">

                <table class="w-full text-sm  text-gray-700 rounded-b-md">
                    <thead>
                        <tr class="border-b border-gray-200 text-center">
                            <th class="px-3 py-2">TOTAL INST</th>
                            <th class="px-3 py-2">PAID INST</th>
                            <th class="px-3 py-2">DUE INST</th>
                            <th class="px-3 py-2">OVERDUE INST</th>
                            <th class="px-3 py-2">INST CANCELED</th>
                            <th class="px-3 py-2">TOTAL INST NOT DUE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td class="px-3 py-2">60</td>
                            <td class="px-3 py-2">1</td>
                            <td class="px-3 py-2">0</td>
                            <td class="px-3 py-2">0</td>
                            <td class="px-3 py-2">0</td>
                            <td class="px-3 py-2">59</td>
                        </tr>
                    </tbody>
                </table>

            </div>


            <!-- BANK DETAILS -->
            <div class="bg-white dark:bg-bg3 border border-gray-200 shadow-md mt-4 rounded-lg">
                <!-- Body -->
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm text-left table-fixed">
                        <tbody class="divide-y divide-gray-200">

                            <tr>
                                <td class="px-4 py-3 w-1/2 text-start align-middle">
                                    Branch
                                </td>
                                <td class="px-4 py-3 w-1/2 text-start align-middle">
                                    {{$rdAccount->branch->branch_name ?? 'N/A'}}
                                </td>
                            </tr>

                            <tr>
                                <td class="px-4 py-3 w-1/2 text-start align-middle">
                                    Joint Account
                                </td>
                                <td class="px-4 py-3 w-1/2 text-start align-middle">
                                    @if($rdAccount->account_type === 'joint')
                                    <span
                                        class="block w-15 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                        Yes
                                    </span>
                                    @else
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-error/10 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                        No
                                    </span>
                                    @endif
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="box dark:bg-bg3 border border-gray-200 mt-4 shadow-md rounded-lg">
                <!-- Header -->
                <div class="px-4 py-3 ">
                    <h3 class="text-lg font-semibold text-black dark:text-white">
                        Transactions <span class="text-gray-500 text-sm">(Showing Last 5)</span>
                    </h3>
                </div>

                <!-- Table Body -->
                <div class="p-4">
                    <div class="overflow-x-auto text-center mt-2">
                        <table class="w-full border whitespace-nowrap rounded-lg overflow-hidden shadow-md">
                            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                <tr>
                                    <th class="px-4 py-2 text-sm font-semibold text-start">Date</th>
                                    <th class="px-4 py-2 text-sm font-semibold text-start">Type</th>
                                    <th class="px-4 py-2 text-sm font-semibold text-start">Payment Mode</th>
                                    <th class="px-4 py-2 text-sm font-semibold text-start">Amount</th>
                                    <th class="px-4 py-2 text-sm font-semibold text-start">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-left dark:text-gray-300">
                                @forelse ($rdAccount->rdTransactions as $txn)
                                <tr class="border-b dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="px-4 py-2 text-sm">
                                        {{ \Carbon\Carbon::parse($txn->t_date)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        {{ ucfirst($txn->transaction_type) }}
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        {{ $txn->payment_mode }}
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        ₹ {{ number_format($txn->amount, 2) }}
                                    </td>
                                    <td class="px-4 py-2 text-sm 
                                        {{ $txn->approve_status === 'Approved' ? 'text-green-600' : ($txn->approve_status === 'pending' ? 'text-yellow-600' : 'text-red-600') }} font-medium">
                                        {{ ucfirst($txn->approve_status) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-2 text-center text-sm text-gray-500">
                                        No transactions found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                    <div class="mt-3 flex justify-center">
                        <button class="mt-3 px-4 py-2 btn-primary text-white rounded-3xl">
                            View All
                        </button>
                    </div>
                </div>
            </div>


        </div>
    </div>



    <!-- JS for PDF Download -->
    <script>
        async function downloadPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const pdf = new jsPDF('p', 'pt', 'a4');
            const content = document.getElementById('pdfContent');

            // Use html2canvas manually to render content
            const canvas = await html2canvas(content, {
                scale: 2
            });
            const imgData = canvas.toDataURL('image/png');

            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight = pdf.internal.pageSize.getHeight();
            const imgWidth = pageWidth - 40; // padding
            const imgHeight = (canvas.height * imgWidth) / canvas.width;

            pdf.addImage(imgData, 'PNG', 20, 20, imgWidth, imgHeight);
            pdf.save('Account-Details.pdf');
        }
    </script>


    <!-- collapsed logic + - button-->
    <script>
        function toggleSection(button) {
            const section = button.closest('.box').querySelector('.overflow-x-auto');
            const icon = button.querySelector('.toggle-icon');

            section.classList.toggle('hidden');
            icon.textContent = section.classList.contains('hidden') ? '+' : '−';
        }
    </script>


      @endsection