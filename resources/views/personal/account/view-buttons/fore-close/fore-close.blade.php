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
            <h3 class="uppercase font-semibold">FORE CLOSE PERSONAL LOAN</h3>
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
                <form action="{{ route('personal.account.forecloser.store', $goldLoan->id) }}" method="POST">
                @csrf
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
                        <input type="text" id="A" name="remaining_amount"
                            value="{{ $currentDebt }}" 
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0" readonly>
                        <x-number-to-word for="loanDisbursementDate" />
                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            Interest Accrued (B)
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="B" name="interest_accrued"
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
                                        <input type="text" name="overdue_interest" id="C" placeholder="0"
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
                                        <input type="text" name="" id="amount_D" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" value="18" id="gst_D" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="notice_charges" id="D" placeholder="0"
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
                                        <input type="text" name="" id="amount_E" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" value="18" id="gst_E" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="service_charges" id="E" placeholder="0"
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
                                        <input type="text" name="" id="amount_F" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" value="18" id="gst_F" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="other_charges" id="F" placeholder="0" value="0"
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
                                        <input type="text" name="" id="amount_G" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="" value="18" id="gst_G" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="foreclosure_charges" id="G" placeholder="0"
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
                        <input type="text" id="totalAmount" name="total_amount_h"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0" readonly>
                        <x-number-to-word for="totalAmount" />
                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-2">
                            Rounding Off (I)
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="roundingOff" value="0" name="rounding_off_i"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0" readonly>
                        <x-number-to-word for="roundingOff" />
                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-2">
                            Closure Discount (J)
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="closureDiscount" name="closure_discount_j"
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
                        <input type="text" id="date" name="transaction_date"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="DD/MM/YYYY">
                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-2">
                            Net Amount to Collect
                            (K = H - I - J)
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="netAmountCollect" name="net_amount_k"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0" readonly>
                        <x-number-to-word for="netAmountCollect" />
                    </div>
                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label for="" class="md:text-lg uppercase font-medium block mb-2">
                            Remarks (if any)
                        </label>
                        <textarea name="remarks" id=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Remarks (if any)"></textarea>
                    </div>

                    <div class="col-span-2 md:col-span-1 mb-2">    
                        <label for="" class="md:text-lg font-medium block mt-3 mb-4 uppercase">
                            Pay Mode :
                        </label>

                        <!-- Radio Buttons -->
                        <div class="mt-3 flex gap-3 ">
                            <!-- Pay Mode -->
                            <label class="mr-4 flex items-center flex-row gap-3">
                                <input type="radio" name="payment_mode" value="cash" {{ old('payment_mode',
                                    $application->payment_mode ?? '') == 'cash' ? 'checked' : '' }}>
                                        Cash
                            </label>
                            <label class="mr-4 flex items-center flex-row gap-3">
                                <input type="radio" name="payment_mode" value="cheque" {{ old('payment_mode',
                                    $application->payment_mode ?? '') == 'cheque' ? 'checked' : '' }}> 
                                    Cheque
                            </label>
                            <label class="mr-4 flex items-center flex-row gap-3">
                                <input type="radio" name="payment_mode" value="online" {{ old('payment_mode',
                                    $application->payment_mode ?? '') == 'online' ? 'checked' : '' }}  > Online Tr.
                            </label>
                        </div>

                        <!-- Bank + Cheque Fields -->
                        <div id="bankDropdownWrapper" class="mt-3 hidden">
                            <label for="bank_id" class="block mb-2 text-sm font-medium">Select Bank</label>
                            <select id="bank_id" name="bank_id"
                                class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                <option value="">-- Select Bank --</option>
                                @foreach($banks as $id => $name)
                                <option value="{{ $id }}" {{ old('bank_id', $application->bank_id ?? '') == $id ?
                                    'selected' : '' }}>
                                    {{ $name }}
                                </option>
                                @endforeach
                            </select>

                            <!-- Cheque No -->
                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700">Cheque No.</label>
                                <input type="text" name="cheque_no"
                                    class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3"
                                    placeholder="Enter Cheque No" value="  {{ old('cheque_no', $application->cheque_no ?? '') }}">
                            </div>

                            <!-- Cheque Date -->
                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700">Cheque Date</label>
                                <input 
                                type="date" 
                                id="cheque_date" 
                                name="cheque_date" 
                                value="{{ old('cheque_date', $application->cheque_date ?? '') }}"
                                class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                            </div>
                        </div>

                        <!-- Online Transaction Fields -->
                        <div id="onlineFields" class="space-y-4 hidden">
                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700 uppercase">
                                    Transfer Date <span class="text-red-500">*</span>
                                </label>
                                <input 
                                type="date" 
                                id="transfer_date" 
                                name="transfer_date" 
                                value="{{ old('transfer_date', $application->transfer_date ?? '') }}"
                                class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 uppercase">
                                    UTR / Transaction No. <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="utr_no" name="utr_no" placeholder="Enter Transaction No."
                                    value="{{ old('utr_no', $application->utr_no ?? '') }}"
                                    class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 uppercase">
                                    Transfer Mode <span class="text-red-500">*</span>
                                </label>
                                <div class="flex gap-4 mt-2">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="transfer_mode" 
                                        value="imps"{{ old('transfer_mode', $application->transfer_mode ?? '') == 'imps' ?
                                        'checked' : '' }}>
                                        <span>IMPS</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="transfer_mode" 
                                        value="vpa"{{ old('transfer_mode', $application->transfer_mode ?? '') == 'vpa' ?
                                        'checked' : '' }}>
                                        <span>VPA</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="transfer_mode" 
                                        value="neft_rtgs"{{ old('transfer_mode', $application->transfer_mode ?? '') == 'neft_rtgs' ?
                                        'checked' : '' }}>
                                        <span>NEFT/RTGS</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 uppercase">
                                    Credited in Company Account <span class="text-red-500">*</span>
                                </label>
                                <div class="flex gap-4">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="credited" value="1"
                                            {{ old('credited') == 1 ? 'checked' : '' }} checked>
                                        <span>Yes</span>
                                    </label>

                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="credited" value="0"
                                            {{ old('credited') == 0 ? 'checked' : '' }}>
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                        </div>                      
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
                    <h3 class="text-black uppercase font-semibold text-lg">PERSONAL LOAN ACCOUNT INFO</h3>

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

