@extends('layout.main')
@section('content')
    <style>
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

    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col gap-2">
                <h1 class="text-2xl font-semibold">
                    DD ACCOUNT -DDA{{ $ddaccount->id }}
                </h1>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('ddsaccounts.installments', $ddaccount->id) }}" class="btn-primary px-4 py-2 rounded-3xl">
                INSTALLMENT PLAN
            </a>

            <a href="{{ route('dds-accounts.transactions', $ddaccount->id) }}"
                class="btn btn-primary px-4 py-2 rounded-3xl">
                VIEW TRANSACTIONS
            </a>

            <a href="{{ route('ddsaccounts.createDeposit', $ddaccount->id) }}" class="btn-primary px-4 py-2 rounded-3xl">
                DEPOSIT MONEY
            </a>

            <a href="{{ route('ddsaccounts.withdraw-create', $ddaccount->id) }}" class="btn-primary px-4 py-2 rounded-3xl">
                WITHDRAW MONEY
            </a>
            <div class="relative inline-block text-left">

                <!-- Button -->
                <button onclick="this.nextElementSibling.classList.toggle('hidden')"
                    class="btn-primary px-4 py-2 rounded-3xl flex items-center gap-2">
                    Account Details
                    <svg class="w-4 h-2 ml-1 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div class="hidden absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg  z-50">
                    <ul class="py-2 text-gray-700">
                        <li>
                            <a href="{{ route('dd.change.account.info', $ddaccount->id) }}"
                                class="block px-4 py-2
                                hover:bg-teal-50 hover:text-teal-700">
                                CHANGE ACCOUNT INFO
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('dd.accounts.nominee', ['type' => 'dd', 'id' => base64_encode($ddaccount->id)]) }}"
                                class="block px-4 py-2 hover:bg-teal-50 hover:text-teal-700">ADD NOMINEE</a>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('ddChange.minor.info', $ddaccount->id) }}"
                                class="block px-4 py-2 hover:bg-teal-50 hover:text-teal-700">
                                ADD MINOR
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dds-accounts.fore-close', $ddaccount->id) }}"
                                class="block px-4 py-2 hover:bg-teal-50 hover:text-teal-700">
                                FORE CLOSE DD
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-teal-50 hover:text-teal-700">
                                REMOVE ACCOUNT
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <button class="btn-primary px-4 py-2 rounded-3xl ">
                PRINT DOCUMENTS
            </button>
            <a href="{{ route('ddsaccounts.createCreditInterest', $ddaccount->id) }}"
                class="btn-primary px-4 py-2 rounded-3xl">
                CREDIT / REVERSE INTEREST
            </a>
            <button class="btn-primary px-4 py-2 rounded-3xl ">
                DEBIT OTHER CHARGES
            </button>

            @if ($isLinked != 1)
                <a href="{{ route('ddsaccounts.createLinkSavingAcc', $ddaccount->id) }}"
                    class="btn-primary px-4 py-2 rounded-3xl">
                    LINK SAVING ACCOUNT (AUTO DEBIT)
                </a>
            @endif


            <a href="{{ route('ddsaccounts.MarkLienAccount', $ddaccount->id) }}" class="btn-primary px-4 py-2 rounded-3xl">
                MARK LIEN AGAINST LOAN
            </a>

            <button class="btn-primary px-4 py-2 rounded-3xl ">
                SHOW AUDIT TRAIL
            </button>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <div class=" w-full  overflow-hidden">
                <div class="overflow-x-auto box rounded-lg dark:bg-bg3 p-2 bg-white shadow-md">
                    <div class="text-end p-3">

                    </div>
                    <table class="min-w-full text-sm text-left border-collapse">
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="font-semibold px-4 py-2 w-1/3 uppercase">Status</td>
                                <td class="px-4 py-2">
                                    <a href="" class="label label-default">
                                        dummy FORE CLOSE APPROVED
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 w-1/3 uppercase">Customer</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('member.show', $ddaccount->member->id) }}"
                                        class="text-primary hover:underline">
                                        {{ ($ddaccount->member?->member_no ??
                                            ($ddaccount->member?->id ? str_pad($ddaccount->member->id, 6, '0', STR_PAD_LEFT) : 'N/A')) .
                                            ' - ' .
                                            ($ddaccount->member?->member_info_first_name || $ddaccount->member?->member_info_last_name
                                                ? ucfirst($ddaccount->member->member_info_first_name) . ' ' . ucfirst($ddaccount->member->member_info_last_name)
                                                : 'N/A') }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-semibold  px-4 py-2 uppercase">Create on</td>
                                <td class="px-4 py-2">Admin App</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Created by</td>
                                <td class="px-4 py-2">Test Test</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">DD No.</td>
                                <td class="px-4 py-2">DDA{{ $ddaccount->id ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Old DD No.</td>
                                <td class="px-4 py-2">0.00</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Scheme</td>
                                <td class="px-4 py-2"> {{ $ddaccount->scheme->scheme_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Open Date </td>
                                <td class="px-4 py-2">{{ $ddaccount->open_date?->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Deposit Frequency </td>
                                <td class="px-4 py-2">{{ $ddaccount->scheme->rd_dd_frequency ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Installment Amount</td>
                                <td class="px-4 py-2">{{ number_format($ddaccount->dd_amount ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Installment Amount Received (C)</td>
                                <td class="px-4 py-2">{{ number_format($installmentReceived, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Penalty/ Other Charges Received</td>
                                <td class="px-4 py-2">{{ number_format($penaltyReceived, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Interest Credited (D) </td>
                                <td class="px-4 py-2">
                                    ({{ optional($ddaccount->transactions->last())->interest_amount ?? '0.00' }})
                                </td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">TDS Deducted (E) </td>
                                <td class="px-4 py-2">{{ number_format($tdsDeduction, 2) }} </td>
                            </tr>
                            <tr>
                                <td class="font-semibold  px-4 py-2 uppercase">Balance Available (C + D - E)</td>
                                <td class="px-4 py-2">{{ number_format($balanceAvailable, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Principal Amount Due (A) </td>
                                <td class="px-4 py-2">{{ number_format($principalDue, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Penalty / Other Charges Due (B)</td>
                                <td class="px-4 py-2">{{ number_format($penaltyDue, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Total Amount Due (A + B) </td>
                                <td class="px-4 py-2">{{ number_format($totalAmountDue, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Maturity Date </td>
                                <td class="px-4 py-2">{{ $ddaccount->maturity_date?->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Close Date </td>
                                <td class="px-4 py-2">{{ $closeDate ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Maturity Amount (approx.)</td>
                                <td class="px-4 py-2">{{ $ddaccount->maturity_amount ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Maturity Bonus Amount</td>
                                <td class="px-4 py-2">{{ $ddaccount->bonus ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Annual Interest Rate (%)</td>
                                <td class="px-4 py-2">{{ number_format($annualInterestRate, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Interest Compounding Interval</td>
                                <td class="px-4 py-2">
                                    {{ ucfirst($ddaccount->scheme->interest_compounding_interval ?? 'N/A') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">TDS Deduction</td>
                                <td class="px-4 py-2"><span
                                        class="px-2 py-1 text-xs font-medium rounded bg-red-100 text-red-600"
                                        {{ $tdsDeduction === 'Yes' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                        {{ $tdsDeduction }}</span></td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Special Account </td>
                                <td class="px-4 py-2"><span
                                        class="px-2 py-1 text-xs font-medium rounded bg-red-100 text-red-600"
                                        {{ $specialAccount === 'Yes' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                        {{ $specialAccount }}
                                    </span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!--MEMBER DETAILS-->
                <div class="box shadow-md mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="border-b px-4 py-3 bg-red-100">
                        <h3 class="text-lg font-semibold text-blacj">CUSTOMER DETAILS</h3>
                    </div>

                    <!-- Body -->
                    <div class="p-4 overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <tbody class="divide-y divide-gray-200">

                                <tr>
                                    <td class="font-semibold px-4 py-2 w-1/3 uppercase">Customer Name</td>
                                    <td class="px-4 py-2">
                                        {{ ($ddaccount->member?->member_no ??
                                            ($ddaccount->member?->id ? str_pad($ddaccount->member->id, 6, '0', STR_PAD_LEFT) : '-')) .
                                            ' - ' .
                                            $ddaccount->member->member_info_first_name ??
                                            'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="font-semibold px-4 py-2 uppercase">Mobile No</td>
                                    <td class="px-4 py-2">{{ $ddaccount->member->member_info_mobile_no ?? 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <td class="font-semibold px-4 py-2 uppercase">Address</td>
                                    <td class="px-4 py-2">
                                        {{ $ddaccount->member->address->member_address_line_1 ?? 'N/A' }}
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
                        <h3 class="text-lg font-semibold uppercase text-black">ALLOCATED Passbook</h3>
                        <button class="btn-primary px-3 py-2 rounded-3xl text-white">
                            <i class="las la-plus"></i>
                            Passbook
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
                                            <!-- <span id="smsLabel" class="ml-4 text-sm font-medium text-black"></span>
                                                                                                                                                                    </labels> -->
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
                                            <!-- <span id="tdsLabel" class="ml-4 text-sm font-medium text-gray-700">OFF</span> -->
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
                                            <!-- <span id="holdLabel" class="ml-4 text-sm font-medium text-gray-700">OFF</span> -->
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
                                            <!-- <span id="holdLabel" class="ml-4 text-sm font-medium text-gray-700">OFF</span> -->
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
                                <label for="" class="block uppercase">Old DD No.
                                </label>
                                <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                                    <input type="text" name="" id=""
                                        class="block w-full bg-secondary/5 px-3 rounded-10 border py-3 dark:text-white"
                                        placeholder="Enter Old DD Number">
                                    <input type="button" value="Update" class="block  btn-primary">
                                </div>
                            </form>
                            <form action="" class="mt-2 px-3">
                                <label for="memberDropdown" class="block uppercase">Customer</label>
                                <div class="mt-2 flex flex-row items-center gap-3 justify-between">
                                    <select id="memberDropdown" name="member_id"
                                        class="w-full rounded-10 border px-3 py-3 bg-secondary/5 dark:bg-bg3 dark:text-white">
                                        @if (!empty($ddaccount->member))
                                            <option value="{{ $ddaccount->member->id }}" selected>
                                                {{ str_pad($ddaccount->member->id, 5, '0', STR_PAD_LEFT) }}
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
                                <label for="branchDropdown" class="block uppercase">Branch</label>
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
                                <label for="" class="block uppercase">Advisor/ Staff</label>
                                <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                                    <select
                                        class="w-full rounded-10 border  px-3 py-3  bg-secondary/5 dark:bg-bg3 dark:text-white">
                                        <option>Select Advisor/ Staff</option>

                                        <option>Option 2</option>
                                    </select>

                                    <input type="button" value="Update" class="block  btn-primary">

                                </div>
                            </form>

                            <form action="" class="mt-2 px-3">
                                <label for="" class="block uppercase">Collection Advisor/ Staff
                                </label>
                                <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                                    <select
                                        class="w-full rounded-10 border  px-3 py-3  bg-secondary/5 dark:bg-bg3 dark:text-white">
                                        <option>Select Advisor/ Staff</option>

                                        <option>Option 2</option>
                                    </select>

                                    <input type="button" value="Update" class="block  btn-primary">

                                </div>
                            </form>
                            <div class=" px-6 flex py-4 flex-row items-start gap-6">
                                <p class="w-full text-lg  uppercase">Current Chart</p>
                                <a href="#" class="text-primary w-full uppercase">None </a>
                            </div>

                            <!--Commission Chart-->
                            <form action="" class="mt-2 px-3 pb-4">
                                <label for="" class="block uppercase">Commission Chart</label>
                                <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                                    <select
                                        class="w-full rounded-10 border  px-3 py-3  bg-secondary/5 dark:bg-bg3 dark:text-white">
                                        <option>Select Commission Chart</option>

                                        <option>Option 2</option>
                                    </select>

                                    <input type="button" value="Update" class="block btn-primary">

                                </div>
                            </form>
                        </div>
                        {{-- AUTO DEBIT SAVING ACCOUNT INFO --}}
                        @if ($isLinked == 1)
                            <div class="box shadow-md dark:bg-bg3 mt-5 rounded-lg overflow-hidden">

                                <!-- Header -->
                                <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                                    onclick="this.nextElementSibling.classList.toggle('hidden')">
                                    <h3 class="text-lg font-semibold uppercase">AUTO DEBIT SAVING ACCOUNT INFO</h3>
                                </div>

                                <!-- Body -->
                                <div class="overflow-x-auto mt-5">
                                    <table
                                        class="w-full border-collapse rounded-lg overflow-hidden shadow-md bg-white dark:bg-bg3">
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                                            <tr>
                                                <td class="font-semibold px-4 py-2 uppercase w-1/2 md:w-1/3">Account No.
                                                </td>
                                                <td class="px-4 py-2 text-right md:text-left">
                                                    {{ $linkedSavingAcc->account_no ?? '' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="font-semibold px-4 py-2 uppercase">Scheme Name</td>
                                                <td class="px-4 py-2 text-right md:text-left">
                                                    {{ $ddaccount->scheme->scheme_name ?? '-' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="font-semibold px-4 py-2 uppercase">Available Balance</td>
                                                <td class="px-4 py-2 text-right md:text-left">
                                                    {{ number_format($availableBalance, 2) }}
                                                </td>
                                            </tr>

                                            @if ($isLinked !== 0)
                                                <tr>
                                                    <td class="font-semibold px-4 py-2 uppercase">Un-link Saving Account
                                                    </td>
                                                    <td class="px-4 py-2 text-right md:text-left">
                                                        <a href="{{ route('ddsaccounts.confirmUnlink', $ddaccount->id) }}"
                                                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                                                            UNLINK ACCOUNT
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

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
                                            <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">Scheme Name</td>
                                            <td class="px-4 py-2   text-right md:text-left">
                                                {{ $ddaccount->scheme->scheme_name ?? '-' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold px-4 py-2 uppercase">Scheme Code</td>
                                            <td class="px-4 py-2   text-right md:text-left">
                                                {{ $ddaccount->scheme->scheme_code ?? '-' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold px-4 py-2 uppercase">Minimum Locking Period</td>
                                            <td class="px-4 py-2   text-right md:text-left">
                                                {{ $ddaccount->scheme->rd_dd_lock_in_period ?? 'NA' }} months
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold px-4 py-2 uppercase">Interest Locking Period</td>
                                            <td class="px-4 py-2   text-right md:text-left">
                                                {{ $ddaccount->scheme->interest_lock_in_period ?? 0 }} Months
                                            </td>
                                        </tr>

                                        <tr class="bg-gray-50 dark:bg-bg3">
                                            <td class="font-bold px-4 py-2 uppercase">Deposit Frequency</td>
                                            <td class="px-4 py-2   text-right md:text-left">
                                                {{ $ddaccount->scheme->rd_dd_frequency ?? '-' }}
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-50 dark:bg-bg3">
                                            <td class="font-bold px-4 py-2 uppercase">Annual Interest Rate (%)</td>
                                            <td class="px-4 py-2   text-right md:text-left">
                                                {{ $ddaccount->scheme->anuual_interest_rate ?? 'NA' }} %
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-50 dark:bg-bg3">
                                            <td class="font-bold px-4 py-2 uppercase">Interest Compounding Interval</td>
                                            <td class="px-4 py-2   text-right md:text-left">
                                                {{ $ddaccount->scheme->interest_compounding_interval ?? 'NA' }}
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-50 dark:bg-bg3">
                                            <td class="font-bold px-4 py-2 uppercase">Tenure</td>
                                            <td class="px-4 py-2   text-right md:text-left">
                                                {{ $ddaccount->scheme->tenure_of_rd_dd_value }}
                                                {{ $ddaccount->scheme->tenure_of_rd_dd_type }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-semibold px-4 py-2 uppercase">Cancellation Charges</td>
                                            <td class="px-4 py-2   text-right md:text-left">
                                                {{ $ddaccount->scheme->cancellation_charges_value }}
                                                {{ $ddaccount->scheme->cancellation_charges_type === 'percentage' ? '%' : 'fixed' }}
                                            </td>
                                        </tr>

                                        <tr class="bg-gray-50 dark:bg-bg3">
                                            <td class="font-bold px-4 py-2 uppercase">Penal Charges</td>
                                            <td class="px-4 py-2   text-right md:text-left">
                                                {{ $ddaccount->scheme->penal_charges ?? '-' }}
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-50 dark:bg-bg3">
                                            <td class="font-bold px-4 py-2 uppercase">Bonus Rate</td>
                                            <td class="px-4 py-2   text-right md:text-left">
                                                {{ $ddaccount->scheme->bonus_rate_value }}
                                                {{ $ddaccount->scheme->bonus_rate_type === 'percentage' ? '%' : 'fixed' }}
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-50 dark:bg-bg3">
                                            <td class="font-bold px-4 py-2 uppercase">Minimum Amount</td>
                                            <td class="px-4 py-2   text-right md:text-left">
                                                {{ $ddaccount->scheme->min_rd_dd_amount ?? 'NA' }}
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-50 dark:bg-bg3">
                                            <td class="font-bold px-4 py-2 uppercase">Skip Days (For DD Only) </td>
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
                                            <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">Maturity Date</td>
                                            <td class="px-4 py-2 text-right md:text-left">
                                                {{ $ddaccount->maturity_date?->format('d-m-Y') }}</td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold px-4 py-2 uppercase">Principal Amount (A)</td>
                                            <td class="px-4 py-2 text-right md:text-left">
                                                {{ number_format($ddaccount->dd_amount, 2) }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold px-4 py-2 uppercase">Total Interest (B)</td>
                                            <td class="px-4 py-2 text-right md:text-left">
                                                {{ $ddaccount->interest_earned }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold px-4 py-2 uppercase">Bonus Amount (C)</td>
                                            <td class="px-4 py-2   text-right md:text-left">
                                                {{ $ddaccount->bonus }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="font-semibold px-4 py-2 uppercase">Maturity Amount (A + B + C) </td>
                                            <td class="px-4 py-2   text-right md:text-left">
                                                {{ $ddaccount->maturity_amount ?? '0' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                            <!-- Body -->
                            <div class="p-4">
                                <div class="overflow-x-auto text-center mt-5">
                                    <div class="overflow-x-auto">
                                        <table
                                            class="w-full border-collapse rounded-lg overflow-hidden shadow-md responsive-table">
                                            <thead class="bg-gray-100 text-start text-gray-700">
                                                <tr class="border-b">
                                                    <th class="px-4 py-2 text-start text-sm font-semibold">TOTAL INST</th>
                                                    <th class="px-4 py-2 text-start text-sm font-semibold">PAID INST</th>
                                                    <th class="px-4 py-2 text-start text-sm font-semibold">DUE INST </th>
                                                    <th class="px-4 py-2 text-start text-sm font-semibold">OVERDUE INST
                                                    </th>
                                                    <th class="px-4 py-2 text-start text-sm font-semibold">INST CANCELED
                                                    </th>
                                                    <th class="px-4 py-2 text-start text-sm font-semibold">TOTAL INST NOT
                                                        DUE</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-left">
                                                <tr class="border-b hover:bg-gray-50">
                                                    <td class="px-4 py-2">
                                                        {{ $ddaccount->total_installments ?? '0' }}
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        {{ $ddaccount->paid_installments ?? '0' }}
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        {{ $ddaccount->due_installments ?? '0' }}
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        {{ $ddaccount->overdue_installments ?? '0' }}
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        {{ $ddaccount->canceled_installments ?? '0' }}
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        {{ $ddaccount->not_due_installments ?? '0' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
                                            <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">Branch</td>
                                            <td class="px-4 py-2">{{ $ddaccount->member->branch->branch_name ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-semibold px-4 py-2 uppercase">Advisor/ Staff</td>
                                            <td class="px-4 py-2 text-right md:text-left">₹ 0.00</td>
                                        </tr>
                                        <tr>
                                            <td class="font-semibold px-4 py-2 uppercase">Joint Account </td>
                                            <td class="px-4 py-2 text-right md:text-left">-</td>
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
                                                @forelse ($ddaccount->transactions as $transaction)
                                                    <tr class="border-b hover:bg-gray-50">
                                                        <td class="px-4 py-2">
                                                            {{ $transaction->transaction_date ?? 'N/A' }}
                                                        </td>
                                                        <td class="px-4 py-2">
                                                            {{ $transaction->type ?? 'N/A' }}
                                                        </td>
                                                        <td class="px-4 py-2">
                                                            {{ $transaction->pay_mode ?? 'N/A' }}
                                                        </td>
                                                        <td class="px-4 py-2">
                                                            {{ $transaction->balance_available ?? 'N/A' }}
                                                        </td>
                                                        <td class="px-4 py-2 text-sm text-green-600 font-medium">Approved
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-3 text-gray-500">No
                                                            transactions found</td>
                                                    </tr>
                                                @endforelse
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
                                    text: "" + String(member.id).padStart(5, '0') + " - " +
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
                                    text: `${String(member.id).padStart(5, '0')} - ${member.member_info_first_name} ${member.member_info_last_name} (${member.mobile_no})`
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
