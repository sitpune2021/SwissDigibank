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
            <div class="flex items-center  flex-row gap-2">
                <h3 class="uppercase text-xl font-semibold">
                    Gold Loan Account - 
                </h3>
                <p class="text-gray-500 text-xs">
                    LOAN EXTENSION
                </p>
            </div>

        </div>
        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-4 gap-5">
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
                            <input type="number" id="amountA" name="remaining_amount" value="{{ $currentDebt }}" readonly
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0">
                            <x-number-to-word for="" />
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                Interest Reverse (B)
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="amountB" name="interest_reverse" value="0" readonly
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0">
                            <x-number-to-word for="" />
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                Interest Accrued (C)
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="amountC" name="interest_accrued" value="0"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0">
                            <x-number-to-word for="" />
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg uppercase font-medium block mb-2">
                                Overdue Interest (D)
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
                                            <input type="number" name="" id="" placeholder="0" readonly
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <td class="px-2 py-2 ">
                                            <input type="number" name="" id="" placeholder="0" readonly
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <td class="px-2 py-2 ">
                                            <input type="number" name="overdue_total" id="totalD" placeholder="0"
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg uppercase font-medium block mb-2">
                                Overdue Penalty/ Other <span class="text-red-500">*</span> <br>
                                Charges (E)
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
                                            <input type="number" id="amountE" name="penalty_amount" placeholder="0" readonly
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <td class="px-2 py-2 ">
                                            <input type="number" id="gstE" name="penalty_gst" placeholder="18" value="18" readonly
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <td class="px-2 py-2 ">
                                            <input type="number" id="totalE" name="penalty_total"
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base"
                                                readonly />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg uppercase font-medium block mb-2">
                                Notice Charges (F)
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
                                    <tr>
                                        <!-- Input Row -->
                                        <td class="px-2 py-2 ">
                                            <input type="number" id="amountF" name="notice_amount" placeholder="0"
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <td class="px-2 py-2 ">
                                            <input type="number" id="gstF" name="notice_gst" placeholder="0" value="18"
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <td class="px-2 py-2 ">
                                            <input type="number" id="totalF" name="notice_total" placeholder="0"
                                                class="w-full px-2 py-2 text-center border rounded-10 text-sm md:text-base bg-white" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg uppercase font-medium block mb-2">
                                Service Charges (G)
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
                                    <tr>
                                        <td class="px-2 py-2 ">
                                            <input type="number" id="amountG" name="service_amount" placeholder="0"
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <td class="px-2 py-2 ">
                                            <input type="number" id="gstG" name="service_gst" placeholder="0" value="18"
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <td class="px-2 py-2 ">
                                            <input type="number" id="totalG" name="service_total" placeholder="0"
                                                class="w-full px-2 py-2 text-center border rounded-10 text-sm md:text-base bg-white" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg uppercase font-medium block mb-2">
                                Total Amount <span class="text-red-500">*</span>
                                (H = A - B + C + D + E + F + G)
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="amountH" name="total_amount_h"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0" readonly>
                            <x-number-to-word for="" />
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg uppercase font-medium block mb-2">
                                Rounding Off (I)
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="roundingOff" name="rounding_off_i"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0" readonly>
                            <x-number-to-word for="roundingOff" />
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg uppercase font-medium block mb-2">
                                Discount (J)
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="amountJ" name="closure_discount_j"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0">
                            <x-number-to-word for="" />
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg uppercase font-medium block mb-2">
                                Net Due Amount
                                (K = H - I - J)
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="amountK" name="net_amount_k"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0" readonly>
                            <x-number-to-word for="netAmountCollect" />
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label class="md:text-lg uppercase font-medium block mb-2">
                                Transaction Date <span class="text-red-500">*</span>
                            </label>

                            <input type="text" name="transaction_date"
                                class="datepicker-field w-full text-sm border rounded-10 px-3 py-2"
                                placeholder="DD/MM/YYYY">
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label class="md:text-lg uppercase font-medium block mb-2">
                                Amount Paid / Collected
                            </label>

                            <input type="number" name="amount_paid"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0">
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label class="md:text-lg uppercase font-medium block mb-2">
                                Remarks (if any)
                            </label>
                            <textarea name="remarks"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Remarks (if any)"></textarea>
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">    
                            <label class="md:text-lg font-medium block mb-4 uppercase">Pay Mode :</label>

                            <div class="mt-3 flex gap-3">
                                <label class="flex items-center gap-3">
                                    <input type="radio" name="payment_mode" value="cash" checked> Cash
                                </label>

                                <label class="flex items-center gap-3">
                                    <input type="radio" name="payment_mode" value="cheque"> Cheque
                                </label>

                                <label class="flex items-center gap-3">
                                    <input type="radio" name="payment_mode" value="online"> Online Tr.
                                </label>
                            </div>

                            <!-- Bank + Cheque -->
                            <div id="bankDropdownWrapper" class="mt-3 hidden">
                                <label class="block mb-2 text-sm font-medium">Select Bank</label>
                                <select name="bank_id" class="w-64 rounded-10 border px-3 py-2 text-sm">
                                    <option>-- Select Bank --</option>
                                </select>

                                <div class="mt-3">
                                    <label class="text-sm font-medium">Cheque No.</label>
                                    <input type="text" name="cheque_no" class="w-64 rounded-10 border px-3 py-2 text-sm"
                                        placeholder="Enter Cheque No">
                                </div>

                                <div class="mt-3">
                                    <label class="text-sm font-medium">Cheque Date</label>
                                    <input type="date" name="cheque_date"
                                        class="w-64 rounded-10 border px-3 py-2 text-sm">
                                </div>
                            </div>

                            <!-- Online Payment -->
                            <div id="onlineFields" class="space-y-4 hidden">
                                <div class="mt-3">
                                    <label class="text-sm font-medium uppercase">Transfer Date *</label>
                                    <input type="date" name="transfer_date" class="w-64 rounded-10 border px-3 py-2 text-sm">
                                </div>

                                <div>
                                    <label class="text-sm font-medium uppercase">UTR / Transaction No *</label>
                                    <input type="text" name="utr_no"
                                        placeholder="Enter Transaction No." class="w-64 rounded-10 border px-3 py-2 text-sm">
                                </div>

                                <div>
                                    <label class="text-sm font-medium uppercase">Transfer Mode *</label>
                                    <div class="flex gap-4 mt-2">
                                        <label><input type="radio" name="transfer_mode" value="imps"> IMPS</label>
                                        <label><input type="radio" name="transfer_mode" value="vpa"> VPA</label>
                                        <label><input type="radio" name="transfer_mode" value="neft_rtgs"> NEFT/RTGS</label>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-sm font-medium uppercase">Credited in Company Account *</label>
                                    <div class="flex gap-4">
                                        <label><input type="radio" name="credited" value="1" checked> Yes</label>
                                        <label><input type="radio" name="credit0ed" value="0"> No</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="mt-5 mb-4">

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label class="md:text-lg uppercase font-medium block mb-2">New Principal</label>
                            <input type="number" name="new_principal" readonly class="w-full text-sm border rounded-10 px-3 py-2">
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label class="md:text-lg uppercase font-medium block mb-2">Loan Reschedule Date *</label>
                            <input type="text" name="reschedule_date" class="datepicker-field w-full text-sm border rounded-10 px-3 py-2">
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label class="md:text-lg uppercase font-medium block mb-2">First EMI Date *</label>
                            <input type="text" name="first_emi_date" class="datepicker-field w-full text-sm border rounded-10 px-3 py-2">
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label class="md:text-lg uppercase font-medium block mb-2">Interest Rate (%) *</label>
                            <input type="number" name="interest_rate"
                                value="{{ $goldLoan->scheme->annual_interest_rate }}" class="w-full text-sm border rounded-10 px-3 py-2">
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label class="md:text-lg uppercase font-medium block mb-2">EMI Collection (MONTHS)</label>
                            <input type="text" name="emi_type" value="MONTHLY" readonly class="w-full text-sm border rounded-10 px-3 py-2">
                        </div>

                        <div class="col-span-2 md:col-span-1 mt-3">
                            <label class="md:text-lg uppercase text-lg flex gap-2 font-medium mb-2">
                                <input type="radio" name="emi_type_mode" checked>
                                Tenure Based EMI
                            </label>
                            <p>(Select this if you want to create a new EMI chart based on tenure.)</p>
                        </div>

                        <div class="col-span-2 md:col-span-1 mt-3">
                            <label class="md:text-lg uppercase font-medium block mb-2">Tenure (MONTHS)</label>
                            <input type="number" name="tenure" value="{{ $goldLoan->scheme->tenure }}" class="w-full border rounded-10 px-3 py-2">
                        </div>

                        <div class="col-span-2 md:col-span-1 mt-3">
                            <label class="md:text-lg uppercase font-medium block mb-2">Reschedule Reason *</label>
                            <textarea name="reason" class="w-full border rounded-10 px-3 py-2"
                                placeholder="Enter Reschedule Reason"></textarea>
                        </div>


                        <!-- Buttons -->
                        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                            <button class="btn-primary uppercase justify-center" type="submit" name="">
                                  calculate
                            </button>

                            <button class="btn-outline uppercase justify-center" type="reset">
                                <a href="#"> BACK</a>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- right: Details -->
            <div class=" w-full  overflow-hidden">
               
                <div class="box toggle-box bg-white dark:bg-bg3 border shadow-md rounded-lg">
                    <!-- Header -->
                    <div class=" ">
                        <button
                            class="toggle-btn flex items-center justify-between w-full bg-secondary/5 text-black px-4 py-3 rounded-10 cursor-pointer">
                            <h3 class="text-lg font-semibold uppercase">Gold Loan Account Info</h3>
                            <span class="toggle-icon text-lg font-bold">+</span>
                        </button>
                    </div>

                    <!-- Content (Initially Hidden) -->
                    <div class="overflow-x-auto p-4 toggle-content">
                        <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                            <tbody>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 w-1/3">Loan No.</td>
                                    <td class="px-3 py-2">{{ $goldLoan->id }}</td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2">Member</td>
                                    <td class="px-3 py-2">
                                        {{ $goldLoan->member->member_no }} - {{ $goldLoan->member->member_info_first_name }}
                                    </td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2">Open Date</td>
                                    <td class="px-3 py-2">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2">Scheme</td>
                                    <td class="px-3 py-2">{{ $goldLoan->scheme->scheme_name }}</td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2">Loan Amount</td>
                                    <td class="px-3 py-2">₹ {{ number_format($goldLoan->loan_amount, 2) }}</td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2">Current Debt</td>
                                    <td class="px-3 py-2">₹ {{ number_format($currentDebt, 2) }}</td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2">Annual Interest Rate</td>
                                    <td class="px-3 py-2">{{ $goldLoan->scheme->annual_interest_rate }} %</td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2">Interest Type</td>
                                    <td class="px-3 py-2">{{ ucfirst($goldLoan->scheme->gold_loan_setting) }}</td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2">Tenure</td>
                                    <td class="px-3 py-2">{{ $goldLoan->scheme->tenure }} MONTHS</td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2">Status</td>
                                    <td class="px-3 py-2">
                                        {{ $goldLoan->status == 1 ? 'Active' : 'Inactive' }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="box toggle-box bg-white dark:bg-bg3 mt-5 border shadow-md rounded-lg">
                    <!-- Header -->
                    <div class=" ">
                        <button
                            class="toggle-btn flex items-center justify-between w-full bg-secondary/5 text-black px-4 py-3 rounded-10 cursor-pointer">
                            <h3 class="text-lg font-semibold uppercase">
                                Gold Loan Scheme Info
                             </h3>
                            <span class="toggle-icon text-lg font-bold">+</span>
                        </button>
                    </div>

                    <!-- Content (Initially Hidden) -->
                    <div class="overflow-x-auto p-4 hidden  toggle-content">
                        <table
                            class="w-full border-collapse rounded-lg overflow-hidden whitespace-nowrap  bg-white dark:bg-bg3">
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3">
                                        Scheme Name
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        {{ $goldLoan->scheme->scheme_name??''}}
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2">Scheme Code</td>
                                    <td class="px-4 py-2 text-right md:text-left">{{ $goldLoan->scheme->scheme_code??'' }}</td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2">
                                        Maximum Loan Amount

                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        ₹ {{ $goldLoan->scheme->max_loan_amount??'' }}
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold px-4 py-2">
                                        Maximum Loan Limit

                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        {{ $goldLoan->scheme->max_loan_limit??'' }} %
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-bold px-4 py-2">Interest Type</td>
                                    <td class="px-4 py-2  text-right md:text-left">
                                        {{$settingLabel ??''}}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-bold px-4 py-2">
                                        Interest Rate
                                    </td>
                                    <td class="px-4 py-2  text-right md:text-left">
                                        {{ $goldLoan->scheme->annual_interest_rate??'' }} %
                                    </td>
                                </tr>
                                <tr class=" text-center">
                                    <td class="font-bold px-4 py-2" colspan="2">
                                        Per EMI Charges
                                    </td>

                                </tr>
                                <tr class="border-b">
                                    <td class="font-bold px-4 py-2">
                                        SMS Charges
                                    </td>
                                    <td class="px-4 py-2  text-right md:text-left">
                                        {{ $goldLoan->scheme->sms_charge??'0.0' }} ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-bold px-4 py-2">
                                        Fuel Charges
                                    </td>
                                    <td class="px-4 py-2  text-right md:text-left">
                                        {{ $goldLoan->scheme->fuel_charge??'0.0' }} ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-bold px-4 py-2">
                                        Stationary Charges
                                    </td>
                                    <td class="px-4 py-2  text-right md:text-left">
                                        {{ $goldLoan->scheme->stationary_charge??'0.0' }} ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-bold px-4 py-2">
                                        Maintenance Charges
                                    </td>
                                    <td class="px-4 py-2  text-right md:text-left">
                                        {{ $goldLoan->scheme->maintenance_charge??'0.0' }} ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-bold px-4 py-2">
                                        Collection Charges
                                    </td>
                                    <td class="px-4 py-2  text-right md:text-left">
                                        {{ $goldLoan->scheme->collection??'0.0' }} ₹
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="box toggle-box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                    <div class="">
                        <!-- Header -->
                        <button
                            class="toggle-btn flex items-center justify-between w-full bg-secondary/5 text-black px-4 py-3 rounded-10 cursor-pointer">
                            <h3 class="text-lg font-semibold uppercase">EMIs Info</h3>
                            <span class="toggle-icon text-lg font-bold">+</span>
                        </button>

                        <!-- Body -->
                        <div class="toggle-content  p-4 rounded-lg mt-2">
                            <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                                <tbody>
                                    <tr class="border-b border-gray-200">
                                        <td class="font-semibold px-3 py-2 w-1/3">No. of EMIs.</td>
                                        <td class="px-3 py-2"> 12</td>
                                    </tr>
                                    <tr class="border-b border-gray-200">
                                        <td class="font-semibold px-3 py-2">PAID</td>
                                        <td class="px-3 py-2">0</td>
                                    </tr>
                                    <tr class="border-b border-gray-200">
                                        <td class="font-semibold px-3 py-2">LEFT</td>
                                        <td class="px-3 py-2"> 1</td>
                                    </tr>
                                    <tr class="border-b border-gray-200">
                                        <td class="font-semibold px-3 py-2">DUE</td>
                                        <td class="px-3 py-2"> 0</td>
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

<!-- Datepicker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

<!-- Datepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
        
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.datepicker-field').forEach(function (dateInput) {
            const picker = new Datepicker(dateInput, {
                autohide: true,
                format: 'dd-mm-yyyy',
                maxDate: new Date(),
            });

            if (!dateInput.value) {
                const today = new Date();
                const formattedDate = today.toLocaleDateString('en-GB').split('/').join('-');
                dateInput.value = formattedDate;
            }

            const calendarIcon = dateInput.parentElement.querySelector('.la-calendar');
            if (calendarIcon) {
                calendarIcon.addEventListener('click', () => picker.show());
            }
        });
    });
