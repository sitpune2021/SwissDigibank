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
            /* 6 * 4px */
        }
    </style>
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-4">
            <div class="flex items-start flex-col gap-2">
                <h1 class="text-lg uppercase font-semibold">Master Settings</h1>

            </div>
        </div>

 @if(session('success'))
            <div class="">
                <div class="w-44 mb-5 flex justify-end">
                    <x-alert />
                </div>
                {{-- {{ session('success') }} --}}
            </div>
        @endif

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">

            <!-- Left: Details -->
            <div class=" w-full  overflow-hidden">
                <div class="box dark:bg-bg3 border-gray-200 shadow-md rounded-lg">
                    <!-- Header -->
                    <div class="px-2 py-3">
                        <h3 class="text-lg border-b font-semibold text-black">SAVING / RD/ DD / FD/ MIS SETTINGS</h3>
                    </div>
                    <div class="p-4 overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <tbody class="divide-y divide-gray-200">

                                <!--  AUTO CREDIT SAVING INTEREST  -->
                                <tr>
                                    <td class="font-semibold text-center align-middle px-4 py-3 w-1/3">
                                        AUTO CREDIT SAVING INTEREST
                                    </td>
                                    <td class="px-4 py-3">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" id="smsToggle" class="sr-only slider-toggle"
                                                data-label-id="smsLabel">
                                            <div class="relative">
                                                <div
                                                    class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                                                </div>
                                                <div
                                                    class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                                                </div>
                                            </div>
                                            <!-- <span id="smsLabel" class="ml-4 text-sm font-medium text-black">OFF</span> -->
                                        </label>
                                    </td>
                                </tr>

                                <!-- AUTO CREDIT RD INTEREST -->
                                <tr>
                                    <td class="font-semibold text-center align-middle px-4 py-3">AUTO CREDIT RD INTEREST
                                    </td>
                                    <td class="px-4 py-3">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" id="tdsToggle" class="sr-only slider-toggle"
                                                data-label-id="tdsLabel">
                                            <div class="relative">
                                                <div
                                                    class="blocks w-14 h-8 bg-gray-300 rounded-full peer-checked:bg-green-500 transition-all">
                                                </div>
                                                <div
                                                    class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                                                </div>
                                            </div>
                                            <!-- <span id="tdsLabel" class="ml-4 text-sm font-medium text-gray-700">OFF</span> -->
                                        </label>
                                    </td>
                                </tr>

                                <!-- AUTO CREDIT DD INTEREST -->
                                <tr>
                                    <td class="font-semibold text-center align-middle px-4 py-3">AUTO CREDIT DD INTEREST
                                    </td>
                                    <td class="px-4 py-3">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" id="holdToggle" class="sr-only slider-toggle"
                                                data-label-id="holdLabel">
                                            <div class="relative">
                                                <div
                                                    class="blocks w-14 h-8 bg-gray-300 rounded-full peer-checked:bg-green-500 transition-all">
                                                </div>
                                                <div
                                                    class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                                                </div>
                                            </div>
                                            <!-- <span id="holdLabel" class="ml-4 text-sm font-medium text-gray-700">OFF</span> -->
                                        </label>
                                    </td>
                                </tr>
                                <!-- CHART BASED FD/ MIS MODULE  -->
                                <tr>
                                    <td class="font-semibold text-center align-middle px-4 py-3">
                                        CHART BASED FD/ MIS MODULE
                                    </td>
                                    <td class="px-4 py-3">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" id="holdToggle" class="sr-only slider-toggle"
                                                data-label-id="holdLabel">
                                            <div class="relative">
                                                <div
                                                    class="blocks w-14 h-8 bg-gray-300 rounded-full peer-checked:bg-green-500 transition-all">
                                                </div>
                                                <div
                                                    class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                                                </div>
                                            </div>
                                            <!-- <span id="holdLabel" class="ml-4 text-sm font-medium text-gray-700">OFF</span> -->
                                        </label>
                                    </td>
                                </tr>
                                <!-- GST CHARGES ENABLED   -->
                                <tr>
                                    <td class="font-semibold text-center align-middle px-4 py-3">
                                        GST CHARGES ENABLED
                                    </td>
                                    <td class="px-4 py-3">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" id="holdToggle" class="sr-only slider-toggle"
                                                data-label-id="holdLabel">
                                            <div class="relative">
                                                <div
                                                    class="blocks w-14 h-8 bg-gray-300 rounded-full peer-checked:bg-green-500 transition-all">
                                                </div>
                                                <div
                                                    class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                                                </div>
                                            </div>
                                            <!-- <span id="holdLabel" class="ml-4 text-sm font-medium text-gray-700">OFF</span> -->
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <!---->
                <div class="box shadow-md mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">

                    <!-- Body -->
                    <div class=" flex justify-end">
                        <a href="{{ route('master-settings.edit') }}" class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    <div class="p-4 overflow-x-auto ">

                        <table class="w-full whitespace-nowrap overflow-x-auto text-sm text-left">
                            <tbody class="divide-y  divide-gray-200">
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 w-1/3 uppercase">Member App Play Store URL</td>
                                    <td class="px-4 py-2">
                                        {{ $setting?->member_playstore_url ?? '' }}
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Member App IOs Store URL</td>
                                    <td class="px-4 py-2">
                                        {{ $setting?->member_ios_url ?? '' }}
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Default Currency</td>
                                    <td class="px-4 py-2">
                                        INR (₹)
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Paid Up Capital</td>
                                    <td class="px-4 py-2">
                                        500,000.00(static)
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Share Nominal Value</td>
                                    <td class="px-4 py-2">
                                        10.00 (static)
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Tax Deduction Limit (TDS)</td>
                                    <td class="px-4 py-2">
                                        {{$setting?->tax_deduction_limit ?? ''}}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Tax Deduction Limit Senior
                                        <br> Citizen (TDS)
                                    </td>
                                    <td class="px-4 py-2">
                                        {{$setting?->tax_deduction_limit_senior ?? ''}}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Enable Fee Collection</td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            @if($setting->membership_fee_enabled == 1)
                                                <span
                                                    class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                    Yes
                                                </span>
                                            @else
                                                <span
                                                    class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                    No
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Membership Fee</td>
                                    <td class="px-4 py-2">
                                        {{$setting?->membership_fee ?? ''}}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Enable Associate
                                        <br> Registration Fee
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            @if($setting->associate_fee_enabled == 1)
                                                <span
                                                    class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                    Yes
                                                </span>
                                            @else
                                                <span
                                                    class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                    No
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Associate Registration Fee</td>
                                    <td class="px-4 py-2">
                                        {{$setting?->associate_fee ?? ''}}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Allocate New Shares
                                        <br> (New Member Registration)
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div> (static)
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Split Promoter Shares
                                        <br>
                                        (New Member Registration)
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                            (static)
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Disable Share Filing

                                        while <br> Allocation/ Transfer
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                            (static)
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Default Shares To Allocate
                                        <br> Every Share Allocation/ Transfer
                                    </td>
                                    <td class="px-4 py-2">
                                        (static)
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Maximum Loan Limit
                                    </td>
                                    <td class="px-4 py-2">
                                        1,500,000.00(static)
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>


                {{-- ATTENDANCE SETTING --}}
                <div class="box shadow-md mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class=" px-4 py-3 flex  gap-2 items-center justify-between  bg-secondary/5 rounded-10">
                        <h3 class="text-lg font-semibold text-black">ATTENDANCE SETTING</h3>

                        <a href="{{ route('master-settings.edit-attendence') }}" class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a>

                    </div>

                    <!-- Body -->

                    <div class="p-4 overflow-x-auto ">

                        <table class="w-full whitespace-nowrap overflow-x-auto text-sm text-left">
                            <tbody class="divide-y  divide-gray-200">
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 w-1/3 uppercase">Full Day Duration </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Half Day Duration </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Mark Half Day After </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Disable In Time </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Disable Out Time </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>


                <!--BANK LIST-->

                <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                        onclick="this.nextElementSibling.classList.toggle('')">
                        <h3 class="text-lg font-semibold uppercase">BANK LIST</h3>
                        <a href="{{ route('master-settings.bank-list') }}" class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    <!-- Body -->
                    <div class="p-4">
                        <div class="overflow-x-auto text-center mt-5">
                            <div class="overflow-x-auto">
                                <table
                                    class="w-full whitespace-nowrap  border-collapse rounded-lg overflow-hidden shadow-md responsive-table">
                                    <thead class="bg-gray-100 text-start text-gray-700">
                                        <tr class="border-b bg-secondary/5">
                                            <th class="px-4 py-2 text-start text-sm font-semibold">SR NO</th>
                                            <th class="px-4 py-2 text-start text-sm font-semibold">BANK NAME</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-b ">
                                            <td class="px-4 py-2 text-start text-sm ">1</td>
                                            <td class="px-4 py-2 text-start text-sm ">SBC GLOBAL DIGITAL BANK</td>
                                        </tr>
                                        <tr class="border-b ">
                                            <td class="px-4 py-2 text-start text-sm ">2</td>
                                            <td class="px-4 py-2 text-start text-sm ">ADCC BANK AKOLA</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <!--BUSINESS TYPE-->
                <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                        onclick="this.nextElementSibling.classList.toggle('')">
                        <h3 class="text-lg font-semibold uppercase">BUSINESS TYPE</h3>
                        <a href="
                            {{-- {{ route('master-settings.edit-bussiness-type') }} --}}
                             " class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    <!-- Body -->
                    <div class="p-4">
                        <div class="overflow-x-auto text-center mt-5">
                            <div class="overflow-x-auto">
                                <table
                                    class="w-full whitespace-nowrap  border-collapse rounded-lg overflow-hidden shadow-md responsive-table">
                                    <thead class="bg-gray-100 text-start text-gray-700">
                                        <tr class="border-b">
                                            <th class="px-4 py-2 text-start text-sm font-semibold">SR NO</th>
                                            <th class="px-4 py-2 text-start text-sm font-semibold"> BUSINESS TYPE</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-b ">
                                            <td class="px-4 py-2 text-start text-sm ">-</td>
                                            <td class="px-4 py-2 text-start text-sm ">-</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <!--NPA Provisioning (%)-->
                <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                        onclick="this.nextElementSibling.classList.toggle('')">
                        <h3 class="text-lg font-semibold uppercase">NPA Provisioning (%)</h3>
                        <a href="{{ route('master-settings.npa-provisioning-settings') }}" class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    <!-- Body -->
                    <div class="p-4">
                        <div class="overflow-x-auto text-center mt-5">
                            <div class="overflow-x-auto">
                                <table
                                    class="w-full whitespace-nowrap  border-collapse rounded-lg overflow-hidden shadow-md responsive-table">
                                    <thead class="bg-gray-100 text-start text-gray-700">
                                        <tr class="border-b bg-secondary/5">
                                            <th class="px-4 py-2 text-start text-sm font-semibold">Asset Category</th>
                                            <th class="px-4 py-2 text-start text-sm font-semibold">
                                                Secured Provisioning (%)
                                            </th>
                                            <th class="px-4 py-2 text-start text-sm font-semibold">
                                                Unsecured Provisioning (%)
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-b ">
                                            <td class="px-4 py-2 text-start text-sm ">Standard Asset</td>
                                            <td class="px-4 py-2 text-start text-sm "></td>
                                            <td class="px-4 py-2 text-start text-sm "></td>
                                        </tr>
                                        <tr class="border-b ">
                                            <td class="px-4 py-2 text-start text-sm ">Sub-Standard Asset</td>
                                            <td class="px-4 py-2 text-start text-sm "></td>
                                            <td class="px-4 py-2 text-start text-sm "></td>
                                        </tr>
                                        <tr class="border-b ">
                                            <td class="px-4 py-2 text-start text-sm ">Doubtful-1 Asset</td>
                                            <td class="px-4 py-2 text-start text-sm "></td>
                                            <td class="px-4 py-2 text-start text-sm "></td>
                                        </tr>
                                        <tr class="border-b ">
                                            <td class="px-4 py-2 text-start text-sm ">Doubtful-2 Asset</td>
                                            <td class="px-4 py-2 text-start text-sm "></td>
                                            <td class="px-4 py-2 text-start text-sm "></td>
                                        </tr>
                                        <tr class="border-b ">
                                            <td class="px-4 py-2 text-start text-sm ">Doubtful-3 Asset</td>
                                            <td class="px-4 py-2 text-start text-sm "></td>
                                            <td class="px-4 py-2 text-start text-sm "></td>
                                        </tr>
                                        <tr class="border-b ">
                                            <td class="px-4 py-2 text-start text-sm ">Loss Asset</td>
                                            <td class="px-4 py-2 text-start text-sm "></td>
                                            <td class="px-4 py-2 text-start text-sm "></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>


                <!--GOLD LOAN SETTINGS-->
                <div class="box shadow-md mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class=" px-4 py-3 flex items-center justify-between bg-secondary/5 rounded-10">
                        <h3 class="text-lg font-semibold text-black">GOLD LOAN SETTINGS</h3>
                        <a href="{{ route('master-settings.edit-goldloan-settings') }}" class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    <!-- Body -->
                    <div class="p-4 overflow-x-auto ">

                        <table class="w-full whitespace-nowrap overflow-x-auto text-sm text-left">
                            <tbody class="divide-y  divide-gray-200">
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 w-1/3 uppercase">Add Collect Adv. Processing fee
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Add Cibil Score Line Item </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Number of CIBIL
                                        <br>
                                        Records Mandatory
                                    </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Reminder SMS </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Penalty Charges </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Overdue Interest (%) </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Documentation Charges </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">EMI Bounce Charges (Cheque) </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        EMI Installment Cancellation
                                        <br>
                                        Charges
                                    </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">No Due Certificate Charges </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">No EMI Interest Slab </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Debit Other Charges
                                        <br>
                                        Directly To Loan Account
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Disburse Setting Active
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Insurance Charges Funded
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Disable Cash Disbursement
                                    </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>

                <!--PERSONAL LOAN SETTINGS-->
                <div class="box shadow-md mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class=" px-4 py-3 flex items-center justify-between bg-secondary/5 rounded-10">
                        <h3 class="text-lg font-semibold text-black">PERSONAL LOAN SETTINGS</h3>
                        <a href="{{ route('master-settings.edit-personal-loan-settings') }}" class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    <!-- Body -->
                    <div class="p-4 overflow-x-auto ">

                        <table class="w-full whitespace-nowrap overflow-x-auto text-sm text-left">
                            <tbody class="divide-y  divide-gray-200">
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 w-1/3 uppercase">Add Charges Per EMI Type </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Add Collect Adv. Processing fee </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Add Cibil Score Line Item </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Number of CIBIL
                                        <br> Records Mandatory
                                    </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Reminder SMS </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Penalty Charges </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Overdue Interest (%) </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Documentation Charges </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">EMI Bounce Charges (Cheque) </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">EMI Installment
                                        <br>
                                        Cancellation Charges
                                    </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">No Due Certificate Charges </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Debit Other Charges
                                        <br>
                                        Directly To Loan Account
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Disburse Setting Active
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Insurance Charges Funded
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Disable Cash Disbursement
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>

                <!--DEPOSIT LOAN SETTINGS-->
                <div class="box shadow-md mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class=" px-4 py-3 flex items-center justify-between bg-secondary/5 rounded-10">
                        <h3 class="text-lg font-semibold text-black">DEPOSIT LOAN SETTINGS</h3>
                        <a href="{{ route('master-settings.edit-deposit-loan') }}" class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    {{-- body --}}
                    <div class="p-4 overflow-x-auto ">

                        <table class="w-full whitespace-nowrap overflow-x-auto text-sm text-left">
                            <tbody class="divide-y  divide-gray-200">
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 w-1/3 uppercase">Add Collect Adv.
                                        <br>
                                        Processing fee
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Add Cibil Score Line Item </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Number of CIBIL
                                        <br>Records Mandatory
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Reminder SMS </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Penalty Charges </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Overdue Interest (%) </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Documentation Charges </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">EMI Bounce Charges (Cheque) </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">EMI Installment
                                        <br> Cancellation Charges
                                    </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">No Due Certificate Charges </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Debit Other Charges Directly
                                        <br />
                                        To Loan Account
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Disburse Setting Active
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Insurance Charges Funded
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Disable Cash Disbursement
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>

                <!--CC LIMIT SETTING-->
                <div class="box shadow-md mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class=" px-4 py-3 flex items-center justify-between bg-secondary/5 rounded-10">
                        <h3 class="text-lg font-semibold text-black">CC LIMIT SETTING</h3>
                        <a href="{{ route('master-settings.edit-cc-limit') }}" class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    {{-- body --}}
                    <div class="p-4 overflow-x-auto ">

                        <table class="w-full whitespace-nowrap overflow-x-auto text-sm text-left">
                            <tbody class="divide-y  divide-gray-200">
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 w-1/3 uppercase">Add Collect Adv.
                                        <br>
                                        Processing fee
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Add Cibil Score Line Item </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Number of CIBIL
                                        <br>Records Mandatory
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Reminder SMS </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Penalty Charges </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Debit Other Charges Directly
                                        <br />
                                        To Account
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right: Settings -->
            <div class=" w-full overflow-hidden ">
                <!--LOAN APPROVAL LEVEL NAME SETTING-->
                <div class="box shadow-md dark:bg-bg3   rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                        onclick="this.nextElementSibling.classList.toggle('')">
                        <h3 class="text-lg font-semibold uppercase">LOAN APPROVAL LEVEL NAME SETTING</h3>
                        <a href="{{ route('master-settings.loan-apr-level-name') }}" class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    <!-- Body -->
                    <div class="p-4">
                        <div class="overflow-x-auto text-center mt-5">
                            <div class="overflow-x-auto">
                                <table
                                    class="w-full whitespace-nowrap  border-collapse rounded-lg overflow-hidden shadow-md responsive-table">
                                    <thead class="bg-gray-100 text-start text-gray-700">
                                        <tr class="border-b bg-secondary/5">
                                            <th class="px-4 py-2 text-start text-sm uppercase font-semibold">Level No</th>
                                            <th class="px-4 py-2 text-start text-sm uppercase font-semibold"> Level Name
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-b ">
                                            <td class="px-4 text-start text-sm py-3 ">
                                                <span
                                                    class="bg-secondary text-white uppercase text-sm py-1 px-3 rounded-10">
                                                    Level 1
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 text-start text-sm ">
                                                LEVEL 1
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- DAILY CASH DEPOSIT / WITHDRAWAL LIMIT --}}
                <div class="box shadow-md dark:bg-bg3 mt-5  rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                        onclick="this.nextElementSibling.classList.toggle('')">
                        <h3 class="text-lg font-semibold uppercase">DAILY CASH DEPOSIT / WITHDRAWAL LIMIT</h3>
                        <a href="{{ route('master-settings.dailycash-deposit') }}" class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    <!-- Body -->
                    <div class="overflow-x-auto mt-5">
                        <table
                            class="w-full whitespace-nowrap border-collapse rounded-lg overflow-x-auto shadow-md bg-white dark:bg-bg3">
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">
                                        Daily Cash Limit Setting Active
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td colspan="2" class="text-center font-semibold px-4 py-2 uppercase">Deposit Accounts
                                        Per Day Cash Limit</td>

                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Cash Deposit Limit Per Member </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        ₹ 0.00(static)
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Cash Withdrawal Limit Per Member
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        ₹ 0.00(static)
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td colspan="2" class="font-semibold text-center px-4 py-2 uppercase">
                                        Loan Accounts Per Day Cash Limit
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Cash Deposit Limit Per Member
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        ₹ 0.00(static)
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Cash Withdrawal Limit Per Member
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        ₹ 0.00(static)
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                {{-- DAILY REMINDER SMS SETTINGS --}}
                <div class="box shadow-md dark:bg-bg3 mt-5  rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                        onclick="this.nextElementSibling.classList.toggle('')">
                        <h3 class="text-lg font-semibold uppercase">DAILY REMINDER SMS SETTINGS</h3>
                        <a href="{{route('master-settings.daily-reminder-setting')}}" class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    <!-- Body -->
                    <div class="overflow-x-auto mt-5">
                        <table
                            class="w-full whitespace-nowrap border-collapse rounded-lg overflow-x-auto shadow-md bg-white dark:bg-bg3">
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">
                                        Loan SMS Reminder Morning Time
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Loan SMS Reminder Evening Time</td>
                                    <td class="px-4 py-2 text-right md:text-left">

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- SAVING SETTING --}}
                <div class="box shadow-md dark:bg-bg3 mt-5  rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                        onclick="this.nextElementSibling.classList.toggle('')">
                        <h3 class="text-lg font-semibold uppercase">SAVING SETTING</h3>
                        {{-- <a href="{{route('master-settings.daily-reminder-setting')}}" class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a> --}}
                    </div>
                    <!-- Body -->
                    <div class="overflow-x-auto mt-5">
                        <table
                            class="w-full whitespace-nowrap border-collapse rounded-lg overflow-x-auto shadow-md bg-white dark:bg-bg3">
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">
                                        Sweep-in Module Active
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Sweep-in Multiplier
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        0.0(static)
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                {{-- DEPOSITS TENURE SETTING --}}
                <div class="box shadow-md dark:bg-bg3 mt-5  rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                        onclick="this.nextElementSibling.classList.toggle('')">
                        <h3 class="text-lg font-semibold uppercase">DEPOSITS TENURE SETTING</h3>
                        {{-- <a href="{{route('master-settings.daily-reminder-setting')}}" class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a> --}}
                    </div>
                    <!-- Body -->
                    <div class="overflow-x-auto mt-5">
                        <table
                            class="w-full whitespace-nowrap border-collapse rounded-lg overflow-x-auto shadow-md bg-white dark:bg-bg3">
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">
                                        Deposits Max Tenure/ Period
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        20 Years
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- RD SETTING --}}
                <div class="box shadow-md dark:bg-bg3 mt-5  rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                        onclick="this.nextElementSibling.classList.toggle('')">
                        <h3 class="text-lg font-semibold uppercase">RD SETTING</h3>
                        <a href="{{route('master-settings.edit-rd-settings')}}" class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    <!-- Body -->
                    <div class="overflow-x-auto mt-5">
                        <table
                            class="w-full whitespace-nowrap border-collapse rounded-lg overflow-x-auto shadow-md bg-white dark:bg-bg3">
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">
                                        Reminder SMS
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Hold Account After
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Mark Installment Canceled
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Maximum Installment Collected
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Penalty Charges
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Penalty Grace Period
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Collection in Multiple
                                        <br>
                                        of Installment Amount
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Debit Other Charges
                                        <br>
                                        Directly To RD Account
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- DD SETTING --}}
                <div class="box shadow-md dark:bg-bg3 mt-5  rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                        onclick="this.nextElementSibling.classList.toggle('')">
                        <h3 class="text-lg font-semibold uppercase">DD SETTING</h3>
                        <a href="{{route('master-settings.edit-dd-settings')}}" class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    <!-- Body -->
                    <div class="overflow-x-auto mt-5">
                        <table
                            class="w-full whitespace-nowrap border-collapse rounded-lg overflow-x-auto shadow-md bg-white dark:bg-bg3">
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">
                                        Reminder SMS
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Hold Account After
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Mark Installment Canceled
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Maximum Installment Collected
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Penalty Charges
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Penalty Grace Period
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Collection in Multiple
                                        <br>
                                        of Installment Amount
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Debit Other Charges
                                        <br>
                                        Directly To RD Account
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <!--BUSINESS LOAN SETTINGS-->
                <div class="box shadow-md mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class=" px-4 py-3 flex items-center justify-between bg-secondary/5 rounded-10">
                        <h3 class="text-lg font-semibold text-black">
                            BUSINESS LOAN SETTINGS
                        </h3>
                        <a href="
                            {{-- {{route('master-settings.edit-bussiness-loan')}} --}}
                            " class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    <!-- Body -->
                    <div class="p-4 overflow-x-auto ">

                        <table class="w-full whitespace-nowrap overflow-x-auto text-sm text-left">
                            <tbody class="divide-y  divide-gray-200">
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 w-1/3 uppercase">
                                        Add Charges Per EMI Type
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Add Collect Adv. Processing fee
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Add Cibil Score Line Item
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Number of CIBIL Records Mandatory
                                    </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Reminder SMS </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Penalty Charges</td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Overdue Interest (%) </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Documentation Charges </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        EMI Bounce Charges (Cheque)
                                    </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">EMI Installment
                                        <br>
                                        Cancellation Charges
                                    </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">No Due Certificate Charges </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Debit Other Charges
                                        <br>
                                        Directly To Loan Account
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Disburse Setting Active
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Insurance Charges Funded
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Disable Cash Disbursement
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>

                <!--PROPERTY LOAN SETTINGS-->
                <div class="box shadow-md mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class=" px-4 py-3 flex items-center justify-between bg-secondary/5 rounded-10">
                        <h3 class="text-lg font-semibold text-black">
                            PROPERTY LOAN SETTINGS
                        </h3>
                        <a href="{{ route('master-settings.edit-property-loan') }}" class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    <!-- Body -->
                    <div class="p-4 overflow-x-auto ">

                        <table class="w-full whitespace-nowrap overflow-x-auto text-sm text-left">
                            <tbody class="divide-y  divide-gray-200">
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 w-1/3 uppercase">
                                        Add Collect Adv. Processing fee
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Add Cibil Score Line Item
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>


                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Number of CIBIL
                                        <br>
                                        Records Mandatory
                                    </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Reminder SMS </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Penalty Charges</td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Overdue Interest (%) </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Documentation Charges </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        EMI Bounce Charges (Cheque)
                                    </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">EMI Installment
                                        <br>
                                        Cancellation Charges
                                    </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">No Due Certificate Charges </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Debit Other Charges
                                        <br>
                                        Directly To Loan Account
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Disburse Setting Active
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Insurance Charges Funded
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Disable Cash Disbursement
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>

                <!--VEHICLE LOAN SETTINGS-->
                <div class="box shadow-md mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class=" px-4 py-3 flex items-center justify-between bg-secondary/5 rounded-10">
                        <h3 class="text-lg font-semibold text-black">
                            VEHICLE LOAN SETTINGS
                        </h3>
                        <a href="{{ route('master-settings.edit-vehicle-settings') }}" class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    <!-- Body -->
                    <div class="p-4 overflow-x-auto ">

                        <table class="w-full whitespace-nowrap overflow-x-auto text-sm text-left">
                            <tbody class="divide-y  divide-gray-200">
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 w-1/3 uppercase">
                                        Add Collect Adv. Processing fee
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Add Cibil Score Line Item
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>


                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Number of CIBIL <br> Records Mandatory
                                    </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Reminder SMS </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Penalty Charges</td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Overdue Interest (%) </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Documentation Charges </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        EMI Bounce Charges (Cheque)
                                    </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">EMI Installment
                                        <br>
                                        Cancellation Charges
                                    </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">No Due Certificate Charges </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Debit Other Charges
                                        <br>
                                        Directly To Loan Account
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Disburse Setting Active
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Insurance Charges Funded
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Disable Cash Disbursement
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>

                <!--DAILY / WEEKLY LOAN SETTINGS-->
                <div class="box shadow-md mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class=" px-4 py-3 flex items-center justify-between bg-secondary/5 rounded-10">
                        <h3 class="text-lg font-semibold text-black">
                            DAILY / WEEKLY LOAN SETTINGS
                        </h3>
                        <a href="{{route('master-settings.edit-daily-weekly-settings')}}" class=" btn-primary p-2 ">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    <!-- Body -->
                    <div class="p-4 overflow-x-auto ">

                        <table class="w-full whitespace-nowrap overflow-x-auto text-sm text-left">
                            <tbody class="divide-y  divide-gray-200">
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 w-1/3 uppercase">
                                        Add Collect Adv. Processing fee
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Add Cibil Score Line Item
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>


                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Number of CIBIL <br> Records Mandatory
                                    </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Reminder SMS </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Penalty Charges</td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Loan Interest Rate (%)</td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Overdue Interest (%) </td>
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Processing Charges (%) </td>
                                    <td class="px-4 py-2">
                                        %
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Stamp Duty Charges (%)</td>
                                    <td class="px-4 py-2">
                                        %
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Insurance Charges (%)
                                    </td>
                                    <td class="px-4 py-2">
                                        %
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Fitness Charges (%)
                                    </td>
                                    <td class="px-4 py-2">
                                        %
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">Fore Close Charges (%) </td>
                                    <td class="px-4 py-2">
                                        %
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        SMS Charges per EMI (%)
                                    </td>
                                    <td class="px-4 py-2">
                                        %
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Stationary Charges per EMI (%)
                                    </td>
                                    <td class="px-4 py-2">
                                        %
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Fuel Charges per EMI (%)
                                    </td>
                                    <td class="px-4 py-2">
                                        %
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Maintenance Charges per EMI (%)
                                    </td>
                                    <td class="px-4 py-2">
                                        %
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Documentation Charges
                                    </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        EMI Bounce Charges (Cheque)
                                    </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        EMI Installment
                                        <br>
                                        Cancellation Charges
                                    </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        No Due Certificate Charges
                                    </td>
                                    <td class="px-4 py-2">
                                        ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Debit Other Charges
                                        <br>
                                        Directly To Loan Account
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Scheme Based Loan Account
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Disburse Setting Active
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Fore Close Full Interest Debit
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 uppercase">
                                        Disable Cash Disbursement
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>


            </div>

        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const interestButton = document.getElementById('interestButton');
                const interestMenu = document.getElementById('interestMenu');
                const interestArrow = document.getElementById('interestArrow');

                // Toggle menu on button click
                interestButton.addEventListener('click', function (e) {
                    e.stopPropagation(); // Prevent click from closing immediately

                    interestMenu.classList.toggle('hidden');
                    interestArrow.classList.toggle('rotate-180');
                });

                // Close menu when clicking outside
                document.addEventListener('click', function (e) {
                    if (!interestMenu.classList.contains('hidden')) {
                        interestMenu.classList.add('hidden');
                        interestArrow.classList.remove('rotate-180');
                    }
                });
            });
        </script>
        <script>
            // Label update on toggle
            document.querySelectorAll('.slider-toggle').forEach(toggle => {
                toggle.addEventListener('change', function () {
                    const label = document.getElementById(this.dataset.labelId);
                    label.textContent = this.checked ? 'ON' : 'OFF';
                });

                // Initialize label on page load
                toggle.dispatchEvent(new Event('change'));
            });
        </script>

@endsection