<!-- A to G total calculation -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    function calculateTotal() {

        // Safe parse (blank = 0)
        let A = parseFloat(document.getElementById("A").value.replace(/,/g, "")) || 0;
        let B = parseFloat(document.getElementById("B").value) || 0;
        let C = parseFloat(document.getElementById("C").value) || 0;
        let D = parseFloat(document.getElementById("D").value) || 0;
        let E = parseFloat(document.getElementById("E").value) || 0;
        let F = parseFloat(document.getElementById("F").value) || 0;
        let G = parseFloat(document.getElementById("G").value) || 0;

        // Total (A to G)
        let total = A + B + C + D + E + F + G;
        document.getElementById("totalAmount").value = total.toFixed(2);

        // --- Net Amount to Collect (K = H - I - J) ---
        let H = parseFloat(document.getElementById("totalAmount").value) || 0;
        let I = parseFloat(document.getElementById("roundingOff").value) || 0;
        let J = parseFloat(document.getElementById("closureDiscount").value) || 0;

        let K = H - I - J;

        document.getElementById("netAmountCollect").value = K.toFixed(2);
    }

    // Trigger calculation for all fields
    ["B", "C", "D", "E", "F", "G", "roundingOff", "closureDiscount"].forEach(id => {
        let el = document.getElementById(id);
        if (el) {
            el.addEventListener("input", calculateTotal);
        }
    });

    calculateTotal(); // initial calculation
});
</script>

<!-- auto calculate in gst -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    function reverseGST(totalId, gstId, amountId) {
        let total = parseFloat(document.getElementById(totalId).value) || 0;
        let gst = parseFloat(document.getElementById(gstId).value) || 0;

        if (total === 0) {
            document.getElementById(amountId).value = "0.00";
            return;
        }

        // Amount = Total / (1 + GST/100)
        let amount = total / (1 + (gst / 100));
        document.getElementById(amountId).value = amount.toFixed(2);
    }

    // Add listeners
    document.getElementById("D").addEventListener("input", function(){
        reverseGST("D", "gst_D", "amount_D");
    });

    document.getElementById("E").addEventListener("input", function(){
        reverseGST("E", "gst_E", "amount_E");
    });

    document.getElementById("F").addEventListener("input", function(){
        reverseGST("F", "gst_F", "amount_F");
    });

    document.getElementById("G").addEventListener("input", function(){
        reverseGST("G", "gst_G", "amount_G");
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


@endsection