</script>

{{-- button toggle --}}
<script>
    document.querySelectorAll(".toggle-box").forEach((box) => {
        const btn = box.querySelector(".toggle-btn");
        const content = box.querySelector(".toggle-content");
        const icon = box.querySelector(".toggle-icon");

        btn.addEventListener("click", () => {
            content.classList.toggle("hidden");
            icon.textContent = content.classList.contains("hidden") ? "+" : "-";
        });
    });
</script>


<!-- pay mode -->
<script>
        document.addEventListener("DOMContentLoaded", () => {
            const radios = document.querySelectorAll('input[name="payment_mode"]');
            const bankDropdownWrapper = document.getElementById("bankDropdownWrapper");
            const onlineFields = document.getElementById("onlineFields");

            radios.forEach(radio => {
                radio.addEventListener("change", () => {
                    bankDropdownWrapper.classList.add("hidden");
                    onlineFields.classList.add("hidden");

                    if (radio.value === "cheque" && radio.checked) {
                        bankDropdownWrapper.classList.remove("hidden");
                    }
                    if (radio.value === "online" && radio.checked) {
                        onlineFields.classList.remove("hidden");
                    }
                });
            });

            // Default dates
            let today = new Date().toISOString().split('T')[0];
            document.getElementById("cheque_date").value = today;
            document.getElementById("transfer_date").value = today;
        });
