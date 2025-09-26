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
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-2xl font-semibold">PROPERTY/ MORTGAGE LOAN DISBURSEMENT</h1>
            <p class="text-gray-500">
                <a href="#" class="text-gray-500">Property/ Mortgage Loan Disbursement</a> >
                <a href="#" class="text-gray-500">100118</a>
            </p>
        </div>
    </div>

    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <!-- Left: Details -->
        <div class="w-full overflow-hidden">
            <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                <form action="">
                    <!-- Header -->
                    <div class="px-4 py-3 ">
                        <h3 class="text-lg border-b mb-4 font-semibold text-black">Application No - 100118</h3>
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
                    <div class="col-span-2 md:col-span-1 mb-4">
                        <label for="" class="md:text-lg font-medium block mb-4">
                            Loan Amount
                        </label>

                        <input type="text" id="loan_amount"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Loan Amount">
                    </div>
                    <hr>
                    <h4>Processing Fee</h4>
                    <div class="w-1/2 bg-secondary/10 rounded-10 px-4 py-4 mb-4">
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
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border  rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- GST (%) -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" value="18.0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border  rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- SGST -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" value="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border  rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- CGST -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" value="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border  rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- IGST -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" value="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border  rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- Total -->
                                    <td class="px-2 py-2">
                                        <input type="number" name="" id="" placeholder="0"
                                            class="w-full px-2 py-2 text-center  border  rounded-10 text-sm md:text-base" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <x-checkbox-calculator id="collectProcessing" name="collect_processing"
                            label="Collect Processing Fee Separately"
                            checked />

                        <x-paymode :amount="$misaccount->amount ?? ''" {{-- :banks="$banks" --}} :showSaving="false"
                            id="processing_fee" :readonly="false" :amountClass="true" :bgColor="false" :hiddenheading="true" :checkedDefault="'cash'" />

                    </div>
                    <hr>
                    <div class="col-span-2 md:col-span-1 mb-4">
                        <label for="" class="md:text-lg font-medium block mb-4 mt-4">
                            Final Amount To Disburse
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="finalAmount"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 mb-4">
                        <hr>
                        <h3>Disbursement Amount :</h3>
                        <div class="w-1/2 bg-secondary/10 rounded-10 px-4 py-4 mt-4 mb-4">
                            <div class="col-span-1 md:col-span-1 mb-4">
                                <label for="" class="md:text-lg font-medium block mb-4 mt-4">
                                    Disburse Mode 1
                                    <span class="text-red-500">*</span>
                                </label>

                                <input type="text" id="D_mode_1"
                                    class="w-full text-sm dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                <x-paymode :mode_1="$misaccount->amount ?? ''" {{-- :banks="$banks" --}} :showSaving="true"
                                    id="amount" :readonly="false" :amountClass="true" :bgColor="false" :hiddenheading="true" :checkedDefault="'cash'" />

                            </div>

                        </div>
                        <div class="w-1/2 bg-secondary/10 rounded-10 px-4 py-4 mt-4 mb-4">
                            <div class="col-span-1 md:col-span-1 mb-4">
                                <label for="" class="md:text-lg font-medium block mb-4 mt-4">
                                    Disburse Mode 2
                                    <span class="text-red-500">*</span>
                                </label>

                                <input type="text" id="D_mode_2"
                                    class="w-full text-sm dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                <x-paymode :mode_2="$misaccount->amount ?? '' "  :showSaving="true"
                                    id="amount" :readonly="false" :amountClass="true" :bgColor="false" :hiddenheading="true" :checkedDefault="'cash'" />

                            </div>

                        </div>
                        <!-- Buttons -->
                        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                            <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                                DISBURSE LOAN
                            </button>

                            <button class="btn-outline uppercase justify-center" type="reset">
                                <a href="#"> BACK</a>
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>


    <div class="w-full overflow-hidden">
        <!--  Property Loan Application Info  -->
        <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg">
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

        <!--EMI Chart-->

        <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
            <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer">
                <h3 class="text-lg font-semibold capitalize">EMI Chart</h3>

                <button type="button" class="p-1 rounded transition"
                    onclick="toggleSection(this)">
                    <span class="toggle-icon text-lg font-bold">−</span>
                </button>

            </div>

            <!-- Body -->
            <div class="p-4">
                <div>
                    <p class="text-center">TOTAL INTEREST RECOVERABLE - 319,960.00</p>
                    <p class="text-center">TOTAL OTHER CHARGES RECOVERABLE - 0.00</p>
                </div>
                <div class="overflow-x-auto text-center mt-4">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full  rounded-lg text-sm">
                            <thead class="bg-secondary/5">
                                <tr>
                                    <th class="px-3 py-2 text-left">NO</th>
                                    <th class="px-3 py-2 text-left">PRINCIPAL</th>
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
                                <tr>
                                    <td class="px-3 py-2"> </td>
                                    <td class="px-3 py-2"></td>
                                    <td class="px-3 py-2 text-center"></td>
                                    <td class="px-3 py-2 text-center"></td>
                                    <td class="px-3 py-2 text-center"></td>
                                    <td class="px-3 py-2 text-center"></td>
                                    <td class="px-3 py-2 text-center"></td>
                                    <td class="px-3 py-2 text-center"></td>
                                    <td class="px-3 py-2 text-center">200000</td>
                                   
                                </tr>
                                
                                <tr>
                                    <td class="px-3 py-2">1 </td>
                                    <td class="px-3 py-2">1,667.00</td>
                                    <td class="px-3 py-2 text-center">2,666.00</td>
                                    <td class="px-3 py-2 text-center">0.00</td>
                                    <td class="px-3 py-2 text-center">4,333.00</td>
                                    <td class="px-3 py-2 text-center">16/09/2025</td>
                                    <td class="px-3 py-2 text-center">100.0</td>
                                    <td class="px-3 py-2 text-center">2.0</td>
                                    <td class="px-3 py-2 text-center">198,333.00.0</td>
                                   
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
<script>
    // Helper function to convert string to float, safely
    function parseAmount(value) {
        const num = parseFloat(value.replace(/,/g, ''));
        return isNaN(num) ? 0 : num;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const finalAmountField = document.getElementById('finalAmount');
        const mode1Field = document.getElementById('D_mode_1');
        const mode2Field = document.getElementById('D_mode_2');

        // When final amount changes, autofill mode 1 equally
        finalAmountField.addEventListener('input', () => {
            let total = parseAmount(finalAmountField.value);
            mode1Field.value = total.toFixed(2);
            mode2Field.value = (0).toFixed(2);
        });

        // When mode 1 changes, update mode 2 with exact split
        mode1Field.addEventListener('input', () => {
            let total = parseAmount(finalAmountField.value);
            let mode1 = parseAmount(mode1Field.value);

            if (mode1 > total) {
                // If mode1 > total, limit mode1 to total
                mode1 = total;
                mode1Field.value = mode1.toFixed(2);
            }

            let mode2 = total - mode1;
            mode2Field.value = mode2.toFixed(2);
        });
    });
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