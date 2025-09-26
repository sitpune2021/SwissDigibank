@extends('layout.main')

@section('content')

<head>
    <style>
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
</head>
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-2xl font-semibold">LOAN AGAINST PROPERTY APPLICATION - 100136</h1>
            <p class="text-gray-500">
                <a href="#" class="text-gray-500">Loan Against Property Application</a> >
                <a href="#" class="text-gray-500">100136</a>
            </p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Menu Buttons -->
    <div class="flex flex-wrap gap-2">

        <a href="#" class="btn-warning px-2 py-2 rounded-10">
            SHOW EMI CHART
        </a>

        <a href="#" class="btn-secondary px-2 py-2 rounded-10">
            COLLECT PROCESSING FEE
        </a>

        <a href="#" class="btn-primary px-2 py-2 rounded-10">
            DISBUSRSE SETTINGS
        </a>

        <a href="#" class="btn-primary px-2 py-2 rounded-10">
            REGISTER eNACH (Fidypay)
        </a>

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
                <ul class="py-2 whitespace-nowrap">
                    <li>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="las la-print text-secondary"></i>
                            APPLICATION FORM</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="las la-print text-secondary"></i>
                            EMI SCHEDULE CHART</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="las la-print text-secondary"></i>
                            SANCTION LETTER</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="las la-print text-secondary"></i>
                            LOAN AGREEMENT</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="las la-print text-secondary"></i>
                            DISBURSE LETTER</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="las la-print text-secondary"></i>
                            PROMISSORY NOTE</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="las la-print text-secondary"></i>
                            LETTER OF UNDERTAKING</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="las la-print text-secondary"></i>
                            LETTER EVIDENCING</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="las la-print text-secondary"></i>
                            JURISDICATION ACK LETTER</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="las la-print text-secondary"></i>
                            INDEMNIFICATION LETTER</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="las la-print text-secondary"></i>
                            RM MORTGAGE DEED</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="las la-print text-secondary"></i>
                            EM MORTGAGE DEED</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <!-- Left: Details -->
        <div class="w-full overflow-hidden">
            <!--MEMBER DETAILS-->
            <div class="bg-white shadow-md  dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <tbody class="divide-y divide-gray-200">

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">Member Name</td>
                                <td class="px-4 py-2">
                                    demo name Akash more
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">1st Co-Applicant Member</td>
                                <td class="px-4 py-2">
                                    demo name Ajay more
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">Application No.</td>
                                <td class="px-4 py-2">100136</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">Application Date</td>
                                <td class="px-4 py-2">
                                    18/09/2025
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">Property Loan Scheme</td>
                                <td class="px-4 py-2">
                                    secure home scheme
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">Amount Approved</td>
                                <td class="px-4 py-2">
                                    ₹ 100,000.00
                                </td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-4 py-2">Status</td>
                                <td class="px-4 py-2">
                                    <span class="block w-20 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary">
                                        Approve
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="p-4 bg-white dark:bg-bg3 rounded-md shadow-md  mt-4 border-gray-200">

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
                            <td class="px-3 py-2">Approved</td>
                            <td class="px-3 py-2"></td>
                            <td class="px-3 py-2">18/02/2025</td>
                            <td class="px-3 py-2">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="box bg-white dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between bg-primary text-white  rounded-t-lg px-2 py-2 cursor-pointer">
                    <h3 class="text-lg font-semibold">Cibil Info</h3>
                    <div class="flex items-center gap-2">
                        <div x-data="{ openCibilModal: false }">
                            <!-- Upload Trigger -->
                            <button
                                @click="openCibilModal = true"
                                class="rounded-3xl text-outline ">
                                <i class="las la-upload"></i>
                            </button>

                            <!-- Modal -->
                            <div
                                x-show="openCibilModal"
                                x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">

                                <div class="box dark:bg-bg3 rounded-lg shadow-lg w- w-1/2 max-w-2xl">

                                    <!-- Header -->
                                    <div class="flex justify-between items-center bg-primary text-white px-4 py-3 rounded-t-lg">
                                        <h2 class="text-lg font-semibold">Credit Score</h2>
                                        <button @click="openCibilModal = false">
                                            <i class="las la-times text-xl"></i>
                                        </button>
                                    </div>

                                    <!-- Body (your component) -->
                                    <div class="p-6">
                                        <x-credit-score-details />
                                    </div>

                                    <!-- Footer -->
                                    <div class="flex justify-center p-4 border-t">
                                        <button
                                            type="submit"
                                            class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-md font-medium">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Toggle Button -->
                        <button
                            class="p-1 rounded transition"
                            onclick="toggleSection(this)">
                            <span class="toggle-icon text-lg font-bold">-</span>
                        </button>
                    </div>
                </div>
                <!-- Body -->
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm  text-gray-700 rounded-b-md">
                            <thead>
                                <tr class="border-b border-gray-200 text-center">
                                    <th class="px-3 py-2">Cibil Type</th>
                                    <th class="px-3 py-2">Cibil Score</th>
                                    <th class="px-3 py-2">Report Date</th>
                                    <th class="px-3 py-2">Document</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td class="px-3 py-2">Transunion</td>
                                    <td class="px-3 py-2">777</td>
                                    <td class="px-3 py-2">18/09/2025</td>
                                    <td class="px-3 py-2">No Document Present</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!--documents-->
            <div class="box bg-white dark:bg-bg3 shadow-md mt-5 mb-4 rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between bg-secondary/5 text-black  rounded-10 px-2 py-2 cursor-pointer">
                    <h3 class="text-lg font-semibold">DOCUMENTS</h3>
                    <div class="flex items-center gap-2">
                        <button class=" bg-white px-3 py-2 rounded-full text-primary"><i class="las la-upload"></i></button>
                        <!-- Toggle Button -->
                        <button
                            class="p-1 rounded transition"
                            onclick="toggleSection(this)">
                            <span class="toggle-icon text-lg font-bold">-</span>
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
        </div>


        <!-- Right: Settings -->
        <div class=" w-full ">
             
                <div class="flex flex-row gap-4 p-3 dark:bg-bg3   rounded-10">
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
 

            <!-- SETTINGS -->
            <div class="box dark:bg-bg3 border border-gray-200 shadow-md rounded-lg">
                <!-- Header -->
                <div class="px-4 py-3">
                    <h3 class="text-lg border-b font-semibold text-black"> SMS SETTINGS</h3>
                </div>
                <!-- Body -->
                <div class=" flex p-4 overflow-x-auto">
                    <span class="font-semibold text-center align-middle px-4 py-3">SMS</span>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="smsToggle" class="sr-only peer slider-toggle" data-label-id="smsLabel">
                        <div class="relative">
                            <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6"></div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Scheme Info -->
            <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg mt-4">
                <!-- Header -->
                <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                    <h3 class="text-black font-semibold text-lg">Property Loan Scheme Info</h3>

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
                                <td class="px-3 py-2">DAILY HOME LOAN</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Scheme Code</td>
                                <td class="px-3 py-2">DAILY HOME LOAN</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Maximum Loan Amount</td>
                                <td class="px-3 py-2">₹ 100000.0</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Maximum Loan Limit</td>
                                <td class="px-3 py-2">50.0 %</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Interest Type</td>
                                <td class="px-3 py-2">Reducing EMI</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Interest Rate</td>
                                <td class="px-3 py-2">20.0 %</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Fore Closure Charges</td>
                                <td class="px-3 py-2">5.0 ₹</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Processing Fee</td>
                                <td class="px-3 py-2">
                                    2.0 %
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Stamp Duty Fee</td>
                                <td class="px-3 py-2">
                                    2.0 %
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Insurance Charges</td>
                                <td class="px-3 py-2">
                                    0.0 %
                                </td>
                            </tr>
                            <tr class="border-b text-center border-gray-200 text-center">
                                <td class="font-semibold px-3 py-2" colspan="2">Per EMI Charges</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">SMS Charges</td>
                                <td class="px-3 py-2">
                                    5.0 ₹
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Fuel Charges</td>
                                <td class="px-3 py-2">
                                    5.0 ₹
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Stationary Charges</td>
                                <td class="px-3 py-2">
                                    5.0 ₹
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Maintenance Charges</td>
                                <td class="px-3 py-2">
                                    5.0 ₹
                                </td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-3 py-2">Collection Charges</td>
                                <td class="px-3 py-2">
                                    5.0 ₹
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

            <!--  Application Info -->
            <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg mt-4">
                <!-- Header -->
                <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                    <h3 class="text-black font-semibold text-lg">Property Loan Application Info</h3>

                    <!-- Toggle Button -->
                    <button
                        class="p-1 rounded transition"
                        onclick="toggleSection(this)">
                        <span class="toggle-icon text-lg font-bold">+</span>
                    </button>

                </div>

                <!-- Content (Initially Hidden) -->
                <div class="overflow-x-auto p-4 hidden">
                    <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2 w-1/3">Branch</td>
                                <td class="px-3 py-2">Kalyanadurgam</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Amount Requested</td>
                                <td class="px-3 py-2">₹ 10,000.00</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Amount Approvable</td>
                                <td class="px-3 py-2"> ₹ 61,562.00</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Amount Approved</td>
                                <td class="px-3 py-2">₹ 10,000.00</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Interest Amount</td>
                                <td class="px-3 py-2"> ₹ 1,117.00</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Annual Interest Rate</td>
                                <td class="px-3 py-2">20.0 %</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Annualized Percentage Rate (APR)</td>
                                <td class="px-3 py-2"> 34.24 % | %</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Credit Period</td>
                                <td class="px-3 py-2">
                                    1 Days
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Total Amount to Recover</td>
                                <td class="px-3 py-2">
                                    ₹ 11,117.00
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">EMI Payout</td>
                                <td class="px-3 py-2">
                                    MONTHLY
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">EMI Amount</td>
                                <td class="px-3 py-2">
                                    ₹ 956.00
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">No. of EMIs</td>
                                <td class="px-3 py-2">
                                    12
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Tenure of Loan</td>
                                <td class="px-3 py-2">
                                    12 MONTHS
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Loan In Ratio</td>
                                <td class="px-3 py-2">
                                    <span class="block w-20 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error">
                                        No
                                    </span>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Processing Fee</td>
                                <td class="px-3 py-2">
                                    ₹ 236.00 (Incl. 18.0 % GST)
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Stamp Duty Fee</td>
                                <td class="px-3 py-2">
                                    ₹ 236.00 (Incl. 18.0 % GST)
                                </td>
                            </tr>
                            <tr>
                                <td class="font-semibold px-3 py-2">Purpose of Loan</td>
                                <td class="px-3 py-2">
                                    123
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

    <!-- 🔹 Security Deposits Section -->
    <div class="box dark:bg-bg3 shadow rounded-2xl overflow-hidden border border-n30 dark:border-n500 mt-4">

        <!-- Header -->
        <div class="border-b border-n30 dark:border-n500 px-4 py-3">
            <h3 class="text-base font-semibold text-gray-700 dark:text-gray-200">SECURITY DEPOSITS</h3>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full  border-collapse">
                <thead>
                    <tr class="bg-secondary/5 text-black text-sm">
                        <th class="px-4 py-3 text-left">PROPERTY TYPE</th>
                        <th class="px-4 py-3 text-left">DOC NO</th>
                        <th class="px-4 py-3 text-left">REGISTRAR NAME</th>
                        <th class="px-4 py-3 text-left">SELLER NAME</th>
                        <th class="px-4 py-3 text-left">PLOT NO/ HOUSE NO</th>
                        <th class="px-4 py-3 text-left">TEHSIL</th>
                        <th class="px-4 py-3 text-left">DISTRICT</th>
                        <th class="px-4 py-3 text-left">AREA(SQ FT/ACRE)</th>
                        <th class="px-4 py-3 text-left">EXPECTED VALUE</th>
                        <th class="px-4 py-3 text-left">REGISTERED</th>
                    </tr>
                </thead>
                <tbody class="text-sm border-b">
                    <tr>
                        <td class="px-4 py-3">House</td>
                        <td class="px-4 py-3">12345666</td>
                        <td class="px-4 py-3">bhausaheb patil</td>
                        <td class="px-4 py-3">mayur kulkarni</td>
                        <td class="px-4 py-3">23/1/1</td>
                        <td class="px-4 py-3">pune</td>
                        <td class="px-4 py-3">pune</td>
                        <td class="px-4 py-3">675</td>
                        <td class="px-4 py-3 font-semibold">300,000.00</td>
                        <td class="px-4 py-3">
                            <span class="block w-20 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary">
                                Yes</span>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="font-semibold text-sm">
                        <td colspan="8" class="px-4 py-3 text-end">TOTAL VALUE</td>
                        <td colspan="2" class="px-4 py-3">300,000.00</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="box">


    </div>


</div>
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