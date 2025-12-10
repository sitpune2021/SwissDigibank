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

 @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-3">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 border border-red-300 text-red-600 px-4 py-2 rounded mb-3">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<div class="main-inner">

   <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 id="formHeading" class="text-xl font-semibold"></h1>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if this is an edit page based on URL
        const isEdit = window.location.href.includes('/edit'); // true if editing

        const heading = document.getElementById('formHeading');
        heading.textContent = isEdit ? 'UPDATE CC LIMIT APPLICATION' : 'NEW CC LIMIT APPLICATION';
    });
    </script>


    <div class="box">
        <form method="POST" 
                        action="{{ isset($application) ? route('cc_od.applications.update', $application->id) : route('cc_od.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($application))
                            @method('PUT')
                        @endif

        <div class="flex flex-col lg:flex-row mb-3 gap-4 ">
          <div class="w-full bg-secondary/5 col-span-12 px-3 py-1 rounded-10 lg:col-span-12">
                <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

                        <div class="col-span-2 md:col-span-1">
                             {{-- Application Date --}}           
                            <label class="md:text-lg font-medium block mb-4">
                                Application Date <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="application_date" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                value="{{ \Carbon\Carbon::parse(old('application_date', default: $application->application_date ?? date('Y-m-d')))->format('d-m-Y') }}">
                        </div>
                        
                        <div class="col-span-2 md:col-span-1">
                            <label for="member_id" class="md:text-lg font-medium block mb-4">
                                CUSTOMER <span class="text-red-500">*</span>
                            </label>
                            
                            <select name="member_id" id="member_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                <option value="">Search Member No or Name</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" data-branch="{{ $member->general_branch }}"
                                    {{ old('member_id', $application->member_id ?? '') == $member->id ? 'selected' : '' }}
                                        data-name="{{ $member->member_info_first_name }}"
                                        data-mobile="{{ $member->member_info_mobile_no }}">
                                        {{ $member->member_info_first_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('member_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
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
                            @error('branch_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
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
                            <select name="scheme_id" id="scheme_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                <option value="">Search Scheme Code</option>
                                @foreach($scheme as $sc)
                                    <option value="{{ $sc->id }}"
                                        {{ old('scheme_id', $application->scheme_id ?? '') == $sc->id ? 'selected' : '' }}
                                        data-code="{{ $sc->scheme_code }}"
                                        data-name="{{ $sc->scheme_name }}"
                                        data-tenure="{{ $sc->tenure ?? 0 }}"
                                        data-max="{{ $sc->max_loan_amount ?? 0 }}"
                                        data-limit="{{ $sc->max_loan_limit ?? 0 }}"
                                        data-min="{{ $sc->min_loan_amount ?? 0 }}"
                                        data-interest="{{ $sc->annual_interest_rate ?? 0 }}"
                                        data-type="{{ $sc->gold_loan_setting ?? '' }}"
                                        data-active="{{ $sc->is_active ? 'Yes' : 'No' }}"
                                        data-charge="{{ $sc->charge_floting ?? '' }}">
                                        {{ $sc->scheme_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('scheme_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            </div>
                        </div>
                                               
                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4">
                                Tenure <span id="tenureLabel" class="text-black uppercase">( MONTHS )</span>
                                <span class="text-error">*</span>
                            </label>
                            <input type="number" id="tenure_value" name="tenure_value"
                                value="{{ old('tenure_value', $application->tenure_value ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                @error('tenure_value')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4">
                                Credit Period ( EMI Grace Period ) ( Days )
                                <span class="text-error">*</span>
                            </label>
                            <input type="number" id="credit_period" name="credit_period" value="{{ old('credit_period', $application->credit_period ?? 0) }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0">
                                @error('credit_period')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="netLoanAmount" class="md:text-lg font-medium block mb-6">
                                Requested CC Limit (₹) <span class="text-error">*</span>
                            </label>
                            <input type="number" id="netLoanAmount" name="net_loan_amount"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 mt-5 rounded-10 px-3 md:px-6 py-2 md:py-3 bg-gray-100"
                                placeholder="0" value="{{ old('net_loan_amount', $application->net_loan_amount ?? 0) }}">
                                <p id="amountInWords" class="text-red-500 text-xs mt-1 italic">Zero</p>
                                @error('net_loan_amount')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-4">
                                Purpose of CC Limit
                                <span class="text-error">*</span>
                            </label>
                            <input type="text" id="purpose_of_loan" name="purpose_of_loan"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Purpose of CC Limit" value="{{ old('purpose_of_loan', $application->purpose_of_loan ?? '') }}">
                                @error('purpose_of_loan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="md:text-lg font-medium block mb-4">
                                Link With FD <span class="text-error">*</span>
                            </label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="charge_per_emi" value="0"
                                        {{ old('charge_per_emi', $application->charge_per_emi ?? '0') == '0' ? 'checked' : '' }}>
                                   YES
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="charge_per_emi" value="1"
                                        {{ old('charge_per_emi', $application->charge_per_emi ?? '') == '1' ? 'checked' : '' }}>
                                    NO
                                </label>
                            </div>
                            @error('charge_per_emi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                </div>

                <!-- Credit Score Details -->
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
    @if(isset($application) && $application->creditScores)
        @foreach($application->creditScores as $score)
            <tr >
                <td class="px-2 py-2">
                    <select name="cibil_type[]" class="w-full text-center rounded-10 px-2 py-2 border">
                        <option value="transunion" {{ $score->cibil_type == 'transunion' ? 'selected' : '' }}>TransUnion</option>
                        <option value="equifax" {{ $score->cibil_type == 'equifax' ? 'selected' : '' }}>Equifax</option>
                        <option value="experian" {{ $score->cibil_type == 'experian' ? 'selected' : '' }}>Experian</option>
                        <option value="crif_highmark" {{ $score->cibil_type == 'crif_highmark' ? 'selected' : '' }}>Crif Highmark</option>
                    </select>
                </td>

                <td class="px-2 py-2">
                    <input type="number" name="cibil_score[]" value="{{ $score->cibil_score }}"
                        class="w-full text-center rounded-10 px-2 py-2 border" />
                </td>

                <td class="px-2 py-2">
                    <input type="text" name="report_date[]" value="{{ \Carbon\Carbon::parse($score->report_date)->format('d/m/Y') }}"
                        class="w-full text-center rounded-10 px-2 py-2 border" />
                </td>

                <td class="px-2 py-2">
                    <input type="file" name="report_file[]" class="w-full text-center rounded-10 px-2 py-2 border" />
                    @if($score->report_file_path)
                        <a href="{{ asset('storage/'.$score->report_file_path) }}" target="_blank" class="text-blue-500 underline text-sm">View File</a>
                    @endif
                </td>

                <td class="px-2 py-2 text-center">
                    <button type="button" class="removeRow text-red-500 hover:text-red-700">
                        <i class="las la-times"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    @endif
</tbody>

                                </table>
                            </div>

                    <div class="mt-3">
                        <button type="button" id="addRow" class="btn-primary uppercase text-sm rounded-10 px-4 py-2">
                            + Add New Score
                        </button>
                    </div>

                    {{--calculator checkbox- --}}
                    <!-- <x-checkbox-calculator id="manualEntry" name="manual_entry" label="Collect Principal Amount as EMI"
                        sublabel="(Check this if you want to collect principal amount as EMIs.)" /> -->
                </div>

                        <!-- Collect Advance Processing Fee -->
                <div class="col-span-12  lg:col-span-12 ">
                    <hr>
                    <label for="" class="md:text-lg font-medium block mt-3 mb-4">
                        Collect Advance Processing Fee
                    </label>
                    <div class="w-full overflow-x-auto bg-secondary/5 rounded-10 p-3">

                        <label for="" class="md:text-lg font-medium block mt-3 mb-4">
                            Collect Processing Fee :</label>
                        <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                            <tbody>
                                <!-- Column Labels -->
                                <tr class="">
                                    <th class="text-center px-3 py-2 uppercase ">Value</th>
                                    <th class="text-center px-3 py-2 uppercase ">GST (%)</th>
                                    <th class="text-center px-3 py-2 uppercase ">SGST</th>
                                    <th class="text-center px-3 py-2 uppercase ">CGST</th>
                                    <th class="text-center px-3 py-2 uppercase ">IGST</th>
                                    <th class="text-center px-3 py-2 uppercase ">Total</th>
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
                            Pay Mode 
                        </label>
                            <!-- Radio Buttons -->
                            <div class="mt-3 flex gap-2">
                                <!-- Pay Mode -->
                                <label class="mr-4 flex gap-2 items-center">
                                    <input type="radio" name="fee_mode" value="cash"
                                        {{ old('fee_mode', $application->fee_mode ?? '') == 'cash' ? 'checked' : '' }} checked> <p>
                                            Cash
                                        </p>
                                </label>
                                <label class="mr-4 flex gap-2 items-center">
                                    <input type="radio" name="fee_mode" value="cheque"
                                        {{ old('fee_mode', $application->fee_mode ?? '') == 'cheque' ? 'checked' : '' }}> <p>Cheque</p>
                                </label>
                                <label class="mr-4 flex gap-2 items-center">
                                    <input type="radio" name="fee_mode" value="online"
                                        {{ old('fee_mode', $application->fee_mode ?? '') == 'online' ? 'checked' : '' }}> <p>Online Tr.</p>
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
                                                {{ old('transfer_mode', $application->transfer_mode ?? '') == 'imps' ? 'checked' : '' }}>
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
                        <h3 class="text-base uppercase font-semibold md:text-lg">Customer Info</h3>
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
                                        <td class="font-semibold uppercase py-2 pr-4">Customer Name</td>
                                        <td class="py-2 capitalize" id="memberName">-</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Mobile No</td>
                                        <td class="py-2" id="memberMobile">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            

                {{--schemeBox info --}}
                <div id="schemeBox" class=" mt-5 hidden">
                    <div class="flex justify-between items-center bg-secondary/5 rounded-10 px-4 py-3 dark:bg-bg3">
                        <h3 class="text-base uppercase font-semibold md:text-lg">Scheme Info</h3>
                        <button type="button" class="p-1 rounded transition"
                            onclick="toggleSection(this, 'schemeInfoBody')">
                            <span class="toggle-icon text-lg font-bold">−</span>
                        </button>
                    </div>

                    <div id="schemeInfoBody" class="px-4 py-3">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <tbody>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Scheme Code</td>
                                        <td class="py-2" id="schemeCode">-</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Scheme Name</td>
                                        <td class="py-2" id="schemeName">-</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Max Tenure</td>
                                        <td class="py-2" id="schemeTenure">-</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Maximum Loan Amount</td>
                                        <td class="py-2" id="schemeMax">-</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Maximum Loan Limit Against Security</td>
                                        <td class="py-2" id="schemeLimit">- %</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Minimum Loan Amount</td>
                                        <td class="py-2" id="schemeMin">-</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Annual Interest Rate</td>
                                        <td class="py-2" id="schemeInterest">-</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Interest Type</td>
                                        <td class="py-2" id="schemeType">-</td>
                                    </tr>
                                
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Active</td>
                                        <td class="py-2" id="schemeActive">-</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Fore Closure Charges</td>
                                        <td class="py-2" id="schemeCharge">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
</div>
    

        
        <!-- Calculation Result Box -->
       <!-- Hidden fields for backend -->
        <input type="hidden" id="inputNetLoan" name="max_loan_amount">
        <input type="hidden" id="inputMaxLoan" name="maximum_approvable_amount">
        <input type="hidden" id="inputApprovable" name="approved_loan_amount">

                <div id="calculationBox" class="mt-5 p-4 bg-secondary/5 rounded-10 hidden">
                    <h3 class="text-lg font-semibold mb-3">Calculation Result</h3>
                    <table class="w-full text-sm">
                        <tbody>
                            <tr>
                                <td class="font-semibold py-1">Net Loan Amount</td>
                                <td id="resNetLoan">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold py-1">Max Loan Amount</td>
                                <td id="resMaxLoan">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold py-1">Maximum Approvable Amount</td>
                                <td id="resApprovable">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>



           <!-- Buttons -->
            <div class="flex flex-col min-w-10 sm:flex-row justify-start gap-3 mt-5">
                <button type="button" id="calculateBtn"
                    class="btn-primary uppercase justify-center">
                    Calculate
                </button>
                <button class="btn-outline uppercase justify-center" type="reset">
                <a href="{{route('cc_od.applications.index')}}"> Back</a>
            </button>
            </div>
    </form>
</div>
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

        // Step 1: Get base value (only Net Loan)
        const netLoan = parseFloat(document.getElementById("netLoanAmount")?.value) || 0;

        // Step 2: Get scheme details
        const scheme = document.getElementById("scheme_id");
        const selected = scheme.options[scheme.selectedIndex];
        const maxLoan = parseFloat(selected.getAttribute("data-max")) || 0;

        // Step 3: Approvable = min(NetLoan, MaxLoan)
        const approvable = Math.min(netLoan, maxLoan);

        // Step 4: Display results
        document.getElementById("resNetLoan").textContent = netLoan.toFixed(2);
        document.getElementById("resMaxLoan").textContent = maxLoan.toFixed(2);
        document.getElementById("resApprovable").textContent = approvable.toFixed(2);

        // Step 5: Set hidden inputs for backend
        document.getElementById("inputNetLoan").value = netLoan.toFixed(2);
        document.getElementById("inputMaxLoan").value = maxLoan.toFixed(2);
        document.getElementById("inputApprovable").value = approvable.toFixed(2);

        // Step 6: Show calculation box
        document.getElementById("calculationBox").classList.remove("hidden");

        // Step 7: Convert Calculate → Submit on 2nd click
        if (!isCalculated) {
            e.preventDefault(); // stop immediate submission
            button.textContent = "Submit";
            button.type = "submit";
            isCalculated = true;
        }
    });
</script>


 <script>
    document.addEventListener("DOMContentLoaded", function () {
    const cibilBody = document.getElementById("cibilBody");
    const addRowBtn = document.getElementById("addRow");

    // Template for new row
    function newRow() {
        const today = new Date();
        const day = String(today.getDate()).padStart(2, '0');
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const year = today.getFullYear();
        const formattedDate = `${day}-${month}-${year}`;

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
                        class="w-full text-center dark:bg-bg3 rounded-10 px-2 py-2 text-sm md:text-base border bg-secondary/5">
                </td>

                <!-- Report Date -->
                <td class="px-2 py-2 relative">
                    <input type="text" name="report_date[]" value="${formattedDate}"
                        class="w-full text-center dark:bg-bg3 rounded-10 px-2 py-2 text-sm md:text-base border bg-secondary/5" required/>
                </td>

                <!-- Upload File -->
                <td class="px-2 py-2">
                    <input type="file" name="report_file[]"
                        class="w-full text-center dark:bg-bg3 rounded-10 px-2 py-2 text-sm md:text-base border bg-secondary/5"/>
                </td>

                <!-- Remove button -->
                <td class="px-2 py-2 text-center">
                    <button type="button" class="removeRow text-red-500 hover:text-red-700">
                        <i class="las la-times"></i>
                    </button>
                </td>
            </tr>
        `;
    }

    // Add new row
    addRowBtn.addEventListener("click", () => {
        cibilBody.insertAdjacentHTML("beforeend", newRow());
    });

    // Remove row (event delegation)
    cibilBody.addEventListener("click", function (e) {
        if (e.target.closest(".removeRow")) {
            e.target.closest("tr").remove();
        }
    });

    // ✅ Only add a new row if there are NO existing rows (i.e. new application)
    if (cibilBody.children.length === 0) {
        cibilBody.insertAdjacentHTML("beforeend", newRow());
    }
});
</script>

<!-- branch Auto populate when select customer -->
 <script>
    document.addEventListener("DOMContentLoaded", function () {
        const memberSelect = document.getElementById("member_id");
        const branchSelect = document.getElementById("branch_id");

        memberSelect.addEventListener("change", function () {
            let selectedOption = this.options[this.selectedIndex];
            let branchId = selectedOption.getAttribute("data-branch");

            if (branchId) {
                branchSelect.value = branchId;
            } else {
                branchSelect.value = "";
            }
        });
    });
</script>

<!-- Max Tenure & tenure vaule Validation -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const schemeSelect = document.getElementById("scheme_id");
        const tenureInput = document.getElementById("tenure_value");

        function validateTenure() {
            const selectedOption = schemeSelect.options[schemeSelect.selectedIndex];
            const maxTenure = parseInt(selectedOption?.getAttribute("data-tenure")) || 0;
            const val = parseInt(tenureInput.value) || 0;

            // If maxTenure not defined, skip
            if (!maxTenure) return;

            // Validate
            if (val > maxTenure) {
                tenureInput.classList.add("border-red-500");
                document.getElementById("tenureError")?.remove();

                const errorMsg = document.createElement("p");
                errorMsg.id = "tenureError";
                errorMsg.className = "text-error text-sm mt-1";
                errorMsg.textContent = `Tenure cannot exceed ${maxTenure} months for this scheme.`;
                tenureInput.insertAdjacentElement("afterend", errorMsg);

                tenureInput.value = maxTenure; // optional cap
            } else {
                tenureInput.classList.remove("border-red-500");
                document.getElementById("tenureError")?.remove();
            }
        }

        schemeSelect.addEventListener("change", validateTenure);
        tenureInput.addEventListener("input", validateTenure);
    });
    </script>

<!-- sub text massage show -->
<script>
function numberToWords(num) {
    const a = [
        '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
        'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen',
        'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
    ];
    const b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

    if ((num = num.toString()).length > 9) return 'Overflow';
    const n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; 
    let str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + ' Crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + ' Lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + ' Thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + ' Hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + ' ' : '';
    return str.trim();
}

document.getElementById('netLoanAmount').addEventListener('input', function() {
    const val = parseInt(this.value);
    const textElement = document.getElementById('amountInWords');
    if (!val) {
        textElement.textContent = 'Zero';
    } else {
        textElement.textContent = numberToWords(val);
    }
});
</script>

@endsection

