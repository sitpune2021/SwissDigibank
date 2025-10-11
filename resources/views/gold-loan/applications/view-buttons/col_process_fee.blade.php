@extends('layout.main')

@section('content')

<head>
    <style>
        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;
            /* Modern browser support */
        }
    </style>
</head>
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-lg font-semibold capitalize">LOAN APPLICATION</h1>
        </div>
    </div>
    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <!-- Left: Details -->
        <div class="w-full overflow-hidden">
            <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                <form action="">
                    <!-- Header -->
                    <div class="px-4 py-3">
                        <h3 class="text-lg border-b font-semibold text-black">COLLECT ADVANCE PROCESSING FEE</h3>
                    </div>
                    <!-- Body -->
                    <div class=" flex p-4 overflow-x-auto">
                        <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                            <tbody>
                                <!-- Column Labels -->
                                <tr class="">
                                    <th class="text-center px-3 py-2 ">Value</th>
                                    <th class="text-center px-3 py-2 ">GST (%)</th>
                                    <th class="text-center px-3 py-2 ">SGST</th>
                                    <th class="text-center px-3 py-2 ">CGST</th>
                                    <th class="text-center px-3 py-2 ">IGST</th>
                                    <th class="text-center px-3 py-2 ">Total</th>
                                </tr>

                                <!-- Input Row -->
                                <tr class="">
                                    <!-- Value -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" value="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- GST (%) -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" value="18.0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- SGST -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" value="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- CGST -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" value="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- IGST -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" value="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- Total -->
                                    <td class="px-2 py-2">
                                        <input type="number" name="" id="" placeholder="0"
                                            class="w-full px-2 py-2 text-center  border  rounded-10 text-sm md:text-base" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <x-datepicker-disabled
                        label="Transaction Date"
                        inputId="tran_date"
                        name="transaction_date" />

                    <x-paymode :amount="$misaccount->amount ?? ''" {{-- :banks="$banks" --}} :showSaving="false"
                        id="amount" :readonly="false" :amountClass="true" :bgColor="false" :hiddenheading="true" />

                        <p for="" class=" text-error text-sm block mt-3 mb-4">
                            Note: If you wish to collect processing fee at the time of disbursement, then enter 0. Fees
                            will be calculated accordingly.
                        </p>
                    <!-- Buttons -->
                    <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                        <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                            SUBMIT
                        </button>

                        <button class="btn-outline uppercase justify-center" type="reset">
                            <a href="#"> BACK</a>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="w-full">
            <!--  Application Info -->
            <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg">
                <!-- Header -->
                <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                    <h3 class="text-black font-semibold text-lg"> Loan Application Info</h3>

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
                                <td class="font-semibold px-3 py-2 w-1/3">Advisor/ Staff</td>
                                <td class="px-3 py-2">Rahul</td>
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
                                <td class="font-semibold px-3 py-2">Interest As First EMI</td>
                                <td class="px-3 py-2">
                                    <span class="block w-20 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error">
                                        No
                                    </span>
                                </td>
                            </tr>
                            <tr >
                                <td class="font-semibold px-3 py-2">Processing Fee</td>
                                <td class="px-3 py-2">
                                    ₹ 236.00 (Incl. 18.0 % GST)
                                </td>
                            </tr>
                           
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

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