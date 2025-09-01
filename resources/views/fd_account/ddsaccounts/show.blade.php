@extends('layout.main')
<style>
    .breadcrumb {
        list-style: none;
        display: flex;
        padding: 0;
        margin-bottom: 1rem;
        font-size: 14px;
    }

    .breadcrumb li+li::before {
        content: "/";
        padding: 0 8px;
        color: #888;
    }

    .breadcrumb li a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb li.active {
        color: #555;
    }

    .custom-thead {
        background-color: #e6f4ea;
        color: #14532d;
    }

    .custom-thead th {
        font-weight: 600;
        border-bottom: 1px solid #ccc;
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


    @media (prefers-color-scheme: dark) {
        .custom-thead {
            background-color: #14532d;
            color: #d1fae5;
        }
    }

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
</style>

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col gap-2">
                <h1 class="text-2xl font-semibold">
                    DD Account -DDA{{ $ddaccount->id }}
                </h1>
                <p class="text-gray-500">
                    <a href="#" class="text-gray-500">DD Account</a> >
                    <a href="#" class="text-gray-500"> 1706</a>
                </p>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <!-- FD Payout Plan -->
            <button type="" class="btn-primary px-4 py-2 rounded-3xl ">
                FD PAYOUT PLAN
            </button>

            <!-- View Transactions -->
            <button class="btn-primary px-4 py-2 rounded-3xl ">
                VIEW TRANSACTIONS
            </button>

            <!-- Account Details -->
            <button class="btn-primary px-4 py-2 rounded-3xl ">
                ACCOUNT DETAILS
            </button>

            <!-- Print Documents -->
            <button class="btn-primary px-4 py-2 rounded-3xl ">
                PRINT DOCUMENTS
            </button>

            <!-- Show Audit Trail -->
            <button class="btn-primary px-4 py-2 rounded-3xl ">
                SHOW AUDIT TRAIL
            </button>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">

            <!-- Left: Details -->
            <div class=" w-full  overflow-hidden">
                <div class="overflow-x-auto box rounded-lg dark:bg-bg3 p-2 bg-white shadow-md">
                    <div class="text-end p-3">
                        <a href="#" class=" p-2 btn-outline">
                            <i class="las la-pen"></i>
                        </a>
                    </div>
                    <table class="min-w-full text-sm text-left border-collapse">
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="font-semibold px-4 py-2 w-1/3">Status</td>
                                <td class="px-4 py-2">
                                    <a href="" class="label label-default">
                                        FORE CLOSE APPROVED
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 w-1/3">Member</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('member.show', $ddaccount->member->id) }}"
                                        class="text-primary hover:underline">
                                        {{ $ddaccount->member->member_info_first_name ?? 'N/A' }}
                                    </a>

                                </td>
                            </tr>
                            <tr>
                                <td class="font-semibold  px-4 py-2">Create on</td>
                                <td class="px-4 py-2">Admin App</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Created by</td>
                                <td class="px-4 py-2">Test Test</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">DD No.</td>
                                <td class="px-4 py-2">DDA{{ $ddaccount->id ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Old DD No.</td>
                                <td class="px-4 py-2">—</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Scheme</td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Open Date </td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Deposit Frequency </td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Installment Amount</td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Installment Amount Received (C)</td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Penalty/ Other Charges Received</td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Interest Credited (D) </td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">TDS Deducted (E) </td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Balance Available (C + D - E)</td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Principal Amount Due (A) </td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Penalty / Other Charges Due (B)</td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Total Amount Due (A + B) </td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Maturity Date </td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Close Date </td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Maturity Amount (approx.)</td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Maturity Bonus Amount</td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Annual Interest Rate (%)</td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Interest Compounding Interval</td>
                                <td class="px-4 py-2">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">TDS Deduction</td>
                                <td class="px-4 py-2"><span
                                        class="px-2 py-1 text-xs font-medium rounded bg-red-100 text-red-600">No</span></td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Special Account </td>
                                <td class="px-4 py-2"><span
                                        class="px-2 py-1 text-xs font-medium rounded bg-red-100 text-red-600">No</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!--MEMBER DETAILS-->
                <div class="box shadow-md mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="border-b px-4 py-3 bg-red-100">
                        <h3 class="text-lg font-semibold text-blacj">MEMBER DETAILS</h3>
                    </div>

                    <!-- Body -->
                    <div class="p-4 overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <tbody class="divide-y divide-gray-200">

                                <tr>
                                    <td class="font-semibold px-4 py-2 w-1/3">Member Name</td>
                                    <td class="px-4 py-2">{{ $ddaccount->member->member_info_first_name ?? 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <td class="font-semibold px-4 py-2">Mobile No</td>
                                    <td class="px-4 py-2">{{ $ddaccount->member->member_info_mobile_no ?? 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <td class="font-semibold px-4 py-2">Address</td>
                                    <td class="px-4 py-2">{{ $ddaccount->member->address->member_address_line_1 ?? 'N/A' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!--PASSBOOK-->
                <div class="box shadow-md mt-5 rounded-lg dark:bg-bg3 overflow-hidden">
                    <!-- Header -->
                    <div class=" px-4 py-3 flex items-center gap-4 justify-between bg-red-100">
                        <h3 class="text-lg font-semibold uppercase text-black">ALLOCATED passbook</h3>
                        <button class="btn-primary px-3 py-2 rounded-3xl text-white">
                            <i class="las la-plus"></i>
                            passbok
                        </button>
                    </div>
                </div>


                <!--documents-->
                <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                        onclick="this.nextElementSibling.classList.toggle('hidden')">
                        <h3 class="text-lg font-semibold">DOCUMENTS</h3>
                        <button class=" btn-outline p-1  ">
                            <i class="las la-upload"></i>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="p-4">
                        <div class="overflow-x-auto">
                            <p class="capitalize">No documents found</p>
                        </div>
                    </div>
                </div>

                <!--COMMENTS-->
                <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-center justify-between bg-secondary/5 text-black rounded-10 px-4 py-3 cursor-pointer"
                        onclick="this.nextElementSibling.classList.toggle('hidden')">
                        <h3 class="text-lg font-semibold">COMMENTS</h3>

                    </div>

                    <!-- Body -->
                    <div class="p-4">
                        <div class="overflow-x-auto text-center mt-5">
                            <button class="btn-primary px-3 py-2 rounded-3xl uppercase text-white">Add COMMENTS</button>
                        </div>
                    </div>

                </div>



            </div>

            <!-- Right: Settings -->
            <div class=" w-full ">

                <!--settings-->
                <div class="box dark:bg-bg3 border-gray-200 shadow-md rounded-lg">
                    <!-- Header -->
                    <div class="px-4 py-3">
                        <h3 class="text-lg border-b font-semibold text-black">SETTINGS</h3>
                    </div>
                    <div class="p-4 overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <tbody class="divide-y divide-gray-200">

                                <!-- SMS Toggle -->
                                <tr>
                                    <td class="font-semibold text-center align-middle px-4 py-3 w-1/3">SMS</td>
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
                                            <span id="smsLabel" class="ml-4 text-sm font-medium text-black">OFF</span>
                                            </labels>
                                    </td>
                                </tr>
                                <!-- DEDUCT TDS Toggle -->
                                <tr>
                                    <td class="font-semibold text-center align-middle px-4 py-3">ACCOUNT ON HOLD</td>
                                    <td class="px-4 py-3">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" id="tdsToggle" class="sr-only slider-toggle"
                                                data-label-id="tdsLabel">
                                            <div class="relative">
                                                <div
                                                    class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                                                </div>
                                                <div
                                                    class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                                                </div>
                                            </div>
                                            <span id="tdsLabel" class="ml-4 text-sm font-medium text-gray-700">OFF</span>
                                        </label>
                                    </td>
                                </tr>

                                <!-- ACCOUNT ON HOLD Toggle -->
                                <tr>
                                    <td class="font-semibold text-center align-middle px-4 py-3">AUTO PENALTY </td>
                                    <td class="px-4 py-3">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" id="holdToggle" class="sr-only slider-toggle"
                                                data-label-id="holdLabel">
                                            <div class="relative">
                                                <div
                                                    class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                                                </div>
                                                <div
                                                    class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                                                </div>
                                            </div>
                                            <span id="holdLabel" class="ml-4 text-sm font-medium text-gray-700">OFF</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-semibold text-center align-middle px-4 py-3">DEDUCT TDS </td>
                                    <td class="px-4 py-3">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" id="holdToggle" class="sr-only slider-toggle"
                                                data-label-id="holdLabel">
                                            <div class="relative">
                                                <div
                                                    class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                                                </div>
                                                <div
                                                    class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                                                </div>
                                            </div>
                                            <span id="holdLabel" class="ml-4 text-sm font-medium text-gray-700">OFF</span>
                                        </label>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Body -->
                <div class="p-4">
                    <form id="autoRenewForm" class="space-y-6">
                        <div class="box dark:bg-bg3 shadow-md mt-4 rounded-xl border border-gray-200">
                            <!--Old MIS No.-->
                            <form action="" class="mt-3 p-3">
                                <label for="" class="block ">Old DD No.
                                </label>
                                <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                                    <input type="text" name="" id=""
                                        class="block w-full bg-secondary/5 px-3 rounded-10 border py-3 dark:text-white"
                                        placeholder="Enter Old DD Number">
                                    <input type="button" value="update" class="block  btn-primary">
                                </div>
                            </form>
                            <form action="" class="mt-2 px-3">
                                <label for="memberDropdown" class="block">Member</label>
                                <div class="mt-2 flex flex-row items-center gap-3 justify-between">
                                    <select id="memberDropdown" name="member_id"
                                        class="w-full rounded-10 border px-3 py-3 bg-secondary/5 dark:bg-bg3 dark:text-white">
                                        @if (!empty($ddaccount->member))
                                            <option value="{{ $ddaccount->member->id }}" selected>
                                                DEMO-{{ str_pad($ddaccount->member->id, 5, '0', STR_PAD_LEFT) }}
                                                - {{ $ddaccount->member->member_info_first_name }}
                                                {{ $ddaccount->member->member_info_last_name }}
                                            </option>
                                        @endif
                                    </select>

                                    <input type="submit" value="Update" class="block btn-primary">
                                </div>
                            </form>
                            <!--Branch-->
                            <form action="" class="mt-2 px-3">
                                <label for="branchDropdown" class="block">Branch</label>
                                <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                                    <select id="branchDropdown" name="branch_id"
                                        class="w-full rounded-10 border px-3 py-3 bg-secondary/5 dark:bg-bg3 dark:text-white">

                                        @if (!empty($ddaccount->branch))
                                            <option value="{{ $ddaccount->branch->id }}" selected>
                                                {{ $ddaccount->branch->branch_name }}
                                            </option>
                                        @endif

                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">
                                                {{ $branch->branch_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <input type="submit" value="Update" class="block btn-primary">
                                </div>
                            </form>

                            <!--Advisor/ Staff-->
                            <form action="" class="mt-2 px-3">
                                <label for="" class="block ">Advisor/ Staff</label>
                                <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                                    <select
                                        class="w-full rounded-10 border  px-3 py-3  bg-secondary/5
       dark:bg-bg3 dark:text-white">
                                        <option>Select Advisor/ Staff</option>

                                        <option>Option 2</option>
                                    </select>

                                    <input type="button" value="update" class="block  btn-primary">

                                </div>
                            </form>

                            <form action="" class="mt-2 px-3">
                                <label for="" class="block ">Collection Advisor/ Staff
                                </label>
                                <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                                    <select
                                        class="w-full rounded-10 border  px-3 py-3  bg-secondary/5
       dark:bg-bg3 dark:text-white">
                                        <option>Select Advisor/ Staff</option>

                                        <option>Option 2</option>
                                    </select>

                                    <input type="button" value="update" class="block  btn-primary">

                                </div>
                            </form>
                            <div class=" px-6 flex py-4 flex-row items-start gap-6">
                                <p class="w-full text-lg  ">Current Chart</p>
                                <a href="#" class="text-primary w-full uppercase">None </a>
                            </div>

                            <!--Commission Chart-->
                            <form action="" class="mt-2 px-3 pb-4">
                                <label for="" class="block ">Commission Chart</label>
                                <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                                    <select
                                        class="w-full rounded-10 border  px-3 py-3  bg-secondary/5
       dark:bg-bg3 dark:text-white">
                                        <option>Select Commission Chart</option>

                                        <option>Option 2</option>
                                    </select>

                                    <input type="button" value="update" class="block  btn-primary">

                                </div>
                            </form>
                        </div>
                        <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                            <!-- Header -->
                            <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                                onclick="this.nextElementSibling.classList.toggle('hidden')">
                                <h3 class="text-lg font-semibold uppercase">Fore Closure Info</h3>
                            </div>
                            <!-- Body -->
                            <div class="overflow-x-auto mt-5">
                                <table
                                    class="w-full border-collapse rounded-lg overflow-hidden shadow-md bg-white dark:bg-bg3">
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                                        <tr>
                                            <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3">Fore Closure Date</td>
                                            <td class="px-4 py-2 text-right md:text-left">02/03/2029</td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold px-4 py-2">Current Balance (A) </td>
                                            <td class="px-4 py-2 text-right md:text-left">₹ 500,000.00</td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold px-4 py-2">Penal Charges (B)</td>
                                            <td class="px-4 py-2 text-right md:text-left">₹ 225,000.00</td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold px-4 py-2">Fore Closure Charges (C)</td>
                                            <td class="px-4 py-2 text-right md:text-left">₹ 0.00</td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold px-4 py-2">Final Payable Amount (A - B - C)</td>
                                            <td class="px-4 py-2 text-right md:text-left">₹ 0.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--Scheme Info-->
                        <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                            <!-- Header -->
                            <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                                onclick="this.nextElementSibling.classList.toggle('hidden')">
                                <h3 class="text-lg font-semibold uppercase">Scheme Info</h3>
                            </div>
                            <!-- Body -->
                            <div class="overflow-x-auto mt-5">
                                <table class="w-full border-collapse rounded-lg overflow-hidden  bg-white dark:bg-bg3">
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                                        <tr>
                                            <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3">Scheme Name</td>
                                            <td class="px-4 py-2   text-right md:text-left">-</td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold px-4 py-2">Scheme Code</td>
                                            <td class="px-4 py-2   text-right md:text-left">-</td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold px-4 py-2">Minimum Locking Period</td>
                                            <td class="px-4 py-2   text-right md:text-left">-</td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold px-4 py-2">Interest Locking Period</td>
                                            <td class="px-4 py-2   text-right md:text-left">-</td>
                                        </tr>

                                        <tr class="bg-gray-50 dark:bg-bg3">
                                            <td class="font-bold px-4 py-2">Deposit Frequency</td>
                                            <td class="px-4 py-2   text-right md:text-left">-</td>
                                        </tr>
                                        <tr class="bg-gray-50 dark:bg-bg3">
                                            <td class="font-bold px-4 py-2">Annual Interest Rate (%)</td>
                                            <td class="px-4 py-2   text-right md:text-left">-</td>
                                        </tr>
                                        <tr class="bg-gray-50 dark:bg-bg3">
                                            <td class="font-bold px-4 py-2">Interest Compounding Interval</td>
                                            <td class="px-4 py-2   text-right md:text-left">-</td>
                                        </tr>
                                        <tr class="bg-gray-50 dark:bg-bg3">
                                            <td class="font-bold px-4 py-2">Tenure</td>
                                            <td class="px-4 py-2   text-right md:text-left">-</td>
                                        </tr>
                                        <tr>
                                            <td class="font-semibold px-4 py-2">Cancellation Charges</td>
                                            <td class="px-4 py-2   text-right md:text-left">-</td>
                                        </tr>

                                        <tr class="bg-gray-50 dark:bg-bg3">
                                            <td class="font-bold px-4 py-2">Penal Charges</td>
                                            <td class="px-4 py-2   text-right md:text-left">-</td>
                                        </tr>
                                        <tr class="bg-gray-50 dark:bg-bg3">
                                            <td class="font-bold px-4 py-2">Bonus Rate</td>
                                            <td class="px-4 py-2   text-right md:text-left">-</td>
                                        </tr>
                                        <tr class="bg-gray-50 dark:bg-bg3">
                                            <td class="font-bold px-4 py-2">Minimum Amount</td>
                                            <td class="px-4 py-2   text-right md:text-left">-</td>
                                        </tr>
                                        <tr class="bg-gray-50 dark:bg-bg3">
                                            <td class="font-bold px-4 py-2">Skip Days (For DD Only) </td>
                                            <td class="px-4 py-2   text-right md:text-left">-</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--FD  Maturity Info-->
                        <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                            <!-- Header -->
                            <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                                onclick="this.nextElementSibling.classList.toggle('hidden')">
                                <h3 class="text-lg font-semibold uppercase">DD Maturity Info</h3>
                            </div>
                            <!-- Body -->
                            <div class="overflow-x-auto mt-5">
                                <table
                                    class="w-full border-collapse rounded-lg overflow-hidden shadow-md bg-white dark:bg-bg3">
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                                        <tr>
                                            <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3">Maturity Date</td>
                                            <td class="px-4 py-2 text-right md:text-left">02/03/2029</td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold px-4 py-2">Principal Amount (A)</td>
                                            <td class="px-4 py-2 text-right md:text-left">₹ 500,000.00</td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold px-4 py-2">Total Interest (B)</td>
                                            <td class="px-4 py-2 text-right md:text-left">₹ 225,000.00</td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold px-4 py-2">Bonus Amount (C)</td>
                                            <td class="px-4 py-2   text-right md:text-left">-</td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold px-4 py-2">Maturity Amount (A + B + C) </td>
                                            <td class="px-4 py-2   text-right md:text-left">-</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--FD Info-->
                        <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                            <!-- Header -->
                            <div class="overflow-x-auto mt-5">
                                <table
                                    class="w-full border-collapse rounded-lg overflow-hidden shadow-md bg-white dark:bg-bg3">
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                                        <tr>
                                            <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3">Branch</td>
                                            <td class="px-4 py-2">{{ $ddaccount->member->branch->branch_name ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-semibold px-4 py-2">Advisor/ Staff</td>
                                            <td class="px-4 py-2 text-right md:text-left">₹ 0.00</td>
                                        </tr>
                                        <tr>
                                            <td class="font-semibold px-4 py-2">Joint Account </td>
                                            <td class="px-4 py-2 text-right md:text-left">60 Months</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--Transactions Info-->
                        <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                            <!-- Header -->
                            <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                                onclick="this.nextElementSibling.classList.toggle('hidden')">
                                <h3 class="text-lg font-semibold uppercase">Transactions Info</h3>
                            </div>
                            <!-- Body -->
                            <div class="p-4">
                                <div class="overflow-x-auto text-center mt-5">
                                    <div class="overflow-x-auto">
                                        <table
                                            class="w-full border-collapse rounded-lg overflow-hidden shadow-md responsive-table">
                                            <thead class="bg-gray-100 text-start text-gray-700">
                                                <tr class="border-b">
                                                    <th class="px-4 py-2 text-start text-sm font-semibold">DATE</th>
                                                    <th class="px-4 py-2 text-start text-sm font-semibold">TYPE</th>
                                                    <th class="px-4 py-2 text-start text-sm font-semibold">PAYMENT MODE
                                                    </th>
                                                    <th class="px-4 py-2 text-start text-sm font-semibold">AMOUNT</th>
                                                    <th class="px-4 py-2 text-start text-sm font-semibold">STATUS</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-left">
                                                <tr class="border-b hover:bg-gray-50">
                                                    <td class="px-4 py-2">
                                                        {{ $ddaccount->transfer_date ?? 'N/A' }}</td>
                                                    <td class="px-4 py-2">
                                                        {{ $ddaccount->account_type ?? 'N/A' }}</td>
                                                    <td class="px-4 py-2">
                                                        {{ $ddaccount->pay_mode ?? 'N/A' }}</td>
                                                    <td class="px-4 py-2">
                                                        {{ $ddaccount->dd_amount ?? 'N/A' }}</td>
                                                    <td class="px-4 py-2 text-sm text-green-600 font-medium">Approved</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button class="btn-primary  mt-3">View All</button>
                                </div>
                            </div>
                        </div>
                        </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Label update on toggle
        document.querySelectorAll('.slider-toggle').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const label = document.getElementById(this.dataset.labelId);
                label.textContent = this.checked ? 'ON' : 'OFF';
            });

            toggle.dispatchEvent(new Event('change'));
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#memberDropdown').select2({
                placeholder: 'Search Member',
                allowClear: true,
                width: '100%',
                ajax: {
                    url: "{{ route('ajax.members.search') }}", // Make sure this route exists
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(member) {
                                return {
                                    id: member.id,
                                    text: "DEMO-" + String(member.id).padStart(5, '0') + " - " +
                                        member.member_info_first_name + " " + member
                                        .member_info_last_name +
                                        " (" + member.mobile_no + ")"
                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2
            });
        });
    </script>
    @push('script')
        <script>
            $(document).ready(function() {
                $('#branchDropdown').select2({
                    placeholder: 'Select Branch',
                    allowClear: true,
                    width: '100%'
                });
            });
        </script>
    @endpush
    <script>
        $(document).ready(function() {
            $('#memberDropdown').select2({
                placeholder: 'Select a member',
                allowClear: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#memberDropdown').select2({
                placeholder: 'Search Member',
                allowClear: true,
                ajax: {
                    url: "{{ route('ajax.members.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        }; // search term
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(member) {
                                return {
                                    id: member.id,
                                    text: `DEMO-${String(member.id).padStart(5, '0')} - ${member.member_info_first_name} ${member.member_info_last_name} (${member.mobile_no})`
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#branchDropdown').select2({
                placeholder: 'Search Branch',
                allowClear: true,
                ajax: {
                    url: "{{ route('ajax.branches.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(branch) {
                                return {
                                    id: branch.id,
                                    text: branch.branch_name
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
@endsection
