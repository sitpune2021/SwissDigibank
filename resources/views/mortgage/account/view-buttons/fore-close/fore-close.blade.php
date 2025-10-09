@extends('layout.main')
@section('content')
<div class="main-inner">

    <head>
        <style>
            input[type="radio"] {
                width: 24px;
                height: 24px;
                accent-color: green;
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

    <div class="mb-4 flex flex-wrap items-center justify-between gap-4 lg:mb-4">
        <div class="flex items-start flex-col gap-2">
            <h3 class="uppercase font-semibold">Fore Close Gold Loan - 00460</h3>
            <p class="text-gray-500">
                <a href="#" class="text-gray-500 text-sm">Gold Loans </a> >
                <a href="#" class="text-gray-500 text-sm">00460 </a>>
                <a href="#" class="text-gray-500 text-sm">FORE CLOSE LOAN</a>
            </p>
        </div>
    </div>
    <div class="rounded-lg border-l-4 border-yellow-500  p-2">
        <a href="" class="btn-primary rounded-10">
            <i class="las la-print"></i>
            FORE CLOSURE LETTER
        </a>
    </div>

    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <!-- Left: Details -->
        <div class=" w-full  overflow-hidden">
            <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                <form action="">
                    <!-- Header -->
                    <div class="px-4 py-3 ">
                        <h3 class="text-lg  border-b mb-4 font-semibold text-black">ACCOUNT DETAILS</h3>
                    </div>
                    <!-- Body -->

                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-md  uppercase font-medium block mb-4">
                            Remaining Amount (A)
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="loanDisbursementDate"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0" readonly>
                        <x-number-to-word for="loanDisbursementDate" />

                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            Interest Accrued (B)
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="interestAccrued"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0">
                        <x-number-to-word for="interestAccrued" />

                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-2">
                            Overdue Interest (C)
                            <span class="text-red-500">*</span>
                        </label>
                        <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                            <tbody>
                                <!-- Column Labels -->
                                <tr class="">
                                    <th class="text-center px-3 py-1 ">Amount</th>
                                    <th class="text-center px-3 py-1 ">GST Rate (%) </th>
                                    <th class="text-center px-3 py-1 ">Total Amount</th>

                                </tr>

                                <!-- Input Row -->
                                <tr class="">

                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>


                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>


                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" placeholder="0"
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>


                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-2">
                            Notice Charges (D)
                            <span class="text-red-500">*</span>
                        </label>
                        <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                            <tbody>
                                <!-- Column Labels -->
                                <tr class="">
                                    <th class="text-center px-3 py-1 ">Amount</th>
                                    <th class="text-center px-3 py-1 ">GST Rate (%) </th>
                                    <th class="text-center px-3 py-1 ">Total Amount</th>

                                </tr>

                                <!-- Input Row -->
                                <tr class="">

                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>


                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>


                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" placeholder="0"
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>


                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-2">
                            Service Charges (E)
                            <span class="text-red-500">*</span>
                        </label>
                        <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                            <tbody>
                                <!-- Column Labels -->
                                <tr class="">
                                    <th class="text-center px-3 py-1 ">Amount</th>
                                    <th class="text-center px-3 py-1 ">GST Rate (%) </th>
                                    <th class="text-center px-3 py-1 ">Total Amount</th>

                                </tr>

                                <!-- Input Row -->
                                <tr class="">

                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>


                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>


                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" placeholder="0"
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>


                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-2">
                            Overdue Penalty/ Other <span class="text-red-500">*</span> <br>
                            Charges (F)

                        </label>
                        <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                            <tbody>
                                <!-- Column Labels -->
                                <tr class="">
                                    <th class="text-center px-3 py-1 ">Amount</th>
                                    <th class="text-center px-3 py-1 ">GST Rate (%) </th>
                                    <th class="text-center px-3 py-1 ">Total Amount</th>

                                </tr>

                                <!-- Input Row -->
                                <tr class="">

                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>


                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>


                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" placeholder="0"
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base"
                                            readonly />
                                    </td>


                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-2">
                            Fore Closure Charges (G)
                            <span class="text-red-500">*</span>
                        </label>
                        <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                            <tbody>
                                <!-- Column Labels -->
                                <tr class="">
                                    <th class="text-center px-3 py-1 ">Amount</th>
                                    <th class="text-center px-3 py-1 ">GST Rate (%) </th>
                                    <th class="text-center px-3 py-1 ">Total Amount</th>

                                </tr>

                                <!-- Input Row -->
                                <tr class="">

                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>


                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>


                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" id="" placeholder="0"
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>


                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-2">
                            Total Amount <span class="text-red-500">*</span>
                            (H = A + B + C + D + E + F + G)
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="totalAmount"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0" readonly>
                        <x-number-to-word for="totalAmount" />

                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-2">
                            Rounding Off (I)
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="roundingOff"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0" readonly>
                        <x-number-to-word for="roundingOff" />

                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-2">
                            Closure Discount (J)
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="closureDiscount"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0">
                        <x-number-to-word for="closureDiscount" />

                    </div>
                    <hr>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-2">
                            Transaction Date
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="date"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="DD/MM/YYYY">


                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-2">
                            Net Amount to Collect
                            (K = H - I - J)
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="netAmountCollect"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0" readonly>
                        <x-number-to-word for="netAmountCollect" />

                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-2">
                            Remarks (if any)

                        </label>

                        <textarea name="" id=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Remarks (if any)"></textarea>

                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        
                         <x-paymode :mode_2="$misaccount->amount ?? '' " :showSaving="true" id="amount" :readonly="false"
                        :amountClass="true" :bgColor="false" :hiddenheading="false" :checkedDefault="'cash'"
                        groupName="disburse_Mode_two" :rdShowing="true" />

                    </div>
                   
                    <!-- Buttons -->
                    <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                        <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                            Close Account
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
                    <h3 class="text-black uppercase font-semibold text-lg">Gold Loan Account Info</h3>

                    <!-- Toggle Button -->
                    <button class="p-1 rounded transition" onclick="toggleSection(this)">
                        <span class="toggle-icon text-lg font-bold">+</span>
                    </button>

                </div>

                <!-- Content (Initially Hidden) -->
                <div class="overflow-x-auto p-4 hidden">
                    <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2 w-1/3">Loan No.</td>
                                <td class="px-3 py-2"> 00462</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Member</td>
                                <td class="px-3 py-2">DEMO-04439 - ajinkya muli</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Co-Applicant Member</td>
                                <td class="px-3 py-2"> DEMO-04391 - sam butler</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Open Date</td>
                                <td class="px-3 py-2">29/09/2025</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Scheme</td>
                                <td class="px-3 py-2"> Suvarna shree yojana flat advanced deduction</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Loan Amount</td>
                                <td class="px-3 py-2">₹ 51,000.00</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Current Debt</td>
                                <td class="px-3 py-2">(51,000.00)</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Annual Interest Rate</td>
                                <td class="px-3 py-2">
                                    15.0 %
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Interest Type</td>
                                <td class="px-3 py-2">
                                   Flat Advanced Interest Deduction
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Tenure</td>
                                <td class="px-3 py-2">
                                   12 MONTHS
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Status</td>
                                <td class="px-3 py-2">
                                    Active
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
                    <h3 class="text-lg font-semibold uppercase">EMI<span>s</span> Info</h3>
                    <div class="">

                       <button
                        class="p-1 rounded transition"
                        onclick="toggleSection(this)">
                        <span class="toggle-icon text-lg font-bold">+</span>
                    </button>
                    </div>
                </div>

                <!-- Body -->
                <div class="p-4" id="SecurityDeposits">
                   <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2 w-1/3">No. of EMIs.</td>
                                <td class="px-3 py-2"> 	12</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">PAID</td>
                                <td class="px-3 py-2">0</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">LEFT</td>
                                <td class="px-3 py-2"> 	1</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">DUE</td>
                                <td class="px-3 py-2">	0</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">OVER DUE</td>
                                <td class="px-3 py-2"> 0</td>
                            </tr>
                            
                         
                        </tbody>
                    </table>
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
@endsection