</script>

<!-- autocalcute Fields -->
<script>
function calcGST(amount, gst = 18) {
    amount = parseFloat(amount) || 0;
    return (amount * gst) / 100;
}

function reverseGST(total, gst = 18) {
    total = parseFloat(total) || 0;
    return total / (1 + (gst / 100));
}

let activeField = null;

// Track focused input
document.querySelectorAll("input").forEach(input => {
    input.addEventListener("focus", () => activeField = input.id);
});

function calculate() {

    let A = parseFloat(document.getElementById("amountA").value) || 0;
    let B = parseFloat(document.getElementById("amountB").value) || 0;
    let C = parseFloat(document.getElementById("amountC").value) || 0;

    // -------- D (Overdue Interest - NO GST) ----------
    let D = parseFloat(document.getElementById("totalD").value) || 0;

    // -------- F (Notice Charge) ----------
    let amountF = document.getElementById("amountF");
    let gstF = parseFloat(document.getElementById("gstF").value) || 18;
    let totalF = document.getElementById("totalF");

    if (activeField === "totalF") {
        amountF.value = reverseGST(totalF.value, gstF).toFixed(2);
    } else if (activeField === "amountF") {
        totalF.value = (parseFloat(amountF.value || 0) + calcGST(amountF.value, gstF)).toFixed(2);
    }

    // -------- G (Service Charge) ----------
    let amountG = document.getElementById("amountG");
    let gstG = parseFloat(document.getElementById("gstG").value) || 18;
    let totalG = document.getElementById("totalG");

    if (activeField === "totalG") {
        amountG.value = reverseGST(totalG.value, gstG).toFixed(2);
    } else if (activeField === "amountG") {
        totalG.value = (parseFloat(amountG.value || 0) + calcGST(amountG.value, gstG)).toFixed(2);
    }

    // -------- E (Fixed GST logic) ----------
    let amountE = parseFloat(document.getElementById("amountE").value) || 0;
    let gstE = parseFloat(document.getElementById("gstE").value) || 18;
    document.getElementById("totalE").value = (amountE + calcGST(amountE, gstE)).toFixed(2);

    // -------- FINAL H ----------
    let totalEVal = parseFloat(document.getElementById("totalE").value) || 0;
    let totalFVal = parseFloat(totalF.value) || 0;
    let totalGVal = parseFloat(totalG.value) || 0;

    let H = A - B + C + D + totalEVal + totalFVal + totalGVal;
    document.getElementById("amountH").value = H.toFixed(2);

    // --------- NET DUE (K = H - I - J) ---------
    let I = parseFloat(document.getElementById("roundingOff").value) || 0;
    let J = parseFloat(document.getElementById("amountJ").value) || 0;

    let K = H - I - J;
    document.getElementById("amountK").value = K.toFixed(2);

    // -------- NEW LOGIC: New Principal (K - Amount Paid) ----------
    let paid = parseFloat(document.querySelector("input[name='amount_paid']").value) || 0;
    let newPrincipal = K - paid;

    document.querySelector("input[name='new_principal']").value = newPrincipal.toFixed(2);
}

// Run calculation on any input change
document.querySelectorAll("input").forEach(input => {
    input.addEventListener("input", calculate);
});

// Auto run on load
window.onload = calculate;
</script>


@endsection