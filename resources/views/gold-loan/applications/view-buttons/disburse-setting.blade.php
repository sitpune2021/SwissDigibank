@extends('layout.main')
@section('content')
    <div class="main-inner">

        <head>
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
            </style>
        </head>

        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col gap-2">
                <h1 class="text-2xl font-semibold">Gold Loan Application - Disburse Settings</h1>
            </div>
        </div>
        <div class="rounded-lg border-l-4 border-yellow-500 bg-warning p-4 mb-4">
            <h4 class="text-white font-semibold text-lg">Info</h4>
            <p class="text-sm md:text-base text-white mt-1">
                Please be aware that this action is irreversible. Once you set this value, you won't be able to change it at
                the time of disbursement. Please fill this information carefully.
            </p>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <!-- Left: Details -->
            <div class=" w-full  overflow-hidden">
                <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                    <form action="">
                        <!-- Header -->
                        <div class="px-4 py-3 ">
                            <h3 class="text-lg border-b mb-4 font-semibold text-black">Application No - {{ $application->id }}</h3>
                        </div>
                        <!-- Body -->

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4">
                                Loan Disbursement Date
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id="disbursalDate"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Loan Disbursement Date">

                        </div>
                        <div class="col-span-2 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg font-medium block mb-4">
                                First EMI Date
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id="emiDate"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="First EMI Date">
                        </div>
                        <hr>
                        <x-checkbox-calculator id="disburseSetting" name="disburse_setting"
                            label="Collect Processing Fee Separately"
                            sublabel="(Check this if you want to collect processing fee separately at the time of loan disbursement)" />
                        <hr>
                        <!-- Buttons -->
                        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                            <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                                UPDATE SETTINGS
                            </button>

                            <button class="btn-outline uppercase justify-center" type="reset">
                                <a href="#"> BACK</a>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Left: Details -->
            <div class=" w-full  overflow-hidden">
                <!--  Application Info -->
                <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg">
                    <!-- Header -->
                    <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                        <h3 class="text-black font-semibold text-lg">Gold Loan Application Info</h3>

                        <!-- Toggle Button -->
                        <button class="p-1 rounded transition" onclick="toggleSection(this)">
                            <span class="toggle-icon text-lg font-bold">+</span>
                        </button>

                    </div>

                    <!-- Content (Initially Hidden) -->
                    <div class="overflow-x-auto p-4 hidden">
                        <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">
                                    Application Date
                                </td>
                                <td class="px-4 py-2 text-right md:text-left uppercase">
                                    {{ $application->application_date  }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Application No.</td>
                                <td class="px-4 py-2 text-right md:text-left">{{ $application->id }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Member
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ $application->member->member_info_first_name }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Branch
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ $application->branch->branch_name }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    1st Co-Applicant Member
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ $application->member->member_info_first_name }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    2nd Co-Applicant Member
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ $application->member->member_info_first_name }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Amount Requested
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    ₹ {{ $application->loan_amount }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Amount Approvable
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    ₹ {{ $application->maximum_approvable_amount }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Amount Approved
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    ₹ {{ $application->loan_amount }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                   Interst Type
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    ₹ {{ $application->scheme->gold_loan_setting }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Annual Interest Rate
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    ₹ {{ $application->scheme->annual_interest_rate }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Credit Period
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    ₹ {{ $application->credit_period }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Tenure of Loan	
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    ₹ {{ $application->tenure_value }}
                                </td>
                            </tr>
                            
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Processing Fee
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    ₹ {{ $application->processing_fee }} (Incl. 18 % GST)
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Stamp Duty Fee
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    ₹ {{ $application->stamp_duty }} (Incl. 18 % GST)
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Insurance Fee
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    ₹ {{ $application->insurance_fee }} (Incl. 18 % GST)
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                   Fitness Fee
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    ₹ {{ $application->fitness_fee }} (Incl. 18 % GST)
                                </td>
                            </tr>
                            <tr>
                            <td class="font-semibold px-4 py-2">Application Status</td>
                            <td class="px-4 py-2">
                                @php
                                    $statusText = 'UNKNOWN';
                                    $statusClass = 'bg-gray-200 text-gray-600 border-gray-300';

                                    if ($application->status == 0) {
                                        $statusText = 'DRAFT';
                                        $statusClass = 'bg-gray-300 text-gray-700 border-gray-400';
                                    } elseif ($application->status == 1) {
                                        $statusText = 'APPROVED';
                                        $statusClass = 'bg-blue-200 text-blue-600 border-blue-300';
                                    } elseif ($application->status == 2) {
                                        $statusText = 'DISBURSEMENT';
                                        $statusClass = 'bg-green-200 text-green-600 border-green-300';
                                    } elseif ($application->status == 3) {
                                        $statusText = 'CANCELED';
                                        $statusClass = 'bg-red-200 text-red-600 border-red-300';
                                    }
                                @endphp

                                <span class="block w-32 rounded-[30px] border py-2 text-center text-xs {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>
                        </tr>                     
                        </tbody>
                        </table>
                    </div>
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
                        <p class="text-sm text-center font-semibold">TOTAL INTEREST RECOVERABLE - 5,525.00</p>
                        <p class="text-sm text-center font-semibold">TOTAL OTHER CHARGES RECOVERABLE - 0.00</p>
                        <div class="overflow-x-auto text-center mt-5">
                            <div class="w-full overflow-x-auto">
                                <table class="w-full  rounded-lg text-sm">
                                    <thead class="bg-secondary/5">
                                        <tr>
                                            <th class="px-3 py-2 text-left">NO</th>
                                            <th class="px-3 py-2 text-left">PRINCIPAL </th>
                                            <th class="px-3 py-2 text-center">INTEREST</th>
                                            <th class="px-3 py-2 text-center">OTHER CHRG.</th>
                                            <th class="px-3 py-2 text-center">EMI</th>
                                            <th class="px-3 py-2 text-center">INT. START DATE</th>
                                            <th class="px-3 py-2 text-center">DATE</th>
                                            <th class="px-3 py-2 text-center">DUE DATE</th>
                                            <th class="px-3 py-2 text-center">DUE PRINCIPAL</th>

                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-200">
                                        <tr class="bg-secondary/10 ">
                                            <td class="px-3 py-2 "></td>
                                            <td class="px-3 py-2 text-center"></td>
                                            <td class="px-3 py-2 text-center">5,525.00</td>
                                            <td class="px-3 py-2 text-center"></td>
                                            <td class="px-3 py-2 text-center"></td>
                                            <td class="px-3 py-2 text-center"></td>
                                            <td class="px-3 py-2 text-center"></td>
                                            <td class="px-3 py-2 text-center"></td>
                                            <td class="text-right">34,000.00</td>
                                        </tr>
                                        <tr>
                                            <td class="px-3 py-2 ">1</td>
                                            <td class="px-3 py-2 text-center">34,000.00</td>
                                            <td class="px-3 py-2 text-center">0.00</td>
                                            <td class="px-3 py-2 text-center">0.00</td>
                                            <td class="px-3 py-2 text-center">34,000.00</td>
                                            <td class="px-3 py-2 text-center">24/09/2025</td>
                                            <td class="px-3 py-2 text-center"> 24/07/2026</td>
                                            <td class="px-3 py-2 text-center">25/07/2026</td>
                                            <td class="text-right">0.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const disbursalInput = document.getElementById('disbursalDate');
            const emiInput = document.getElementById('emiDate');

            const disbursalPicker = new Datepicker(disbursalInput, {
                autohide: true,
                format: 'dd-mm-yyyy'
            });

            const emiPicker = new Datepicker(emiInput, {
                autohide: true,
                format: 'dd-mm-yyyy',
                minDate: null,
                maxDate: null
            });

            disbursalInput.addEventListener('changeDate', function () {
                if (disbursalInput.value) {
                    // Parse selected date: dd-mm-yyyy
                    let [day, month, year] = disbursalInput.value.split('-').map(Number);
                    let minDate = new Date(year, month - 1, day);

                    // Max date = minDate plus 2 months (same day)
                    let maxDate = new Date(minDate);
                    maxDate.setMonth(maxDate.getMonth() + 2);

                    // Adjust for months with fewer days
                    if (maxDate.getDate() !== minDate.getDate()) {
                        maxDate.setDate(0);
                    }

                    // Autofill EMI input with date 1 month later
                    let emiDate = new Date(minDate);
                    emiDate.setMonth(emiDate.getMonth() + 1);
                    // Adjust for months with fewer days
                    if (emiDate.getDate() !== minDate.getDate()) {
                        emiDate.setDate(0);
                    }
                    let emiStr = [
                        String(emiDate.getDate()).padStart(2, '0'),
                        String(emiDate.getMonth() + 1).padStart(2, '0'),
                        String(emiDate.getFullYear())
                    ].join('-');
                    emiInput.value = emiStr;

                    emiPicker.setOptions({
                        minDate: minDate,
                        maxDate: maxDate
                    });
                    emiPicker.setDate(emiDate);
                }
            });
        });
    </script>

    <script>
        function toggleSection(button) {
            const section = button.closest('.box').querySelector('.overflow-x-auto');
            const icon = button.querySelector('.toggle-icon');
            section.classList.toggle('hidden');
            icon.textContent = section.classList.contains('hidden') ? '+' : '−';
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    const disbursementInput = document.getElementById("disbursalDate");
    const emiDateInput = document.getElementById("emiDate");

    const today = new Date();
    const formattedToday = today.toISOString().split("T")[0];
    disbursementInput.value = formattedToday;

    const emiDate = new Date();
    emiDate.setMonth(emiDate.getMonth() + 1);
    const formattedEmiDate = emiDate.toISOString().split("T")[0];
    emiDateInput.value = formattedEmiDate;
});

    </script>

@endsection