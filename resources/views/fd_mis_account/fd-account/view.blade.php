@extends('layout.main')

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

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-2xl font-semibold">FD ACCOUNT - {{$fdAccount->id}}</h1>
            <p class="text-gray-500">
                <a href="#" class="text-gray-500">FD Account</a> >
                <a href="#" class="text-gray-500"> {{$fdAccount->id}}</a>
            </p>
        </div>
    </div>

    <div class="flex flex-wrap gap-3">
        <!-- FD Payout Plan -->
        <a href="{{ route('fd-mis-account.fd-payoutplan.fdpayoutplan', $fdAccount->id) }}" class="btn-primary px-4 py-2 rounded-10">
            FD PAYOUT PLAN
        </a>

        <!-- View Transactions -->
        <button class="btn-primary px-4 py-2 rounded-10 ">
            VIEW TRANSACTIONS
        </button>

        <!-- Account Details -->
        <!-- <button class="btn-primary px-4 py-2 rounded-10 ">
            ACCOUNT DETAILS
        </button> -->

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
                        <a href="{{route('fd.change.account.info',$fdAccount->id)}}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Change A/c Info</a>
                    </li>
                    <li>
                        <a href="{{route('fd.add.nominee',$fdAccount->id)}}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Add Nominee</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Print Documents -->
        <button class="btn-primary px-4 py-2 rounded-10 ">
            PRINT DOCUMENTS
        </button>

        <!-- Show Audit Trail -->
        <button class="btn-primary px-4 py-2 rounded-10 ">
            SHOW AUDIT TRAIL
        </button>
    </div>



    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">

        <!-- Left: Details -->
        <div class=" w-full  overflow-hidden">
            <div class="overflow-x-auto box rounded-lg dark:bg-bg3 p-2 bg-white shadow-md">
                <!-- <div class="text-end p-3">
                    <a href="#" class=" p-2 btn-outline">
                        <i class="las la-pen"></i>
                    </a>
                </div> -->
                <table class="min-w-full text-sm text-left border-collapse">
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="font-semibold px-4 py-2 w-1/3 uppercase">Member</td>
                            <td class="px-4 py-2">
                                <a href="" class="text-primary hover:underline">
                                    {{ $fdAccount->member->member_no 
    ?? ($fdAccount->member_id ? str_pad($fdAccount->member_id, 6, '0', STR_PAD_LEFT) : '-') }} - {{$fdAccount->member?->member_info_first_name ?? 'NA' }}
                                   
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
                            <td class="font-semibold px-4 py-2 uppercase">FD No.</td>
                            <td class="px-4 py-2">FD-{{$fdAccount->id}}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2 uppercase">Old FD No.</td>
                            <td class="px-4 py-2">—</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2 uppercase">Scheme</td>
                            <td class="px-4 py-2">{{$fdAccount->fdscheme->scheme_name}}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2 uppercase">Principal Amount</td>
                            <td class="px-4 py-2">₹ {{$fdAccount->fd_amount}}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2 uppercase">Open Date</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($fdAccount->created_at)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2 uppercase">Maturity Date</td>
                            <td class="px-4 py-2">{{$fdAccount->maturity_date ?? 'N/A'}}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2 uppercase">Tenure of FD/MIS</td>
                            <td class="px-4 py-2">{{$fdAccount->tenure_year}}Y,{{$fdAccount->tenure_month}}M,{{$fdAccount->tenure_days}}D</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2 uppercase">Interest Payout Type</td>
                            <td class="px-4 py-2">{{$fdAccount->interest_payout_type}}</td>
                        </tr>

                        <tr>
                            <td class="font-semibold px-4 py-2 uppercase">Close Date</td>
                            <td class="px-4 py-2">—</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2 uppercase">Annual Interest Rate (%)</td>
                            <td class="px-4 py-2">{{ $fdAnnualIntrest }} %</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2 uppercase">Balance Available</td>
                            <td class="px-4 py-2">₹ {{$fdAccount->fd_amount}}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2 uppercase">Status</td>
                            <td class="px-4 py-2">Fore close approved</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2 uppercase">TDS Deduction</td>
                            <td class="px-4 py-2">
                                @if($fdAccount->tds_deduction == 1)
                                <span class="px-2 py-1 text-xs font-medium rounded bg-green-100 text-green-600">Yes</span>
                                @else
                                <span class="px-2 py-1 text-xs font-medium rounded bg-red-100 text-red-600">No</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2 uppercase">Special Account</td>
                            <td class="px-4 py-2"><span
                                    class="px-2 py-1 text-xs font-medium rounded bg-red-100 text-red-600">No</span></td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2 uppercase">IS Lien</td>
                            <td class="px-4 py-2"><span
                                    class="px-2 py-1 text-xs font-medium rounded bg-red-100 text-red-600">No</span></td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2 uppercase">Sweep In</td>
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
                                <td class="font-semibold px-4 py-2 w-1/3 uppercase">Member Name</td>
                                <td class="px-4 py-2">
                                  {{ $fdAccount->member->member_no 
    ?? ($fdAccount->member_id ? str_pad($fdAccount->member_id, 6, '0', STR_PAD_LEFT) : '-') }} -   
                                {{$fdAccount->member->member_info_first_name??''}}</td>
                            </tr>

                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Mobile No</td>
                                <td class="px-4 py-2">{{$fdAccount->member->member_info_mobile_no??''}}</td>
                            </tr>

                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Address</td>
                                <td class="px-4 py-2">{{$fdAccount->member->address->member_address_line_1??''}}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Table Wrapper -->
            <div class="overflow-x-auto  md:block box mt-4 shadow-md rounded-lg">
                <table class="w-full text-sm  ">
                    <thead class="bg-gray-100  text-start">
                        <tr class="text-start">
                            <th class="px-4 py-2 font-semibold text-start text-gray-700 uppercase">Status</th>
                            <th class="px-4 py-2 font-semibold text-start text-gray-700 uppercase">Remarks</th>
                            <th class="px-4 py-2 font-semibold text-start text-gray-700 uppercase">Updated at</th>
                            <th class="px-4 py-2 font-semibold text-start text-gray-700 uppercase">Approved By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t border-b">
                            <td class="px-4 py-2 text-gray-800">Pending for approval</td>
                            <td class="px-4 py-2 text-gray-800">—</td>
                            <td class="px-4 py-2 text-gray-800">21/08/2025 17:00</td>
                            <td class="px-4 py-2 text-gray-800">—</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!--PASSBOOK-->
            <div class="box shadow-md mt-5 rounded-lg dark:bg-bg3 overflow-hidden">
                <!-- Header -->
                <div class=" px-4 py-3 flex items-center gap-4 justify-between bg-red-100">
                    <h3 class="text-lg font-semibold uppercase text-black">ALLOCATED passbook</h3>
                    <button class="btn-primary px-3 py-2 rounded-3xl text-white">
                        <i class="las la-plus"></i>
                        Passbok
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
                            <table class="w-full border-collapse rounded-lg overflow-hidden shadow-md responsive-table">
                                <thead class="bg-gray-100 text-start text-gray-700">
                                    <tr class="border-b">
                                        <th class="px-4 py-2 text-start text-sm font-semibold">DATE</th>
                                        <th class="px-4 py-2 text-start text-sm font-semibold">TYPE</th>
                                        <th class="px-4 py-2 text-start text-sm font-semibold">PAYMENT MODE</th>
                                        <th class="px-4 py-2 text-start text-sm font-semibold">AMOUNT</th>
                                        <th class="px-4 py-2 text-start text-sm font-semibold">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody class="text-left">
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-2 text-sm">31/07/2024 13:32</td>
                                        <td class="px-4 py-2 text-sm">Credit</td>
                                        <td class="px-4 py-2 text-sm">System</td>
                                        <td class="px-4 py-2 text-sm">10,000.00</td>
                                        <td class="px-4 py-2 text-sm text-green-600 font-medium">Approved</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <button class="btn-primary  mt-3">View All</button>
                    </div>
                </div>

            </div>

        </div>

        <!-- Right: Settings -->
        <div class=" w-full ">

            <!--settings-->
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
                                        <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel">
                                        <div class="relative">
                                            <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all"></div>
                                            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6"></div>
                                        </div>
                                        <!-- <span id="smsLabel" class="ml-4 text-sm font-medium text-black">OFF</span> -->
                                    </label>
                                </td>
                            </tr>

                            <!-- DEDUCT TDS Toggle -->
                            <tr>
                                <td class="font-semibold text-center align-middle px-4 py-3">DEDUCT TDS</td>
                                <td class="px-4 py-3">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="tdsToggle" class="sr-only slider-toggle" data-label-id="tdsLabel">
                                        <div class="relative">
                                            <div class="blocks w-14 h-8 bg-gray-300 rounded-full peer-checked:bg-green-500 transition-all"></div>
                                            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6"></div>
                                        </div>
                                        <!-- <span id="tdsLabel" class="ml-4 text-sm font-medium text-gray-700">OFF</span> -->
                                    </label>
                                </td>
                            </tr>

                            <!-- ACCOUNT ON HOLD Toggle -->
                            <tr>
                                <td class="font-semibold text-center align-middle px-4 py-3">ACCOUNT ON HOLD</td>
                                <td class="px-4 py-3">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="holdToggle" class="sr-only slider-toggle" data-label-id="holdLabel">
                                        <div class="relative">
                                            <div class="blocks w-14 h-8 bg-gray-300 rounded-full peer-checked:bg-green-500 transition-all"></div>
                                            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6"></div>
                                        </div>
                                        <!-- <span id="holdLabel" class="ml-4 text-sm font-medium text-gray-700">OFF</span> -->
                                    </label>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>

            <!--AUTO RENEW SETTINGS-->
            <div class="box dark:bg-bg3 shadow-md mt-4 rounded-xl">
                <!-- Header -->
                <div class="border-b px-4 py-3">
                    <h3 class="text-lg font-semibold text-black">AUTO RENEW SETTINGS</h3>
                </div>

                <!-- Body -->
                <div class="p-4">
                    <form id="autoRenewForm" class="space-y-6">

                        <!-- AUTO RENEW -->
                        <div class="flex flex-col md:flex-row md:items-center md:gap-6">
                            <label class="md:w-1/3 font-medium text-gray-700">AUTO RENEW</label>
                            <div class="flex gap-6 md:mt-0">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="autoRenew" value="true"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span>Yes</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="autoRenew" value="false" checked
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span>No</span>
                                </label>
                            </div>
                        </div>

                        <!-- AUTO RENEW INSTRUCTION -->
                        <div class="flex flex-col md:flex-row mt-5 md:items-center md:gap-6">
                            <label class="md:w-1/3 font-medium text-gray-700">AUTO RENEW INSTRUCTION</label>

                            <select id="renewInstruction"
                                class="w-full rounded-10 bg-secondary/5 py-3 shadow-sm focus:ring-primary focus:border-blue-500 text-sm p-2"
                                disabled>
                                <option value="">Select Instruction</option>
                                <option value="REINVEST_PRINCIPAL">REINVEST_PRINCIPAL</option>
                                <option value="REINVEST_PRINCIPAL_AND_INTEREST">REINVEST_PRINCIPAL_AND_INTEREST</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center mt-5">
                            <button type="submit" class="btn-primary px-4 py-2 rounded-3xl">
                                UPDATE
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            <!---->
            <div class="box dark:bg-bg3 shadow-md mt-4 rounded-xl border border-gray-200">
                <!--Old MIS No.-->
                <form action="" class="mt-3 p-3">
                    <label for="" class="block uppercase">Old FD No.</label>
                    <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                        <input type="text" name="" id=""
                            class="block w-full bg-secondary/5 px-3 rounded-10 border py-3 dark:text-white"
                            placeholder="Enter Old FD Number">
                        <input type="button" value="update" class="block  btn-primary">
                    </div>
                </form>

                <!--Branch-->
                <form action="{{ route('fd.updateBranch', $fdAccount->id) }}" method="POST" class="mt-2 px-3">
                    @csrf
                    @method('PUT')

                    <label for="branch_id" class="block uppercase">Branch</label>
                    <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                        <select name="branch_id" id="branch_id"
                            class="w-full rounded-10 border px-3 py-3 bg-secondary/5 dark:bg-bg3 dark:text-white">
                            <option value="">Select Branch</option>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"
                                {{ $fdAccount->branch_id == $branch->id ? 'selected' : '' }}>
                                {{ $branch->branch_name }}
                            </option>
                            @endforeach
                        </select>
                        <button type="submit" class="block btn-primary">Update</button>
                    </div>
                </form>

                <!--Advisor/ Staff-->
                <form action="" class="mt-2 px-3">
                    <label for="" class="block uppercase">Advisor/ Staff</label>
                    <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                        <select class="w-full rounded-10 border  px-3 py-3  bg-secondary/5
       dark:bg-bg3 dark:text-white">
                            <option>Select Advisor/ Staff</option>

                            <option>Option 2</option>
                        </select>

                        <input type="button" value="update" class="block  btn-primary">

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
                        <select class="w-full rounded-10 border  px-3 py-3  bg-secondary/5
       dark:bg-bg3 dark:text-white">
                            <option>Select Commission Chart</option>

                            <option>Option 2</option>
                        </select>

                        <input type="button" value="update" class="block  btn-primary">

                    </div>
                </form>
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
                                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">Scheme Name</td>
                                <td class="px-4 py-2 text-right md:text-left">{{ $fdAccount->fdscheme->scheme_name??'NA'}}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Scheme Code</td>
                                <td class="px-4 py-2 text-right md:text-left">{{ $fdAccount->fdscheme->scheme_name}}{{ $fdAccount->fdscheme->id}}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Minimum Locking Period</td>
                                <td class="px-4 py-2 text-right md:text-left">{{ $fdAccount->fdscheme->lock_in_period ?? 0}}Months</td>
                            </tr>

                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Interest Locking Period</td>
                                <td class="px-4 py-2 text-right md:text-left">{{ $fdAccount->fdscheme->interest_lock_in ?? 0}} Months</td>
                            </tr>

                            <tr class="bg-gray-50 dark:bg-bg3">
                                <td class="font-bold px-4 py-2 uppercase">Bonus Rate</td>
                                <td class="px-4 py-2  text-right md:text-left">{{ $fdAccount->fdscheme->bonus_rate ?? 0.0}} %</td>
                            </tr>
                            <tr class="bg-gray-50 dark:bg-bg3">
                                <td class="font-bold px-4 py-2 uppercase">Cancellation Charges</td>
                                <td class="px-4 py-2  text-right md:text-left">₹ {{ $fdAccount->fdscheme->cancellation_charge ?? 0}}</td>
                            </tr>
                            <tr class="bg-gray-50 dark:bg-bg3">
                                <td class="font-bold px-4 py-2 uppercase">Penal Charges (%)</td>
                                <td class="px-4 py-2   text-right md:text-left">{{ $fdAccount->fdscheme->penal_charge ?? 0.0}} %</td>
                            </tr>
                            <tr class="bg-gray-50 dark:bg-bg3">
                                <td class="font-bold px-4 py-2 uppercase">Min. Amount</td>
                                <td class="px-4 py-2  text-right md:text-left">₹ {{ $fdAccount->fdscheme->min_amount ?? 0}}</td>
                            </tr>

                        </tbody>
                    </table>


                    <!-- Table Wrapper  -->
                    <div class="overflow-x-auto mt-5  bg-white dark:bg-bg3">
                        <table class="min-w-full text-sm ">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th colspan="4" class="px-4 py-3 text-center text-lg dark:text-gray-50   font-semibold text-gray-800 border-b">
                                        INTEREST CHART INFO
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2" class="px-4 py-2 text-center font-semibold text-gray-700 border-b">DAYS</th>
                                    <th rowspan="2" class="px-4 py-2 text-center font-semibold text-gray-700 border-b">
                                        INTEREST RATE (%) (ANNUAL)
                                    </th>
                                    <th rowspan="2" class="px-4 py-2 text-center font-semibold text-gray-700 border-b">
                                        SRCTZN INTEREST RATE (%)
                                    </th>
                                </tr>
                                <tr>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-700 border-b">FROM</th>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-700 border-b">TO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fdSlabs as $slab)
                                <tr class="text-center border-t">
                                    <td class="px-3 py-2">{{ $slab->day_from }}</td>
                                    <td class="px-3 py-2">{{ $slab->day_to }}</td>
                                    <td class="px-3 py-2">{{ $slab->interest_rate }} %</td>
                                    <td class="px-3 py-2">{{ $slab->sr_citizen_rate }} %</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


            <!--FD  Maturity Info-->
            <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                    onclick="this.nextElementSibling.classList.toggle('hidden')">
                    <h3 class="text-lg font-semibold uppercase">FD Maturity Info</h3>
                </div>
                <!-- Body -->
                <div class="overflow-x-auto mt-5">
                    <table class="w-full border-collapse rounded-lg overflow-hidden shadow-md bg-white dark:bg-bg3">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                            <tr>
                                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">Maturity Date</td>
                                <td class="px-4 py-2 text-right md:text-left">{{$fdAccount->maturity_date}}</td>
                            </tr>

                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Principal Amount (A)</td>
                                <td class="px-4 py-2 text-right md:text-left">₹ {{$fdAccount->fd_amount}}</td>
                            </tr>

                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Total Interest (B)</td>
                                <td class="px-4 py-2 text-right md:text-left">₹ {{$totalInterest}}</td>
                            </tr>

                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Total TDS Deducted (C)</td>
                                <td class="px-4 py-2 text-right md:text-left">₹ {{$tds}}</td>
                            </tr>

                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Maturity Bonus Amount (D)</td>
                                <td class="px-4 py-2 text-right md:text-left">₹ {{$bonus}}</td>
                            </tr>

                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Maturity Amount (A + B + D)</td>
                                <td class="px-4 py-2 text-right md:text-left">₹ {{$maturityAmount}}</td>
                            </tr>

                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Net Maturity Amount (A + B + D - C)</td>
                                <td class="px-4 py-2 text-right md:text-left">₹ {{$netMaturityAmount}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <!--FD Info-->

            <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                    onclick="this.nextElementSibling.classList.toggle('hidden')">
                    <h3 class="text-lg font-semibold uppercase">FD Info</h3>

                </div>

                <!-- Body -->

                <div class="overflow-x-auto mt-5">
                    <table class="w-full border-collapse rounded-lg overflow-hidden shadow-md bg-white dark:bg-bg3">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            <tr>
                                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">Interest Credited</td>
                                <td class="px-4 py-2 text-right md:text-left">₹ {{ number_format($fdAccount->interest_credited ?? 0, 2) }}</td>
                            </tr>

                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Interest Released</td>
                                <td class="px-4 py-2 text-right md:text-left">₹ {{ number_format($fdAccount->interest_released ?? 0, 2) }}</td>
                            </tr>

                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">TDS Deducted</td>
                                <td class="px-4 py-2 text-right md:text-left">{{ number_format($fdAccount->tds_deducted ?? 0, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <!--FD  Branch Info-->

            <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                    onclick="this.nextElementSibling.classList.toggle('hidden')">
                    <h3 class="text-lg font-semibold uppercase">FD Branch Info</h3>

                </div>

                <!-- Body -->

                <div class="overflow-x-auto mt-5">
                    <table class="w-full border-collapse rounded-lg overflow-hidden shadow-md bg-white dark:bg-bg3">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                            <tr>
                                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">Branch</td>
                                <td class="px-4 py-2 text-right md:text-left">{{$fdAccount->branch->branch_name}}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Joint Account</td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    @if(!empty($fdAccount->joint_member_id))
                                    <span class="text-green-600 font-semibold">Yes</span>
                                    @else
                                    <span class="text-red-600 font-semibold">No</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>



            </div>

        </div>

    </div>


    @endsection
    <script>
        // Label update on toggle
        document.querySelectorAll('.slider-toggle').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const label = document.getElementById(this.dataset.labelId);
                label.textContent = this.checked ? 'ON' : 'OFF';
            });

            // Initialize label on page load
            toggle.dispatchEvent(new Event('change'));
        });
    </script>