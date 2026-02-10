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
            <h3 class="uppercase text-lg font-semibold">Fixed Loan Disbursements</h3>
        </div>
    </div>

    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <!-- Left: Details -->
        <div class="w-full overflow-hidden">
            <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                <form id="disbursementForm" action="{{ route('fixed_loan_disbursment.store') }}" method="POST">
                    @csrf

                    <!-- Header -->
                    <div class="px-2 py-3">
                        <h3 class="text-lg border-b mb-4 font-semibold text-black">
                            Application No - {{ str_pad($disbursement->id, 10, '0', STR_PAD_LEFT) }}
                        </h3>
                        <input type="hidden" name="loan_application_id"
                            value="{{ $disbursement->loan_application_id ?? $disbursement->id }}">
                    </div>

                    <!-- Loan Disbursement Date -->
                    <div class="mb-4">
                        <label class="md:text-lg font-medium block mb-2">
                            Loan Disbursement Date <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="disbursal_date" class="form-input w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3" value="{{ date('d-m-Y') }}"
                            required>
                    </div>

                    <!-- First EMI Date -->
                    <div class="mb-4">
                        <label class="md:text-lg font-medium block mb-2">
                            First EMI Date <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="emi_date" class="form-input w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3"
                            value="{{ \Carbon\Carbon::now()->addMonth()->format('d-m-Y') }}" required>
                    </div>

                    <!-- Loan Amount -->
                    <div class="mb-4">
                        <label class="md:text-lg font-medium block mb-2">Loan Amount</label>
                        <input type="number" name="loan_amount" class="form-input w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3"
                            value="{{ $disbursement->loan_amount ?? '' }}" readonly>
                    </div>

                    <h4 class="uppercase">Processing Fee</h4>
                    <div class="w-1/2 bg-secondary/10 rounded-10 px-4 py-4 mb-4">
                        <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                            <tbody>
                                <tr>
                                    <th class="text-center px-3 py-2 ">Value</th>
                                    <th class="text-center px-3 py-2 ">GST (%)</th>
                                    <th class="text-center px-3 py-2 ">SGST</th>
                                    <th class="text-center px-3 py-2 ">CGST</th>
                                    <th class="text-center px-3 py-2 ">IGST</th>
                                    <th class="text-center px-3 py-2 ">Total</th>
                                </tr>

                                <tr>
                                    <!-- Value -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="processing_fee" id="processing_fee"
                                            value="{{ number_format($processingFee, 2, '.', '') }}" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- GST (%) -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="processing_fee_gst_percent" id="gst_percent" value="{{ $gstPercent }}"
                                            readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- SGST -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="processing_fee_sgst" id="sgst" value="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- CGST -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="processing_fee_cgst" id="cgst" value="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- IGST -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="processing_fee_igst" id="igst" value="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- Total -->
                                    <td class="px-2 py-2">
                                        <input type="number" name="processing_fee_total" id="processing_fee_total"
                                            value="{{ number_format($totalProcessingFee, 2, '.', '') }}" readonly
                                            class="w-full px-2 py-2 text-center border rounded-10 text-sm md:text-base" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                            <span class="flex items-center gap-2">
                                <input type="checkbox" class="toggle-checkbox" data-target="processingfeepaymodeWrapper">
                                <span>
                                    Collect Processing Fee Separately
                                </span>
                            </span>
                            <div id="processingfeepaymodeWrapper" class="mt-3 ">

                                        <div class="mt-3">
                                             
                                            <div class="flex items-center gap-3">
                                                
                                            <label class="flex gap-2">
                                                <input type="radio" name="processingfee_payment_mode" value="cash"
                                                    checked> 
                                                    <span>
                                                        Cash
                                                    </span>
                                            </label>
                                            <label class="flex gap-2">
                                                <input type="radio" name="processingfee_payment_mode" value="cheque">
                                                <span>
                                                    Cheque
                                                </span>

                                            </label >

                                            <label class="flex gap-2">
                                                <input type="radio" name="processingfee_payment_mode" value="online">
                                                Online Tr.
                                            </label>
                                            </div>


                                            <!-- Fields for Cheque -->
                                            <div id="cheque_fields" style="display:none; margin-top:10px;"
                                                class="payment-section" data-mode="cheque">
                                                <label for="bank_id" class="block mb-2 text-sm font-medium">Select
                                                    Bank</label>
                                                <select id="bank_id" name="processing_fee_bank_id"
                                                    class="w-full rounded-10 border px-3 py-2 text-sm dark:bg-bg3">
                                                    <option value="">-- Select Bank --</option>
                                                    @foreach($banks as $id => $name)
                                                    <option value="{{ $id }}">
                                                        {{ $name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <!-- Cheque No -->
                                                <div class="mt-3">
                                                    <label class="block text-sm font-medium text-gray-700">Cheque
                                                        No.</label>
                                                    <input type="text" name="processing_fee_cheque_no"
                                                        class="w-full rounded-10 border px-3 py-2 text-sm dark:bg-bg3"
                                                        placeholder="Enter Cheque No">
                                                </div>

                                                <!-- Cheque Date -->
                                                <div class="mt-3">
                                                    <label class="block text-sm font-medium text-gray-700">Cheque
                                                        Date</label>
                                                    <input type="date" id="cheque_date" name="processing_fee_cheque_date"
                                                        value="{{ old('cheque_date', date('Y-m-d')) }}"
                                                        class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                                </div>
                                            </div>

                                            <!-- Fields for Online -->
                                            <div id="online_fields" style="display:none; margin-top:10px;"
                                                class="payment-section" data-mode="online">
                                                <div class="mt-3">
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        Transfer Date <span class="text-red-500">*</span>
                                                    </label>
                                                    <input type="date" id="transfer_date" name="processing_fee_transfer_date"
                                                        value="{{ old('transfer_date', date('Y-m-d')) }}"
                                                        class="w-full rounded-10 border px-3 py-2 text-sm  dark:bg-bg3">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        UTR / Transaction No. <span class="text-red-500">*</span>
                                                    </label>
                                                    <input type="text" id="utr_no" name="processing_fee_utr_no"
                                                        placeholder="Enter Transaction No."
                                                        class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        Transfer Mode <span class="text-red-500">*</span>
                                                    </label>
                                                    <div class="flex gap-4 mt-2">
                                                        <label class="flex items-center gap-2">
                                                            <input type="radio" name="processing_fee_transfer_mode" value="imps">
                                                            <span>IMPS</span>
                                                        </label>
                                                        <label class="flex items-center gap-2">
                                                            <input type="radio" name="processing_fee_transfer_mode" value="vpa">
                                                            <span>VPA</span>
                                                        </label>
                                                        <label class="flex items-center gap-2">
                                                            <input type="radio" name="processing_fee_transfer_mode" value="neft_rtgs">
                                                            <span>NEFT/RTGS</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                           </div>
                    </div>
                    <h4 class="uppercase">Stamp Duty Fee</h4>
                    <div class="w-1/2 bg-secondary/10 rounded-10 px-4 py-4 mb-4">
                        <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                            <tbody>
                                <tr>
                                    <th class="text-center px-3 py-2">Value</th>
                                    <th class="text-center px-3 py-2">GST (%)</th>
                                    <th class="text-center px-3 py-2">SGST</th>
                                    <th class="text-center px-3 py-2">CGST</th>
                                    <th class="text-center px-3 py-2">IGST</th>
                                    <th class="text-center px-3 py-2">Total</th>
                                </tr>

                                <tr>
                                    <!-- Value -->
                                    <td class="px-2 py-2">
                                        <input type="text" name="stamp_duty_fee" id="stamp_duty_fee" value="0.00" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- GST (%) -->
                                    <td class="px-2 py-2">
                                        <input type="text" name="stamp_gst_percent" id="stamp_gst_percent"
                                            value="{{ $gstPercent }}" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- SGST -->
                                    <td class="px-2 py-2">
                                        <input type="text" value="0" readonly name="stamp_duty_fee_sgst"
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base">
                                    </td>

                                    <!-- CGST -->
                                    <td class="px-2 py-2"><input type="text" value="0" readonly name="stamp_duty_fee_cgst"
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base">
                                    </td>

                                    <!-- IGST -->
                                    <td class="px-2 py-2">
                                        <input type="text" value="0" readonly name="stamp_duty_fee_igst"
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base">
                                    </td>

                                    <!-- Total -->
                                    <td class="px-2 py-2">
                                        <input type="number" name="stamp_duty_total" id="stamp_duty_total" value="0.00"
                                            readonly
                                            class="w-full px-2 py-2 text-center border rounded-10 text-sm md:text-base" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                            <span class="flex items-center gap-2">
                                <input type="checkbox" class="toggle-checkbox" data-target="stampDutyFeepaymodeWrapper">
                                <span>
                                    Collect Stamp Duty Fee Separately
                                </span>
                            </span>
                        <div id="stampDutyFeepaymodeWrapper" class="mt-3 ">

                            <div class="mt-3">

                               <div class="flex gap-3">
                                 <label  class="flex gap-2">
                                    <input type="radio" name="stamp_duty_fee_payment_mode" value="cash" checked>
                                    <span> Cash</span>
                                </label>
                                <label class="flex gap-2">
                                    <input type="radio" name="stamp_duty_fee_payment_mode" value="cheque">
                                   <span> Cheque</span>
                                </label>

                                <label class="flex gap-2">
                                    <input type="radio" name="stamp_duty_fee_payment_mode" value="online"> 
                                    <span>
                                        Online Tr.
                                    </span>
                                </label>
                               </div>


                                <!-- Fields for Cheque -->
                                <div id="cheque_fields" style="display:none; margin-top:10px;"
                                    class="stamp-payment-section" data-mode="cheque">
                                    <label for="bank_id" class="block mb-2 text-sm font-medium">Select Bank</label>
                                    <select id="bank_id" name="stamp_duty_fee_bank_id"
                                        class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                        <option value="">-- Select Bank --</option>
                                        @foreach($banks as $id => $name)
                                        <option value="{{ $id }}">
                                            {{ $name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <!-- Cheque No -->
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">Cheque No.</label>
                                        <input type="text" name="stamp_duty_fee_cheque_no"
                                            class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3"
                                            placeholder="Enter Cheque No">
                                    </div>

                                    <!-- Cheque Date -->
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">Cheque Date</label>
                                        <input type="date" id="cheque_date" name="stamp_duty_fee_cheque_date"
                                            value="{{ old('cheque_date', date('Y-m-d')) }}"
                                            class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>
                                </div>

                                <!-- Fields for Online -->
                                <div id="online_fields" style="display:none; margin-top:10px;"
                                    class="stamp-payment-section" data-mode="online">
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">
                                            Transfer Date <span class="text-red-500">*</span>
                                        </label>
                                        <input type="date" id="transfer_date" name="stamp_duty_fee_transfer_date"
                                            value="{{ old('transfer_date', date('Y-m-d')) }}"
                                            class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">
                                            UTR / Transaction No. <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="utr_no" name="stamp_duty_fee_utr_no" placeholder="Enter Transaction No."
                                            class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">
                                            Transfer Mode <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex gap-4 mt-2">
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="stamp_duty_fee_transfer_mode" value="imps">
                                                <span>IMPS</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="stamp_duty_fee_transfer_mode" value="vpa">
                                                <span>VPA</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="stamp_duty_fee_transfer_mode" value="neft_rtgs">
                                                <span>NEFT/RTGS</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="uppercase">Insurance Fee</h4>
                    <div class="w-1/2 bg-secondary/10 rounded-10 px-4 py-4 mb-4">
                        <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                            <tbody>
                                <tr>
                                    <th class="text-center px-3 py-2">Value</th>
                                    <th class="text-center px-3 py-2">GST (%)</th>
                                    <th class="text-center px-3 py-2">SGST</th>
                                    <th class="text-center px-3 py-2">CGST</th>
                                    <th class="text-center px-3 py-2">IGST</th>
                                    <th class="text-center px-3 py-2">Total</th>
                                </tr>

                                <tr>
                                    <!-- Value -->
                                    <td class="px-2 py-2">
                                        <input type="text" name="insurance_fee" id="insurance_fee" value="0.00" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- GST (%) -->
                                    <td class="px-2 py-2">
                                        <input type="text" name="insurance_gst_percent" id="insurance_gst_percent"
                                            value="{{ $gstPercent }}" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- SGST -->
                                    <td class="px-2 py-2"><input type="text" value="0" readonly name="insurance_fee_sgst"
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base">
                                    </td>

                                    <!-- CGST -->
                                    <td class="px-2 py-2"><input type="text" value="0" readonly name="insurance_fee_cgst"
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base">
                                    </td>

                                    <!-- IGST -->
                                    <td class="px-2 py-2"><input type="text" value="0" readonly name="insurance_fee_igst"
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base">
                                    </td>

                                    <!-- Total -->
                                    <td class="px-2 py-2">
                                        <input type="number" name="insurance_total" id="insurance_total" value="0.00"
                                            readonly
                                            class="w-full px-2 py-2 text-center border rounded-10 text-sm md:text-base" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                       <span class="flex items-center gap-2">
                                <input type="checkbox" class="toggle-checkbox" data-target="insuranceFeepaymodeWrapper">
                                <span>
                                    Collect Insurance Fee Separately
                                </span>
                            </span>
                        <div id="insuranceFeepaymodeWrapper" class="mt-3 ">

                            <div class="mt-3">

                              <div class="flex gap-2 items-center">
                                  <label class="flex gap-2">
                                    <input type="radio" name="insurance_fee_payment_mode" value="cash" checked>  <span>
                                         Cash
                                    </span>
                                </label>
                                <label class="flex gap-2">
                                    <input type="radio" name="insurance_fee_payment_mode" value="cheque"> 
                                    <span>
                                        Cheque
                                    </span>
                                </label>

                                <label class="flex gap-2">
                                    <input type="radio" name="insurance_fee_payment_mode" value="online"> 
                                    <span>
                                        Online Tr.
                                    </span>
                                </label>

                              </div>

                                <!-- Fields for Cheque -->
                                <div id="cheque_fields" style="display:none; margin-top:10px;"
                                    class="insurance-payment-section" data-mode="cheque">
                                    <label for="bank_id" class="block mb-2 text-sm font-medium">Select Bank</label>
                                    <select id="bank_id" name="insurance_fee_bank_id"
                                        class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                        <option value="">-- Select Bank --</option>
                                        @foreach($banks as $id => $name)
                                        <option value="{{ $id }}">
                                            {{ $name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <!-- Cheque No -->
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">Cheque No.</label>
                                        <input type="text" name="insurance_fee_cheque_no"
                                            class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3"
                                            placeholder="Enter Cheque No">
                                    </div>

                                    <!-- Cheque Date -->
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">Cheque Date</label>
                                        <input type="date" id="cheque_date" name="insurance_fee_cheque_date"
                                            value="{{ old('cheque_date', date('Y-m-d')) }}"
                                            class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>
                                </div>

                                <!-- Fields for Online -->
                                <div id="online_fields" style="display:none; margin-top:10px;"
                                    class="insurance-payment-section" data-mode="online">
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">
                                            Transfer Date <span class="text-red-500">*</span>
                                        </label>
                                        <input type="date" id="transfer_date" name="insurance_fee_transfer_date"
                                            value="{{ old('transfer_date', date('Y-m-d')) }}"
                                            class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">
                                            UTR / Transaction No. <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="utr_no" name="insurance_fee_utr_no" placeholder="Enter Transaction No."
                                            class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">
                                            Transfer Mode <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex gap-4 mt-2">
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="insurance_fee_transfer_mode" value="imps">
                                                <span>IMPS</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="insurance_fee_transfer_mode" value="vpa">
                                                <span>VPA</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="insurance_fee_transfer_mode" value="neft_rtgs">
                                                <span>NEFT/RTGS</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="uppercase font-semibold">Fitness Fee</h4>
                    <div class="w-1/2 bg-secondary/10 rounded-10 px-4 py-4 mb-4">
                        <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                            <tbody>
                                <tr>
                                    <th class="text-center px-3 py-2 ">Value</th>
                                    <th class="text-center px-3 py-2 ">GST (%)</th>
                                    <th class="text-center px-3 py-2 ">SGST</th>
                                    <th class="text-center px-3 py-2 ">CGST</th>
                                    <th class="text-center px-3 py-2 ">IGST</th>
                                    <th class="text-center px-3 py-2 ">Total</th>
                                </tr>

                                <tr>
                                    <!-- Value -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="fitness_fee" id="processing_fee" value="0.00" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- GST (%) -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="fitness_fee_gst_percent" id="gst_percent" value="{{ $gstPercent }}"
                                            readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- SGST -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="fitness_fee_sgst" id="sgst" value="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- CGST -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="fitness_fee_cgst" id="cgst" value="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- IGST -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="fitness_fee_igst" id="igst" value="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/10 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- Total -->
                                    <td class="px-2 py-2">
                                        <input type="number" name="fitness_fee_total" id="fitness_fee_total"
                                            value="0.00" readonly
                                            class="w-full px-2 py-2 text-center border rounded-10 text-sm md:text-base" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <span class="flex gap-2 items-center">
                                <input type="checkbox" class="toggle-checkbox" data-target="fitnessFeepaymodeWrapper">
                                <span>
                                    Collect Fitness Fee Separately
                                </span>
                            </span>
                        <div id="fitnessFeepaymodeWrapper" class="mt-3 ">

                            <div class="mt-3">

                               <div class="flex items-center gap-2">
                                 <label  class="flex gap-2">
                                    <input type="radio" name="fitness_fee_payment_mode" value="cash" checked> 
                                    <span>
                                        Cash
                                    </span>
                                </label>
                                <label class="flex gap-2">
                                    <input type="radio" name="fitness_fee_payment_mode" value="cheque"> <span>
                                        Cheque
                                    </span>
                                </label>

                                <label class="flex gap-2">
                                    <input type="radio" name="fitness_fee_payment_mode" value="online"> 
                                    <span>
                                        Online Tr.
                                    </span>
                                </label>
                               </div>


                                <!-- Fields for Cheque -->
                                <div id="cheque_fields" style="display:none; margin-top:10px;"
                                    class="fitness-payment-section" data-mode="cheque">
                                    <label for="bank_id" class="block mb-2 text-sm font-medium">Select Bank</label>
                                    <select id="bank_id" name="fitness_fee_bank_id"
                                        class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                        <option value="">-- Select Bank --</option>
                                        @foreach($banks as $id => $name)
                                        <option value="{{ $id }}">
                                            {{ $name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <!-- Cheque No -->
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">Cheque No.</label>
                                        <input type="text" name="fitness_fee_cheque_no"
                                            class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3"
                                            placeholder="Enter Cheque No">
                                    </div>

                                    <!-- Cheque Date -->
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">Cheque Date</label>
                                        <input type="date" id="cheque_date" name="fitness_fee_cheque_date"
                                            value="{{ old('cheque_date', date('Y-m-d')) }}"
                                            class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>
                                </div>

                                <!-- Fields for Online -->
                                <div id="online_fields" style="display:none; margin-top:10px;"
                                    class="fitness-payment-section" data-mode="online">
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">
                                            Transfer Date <span class="text-red-500">*</span>
                                        </label>
                                        <input type="date" id="transfer_date" name="fitness_fee_transfer_date"
                                            value="{{ old('transfer_date', date('Y-m-d')) }}"
                                            class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">
                                            UTR / Transaction No. <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="utr_no" name="fitness_fee_utr_no" placeholder="Enter Transaction No."
                                            class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">
                                            Transfer Mode <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex gap-4 mt-2">
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="fitness_fee_transfer_mode" value="imps">
                                                <span>IMPS</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="fitness_fee_transfer_mode" value="vpa">
                                                <span>VPA</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="fitness_fee_transfer_mode" value="neft_rtgs">
                                                <span>NEFT/RTGS</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Final Amount -->
                    <div class="mb-4">
                        <label class="md:text-lg font-medium block mb-2">
                            Final Amount To Disburse <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="final_amount" id="finalAmount" class="form-input w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3"
                            value="{{ number_format($finalAmount, 2, '.', '') }}" readonly>
                    </div>

                    <h3>Disbursement Amount :</h3>
                    <div class="w-1/2 bg-secondary/10 rounded-10 px-4 py-4 mt-4 mb-4">
                        <div class="col-span-1 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg font-medium block mb-4 mt-4">
                                Disburse Mode 1
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id="D_mode_1" name="D_mode_1"
                                class="w-full text-sm dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                value="{{ number_format($finalAmount, 2, '.', '') }}">
                            <x-number-to-word for="D_mode_1" />
                            {{-- <div class="mt-3"> --}}
                                   <div id="" class="mt-3 ">

                                <div class=" flex items-center gap-2">
                                    <label class="flex items-center gap-2">
                                    <input type="radio" name="payment_mode" value="cash" checked>
                                    <span>
                                         Cash
                                    </span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="payment_mode" value="cheque"> <span>
                                        Cheque
                                    </span>
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="radio" name="payment_mode" value="online"> <span>
                                        Online Transfer
                                    </span>
                                </label>
                               
                                </div>
                                 <label class="flex items-center mt-3 gap-2">
                                    <input type="radio" name="payment_mode" value="saving"> <span>
                                        Saving Account
                                    </span>
                                </label>

                                <!-- Fields for Cheque -->
                                <div id="cheque_fields1" class="" style="display:none; margin-top:10px;">
                                    <label for="bank_id" class="block mb-2 text-sm font-medium">Select Bank</label>
                                    <select id="bank_id" name="bank_id"
                                        class="w-full rounded-10 border px-3 py-2 text-sm  dark:bg-bg3">
                                        <option value="">-- Select Bank --</option>
                                        @foreach($banks as $id => $name)
                                        <option value="{{ $id }}">
                                            {{ $name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <!-- Cheque No -->
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">Cheque No.</label>
                                        <input type="text" name="cheque_no"
                                            class="w-full rounded-10 border px-3 py-2 text-sm  dark:bg-bg3"
                                            placeholder="Enter Cheque No">
                                    </div>

                                    <!-- Cheque Date -->
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">Cheque Date</label>
                                        <input type="date" id="cheque_date" name="cheque_date"
                                            value="{{ old('cheque_date', date('Y-m-d')) }}"
                                            class="w-full rounded-10 border px-3 py-2 text-sm  dark:bg-bg3">
                                    </div>
                                </div>

                                <!-- Fields for Online -->
                                <div id="online_fields1" style="display:none; margin-top:10px;">
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">
                                            Transfer Date <span class="text-red-500">*</span>
                                        </label>
                                        <input type="date" id="transfer_date" name="transfer_date"
                                            value="{{ old('transfer_date', date('Y-m-d')) }}"
                                            class="w-full rounded-10 border px-3 py-2 text-sm  dark:bg-bg3">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">
                                            UTR / Transaction No. <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="utr_no" name="utr_no" placeholder="Enter Transaction No."
                                            class="w-full rounded-10 border px-3 py-2 text-sm dark:bg-bg3">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">
                                            Transfer Mode <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex gap-4 mt-2">
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="transfer_mode" value="imps">
                                                <span>IMPS</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="transfer_mode" value="vpa">
                                                <span>VPA</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="transfer_mode" value="neft_rtgs">
                                                <span>NEFT/RTGS</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fields for Saving Account -->
                                <div id="saving_fields" style="display:none; margin-top:10px;">
                                    <label>Saving Account:</label>
                                    <select id="saving" name="saving"
                                        class="w-full rounded-10 border px-3 py-2 text-sm  dark:bg-bg3">
                                        <option value="">-- Select Saving Acc. --</option>
                                        <option value="abcd">abcd</option>
                                    </select>
                                </div>

                                <div class="w-1/2 bg-secondary/10 rounded-10 px-4 py-4 mt-4 mb-4">
                                    <div class="col-span-1 md:col-span-1 mb-4">
                                        <label for="" class="md:text-lg font-medium block mb-4 mt-4">
                                            Disburse Mode 2
                                            <span class="text-red-500">*</span>
                                        </label>

                                        <input type="text" id="D_mode_2" name="D_mode_2"
                                            class="w-full text-sm dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                            value="0" readonly>

                                        <div class="mt-3">
                                           <div class="flex  items-center gap-2">
                                             <label class="flex gap-2 items-center">
                                                <input type="radio" name="payment_mode2" value="cash" checked> 
                                                <span>Cash</span>
                                            </label>
                                            <label class="flex gap-2 items-center">
                                                <input type="radio" name="payment_mode2" value="cheque"> 
                                                <span>
                                                    Cheque
                                                </span>
                                            </label>
                                            <label class="flex gap-2 items-center">
                                                <input type="radio" name="payment_mode2" value="online"> 
                                                <span>Online Transfer</span>
                                            </label>
                                           
                                           </div>
                                            <label class="mt-3 flex items-center gap-2" >
                                                <input type="radio" name="payment_mode2" value="saving"> 
                                                <span>
                                                    Saving Account
                                                </span>
                                            </label>
                                            <!-- Fields for Disburse Mode 2 -->
                                            <div id="cheque_fields2" style="display:none; margin-top:10px;">
                                                <select id="bank_id2" name="bank_id2"
                                                    class="w-full rounded-10 border px-3 py-2 text-sm dark:bg-bg3">
                                                    <option value="">-- Select Bank --</option>
                                                    @foreach($banks as $id => $name)
                                                    <option value="{{ $id }}">
                                                        {{ $name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <!-- Cheque No -->
                                                <div class="mt-3">
                                                    <label class="block text-sm font-medium text-gray-700">Cheque
                                                        No.</label>
                                                    <input type="text" name="cheque_no2"
                                                        class="w-full rounded-10 border px-3 py-2 text-sm dark:bg-bg3"
                                                        placeholder="Enter Cheque No">
                                                </div>

                                                <!-- Cheque Date -->
                                                <div class="mt-3">
                                                    <label class="block text-sm font-medium text-gray-700">Cheque
                                                        Date</label>
                                                    <input type="date" id="cheque_date2" name="cheque_date2"
                                                        value="{{ old('cheque_date2', date('Y-m-d')) }}"
                                                        class="w-full rounded-10 border px-3 py-2 text-sm dark:bg-bg3">
                                                </div>
                                            </div>
                                            <!-- Fields for Online -->
                                            <div id="online_fields2" style="display:none; margin-top:10px;">
                                                <div class="mt-3">
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        Transfer Date <span class="text-red-500">*</span>
                                                    </label>
                                                    <input type="date" id="transfer_date2" name="transfer_date2"
                                                        value="{{ old('transfer_date2', date('Y-m-d')) }}"
                                                        class="w-full rounded-10 border px-3 py-2 text-sm dark:bg-bg3">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        UTR / Transaction No. <span class="text-red-500">*</span>
                                                    </label>
                                                    <input type="text" id="utr_no2" name="utr_no2"
                                                        placeholder="Enter Transaction No."
                                                        class="w-full rounded-10 border px-3 py-2 text-sm  dark:bg-bg3">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        Transfer Mode <span class="text-red-500">*</span>
                                                    </label>
                                                    <div class="flex gap-4 mt-2">
                                                        <label class="flex items-center gap-2">
                                                            <input type="radio" name="transfer_mode2" value="imps">
                                                            <span>IMPS</span>
                                                        </label>
                                                        <label class="flex items-center gap-2">
                                                            <input type="radio" name="transfer_mode2" value="vpa">
                                                            <span>VPA</span>
                                                        </label>
                                                        <label class="flex items-center gap-2">
                                                            <input type="radio" name="transfer_mode2" value="neft_rtgs">
                                                            <span>NEFT/RTGS</span>
                                                        </label>
                                                    </div>
                                                </div>

                                                

                                            </div>
<!-- Fields for Saving Account -->
                                                <div id="saving_fields2" style="display:none; margin-top:10px;">
                                                    <label>Saving Account:</label>
                                                    <select id="saving2" name="saving2"
                                                        class="w-full rounded-10 border px-3 py-2 text-sm  dark:bg-bg3">
                                                        <option value="">-- Select Saving Acc. --</option>
                                                      
                                                    </select>
                                                </div>
                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>

                        <!-- Dynamic Fields -->
                        <div id="extraFields" class="mb-4"></div>

                        <!-- Submit Buttons -->
                        <div class="flex flex-col sm:flex-row justify-center gap-3 mt-5">
                            <button class="btn-primary uppercase justify-center" type="submit" id="submitBtn">
                                DISBURSE LOAN
                            </button>
                            <a href="{{ route('fixed_loan.disbursements.index') }}"
                                class="btn-outline uppercase justify-center">BACK</a>
                        </div>
                </form>

                <!-- Script -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const form = document.getElementById('disbursementForm');
                        const paymentMode = document.getElementById('payment_mode');
                        const extraFields = document.getElementById('extraFields');

                        paymentMode.addEventListener('change', function() {
                            const mode = this.value;
                            extraFields.innerHTML = ''; // clear previous

                            if (mode === 'cheque') {
                                extraFields.innerHTML = `
                                    <label>Bank Name</label>
                                    <input type="text" name="bank_name" class="form-input" required>
                                    <label>Cheque No</label>
                                    <input type="text" name="cheque_no" class="form-input" required>
                                    <label>Cheque Date</label>
                                    <input type="date" name="cheque_date" class="form-input" required>
                                `;
                            } else if (mode === 'online') {
                                extraFields.innerHTML = `
                                    <label>UTR / Transaction No</label>
                                    <input type="text" name="utr_no" class="form-input" required>
                                    <label>Transfer Date</label>
                                    <input type="date" name="transfer_date" class="form-input" required>
                                `;
                            } else if (mode === 'saving') {
                                extraFields.innerHTML = `
                                    <label>Saving Account No</label>
                                    <input type="text" name="saving_acc_no" class="form-input" required>
                                `;
                            }
                        });
                    });
                </script>

            </div>
        </div>
    </div>

    <div class="w-full overflow-hidden">
        <!-- Gold Loan Application Info  -->
        <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg">
            <!-- Header -->
            <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                <h3 class="text-black uppercase font-semibold text-lg">Fixed Loan Application Info</h3>

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
                            <td class="font-semibold uppercase px-3 py-2 w-1/3">Application Date</td>
                            <td class="px-3 py-2">{{ $disbursement->application_date }}</td>
                        </tr>

                        <tr class="border-b border-gray-200">
                            <td class="font-semibold uppercase px-3 py-2">Application No</td>
                            <td class="px-3 py-2">{{ $disbursement->id }}</td>
                        </tr>

                        <tr class="border-b border-gray-200">
                            <td class="font-semibold uppercase px-3 py-2">Member</td>
                            <td class="px-3 py-2">{{ $disbursement->member->id ?? '' }} - {{
                                $disbursement->member->member_info_first_name ?? '' }}</td>
                        </tr>

                        <tr class="border-b border-gray-200">
                            <td class="font-semibold uppercase px-3 py-2">Amount Requested</td>
                            <td class="px-3 py-2">₹ {{ $disbursement->loan_amount ?? '' }}</td>
                        </tr>

                        <tr class="border-b border-gray-200">
                            <td class="font-semibold uppercase px-3 py-2">Amount Approved</td>
                            <td class="px-3 py-2">
                                ₹ {{ $disbursement->loan_amount ?? '' }}
                            </td>
                        </tr>

                        <tr class="border-b border-gray-200">
                            <td class="font-semibold uppercase px-3 py-2">Status</td>
                            <td class="px-3 py-2">
                                Approved
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <!--EMI Chart-->

        <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
            <div
                class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer">
                <h3 class="text-lg font-semibold capitalize">EMI Chart</h3>

                <button type="button" class="p-1 rounded transition" onclick="toggleSection(this)">
                    <span class="toggle-icon text-lg font-bold">−</span>
                </button>

            </div>

            <!-- Body -->
            <div class="p-4">
                <div>
                    <p class="text-center font-semibold">TOTAL INTEREST RECOVERABLE - 319,960.00</p>
                    <p class="text-center font-semibold">TOTAL OTHER CHARGES RECOVERABLE - 0.00</p>
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

{{-- paymode --}}
<script>
    document.querySelectorAll('input[name="payment_mode"]').forEach((elem) => {
  elem.addEventListener("change", function(event) {
    let value = event.target.value;

    // hide all first
    document.getElementById("cheque_fields1").style.display = "none";
    document.getElementById("online_fields1").style.display = "none";
    document.getElementById("saving_fields").style.display = "none";

    // show according to selection
    if (value === "cheque") {
      document.getElementById("cheque_fields1").style.display = "block";
    } else if (value === "online") {
      document.getElementById("online_fields1").style.display = "block";
    } else if (value === "saving") {
      document.getElementById("saving_fields").style.display = "block";
    }
  });
});

// Disburse Mode 2
document.querySelectorAll('input[name="payment_mode2"]').forEach((elem) => {
  elem.addEventListener("change", function(event) {
    let value = event.target.value;

    // hide all first
    document.getElementById("cheque_fields2").style.display = "none";
    document.getElementById("online_fields2").style.display = "none";
    document.getElementById("saving_fields2").style.display = "none";

    // show according to selection
    if (value === "cheque") {
      document.getElementById("cheque_fields2").style.display = "block";
    } else if (value === "online") {
      document.getElementById("online_fields2").style.display = "block";
    } else if (value === "saving") {
      document.getElementById("saving_fields2").style.display = "block";
    }
  });
});
</script>

<script>
    function calculateTotal() {
        let insurance = parseFloat(document.getElementById("insurance").value) || 0;
        let gst = parseFloat(document.getElementById("gst").value) || 0;
        let sgst = parseFloat(document.getElementById("sgst").value) || 0;
        let cgst = parseFloat(document.getElementById("cgst").value) || 0;
        let igst = parseFloat(document.getElementById("igst").value) || 0;

        let total = insurance + gst + sgst + cgst + igst;
        document.getElementById("total").value = total.toFixed(2);
    }

    // Page load pe run hoga
    window.onload = calculateTotal;
</script>

<script>
    // Helper function to convert string to float, safely
    function parseAmount(value) {
        const num = parseFloat(value.replace(/,/g, ''));
        return isNaN(num) ? 0 : num;
    }

    document.addEventListener('DOMContentLoaded', function () {
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



    document.addEventListener("DOMContentLoaded", function () {
        const checkboxes = document.querySelectorAll(".toggle-paymode");

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener("change", function () {
                const targetId = this.dataset.target;
                const target = document.getElementById(targetId);

                if (target) {
                    target.classList.toggle("hidden", !this.checked);
                }
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('cheque_date').value = today;
    document.getElementById('transfer_date').value = today;
    document.getElementById('cheque_date2').value = today;
    document.getElementById('transfer_date2').value = today;
});
</script>

{{-- reusable js for payment modes --}}
<script>
    // reusable js for payment modes
    function radioSectionToggle({ wrapperId, radioName, sectionClass }) {
    const wrapper = document.getElementById(wrapperId);
    if (!wrapper) return;

    const radios = wrapper.querySelectorAll(`input[name="${radioName}"]`);
    const sections = wrapper.querySelectorAll(`.${sectionClass}`);

    function hideAll() {
        sections.forEach(sec => sec.style.display = 'none');
    }

    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            hideAll();

            const target = wrapper.querySelector(
                `.${sectionClass}[data-mode="${this.value}"]`
            );

            if (target) {
                target.style.display = 'block';
            }
        });
    });

    // Init on page load
    const checked = wrapper.querySelector(`input[name="${radioName}"]:checked`);
    if (checked) {
        checked.dispatchEvent(new Event('change'));
    }
}

// Initialize for your form
radioSectionToggle({
    wrapperId: 'processingfeepaymodeWrapper',
    radioName: 'processingfee_payment_mode',
    sectionClass: 'payment-section'
});

radioSectionToggle({
    wrapperId: 'stampDutyFeepaymodeWrapper',
    radioName: 'stamp_duty_fee_payment_mode',
    sectionClass: 'stamp-payment-section'
});

radioSectionToggle({
    wrapperId: 'insuranceFeepaymodeWrapper',
    radioName: 'insurance_fee_payment_mode',
    sectionClass: 'insurance-payment-section'
});
radioSectionToggle({
    wrapperId: 'fitnessFeepaymodeWrapper',
    radioName: 'fitness_fee_payment_mode',
    sectionClass: 'fitness-payment-section'
});

</script>

<script>
    function initCheckboxToggles(selector = '.toggle-checkbox') {
    document.querySelectorAll(selector).forEach(checkbox => {

        const targetId = checkbox.dataset.target;
        if (!targetId) return;

        const target = document.getElementById(targetId);
        if (!target) return;

        // Set initial state
        target.style.display = checkbox.checked ? 'block' : 'none';

        checkbox.addEventListener('change', () => {
            target.style.display = checkbox.checked ? 'block' : 'none';
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initCheckboxToggles();
});
</script>


@endsection