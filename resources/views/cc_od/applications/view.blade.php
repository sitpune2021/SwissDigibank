@extends('layout.main')
@section('content')
<style>
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
            <h1 class="text-2xl uppercase font-semibold">Loan AGAINSTS Application - 00591 </h1>
        </div>
    </div>

    <div class="flex flex-wrap gap-3">

        <a href="{{route('gold-loan.applications.view-buttons.show-emi-chart')}}" class="btn-primary uppercase px-2 py-2 rounded-10 ">
            Show Emi Chart
        </a>

        <a href="{{route('gold-loan.applications.view-buttons.col_process_fee')}}" class="btn-warning  uppercase px-2 py-2 rounded-10 ">
            Collect Processing Fee
        </a>
        <a href="{{route('gold-loan.applications.view-buttons.disburse-setting')}}" class="btn-warning  uppercase px-2 py-2 rounded-10 ">
            DISBURSE SETTINGS
        </a>

        <a href="{{route('gold-loan.applications.view-buttons.show-emi-chart')}}" class="btn-primary   px-2 py-2 rounded-10 ">
            REGISTER eNACH ( Fidypay )
        </a>


        <div class="relative inline-block text-left">
            <!-- Button -->
            <button type="button" class="btn-secondary px-2 py-2 rounded-10 flex items-center gap-2"
                onclick="toggleDropdown('printDropdown')">
                <i class="las la-print text-lg"></i>
                PRINT DOCUMENTS
                <i class="las la-angle-down text-xs"></i>
            </button>

            <!-- Dropdown Menu -->
            <div id="printDropdown"
                class="hidden absolute right-0 mt-2 w-56 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                <div class="py-1">
                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="las la-print text-secondary"></i> APPLICATION FORM
                    </a>
                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="las la-print text-secondary"></i> EMI SCHEDULE CHART
                    </a>
                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="las la-print text-secondary"></i> SANCTION LETTER
                    </a>
                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="las la-print text-secondary"></i> LOAN AGREEMENT
                    </a>
                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="las la-print text-secondary"></i> DISBURSE LETTER
                    </a>
                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="las la-print text-secondary"></i> PROMISSORY NOTE
                    </a>
                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="las la-print text-secondary"></i> LETTER OF UNDERTAKING
                    </a>
                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="las la-print text-secondary"></i> LETTER OF EVIDENCING
                    </a>
                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="las la-print text-secondary"></i> GUARANTOR AGREEMENT
                    </a>
                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="las la-print text-secondary"></i> JURISDICTION ACK LETTER
                    </a>

                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="las la-print text-secondary"></i> INDEMNIFICATION LETTER
                    </a>

                </div>
            </div>
        </div>

    </div>


    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">

        <!-- Left: Details -->
        <div class=" w-full  overflow-hidden">
            <div class="overflow-x-auto box rounded-lg dark:bg-bg3 p-2 bg-white shadow-md">
                <div class="text-end p-3">
                   <a href="{{ route('bussiness.applications.edit', $application->id) }}" class="p-2 btn-primary">
                        <i class="las la-pencil-alt"></i>
                    </a>

                    <!-- <a href="#" class=" p-2 btn-error">
                        <i class="las la-trash-alt"></i>
                    </a> -->

                </div>
                <table class="min-w-full text-sm text-left border-collapse">
                    <tbody class="divide-y divide-gray-200">
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 w-1/3">Member</td>
                            <td class="px-4 py-2">
                                <a href="{{ url('members/member/'. $application->member->id) }}" 
                                class="text-primary capitalize hover:underline">
                                {{ $application->member->member_no }} - {{ $application->member->member_info_first_name }}
                                </a>
                            </td>
                        </tr>

                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2">1st Co-Applicant Member</td>
                            <td class="px-4 py-2 capitalize text-primary">
                                {{ optional($application->coApplicant1)->member_no }} - {{ optional($application->coApplicant1)->member_info_first_name }}
                            </td>
                        </tr>

                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2">Guarantor 1 Member</td>
                            <td class="px-4 py-2 capitalize text-primary">
                                {{ optional($application->guarantor1)->member_no }} - {{ optional($application->guarantor1)->member_info_first_name }}
                            </td>
                        </tr>

                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2">Application No.</td>
                            <td class="px-4 py-2">{{ $application->id }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2">Application Date</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($application->application_date)->format('d/m/Y') }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2">Loan Account No.</td>
                            <td class="px-4 py-2 text-primary">00459</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2">Gold Loan Scheme</td>
                           <td class="text-start !py-5 px-6">
                                {{ $application->scheme->scheme_name ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2">Amount Approved</td>
                            <td class="px-4 py-2">₹ 100,000.00</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2">Status</td>
                            <td class="px-4 py-2">
                                <span
                                    class="block w-32 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary ">DISBURSED</span>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">

                <div class="border-b flex items-center bg-secondary/5 justify-between px-4 py-2 rounded-10 ">
                    <h3 class="text-lg font-semibold text-black  capitalize">
                        Disbursement Settings
                    </h3>
                    <div class="">


                        <button type="button" class="p-1 rounded transition"
                            onclick="toggleSection(this, 'goldLoanSchemeInfo')">
                            <span class="toggle-icon text-lg font-bold">−</span>
                        </button>
                    </div>
                </div>
                <!-- Body -->
                <div class="overflow-x-auto mt-5 " id="goldLoanSchemeInfo">
                    <table class="w-full border-collapse rounded-lg overflow-hidden  bg-white dark:bg-bg3">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3">
                                    Disbursement Date
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    24/09/2025
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">First EMI Date </td>
                                <td class="px-4 py-2 text-right md:text-left"> 24/07/2026</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Collect Processing Fee Separately
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-primary/10 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16"> Yes </span>
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Collect Stamp Duty Fee Separately
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-error/10 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16"> No </span>
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-bold px-4 py-2"> Collect Insurance Fee Separately</td>
                                <td class="px-4 py-2  text-right md:text-left">
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-error/10 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16"> No </span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    Collect Adv. Interest Separately
                                </td>
                                <td class="px-4 py-2  text-right md:text-left">
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-error/10 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16"> No </span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">Collect Off Adv. EMI Interest Separately</td>
                                <td class="px-4 py-2   text-right md:text-left">
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-error/10 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16"> No </span>
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>

            <!--Cibil Info-->
            <div class="box shadow-md mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">

                <div class="border-b flex items-center bg-secondary/5 text-black justify-between px-4 py-2 rounded-10 ">
                    <h3 class="text-lg font-semibold text-black  capitalize">Cibil Info</h3>
                    <div class=" flex gap-3">
                        <a href="{{route('gold-loan.applications.upload-cibil-score')}}"
                            class="p-2 btn-primary">
                            <i class="las la-upload"></i>

                        </a>
                        <!-- Modal Background (hidden by default) -->
                        <div id="creditScoreModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <!-- Modal Container -->
                            <div class="bg-white rounded-lg shadow-xl min-w-full max-w-5xl mx-4">

                                <!-- Modal Header -->
                                <div class="flex items-center justify-between px-4 py-3 bg-blue-600 rounded-t-lg">
                                    <h2 class="text-white text-lg font-semibold">Credit Score</h2>
                                    <button class="text-white hover:text-gray-200" onclick="closeModal()">
                                        ✕
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="p-6">
                                    <x-credit-score-details />
                                </div>
                            </div>
                        </div>
                        <button type="button" class="p-1 rounded transition" onclick="toggleSection(this, 'cibilInfo')">
                            <span class="toggle-icon text-lg font-bold">−</span>
                        </button>
                    </div>
                </div>


                <!-- Body -->
                <div class="p-4 overflow-x-auto" id="cibilInfo">
                    <table class="w-full text-sm text-left">
                        <tbody class="divide-y divide-gray-200">

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 w-1/3">No Cibil Data Found</td>
                                <td class="px-4 py-2"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>




            <div class="overflow-x-auto  md:block box mt-4 shadow-md rounded-lg">
                <table class="w-full text-md  whitesapce-nowrap">
                    <thead class="bg-gray-100  text-start">
                        <tr class="text-start">
                            <th class="px-2 py-2 font-semibold text-start text-gray-700">Status</th>
                            <th class="px-2 py-2 font-semibold text-start text-gray-700">Remarks</th>
                            <th class="px-2 py-2 font-semibold text-start text-gray-700">Updated at</th>
                            <th class="px-2 py-2 font-semibold text-start text-gray-700">Approved By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t border-b">
                            <td class="px-2 py-2 text-gray-800 capitalize"> approved</td>
                            <td class="px-2 py-2 text-gray-800 capitalize">—</td>
                            <td class="px-2 py-2 text-gray-800">21/08/2025 </td>
                            <td class="px-2 py-2 text-gray-800 capitalize">Test Test</td>
                        </tr>
                    </tbody>
                </table>
            </div>







            <!--Security Deposits-->
            <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">

                <div
                    class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer">
                    <h3 class="text-lg font-semibold capitalize">Security Deposits</h3>
                    <div class="">


                        <button type="button" class="p-1 rounded transition"
                            onclick="toggleSection(this, 'SecurityDeposits')">
                            <span class="toggle-icon text-lg font-bold">−</span>
                        </button>
                    </div>
                </div>

                <!-- Body -->
                <div class="p-4" id="SecurityDeposits">
                    <div class="overflow-x-auto text-center mt-5">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full  rounded-lg text-sm">
                                <thead class="bg-secondary/5">
                                    <tr>
                                        <th class="px-3 py-2 text-left">Item Type</th>
                                        <th class="px-3 py-2 text-left">Name</th>
                                        <th class="px-3 py-2 text-center">Qty</th>
                                        <th class="px-3 py-2 text-center">Val./gm (₹)</th>
                                        <th class="px-3 py-2 text-center">Gross Weight (gm)</th>
                                        <th class="px-3 py-2 text-center">Net Weight (gm)</th>
                                        <th class="px-3 py-2 text-center">Tunch (%)</th>
                                        <th class="px-3 py-2 text-center">Fine Weight (gm)</th>
                                        <th class="px-3 py-2 text-center">Total Val. (₹)</th>
                                        <th class="px-3 py-2 text-center">Image</th>
                                        <th class="px-3 py-2 text-center">Status</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-3 py-2">Gold Jewellery</td>
                                        <td class="px-3 py-2">abc</td>
                                        <td class="px-3 py-2 text-center">3</td>
                                        <td class="px-3 py-2 text-center">20000.0</td>
                                        <td class="px-3 py-2 text-center">3.0</td>
                                        <td class="px-3 py-2 text-center">2.0</td>
                                        <td class="px-3 py-2 text-center">100.0</td>
                                        <td class="px-3 py-2 text-center">2.0</td>
                                        <td class="px-3 py-2 text-center">40000.0</td>
                                        <td class="px-3 py-2 text-center">
                                            <!-- Upload Button -->
                                            <a class="btn-primary p-1">
                                                <i class="las la-upload"></i>
                                            </a>
                                        </td>
                                        <td class="px-3 py-2 text-center">Mortgage</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>



            <!--documents-->
            <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="border-b flex items-center bg-secondary/5 justify-between px-4 py-2 rounded-10 ">
                    <h3 class="text-lg font-semibold text-black  capitalize">
                        Documents

                    </h3>
                    <div class="">
                        <a href="{{route('gold-loan.applications.upload_documents')}}" class="btn-primary p-1 pointer">
                            <i class="las la-upload y"></i>
                        </a>

                        <button type="button" class="p-1 rounded transition" onclick="toggleSection(this, 'Documents')">
                            <span class="toggle-icon text-lg font-bold">−</span>
                        </button>
                    </div>
                </div>
                <!-- Body -->
                <div class="p-4" id="Documents">
                    <div class="overflow-x-auto">
                        <p class="capitalize">No documents found</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Right: Settings -->
        <div class=" w-full ">


            <div class="flex flex-row gap-4 p-3 dark:bg-bg3  mt-4 rounded-10">
                <div class="w-full bg-white dark:bg-bg3 p-4 rounded-10 shadow-md border border-gray-200">
                    <div class="flex justify-center gap-2  border-gray-200 px-4 py-3 bg-gray-50 rounded-t-2xl border-b">

                        <h3 class="font-semibold  text-center sm:text-lg">
                            CIBIL SCORE
                        </h3>
                    </div>

                    <div
                        class="flex justify-center items-center mt-3 px-4 py-6 text-2xl sm:text-3xl font-semibold text-red-500">
                        <label class="cursor-pointer">
                            <button type="button" class="btn-primary px-2 py-1 rounded-10">
                                <i class="las la-upload y"></i>
                                <span>UPLOAD</span>
                            </button>
                        </label>
                    </div>
                </div>
                <div class="w-full bg-white dark:bg-bg3 p-4 rounded-10 shadow-md border border-gray-200">
                    <div class="flex justify-center gap-2 border-b border-gray-200 px-4 py-3 bg-gray-50 rounded-t-2xl">

                        <h3 class="font-semibold  text-center sm:text-lg">
                            PROCESSING FEE
                        </h3>
                    </div>

                    <div class="flex justify-center items-center px-4 py-6 mt-3 text-2xl sm:text-3xl font-semibold ">
                        <label class="cursor-pointer">
                            <h3>0.0</h3>
                        </label>
                    </div>
                </div>
            </div>

            <!--SMS SETTINGS-->
            <div class="box dark:bg-bg3 mt-3 border-gray-200 shadow-md rounded-lg">
                <!-- Header -->
                <div class="px-4 py-3">
                    <h3 class="text-lg border-b font-semibold text-black">SMS SETTINGS</h3>
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
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Gold Loan Scheme Info-->
            <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">

                <div class="border-b flex items-center bg-secondary/5 justify-between px-4 py-2 rounded-10 ">
                    <h3 class="text-lg font-semibold text-black  capitalize">
                        Gold Loan Scheme Info
                    </h3>
                    <div class="">


                        <button type="button" class="p-1 rounded transition"
                            onclick="toggleSection(this, 'goldLoanSchemeInfo')">
                            <span class="toggle-icon text-lg font-bold">−</span>
                        </button>
                    </div>
                </div>
                <!-- Body -->
                <div class="overflow-x-auto mt-5 " id="goldLoanSchemeInfo">
                    <table class="w-full border-collapse rounded-lg overflow-hidden  bg-white dark:bg-bg3">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

    <tr class="border-b">
        <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3">Scheme Name</td>
        <td class="px-4 py-2 text-right md:text-left">
            {{ $application->scheme->scheme_name ?? '-' }}
        </td>
    </tr>

    <tr class="border-b">
        <td class="font-semibold px-4 py-2">Scheme Code</td>
        <td class="px-4 py-2 text-right md:text-left">
            {{ $application->scheme->scheme_code ?? '-' }}
        </td>
    </tr>

    <tr class="border-b">
        <td class="font-semibold px-4 py-2">Maximum Loan Amount</td>
        <td class="px-4 py-2 text-right md:text-left">
            ₹ {{ $application->scheme->max_loan_amount ?? 0 }}
        </td>
    </tr>

    <tr class="border-b">
        <td class="font-semibold px-4 py-2">Maximum Loan Limit</td>
        <td class="px-4 py-2 text-right md:text-left">
            {{ $application->scheme->max_loan_limit ?? 0 }} %
        </td>
    </tr>

    <tr class="border-b">
        <td class="font-bold px-4 py-2">Interest Type</td>
        <td class="px-4 py-2 text-right md:text-left">
            {{ $application->scheme->interest_type ?? '-' }}
        </td>
    </tr>

    <tr class="border-b">
        <td class="font-bold px-4 py-2">Interest Rate</td>
        <td class="px-4 py-2 text-right md:text-left">
            {{ $application->scheme->annual_interest_rate ?? 0 }} %
        </td>
    </tr>

    <tr class="border-b">
        <td class="font-bold px-4 py-2">Processing Fee</td>
        <td class="px-4 py-2 text-right md:text-left">
            ₹ {{ $application->scheme->processing_fee ?? 0 }}
        </td>
    </tr>

</tbody>

                    </table>
                </div>
            </div>


            <!--Gold Loan Application Info-->
            <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">

                <div class="border-b flex items-center bg-secondary/5 justify-between px-4 py-2 rounded-10 ">
                    <h3 class="text-lg font-semibold text-black  capitalize">
                        Gold Loan Application Info

                    </h3>
                    <div class="">


                        <button type="button" class="p-1 rounded transition"
                            onclick="toggleSection(this, 'goldLoanAppInfo')">
                            <span class="toggle-icon text-lg font-bold">−</span>
                        </button>
                    </div>
                </div>
                <!-- Body -->
                <div class="overflow-x-auto mt-5 " id="goldLoanAppInfo">
                    <table class="w-full border-collapse rounded-lg overflow-hidden  bg-white dark:bg-bg3">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3">
                                    Branch
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    Kalyanadurgam
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">Amount Requested</td>
                                <td class="px-4 py-2 text-right md:text-left">₹ 34,000.00</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Amount Approvable
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    ₹ 36,000.00
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Amount Approved
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    ₹ 34,000.00
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    Interest Amount
                                </td>
                                <td class="px-4 py-2  text-right md:text-left">
                                    ₹ 5,525.00
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    Annual Interest Rate
                                </td>
                                <td class="px-4 py-2  text-right md:text-left">
                                    19.5 %
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    Annualized Percentage Rate (APR)
                                </td>
                                <td class="px-4 py-2   text-right md:text-left">
                                    0 % | %
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    Credit Period
                                </td>
                                <td class="px-4 py-2   text-right md:text-left">
                                    1 Days
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    Total Amount to Recover
                                </td>
                                <td class="px-4 py-2   text-right md:text-left">
                                    ₹ 39,525.00
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    Tenure of Loan
                                </td>
                                <td class="px-4 py-2   text-right md:text-left">
                                    10 MONTHS
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    Collect Principal Amount as EMI
                                </td>
                                <td class="px-4 py-2   text-right md:text-left">
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">no</span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    Processing Fee
                                </td>
                                <td class="px-4 py-2   text-right md:text-left">
                                    ₹ 118.00 (Incl. 18.0 % GST)
                                </td>
                            </tr>
                            <tr class="">
                                <td class="font-bold px-4 py-2">
                                    Purpose of Loan
                                </td>
                                <td class="px-4 py-2   text-right md:text-left">
                                    Property
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>







    <script>
        function toggleDropdown(id) {
            document.getElementById(id).classList.toggle("hidden");
        }

        // Close dropdown if clicked outside
        window.addEventListener("click", function(e) {
            const dropdown = document.getElementById("printDropdown");
            if (!e.target.closest("button") && !e.target.closest("#printDropdown")) {
                dropdown.classList.add("hidden");
            }
        });
    </script>





    <script>
        // <!-- collapsed logic + - button-->

        function toggleSection(button, sectionId) {
            const section = document.getElementById(sectionId);
            const icon = button.querySelector('.toggle-icon');

            section.classList.toggle('hidden');
            icon.textContent = section.classList.contains('hidden') ? '+' : '−';
        }
    </script>

    @endsection