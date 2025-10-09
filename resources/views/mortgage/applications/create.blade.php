@extends('layout.main')
@section('content')

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
</style>

<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col  gap-2">
            <h1 class="text-xl font-semibold">Mortgage Applications</h1>
        </div>
    </div>

    <div class="box">
        <div class="flex flex-col lg:flex-row mb-3 gap-4 ">
            <div class=" rounded-10 flex-1 bg-primary/5 p-2">
                <div class="w-full col-span-12 px-3 py-1 rounded-10 lg:col-span-12">
                   <form method="POST" 
                        action="{{ isset($application) ? route('mortgage.applications.update', $application->id) : route('mortgage.store') }}">
                        @csrf
                        @if(isset($application))
                            @method('PUT')
                        @endif

                        <div class="col-span-2 md:col-span-1">
                             {{-- Application Date --}}           
                            <label class="md:text-lg font-medium block mb-4">
                                Application Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="application_date"
                                value="{{ old('application_date', $application->application_date ?? date('Y-m-d')) }}">
                        </div>
                        
                        <div class="col-span-2 md:col-span-1">
                            <label for="member_id" class="md:text-lg font-medium block mb-4">
                                Member <span class="text-red-500">*</span>
                            </label>
                            
                            <select name="member_id" id="member_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                <option value="">Search Member No or Name</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}"
                                    {{ old('member_id', $application->member_id ?? '') == $member->id ? 'selected' : '' }}
                                        data-name="{{ $member->member_info_first_name }}"
                                        data-mobile="{{ $member->member_info_mobile_no }}">
                                        {{ $member->member_info_first_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4">
                                1st Co-Applicant Member</label>
                           <select name="co_applicant_1_id" id="co_applicant_1_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                <option value="">Search Member No or Name</option>
                                @foreach($members as $member)
                                     <option value="{{ $member->id }}"
                                        {{ old('member_id', $application->co_applicant_1_id ?? '') == $member->id ? 'selected' : '' }}>
                                        {{ $member->member_info_first_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4">
                                2nd Co-Applicant Member</label>
                            <select name="co_applicant_2_id" id="co_applicant_2_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                <option value="">Search Member No or Name</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}"
                                        {{ old('member_id', $application->co_applicant_2_id ?? '') == $member->id ? 'selected' : '' }}>
                                        {{ $member->member_info_first_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4">
                                Branch
                                <span class="text-red-500">*</span>
                            </label>
                            <select name="branch_id" id="branch_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                <option value="">Search Branch No or Name</option>
                                @foreach($branch as $member)
                                <option value="{{ $member->id }}"
                                        {{ old('member_id', $application->branch_id ?? '') == $member->id ? 'selected' : '' }}>
                                        {{ $member->branch_name }}
                                    </option>
                                    
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4">
                                Advisor/ Staff</label>
                            <select
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                placeholder="Enter Scheme Code">
                                <option value="">select Advisor/ Staff </option>
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4">
                                Guarantor 1 </label>
                            <select name="guarantor_1_id" id="guarantor_1_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                <option value="">Search Member No or Name</option>
                                @foreach($members as $member)
                                 <option value="{{ $member->id }}"
                                        {{ old('member_id', $application->guarantor_1_id ?? '') == $member->id ? 'selected' : '' }}>
                                        {{ $member->member_info_first_name }}
                                    </option>
                                   
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <div class="col-sm-7">
                                <label for="" class="md:text-lg font-medium block mb-4">
                                    Guarantor 2</label>
                                <select name="guarantor_2_id" id="guarantor_2_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                <option value="">Search Member No or Name</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}"
                                        {{ old('member_id', $application->guarantor_2_id ?? '') == $member->id ? 'selected' : '' }}>
                                        {{ $member->member_info_first_name }}
                                    </option>
                                @endforeach
                            </select>
                            </div>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <div class="col-sm-7">
                                <label for="" class="md:text-lg font-medium block mb-4">
                                    Guarantor 3 </label>
                                <select name="guarantor_3_id" id="guarantor_3_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                <option value="">Search Member No or Name</option>
                                @foreach($members as $member)
                                     <option value="{{ $member->id }}"
                                        {{ old('member_id', $application->guarantor_3_id ?? '') == $member->id ? 'selected' : '' }}>
                                        {{ $member->member_info_first_name }}
                                    </option>
                                @endforeach
                            </select>
                            </div>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <div class="col-sm-7">
                                <label for="" class="md:text-lg font-medium block mb-4">
                                    Guarantor 4 </label>
                               <select name="guarantor_4_id" id="guarantor_4_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                <option value="">Search Member No or Name</option>
                                @foreach($members as $member)
                                     <option value="{{ $member->id }}"
                                        {{ old('member_id', $application->guarantor_4_id ?? '') == $member->id ? 'selected' : '' }}>
                                        {{ $member->member_info_first_name }}
                                    </option>
                                @endforeach
                            </select>
                            </div>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <div class="col-sm-7">
                                <label for="" class="md:text-lg font-medium block mb-4">
                                    Scheme <span class="text-error">*</span>
                                </label>
                               <!-- <select name="scheme_id" id="scheme_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                <option value="">Search Scheme Code</option>
                                @foreach($scheme as $sc)
                                    <option value="{{ $sc->id }}"
                                        data-code="{{ $sc->scheme_code }}"
                                        data-name="{{ $sc->scheme_name }}"
                                        data-tenure="{{ $sc->tenure ?? '-' }}"
                                        data-max="{{ $sc->max_loan_amount ?? '-' }}"
                                        data-limit="{{ $sc->max_loan_limit ?? '-' }}"
                                        data-min="{{ $sc->min_loan_amount ?? '-' }}"
                                        data-interest="{{ $sc->annual_interest_rate ?? '-' }}"
                                        data-type="{{ $sc->gold_loan_setting ?? '-' }}"                              
                                        data-active="{{ $sc->is_active ? 'Yes' : 'No' }}"
                                        data-charge="{{ $sc->charge_floting ?? '-' }}">
                                        {{ $sc->scheme_code }}
                                    </option>
                                @endforeach
                            </select> -->
                            <select name="scheme_id" id="scheme_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                <option value="">Search Scheme Code</option>
                                @foreach($scheme as $sc)
                                    <option value="{{ $sc->id }}"
                                        {{ old('scheme_id', $application->scheme_id ?? '') == $sc->id ? 'selected' : '' }}
                                        data-code="{{ $sc->scheme_code }}"
                                        data-name="{{ $sc->scheme_name }}"
                                        data-tenure="{{ $sc->tenure ?? '-' }}"
                                        data-max="{{ $sc->max_loan_amount ?? '-' }}"
                                        data-limit="{{ $sc->max_loan_limit ?? '-' }}"
                                        data-min="{{ $sc->min_loan_amount ?? '-' }}"
                                        data-interest="{{ $sc->annual_interest_rate ?? '-' }}"
                                        data-type="{{ $sc->gold_loan_setting ?? '-' }}"
                                        data-active="{{ $sc->is_active ? 'Yes' : 'No' }}"
                                        data-charge="{{ $sc->charge_floting ?? '-' }}">
                                        {{ $sc->scheme_code }}
                                    </option>
                                @endforeach
                            </select>
                            </div>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            {{-- do not remove div --}}
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <div class="col-sm-7">
                                <label for="" class="md:text-lg font-medium block mb-4">
                                    Tenure Type
                                    <span class="text-error">*</span>
                                </label>
                                <div class="flex">
                                    <label class="flex items-center gap-2 space-x-2 p-2">
                                        <input type="radio" name="tenure_type" value="days"
                                            {{ old('tenure_type', $application->tenure_type ?? '') == 'days' ? 'checked' : '' }}>
                                        <span class="text-gray-70 capitalize">DAYS</span>
                                    </label>
                                    <label class="flex items-center gap-2 space-x-2 p-2">
                                        <input type="radio" name="tenure_type" value="weeks"
                                            {{ old('tenure_type', $application->tenure_type ?? '') == 'weeks' ? 'checked' : '' }}>
                                        <span class="text-gray-70 capitalize">WEEKS</span>
                                    </label>
                                    <label class="flex items-center gap-2 space-x-2 p-2">
                                        <input type="radio" name="tenure_type" value="months"
                                            {{ old('tenure_type', $application->tenure_type ?? '') == 'months' ? 'checked' : '' }}>
                                        <span class="text-gray-70 capitalize">MONTHS</span>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4">
                                Tenure <span id="tenureLabel" class="text-black uppercase">( MONTHS )</span>
                                <span class="text-error">*</span>
                            </label>
                            <input type="number" id="tenure_value" name="tenure_value"
                                value="{{ old('tenure_value', $application->tenure_value ?? '') }}"
                                class="w-full text-sm border px-3 py-2">
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4">
                                EMI Collection <span class="text-error">* </span>
                            </label>
                            <select name="emi_collection" class="w-full text-sm border px-3 py-2">
                            <option value="">Please Select</option>
                            <option value="Monthaly" {{ old('emi_collection', $application->emi_collection ?? '') == 'Monthaly' ? 'selected' : '' }}>Monthaly</option>
                            <option value="Qaurterly" {{ old('emi_collection', $application->emi_collection ?? '') == 'Qaurterly' ? 'selected' : '' }}>Qaurterly</option>
                            <option value="Half_yearly" {{ old('emi_collection', $application->emi_collection ?? '') == 'Half_yearly' ? 'selected' : '' }}>Half_yearly</option>
                            <option value="Yearly" {{ old('emi_collection', $application->emi_collection ?? '') == 'Yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>

                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4">
                                Credit Period ( EMI Grace Period ) ( Days )
                                <span class="text-error">*</span>
                            </label>
                            <input type="number" id="credit_period" name="credit_period" value="{{ old('credit_period', $application->credit_period ?? 0) }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0">
                        </div>

                       <div class="col-span-2 md:col-span-1">
                            <label for="loanAmount" class="md:text-lg font-medium block mb-4">
                                Loan Amount (₹) <span class="text-error">*</span>
                            </label>
                            <input type="number" id="loanAmount" name="loan_amount"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0" value="{{ old('loan_amount', $application->loan_amount ?? 0) }}">
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="insuranceAmount" class="md:text-lg font-medium block mb-4">
                                Insurance Amount (₹) <span class="text-error">*</span>
                            </label>
                            <input type="number" id="insuranceAmount" name="insurance_amount"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Insurance Amount (₹)" value="{{ old('insurance_amount', $application->insurance_amount ?? 0) }}">
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="netLoanAmount" class="md:text-lg font-medium block mb-4">
                                Net Loan Amount (₹) <span class="text-error">*</span>
                            </label>
                            <input type="number" id="netLoanAmount" name="net_loan_amount" readonly
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 bg-gray-100"
                                placeholder="0" value="{{ old('net_loan_amount', $application->net_loan_amount ?? 0) }}">
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-4">
                                Purpose of Loan
                                <span class="text-error">*</span>
                            </label>

                            <input type="text" id="purpose_of_loan" name="purpose_of_loan"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Purpose of Loan" value="{{ old('purpose_of_loan', $application->purpose_of_loan ?? '') }}">
                        </div>
                </div>


                <div class="col-span-12  lg:col-span-12 mb-5">
                    <hr>
                   <label for="" class="md:text-lg font-medium block mt-3 mb-4 uppercase">
                                Credit Score Details </label>
                            <div class="w-full overflow-x-auto">
                                <table class="w-full  rounded-lg whitespace-nowrap" id="cibilTable">
                                    <thead class="bg-secondary/5 whitespace-nowrap">
                                        <tr class="bg-gray-100">
                                            <th
                                                class="text-center px-2 py-2 md:px-4 md:py-2 uppercase text-sm md:text-base">
                                                Cibil Type
                                            </th>
                                            <th
                                                class="text-center px-2 py-2 md:px-4 md:py-2 uppercase text-sm md:text-base">
                                                Cibil Score
                                            </th>
                                            <th
                                                class="text-center  px-2 py-2 md:px-4 md:py-2 uppercase text-sm md:text-base">
                                                Report Date
                                            </th>
                                            <th
                                                class="text-center px-2 py-2 md:px-4 md:py-2 uppercase text-sm md:text-base">
                                                Upload File
                                            </th>
                                            <th class=" px-2 py-2 md:px-4 md:py-2"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="cibilBody" class="bg-gray-100 whitespace-nowrap">
                                        {{-- Credit Score Details Table --}}
                                    </tbody>
                                </table>
                            </div>

                    <div class="mt-3">
                        <button type="button" id="addRow" class="btn-primary rounded-10 px-4 py-2">
                            + Add New Score
                        </button>
                    </div>

                    {{--calculator checkbox- --}}
                    <x-checkbox-calculator id="manualEntry" name="manual_entry" label="Collect Principal Amount as EMI"
                        sublabel="(Check this if you want to collect principal amount as EMIs.)" />
                </div>


                <div class="col-span-12  lg:col-span-12 ">
                    <hr>
                    <label for="" class="md:text-lg font-medium block mt-3 mb-4">
                        Collect Advance Processing Fee
                    </label>
                    <div class="w-full overflow-x-auto bg-secondary/5 rounded-10 p-3">

                        <div class="w-full">
                            <div class="flex  flex-row justify-around items-center gap-3">
                                <!-- Label -->
                                <label for="" class="text-sm block font-medium text-gray-700 dark:text-gray-200">
                                    Total Processing Fee : </label>
                                <input type="text" name="processing_fee_value" id="processing_fee_value" readonly placeholder="0"
                                    class="w-64 rounded-10 block border dark:bg-bg3 px-3 py-2 text-sm " />
                            </div>
                        </div>

                        <label for="" class="md:text-lg font-medium block mt-3 mb-4">
                            Collect Processing Fee :</label>
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
                                            class="w-full px-2 py-2 text-center  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <!-- GST (%) -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="processing_fee_gst" id="processing_fee_gst" value="18.0" readonly
                                            class="w-full px-2 py-2 text-center  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <!-- SGST -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="processing_fee_sgst" id="processing_fee_sgst" value="0" readonly
                                            class="w-full px-2 py-2 text-center  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <!-- CGST -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="processing_fee_cgst" id="processing_fee_cgst" value="0" readonly
                                            class="w-full px-2 py-2 text-center  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <!-- IGST -->
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="processing_fee_igst" id="processing_fee_igst" value="0" readonly
                                            class="w-full px-2 py-2 text-center  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <!-- Total -->
                                    <td class="px-2 py-2">
                                        <input type="number" name="processing_fee_total" id="processing_fee_total" placeholder="0"
                                            class="w-full px-2 py-2 text-center  rounded-10 text-sm md:text-base" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <label for="" class="md:text-lg font-medium block mt-3 mb-4">
                            Pay Mode :</label>
                            <!-- Radio Buttons -->
                            <div class="mt-3">
                                <!-- Pay Mode -->
                                <label class="mr-4">
                                    <input type="radio" name="fee_mode" value="cash"
                                        {{ old('fee_mode', $application->fee_mode ?? '') == 'cash' ? 'checked' : '' }}> Cash
                                </label>
                                <label class="mr-4">
                                    <input type="radio" name="fee_mode" value="cheque"
                                        {{ old('fee_mode', $application->fee_mode ?? '') == 'cheque' ? 'checked' : '' }}> Cheque
                                </label>
                                <label>
                                    <input type="radio" name="fee_mode" value="online"
                                        {{ old('fee_mode', $application->fee_mode ?? '') == 'online' ? 'checked' : '' }}> Online Tr.
                                </label>
                            </div>

                            <!-- Bank + Cheque Fields -->
                            <div id="bankDropdownWrapper" class="mt-3 hidden">
                                <label for="bank_id" class="block mb-2 text-sm font-medium">Select Bank</label>
                               <select id="bank_id" name="bank_id"
                                    class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                    <option value="">-- Select Bank --</option>
                                    @foreach($banks as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ old('bank_id', $application->bank_id ?? '') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Cheque No -->
                                <div class="mt-3">
                                    <label class="block text-sm font-medium text-gray-700">Cheque No.</label>
                                    <input type="text" name="cheque_no"
                                        class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3"
                                        placeholder="Enter Cheque No" value="{{ old('cheque_no', $application->cheque_no ?? '') }}">
                                </div>

                                <!-- Cheque Date -->
                                <div class="mt-3">
                                    <label class="block text-sm font-medium text-gray-700">Cheque Date</label>
                                    <input type="date" id="cheque_date" name="cheque_date" value="{{ old('cheque_date', $application->cheque_date ?? '') }}"
                                        class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                </div>
                            </div>

                            <!-- Online Transaction Fields -->
                            <div id="onlineFields" class="space-y-4 hidden">
                                <div class="mt-3">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Transfer Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="transfer_date" name="transfer_date" value="{{ old('transfer_date', $application->transfer_date ?? '') }}"
                                        class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        UTR / Transaction No. <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="utr_no" name="utr_no" placeholder="Enter Transaction No." value="{{ old('utr_no', $application->utr_no ?? '') }}"
                                        class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Transfer Mode <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex gap-4 mt-2">
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="transfer_mode" value="imps"
                                                {{ old('transfer_mode', $application->transfer_mode ?? '') == 'imps' ? 'checked' : '' }}>>
                                            <span>IMPS</span>
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="transfer_mode" value="vpa"
                                                {{ old('transfer_mode', $application->transfer_mode ?? '') == 'vpa' ? 'checked' : '' }}>

                                            <span>VPA</span>
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="transfer_mode" value="neft_rtgs"
                                                {{ old('transfer_mode', $application->transfer_mode ?? '') == 'neft_rtgs' ? 'checked' : '' }}>
                                            <span>NEFT/RTGS</span>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Credited in Company Account <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex gap-4 mt-2">
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="credited" value="yes"
                                                {{ old('credited', $application->credited ?? '') == 'yes' ? 'checked' : '' }}>
                                            <span>Yes</span>
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="credited" value="no"
                                                {{ old('credited', $application->credited ?? '') == 'no' ? 'checked' : '' }}>
                                            <span>No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        
                        <p for="" class=" text-error text-sm block mt-3 mb-4">
                            Note: If you wish to collect processing fee at the time of disbursement, then enter 0. Fees
                            will be calculated accordingly.
                        </p>

                    </div>
                </div>
            </div>


            <div class="flex-2 col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6 min-w-[300px]">
                {{-- Member Info Box --}}
                <div id="memberBox" class="w-full hidden"> {{-- hidden by default --}}
                    <div class="flex justify-between items-center bg-secondary/5  rounded-10 px-4 py-3 dark:bg-bg3">
                        <h3 class="text-base capitalize font-semibold md:text-lg">Member Info</h3>
                        <button type="button" class="p-1 rounded transition"
                            onclick="toggleSection(this, 'memberInfoBody')">
                            <span class="toggle-icon text-lg font-bold">−</span>
                        </button>
                    </div>
                    <div id="memberInfoBody" class="px-4 py-3">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                    <tr class="border-b">
                                        <td class="font-semibold py-2 pr-4">Member Name</td>
                                        <td class="py-2 capitalize" id="memberName">-</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold py-2 pr-4">Mobile No</td>
                                        <td class="py-2" id="memberMobile">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

                {{--schemeBox info --}}
                <div id="schemeBox" class=" mt-5 hidden">
                    <div class="flex justify-between items-center bg-secondary/5 rounded-10 px-4 py-3 dark:bg-bg3">
                        <h3 class="text-base font-semibold md:text-lg">Scheme Info</h3>
                        <button type="button" class="p-1 rounded transition"
                            onclick="toggleSection(this, 'schemeInfoBody')">
                            <span class="toggle-icon text-lg font-bold">−</span>
                        </button>
                    </div>

                    <div id="schemeInfoBody" class="px-4 py-3">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <tbody>
                                    <tr>
                                        <td class="font-semibold py-2 pr-4">Scheme Code</td>
                                        <td class="py-2" id="schemeCode">-</td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold py-2 pr-4">Scheme Name</td>
                                        <td class="py-2" id="schemeName">-</td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold py-2 pr-4">Max Tenure</td>
                                        <td class="py-2" id="schemeTenure">-</td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold py-2 pr-4">Maximum Loan Amount</td>
                                        <td class="py-2" id="schemeMax">-</td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold py-2 pr-4">Maximum Loan Limit Against Security</td>
                                        <td class="py-2" id="schemeLimit">-</td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold py-2 pr-4">Minimum Loan Amount</td>
                                        <td class="py-2" id="schemeMin">-</td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold py-2 pr-4">Annual Interest Rate</td>
                                        <td class="py-2" id="schemeInterest">-</td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold py-2 pr-4">Interest Type</td>
                                        <td class="py-2" id="schemeType">-</td>
                                    </tr>
                                
                                    <tr>
                                        <td class="font-semibold py-2 pr-4">Active</td>
                                        <td class="py-2" id="schemeActive">-</td>
                                    </tr>
                                    <tr>
                                        <td class="font-semibold py-2 pr-4">Fore Closure Charges</td>
                                        <td class="py-2" id="schemeCharge">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>


               <div id="itemsContainer"></div>

            <div class="col-span-2 md:col-span-1">
                <label for="" class="uppercase:text-lg font-medium block mb-4">
                    Total Security Amount
                </label>

                <input type="number" id="" name=""
                    class="w-1/3 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="0">
            </div>

            <div class="mt-3">
                <button type="button" id="additem" class="btn-primary uppercase rounded-10 px-4 py-2">
                    + Add NEW Items
                </button>
            </div>



        <!-- Calculation Result Box -->
         <!-- Hidden fields for saving calculation result -->
        <input type="hidden" name="security_value" id="inputSecurity">
        <input type="hidden" name="max_loan_amount" id="inputMaxLoan">
        <input type="hidden" name="max_loan_limit" id="inputLimit">
        <input type="hidden" name="maximum_approvable_amount" id="inputApprovable">
        <input type="hidden" name="approved_loan_amount" id="inputApproved">

        <div id="calculationBox"
            class="mt-5 p-4 bg-secondary/5 rounded-10 hidden">
            <h3 class="text-lg font-semibold mb-3">Calculation Result</h3>
            <table class="w-full text-sm">
                <tbody>
                    <tr>
                        <td class="font-semibold py-1">Net Loan Amount</td>
                        <td id="resNetLoan">-</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1">Security Value</td>
                        <td id="resSecurity">-</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1">Max Loan Amount</td>
                        <td id="resMaxLoan">-</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1">Max Loan Limit</td>
                        <td id="resLimit">-</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1">Maximum Approvable Amount</td>
                        <td id="resApprovable">-</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-1">Approved Loan Amount</td>
                        <td id="resApproved">-</td>
                    </tr>
                </tbody>
            </table>
        </div>

           <!-- Buttons -->
            <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                <button type="button" id="calculateBtn"
                    class="btn-primary rounded-10 px-4 py-2 mt-4">
                    Calculate
                </button>
            </div>

            <button class="btn-outline uppercase justify-center" type="reset">
                <a href="{{route('mortgage.applications.index')}}"> BAck</a>
            </button>
        </div>
    </div>
    </form>
</div>



<script>
document.getElementById('member_id').addEventListener('change', function () {
    let selected = this.options[this.selectedIndex];
    let name = selected.getAttribute('data-name') || '-';
    let mobile = selected.getAttribute('data-mobile') || '-';

    document.getElementById('memberName').textContent = name;
    document.getElementById('memberMobile').textContent = mobile;

    document.getElementById('memberBox').classList.remove('hidden');
});
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const memberSelect = document.getElementById("member_id");
    const memberBox = document.getElementById("memberBox");
    const memberName = document.getElementById("memberName");
    const memberMobile = document.getElementById("memberMobile");

    memberSelect.addEventListener("change", function () {
        const selectedOption = this.options[this.selectedIndex];
        const name = selectedOption.getAttribute("data-name") || "-";
        const mobile = selectedOption.getAttribute("data-mobile") || "-";

        // values set karna
        memberName.textContent = name;
        memberMobile.textContent = mobile;

        // box visible karna
        if (this.value) {
            memberBox.classList.remove("hidden");
        } else {
            memberBox.classList.add("hidden");
        }
    });
});
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const schemeSelect = document.getElementById("scheme_id");
    const schemeBox = document.getElementById("schemeBox");

    const schemeCode = document.getElementById("schemeCode");
    const schemeName = document.getElementById("schemeName");
    const schemeTenure = document.getElementById("schemeTenure");
    const schemeMax = document.getElementById("schemeMax");
    const schemeLimit = document.getElementById("schemeLimit");
    const schemeMin = document.getElementById("schemeMin");
    const schemeInterest = document.getElementById("schemeInterest");
    const schemeType = document.getElementById("schemeType");
   
    const schemeActive = document.getElementById("schemeActive");
    const schemeCharge = document.getElementById("schemeCharge");

    schemeSelect.addEventListener("change", function () {
        const selectedOption = this.options[this.selectedIndex];

        if (this.value) {
            // values set karna
            schemeCode.textContent = selectedOption.getAttribute("data-code") || "-";
            schemeName.textContent = selectedOption.getAttribute("data-name") || "-";
            schemeTenure.textContent = selectedOption.getAttribute("data-tenure") || "-";
            schemeMax.textContent = selectedOption.getAttribute("data-max") || "-";
            schemeLimit.textContent = selectedOption.getAttribute("data-limit") || "-";
            schemeMin.textContent = selectedOption.getAttribute("data-min") || "-";
            schemeInterest.textContent = selectedOption.getAttribute("data-interest") || "-";
            schemeType.textContent = selectedOption.getAttribute("data-type") || "-";
            
            schemeActive.textContent = selectedOption.getAttribute("data-active") || "-";
            schemeCharge.textContent = selectedOption.getAttribute("data-charge") || "-";

            // box visible
            schemeBox.classList.remove("hidden");
        } else {
            // agar select empty ho jaye to hide
            schemeBox.classList.add("hidden");
        }
    });
});
</script>




<script>
document.addEventListener("DOMContentLoaded", () => {
    const radios = document.querySelectorAll('input[name="fee_mode"]');
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

 <script>
let isCalculated = false;

document.getElementById("calculateBtn").addEventListener("click", function (e) {
    const button = this;
    let rows = document.querySelectorAll("#itemsBody tr");
    let totalSecurity = 0;

    rows.forEach(row => {
        let valuePerGram = parseFloat(row.querySelector(".valuePerGram")?.value) || 0;
        let netWeight = parseFloat(row.querySelector(".netWeight")?.value) || 0;
        let tunch = parseFloat(row.querySelector(".tunch")?.value) || 0;

        // Fine Weight = (Net Weight × Tunch%) / 100
        let fineWeight = (netWeight * tunch) / 100;

        // Total Value = ValuePerGram × FineWeight
        let totalValue = valuePerGram * fineWeight;

        // Update total value cell
        let totalValueCell = row.querySelector(".totalValue");
        if (totalValueCell) totalValueCell.textContent = totalValue.toFixed(2);

        totalSecurity += totalValue;
    });

    // Loan and insurance
    let loanAmount = parseFloat(document.getElementById("loanAmount")?.value) || 0;
    let insurance = parseFloat(document.getElementById("insuranceAmount")?.value) || 0;
    let netLoan = loanAmount - insurance;
    document.getElementById("netLoanAmount").value = netLoan.toFixed(2);

    // Scheme details
    let scheme = document.getElementById("scheme_id");
    let selected = scheme.options[scheme.selectedIndex];
    let maxLoan = parseFloat(selected.getAttribute("data-max")) || 0;
    let limit = parseFloat(selected.getAttribute("data-limit")) || 0;
    let approvable = (totalSecurity * limit) / 100;

    // Show in box
    document.getElementById("resNetLoan").textContent = netLoan.toFixed(2);
    document.getElementById("resSecurity").textContent = totalSecurity.toFixed(2);
    document.getElementById("resMaxLoan").textContent = maxLoan.toFixed(2);
    document.getElementById("resLimit").textContent = limit + "%";
    document.getElementById("resApprovable").textContent = approvable.toFixed(2);
    document.getElementById("resApproved").textContent = approvable.toFixed(2);

    // Set hidden fields for backend saving
    document.getElementById("inputSecurity").value = totalSecurity.toFixed(2);
    document.getElementById("inputMaxLoan").value = maxLoan.toFixed(2);
    document.getElementById("inputLimit").value = limit;
    document.getElementById("inputApprovable").value = approvable.toFixed(2);
    document.getElementById("inputApproved").value = approvable.toFixed(2);

    // Show result box
    document.getElementById("calculationBox").classList.remove("hidden");

    // Change button behavior
    if (!isCalculated) {
        e.preventDefault(); // stop submit on first click
        button.textContent = "Submit";
        button.type = "submit";
        isCalculated = true;
    }
});
</script>


<script>
    const addItemBtn = document.getElementById("additem");
    const itemsContainer = document.getElementById("itemsContainer");

    // Template for property block
    const getPropertyBlock = () => `
    
    <div class="box bg-secondary/10 border-b mb-4 mt-4 property-block">
                <div class="flex flex-wrap gap-6">
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            Property Type
                            <span class="text-error">*</span>
                        </label>
                        <select
                            class="w-full text-sm dark:bg-bg3 border border-n30 dark:border-n500 items-start rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                            placeholder="Enter Scheme Code">
                            <option value="">select Property Type</option>
                            <option value="agriculture_land">Agriculture Land</option>
                            <option value="urban_land">Urban Land</option>
                            <option value="plot">Plot</option>
                            <option value="house">House</option>
                            <option value="shop">Shop</option>
                        </select>
                    </div>
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            Doc Number
                        </label>

                        <input type="number" id="" name=""
                            class="w-full text-sm dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Doc Number">
                    </div>
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            Registrar Name
                        </label>

                        <input type="text" id="" name=""
                            class="w-full text-sm dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Registrar Name">
                    </div>
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            Owner Name
                        </label>

                        <input type="text" id="" name=""
                            class="w-1/2 text-sm  dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Owner Name">
                    </div>
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            Parent Name
                        </label>
                        <input type="text" id="" name=""
                            class="w-1/2 text-sm  dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Property Owner's Parent Name">
                    </div>
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            Plot No
                        </label>
                        <input type="number" id="" name=""
                            class="w-1/2 text-sm  dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Plot No/ House No">
                    </div>
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            Tehsil
                        </label>

                        <input type="text" id="" name=""
                            class="w-1/2 text-sm dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Tehsil">
                    </div>
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            District
                        </label>

                        <input type="text" id="" name=""
                            class="w-1/2 text-sm dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter District">
                    </div>
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            Area (SQ FT)
                        </label>

                        <input type="text" id="" name=""
                            class="w-1/2 text-sm dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Area (SQ FT)">
                    </div>

                </div>

                <label for="" class="uppercase:text-lg font-medium block mt-3 mb-4">
                    Boundaries as per Sale Deed
                </label>
                <div class="flex flex-wrap mt-4 gap-6">
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            East
                        </label>

                        <input type="number" id="" name=""
                            class="w-full text-sm dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter East">
                    </div>
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            West
                        </label>

                        <input type="text" id="" name=""
                            class="w-full text-sm dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter West">
                    </div>
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            North
                        </label>

                        <input type="text" id="" name=""
                            class="w-1/2 text-sm dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter North">
                    </div>
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            South
                        </label>
                        <input type="text" id="" name=""
                            class="w-1/2 text-sm dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter South">
                    </div>

                </div>

                 <label for="" class="uppercase :text-lg font-medium block mt-3 mb-4">
                    Boundaries  as per Technical
                </label>
                <div class="flex flex-wrap mt-4 gap-6">
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            East
                        </label>

                        <input type="number" id="" name=""
                            class="w-full text-sm dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter East">
                    </div>
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            West
                        </label>

                        <input type="text" id="" name=""
                            class="w-full text-sm dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter West">
                    </div>
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            North
                        </label>

                        <input type="text" id="" name=""
                            class="w-1/2 text-sm dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter North">
                    </div>
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            South
                        </label>
                        <input type="text" id="" name=""
                            class="w-1/2 text-sm dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter South">
                    </div>
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            Expected Value
                            <span class="text-red-500" >*</span>
                        </label>
                        <input type="text" id="" name=""
                            class="w-1/2 text-sm dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Expected Value">
                    </div>
                    <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                            Registered
                        </label>
                        <select
                            class="w-1/2 text-sm dark:bg-bg3 border border-n30 dark:border-n500 items-start rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                            placeholder="Enter Scheme Code">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                     <div class="w-1/2 mb-3">
                        <label for="" class="uppercase m:text-lg font-medium block mb-4">
                           Action
                        </label>
                            <button class="btn-error text-white justify-center rounded-10 px-4 py-2 remove-item"><i class="las la-times"></i>Remove</button>
                        </div>

                </div>
            </div>
  `;

    // Preload one block on page load
    window.addEventListener("DOMContentLoaded", () => {
        itemsContainer.insertAdjacentHTML("beforeend", getPropertyBlock());
    });

    // Add item on button click
    addItemBtn.addEventListener("click", () => {
        itemsContainer.insertAdjacentHTML("beforeend", getPropertyBlock());
    });

    // Delegate remove action
    itemsContainer.addEventListener("click", (e) => {
        if (e.target.closest(".remove-item")) {
            e.target.closest(".property-block").remove();
        }
    });
</script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const cibilBody = document.getElementById("cibilBody");
            const addRowBtn = document.getElementById("addRow");

            // Template for new row
            function newRow() {
                // Get current date in DD/MM/YYYY format
                const today = new Date();
                const day = String(today.getDate()).padStart(2, '0');
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const year = today.getFullYear();
                const formattedDate = `${day}/${month}/${year}`;

                return `
                                    <tr class="nested-fields border-b">
                                        <!-- Cibil Type -->
                                        <td class="px-2 py-2" style="width:230px;">
                                            <select name="cibil_type[]" required
                                                class="w-full text-center dark:bg-bg3 rounded-10 px-2 py-2 text-sm md:text-base border bg-secondary/5">
                                                <option value="transunion">TransUnion</option>
                                                <option value="equifax">Equifax</option>
                                                <option value="experian">Experian</option>
                                                <option value="crif_highmark">Crif Highmark</option>
                                            </select>
                                        </td>

                                        <!-- Cibil Score -->
                                        <td class="px-2 py-2">
                                            <input type="number" name="cibil_score[]" placeholder="Enter CIBIL Score"
                                                class="w-full text-center dark:bg-bg3 rounded-10 px-2 py-2 text-sm md:text-base border bg-secondary/5" required/>
                                        </td>

                                        <!-- Report Date -->
                                        <td class="px-2 py-2 relative">
                                            <input type="text" id="date2" name="report_date[]" value="${formattedDate}"
                                                class="w-full text-center dark:bg-bg3 rounded-10 px-2 py-2 text-sm md:text-base border bg-secondary/5" required/>
                                        </td>

                                        <!-- Upload File -->
                                        <td class="px-2 py-2">
                                            <input type="file" name="report_file[]"
                                                class="w-full text-center dark:bg-bg3 rounded-10 px-2 py-2 text-sm md:text-base border bg-secondary/5"/>
                                        </td>

                                        <!-- Remove button -->
                                        <td class="px-2 py-2 md:px-4 md:py-2 text-center">
                                            <button type="button" class="removeRow text-red-500 hover:text-red-700">
                                                <i class="las la-times" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;
            }


            // Add row
            addRowBtn.addEventListener("click", () => {


                cibilBody.insertAdjacentHTML("beforeend", newRow());
            });

            // Remove row (event delegation)
            cibilBody.addEventListener("click", function (e) {
                if (e.target.closest(".removeRow")) {
                    e.target.closest("tr").remove();
                }
            });

            //  Add one default row when page loads
            cibilBody.insertAdjacentHTML("beforeend", newRow());
        });

        </script>

@endsection

