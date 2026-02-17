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
<style>
    label {
        text-transform: uppercase;
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
    <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col  gap-2">

            <h1 class="text-xl font-semibold"> {{ isset($application) ? 'UPDATE GOLD LOAN APPLICATION' : 'NEW GOLD LOAN APPLICATION' }}</h1>
        </div>
    </div>

    <div class="box">

        <form id="loanForm" method="POST" enctype="multipart/form-data"
            action="  {{ isset($application) ? route('gold-loan.applications.update', $application->id) : route('loan-applications.store') }}">
            @csrf
            @if(isset($application))
            @method('PUT')
            @endif

            <!-- Hidden Calculation Fields -->
            <input type="hidden" name="security_value" id="security_value">
            <input type="hidden" name="max_loan_amount" id="max_loan_amount">
            <input type="hidden" name="max_loan_limit" id="max_loan_limit">
            <input type="hidden" name="maximum_approvable_amount" id="maximum_approvable_amount">
            <input type="hidden" name="approved_loan_amount" id="approved_loan_amount">

            <div class=" flex flex-col lg:flex-row  gap-2">

                <div class="w-full col-span-12 bg-primary/5 px-3 py-1 rounded-10  lg:col-span-12">

                    <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

                        <div class="col-span-2 md:col-span-1">
                            {{-- Application Date --}}
                            <label class="md:text-lg font-medium block mb-4">
                                Application Date <span class="text-red-500">*</span>
                            </label>

                            <input type="text" name="application_date" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                value="{{ \Carbon\Carbon::parse(old('application_date', $application->application_date ?? date('Y-m-d')))->format('d-m-Y') }}">
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
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                1st Co-Applicant Customer</label>
                            <select name="co_applicant_1_id" id="co_applicant_1_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                <option value="">Search Customer No or Name</option>
                                @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id', $application->
                                        co_applicant_1_id ?? '') == $member->id ? 'selected' : '' }}>
                                    {{ $member->member_info_first_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                2nd Co-Applicant Customer</label>
                            <select name="co_applicant_2_id" id="co_applicant_2_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                <option value="">Search Customer No or Name</option>
                                @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id', $application->
                                        co_applicant_2_id ?? '') == $member->id ? 'selected' : '' }}>
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
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                Advisor/ Staff</label>
                            <select
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                placeholder="Enter Scheme Code">
                                <option value="">select Advisor/ Staff </option>
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                Guarantor 1 </label>
                            <select name="guarantor_1_id" id="guarantor_1_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                <option value="">Search Customer No or Name</option>
                                @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id', $application->guarantor_1_id
                                        ?? '') == $member->id ? 'selected' : '' }}>
                                    {{ $member->member_info_first_name }}
                                </option>

                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <div class="col-sm-7">
                                <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                    Guarantor 2</label>
                                <select name="guarantor_2_id" id="guarantor_2_id"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Search Customer No or Name</option>
                                    @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ old('member_id', $application->
                                            guarantor_2_id ?? '') == $member->id ? 'selected' : '' }}>
                                        {{ $member->member_info_first_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <div class="col-sm-7">
                                <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                    Guarantor 3 </label>
                                <select name="guarantor_3_id" id="guarantor_3_id"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Search Customer No or Name</option>
                                    @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ old('member_id', $application->
                                            guarantor_3_id ?? '') == $member->id ? 'selected' : '' }}>
                                        {{ $member->member_info_first_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <div class="col-sm-7">
                                <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                    Guarantor 4 </label>
                                <select name="guarantor_4_id" id="guarantor_4_id"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Search Customer No or Name</option>
                                    @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ old('member_id', $application->
                                            guarantor_4_id ?? '') == $member->id ? 'selected' : '' }}>
                                        {{ $member->member_info_first_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <div class="col-sm-7">
                                <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                    Scheme <span class="text-error">*</span>
                                </label>

                                <select name="scheme_id" id="scheme_id"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Search Scheme Code</option>
                                    @foreach($scheme as $sc)
                                    <option value="{{ $sc->id }}" {{ old('scheme_id', $application->scheme_id ?? '')
                                            == $sc->id ? 'selected' : '' }}
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
                                        {{ $sc->scheme_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('scheme_id')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            {{-- do not remove div --}}
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <div class="col-sm-7">
                                <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                    Tenure Type
                                    <span class="text-error">*</span>
                                </label>
                                <div class="flex">
                                    <label class="flex items-center gap-2 space-x-2 p-1">
                                        <input type="radio" name="tenure_type" value="days" {{ old('tenure_type',
                                                $application->tenure_type ?? '') == 'days' ?
                                            'checked' : '' }}>
                                        <span class="text-gray-70 capitalize">DAYS</span>
                                    </label>
                                    <label class="flex items-center gap-2 space-x-2 p-1">
                                        <input type="radio" name="tenure_type" value="weeks" {{ old('tenure_type',
                                                $application->tenure_type ?? '') == 'weeks' ?
                                            'checked' : '' }}>
                                        <span class="text-gray-70 capitalize">WEEKS</span>
                                    </label>
                                    <label class="flex items-center gap-2 space-x-2 p-1">
                                        <input type="radio" name="tenure_type" value="months" {{ old('tenure_type',
                                                $application->tenure_type ?? '') == 'months' ?
                                            'checked' : '' }}>
                                        <span class="text-gray-70 capitalize">MONTHS</span>
                                    </label>
                                </div>
                                @error('tenure_type')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                Tenure <span id="tenureLabel" class="text-black uppercase">( MONTHS )</span>
                                <span class="text-error">*</span>
                            </label>
                            <input type="number" id="tenure_value" name="tenure_value" value="{{ old('tenure_value', $application->tenure_value ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                            @error('tenure_value')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="md:text-lg font-medium block mb-4  uppercase">
                                EMI Collection <span class="text-error">* </span>
                            </label>
                            <select id="emi_collection" name="emi_collection" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 mt-7 capitalize">
                                <option value="">Please Select</option>
                                {{-- options will be dynamically added --}}
                            </select>
                            @error('emi_collection')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                Credit Period(EMI Grace Period)(Days)
                                <span class="text-error">*</span>
                            </label>
                            <input type="number" id="credit_period" name="credit_period" value="{{ old('credit_period', $application->credit_period ?? 0) }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0">
                            @error('credit_period')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="loanAmount" class="md:text-lg font-medium block mb-4 uppercase">
                                Loan Amount (₹) <span class="text-error">*</span>
                            </label>
                            <input type="number" id="loanAmount" name="loan_amount"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0" value="{{ old('loan_amount', $application->loan_amount ?? 0) }}">
                            <p id="amountInWords" class="text-red-600 text-sm mt-1"></p>
                            @error('loan_amount')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="insuranceAmount" class="md:text-lg font-medium block mb-4 uppercase">
                                Insurance Amount (₹) <span class="text-error">*</span>
                            </label>
                            <input type="number" id="insuranceAmount" name="insurance_amount"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Insurance Amount (₹)" value="{{ old('insurance_amount', $application->insurance_amount ?? 0) }}">
                            <p id="insuranceInWords" class="text-red-600 text-sm mt-1"></p>
                            @error('insurance_amount')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="netLoanAmount" class="md:text-lg font-medium block mb-4 uppercase">
                                Net Loan Amount (₹) <span class="text-error">*</span>
                            </label>
                            <input type="number" id="netLoanAmount" name="net_loan_amount" readonly
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 bg-gray-100"
                                placeholder="0" value="{{ old('net_loan_amount', $application->net_loan_amount ?? 0) }}">
                            <p id="netAmountInWords" class="text-red-600 text-sm mt-1"></p>
                            @error('net_loan_amount')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                Purpose of Loan
                                <span class="text-error">*</span>
                            </label>

                            <input type="text" id="purpose_of_loan" name="purpose_of_loan"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Purpose of Loan" value="{{ old('purpose_of_loan', $application->purpose_of_loan ?? '') }}">
                            @error('purpose_of_loan')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
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
                                    @if(isset($creditScores) && count($creditScores))
                                    @foreach($creditScores as $score)
                                    <tr class="nested-fields border-b">
                                        <td class="px-2 py-2" style="width:230px;">
                                            <select name="cibil_type[]"
                                                class="w-full text-center dark:bg-bg3 rounded-10 px-2 py-2 text-sm md:text-base border bg-secondary/5">
                                                <option value="transunion" {{ $score->cibil_type == 'transunion' ? 'selected' : '' }}>TransUnion</option>
                                                <option value="equifax" {{ $score->cibil_type == 'equifax' ? 'selected' : '' }}>Equifax</option>
                                                <option value="experian" {{ $score->cibil_type == 'experian' ? 'selected' : '' }}>Experian</option>
                                                <option value="crif_highmark" {{ $score->cibil_type == 'crif_highmark' ? 'selected' : '' }}>Crif Highmark</option>
                                            </select>
                                        </td>

                                        <td class="px-2 py-2">
                                            <input type="number" name="cibil_score[]" placeholder="Enter CIBIL Score"
                                                class="w-full text-center dark:bg-bg3 rounded-10 px-2 py-2 text-sm md:text-base border bg-secondary/5"
                                                value="{{ $score->cibil_score }}">
                                        </td>

                                        <td class="px-2 py-2 relative">
                                            <input type="text" name="report_date[]"
                                                value="{{ $score->report_date ? \Carbon\Carbon::parse($score->report_date)->format('d-m-Y') : '' }}"
                                                class="w-full text-center dark:bg-bg3 rounded-10 px-2 py-2 text-sm md:text-base border bg-secondary/5">
                                        </td>

                                        <td class="px-2 py-2 text-center">
                                            @if(!empty($score->report_file))
                                            @php
                                            $filePath = 'storage/'.$score->report_file;
                                            $extension = pathinfo($score->report_file, PATHINFO_EXTENSION);
                                            @endphp

                                            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                            {{-- Show small image preview --}}
                                            <a href="{{ asset($filePath) }}" target="_blank">
                                                <img src="{{ asset($filePath) }}"
                                                    alt="Credit Report"
                                                    class="mx-auto rounded-md border border-gray-300 shadow-sm"
                                                    style="width:60px; height:60px; object-fit:cover;">
                                            </a>
                                            @else
                                            {{-- Show "View File" link for non-image files --}}
                                            <a href="{{ asset($filePath) }}" target="_blank" class="text-blue-600 underline">
                                                View File
                                            </a>
                                            @endif
                                            <br>
                                            @endif

                                            {{-- Upload new file --}}
                                            <input type="file" name="report_file[]"
                                                class="w-full text-center dark:bg-bg3 rounded-10 px-2 py-2 text-sm md:text-base border bg-secondary/5" />
                                        </td>

                                        <td class="px-2 py-2 md:px-4 md:py-2 text-center">
                                            <button type="button" class="removeRow text-red-500 hover:text-red-700">
                                                <i class="las la-times" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    {{-- If no records, show default empty row --}}
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <button type="button" id="addRow" class="btn-primary rounded-10 px-4 py-2 uppercase">
                                + Add New Score
                            </button>
                        </div>

                    </div>

                    <!-- Collect Advance Processing Fee -->
                    <div class="col-span-12  lg:col-span-12 mb-4 ">
                        <hr>
                        <label for="" class="md:text-lg font-medium block mt-3 mb-4 uppercase">
                            Collect Advance Processing Fee
                        </label>
                        <div class="w-full overflow-x-auto bg-secondary/5 rounded-10 p-3">

                            <label for="" class="md:text-lg font-medium block mt-3 mb-4 uppercase">
                                Collect Processing Fee :</label>
                            <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                                <tbody>
                                    <!-- Column Labels -->
                                    <tr class="">
                                        <th class="text-center px-3 py-2 uppercase">Value</th>
                                        <th class="text-center px-3 py-2 uppercase">GST (%)</th>
                                        <th class="text-center px-3 py-2 uppercase">SGST</th>
                                        <th class="text-center px-3 py-2 uppercase">CGST</th>
                                        <th class="text-center px-3 py-2 uppercase">IGST</th>
                                        <th class="text-center px-3 py-2 uppercase">Total</th>
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
                                            <input type="text" name="processing_fee_gst" id="processing_fee_gst"
                                                value="18.0" readonly
                                                class="w-full px-2 py-2 text-center  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <!-- SGST -->
                                        <td class="px-2 py-2 ">
                                            <input type="text" name="processing_fee_sgst" id="processing_fee_sgst"
                                                value="0" readonly
                                                class="w-full px-2 py-2 text-center  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <!-- CGST -->
                                        <td class="px-2 py-2 ">
                                            <input type="text" name="processing_fee_cgst" id="processing_fee_cgst"
                                                value="0" readonly
                                                class="w-full px-2 py-2 text-center  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <!-- IGST -->
                                        <td class="px-2 py-2 ">
                                            <input type="text" name="processing_fee_igst" id="processing_fee_igst"
                                                value="0" readonly
                                                class="w-full px-2 py-2 text-center  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <!-- Total -->
                                        <td class="px-2 py-2">
                                            <input type="number" name="processing_fee_total" id="processing_fee_total"
                                                placeholder="0"
                                                class="w-full px-2 py-2 text-center  rounded-10 text-sm md:text-base" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <label for="" class="md:text-lg font-medium block mt-3 mb-4 uppercase">
                                Pay Mode
                            </label>
                            <!-- Radio Buttons -->
                            <div class="mt-3 flex gap-3 ">
                                <!-- Pay Mode -->
                                <label class="mr-4 flex items-center flex-row gap-3">
                                    <input type="radio" name="fee_mode" value="cash" {{ old('fee_mode',
                                            $application->fee_mode ?? '') == 'cash' ? 'checked' : '' }}>
                                    Cash
                                </label>
                                <label class="mr-4 flex items-center flex-row gap-3">
                                    <input type="radio" name="fee_mode" value="cheque" {{ old('fee_mode',
                                            $application->fee_mode ?? '') == 'cheque' ? 'checked' : '' }}>
                                    Cheque
                                </label>
                                <label class="mr-4 flex items-center flex-row gap-3">
                                    <input type="radio" name="fee_mode" value="online" {{ old('fee_mode',
                                            $application->fee_mode ?? '') == 'online' ? 'checked' : '' }}> Online Tr.
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
                                        type="text"
                                        id="cheque_date"
                                        name="cheque_date"
                                        value="{{ old('cheque_date', isset($application->cheque_date) ? \Carbon\Carbon::parse($application->cheque_date)->format('d-m-Y') : '') }}"
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
                                        type="text"
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
                                                value="imps" {{ old('transfer_mode', $application->transfer_mode ?? '') == 'imps' ?
                                                'checked' : '' }}>
                                            <span>IMPS</span>
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="transfer_mode"
                                                value="vpa" {{ old('transfer_mode', $application->transfer_mode ?? '') == 'vpa' ?
                                                'checked' : '' }}>
                                            <span>VPA</span>
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="transfer_mode"
                                                value="neft_rtgs" {{ old('transfer_mode', $application->transfer_mode ?? '') == 'neft_rtgs' ?
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

                            <p for="" class=" text-error text-sm block mt-3 mb-4">
                                Note: If you wish to collect processing fee at the time of disbursement, then enter 0.
                                Fees
                                will be calculated accordingly.
                            </p>

                        </div>
                    </div>

                    <input type="hidden" name="ratio_enabled" id="ratio_enabled"
                            value="{{ old('ratio_enabled', $application->ratio_enabled ?? 'No') }}">

                    <input type="hidden" name="ratio_first_emi" id="ratio_first_emi"
                          value="{{ old('ratio_first_emi', $application->ratio_first_emi ?? '') }}">

                    <input type="hidden" name="ratio_first_percentage" id="ratio_first_percentage"
                            value="{{ old('ratio_first_percentage', $application->ratio_first_percentage ?? '') }}">

                    <input type="hidden" name="interest_as_emi" id="interest_as_emi"
                            value="{{ old('interest_as_emi', $application->interest_as_emi ?? '') }}">

                    <input type="hidden" name="interest_as_first" id="interest_as_first"
                        value="{{ old('interest_as_first', $application->interest_as_first ?? '') }}">
                    
                    <div id="interestOptions" style="display:none; margin-top:10px;">
                        <!-- Checkbox 1 -->
                        <label class="flex gap-2" id="chk_emi_box">
                            <input type="checkbox" name="option_interest_emi" id="option_interest_emi" value="Yes"
                            {{ old('interest_as_emi', $application->interest_as_emi ?? '') == 'Yes' ? 'checked' : '' }}>
                            <span id="chk_emi_text">Collect Interest as EMI & Principal after tenure</span>
                        </label>

                        <!-- Checkbox 2 -->
                        <label class="flex gap-2 mt-2" id="chk_first_box">
                            <input type="checkbox" name="option_interest_first" id="option_interest_first" value="Yes"
                            {{ old('interest_as_first', $application->interest_as_first ?? '') == 'Yes' ? 'checked' : '' }}>
                            <span id="chk_emi_text">Collect Interest as EMIs First & then after Principal as EMIs</span>
                        </label>

                    </div>


                    <!-- REDUCING EMI SPECIAL CHECKBOX -->
                    <div class="flex gap-2" id="reduce_ratio_box" style="display:none;">
                        <label class="flex gap-2 items-center">
                            <input type="checkbox"  name="divide_emi_ratio" id="divide_emi_ratio" value="1" 
                            {{ old('ratio_enabled', $application->ratio_enabled ?? '') == 'Yes' ? 'checked' : '' }}
                            style="width:20px !important; height:20px !important;">
                        </label>
                        <span>Check this if you want to divide loan EMIs in ratio.</span>
                    </div>


                    <!-- RATIO FIELDS -->
                    <div id="ratioFields" style="display: {{ old('ratio_enabled', $application->ratio_enabled ?? 'No') == 'Yes' ? 'block' : 'none' }}; margin-top:10px;">


                        <!-- EMI Ratio -->
                        <label class="block mb-2 font-semibold">EMI Ratio <span id="emi_total_text"></span> </label>

                        <div class="flex gap-3">
                            <input type="number" id="emi_ratio_1" class="w-full rounded-10 bg-secondary/5 border p-2" 
                            value="{{ old('ratio_first_emi', $application->ratio_first_emi ?? '') }}"
                            min="1">
                            <input type="number" id="emi_ratio_2" class="w-full rounded-10 bg-secondary/5 border p-2 bg-gray-100" readonly>
                        </div>

                        <!-- Loan Amount Ratio -->
                        <label class="block mt-4 mb-2 font-semibold">Loan Amount % Ratio</label>

                        <div class="flex gap-3">
                            <input type="number" name="ratio_first_percentage" id="amt_ratio_1" class="w-full border bg-secondary/5 rounded-10 p-2"
                            value="{{ old('ratio_first_percentage', $application->ratio_first_percentage ?? '') }}" min="1" max="100">
                            <input type="number" id="amt_ratio_2" class="w-full border bg-secondary/5 rounded-10 p-2 bg-gray-100" readonly>
                        </div>

                    </div>
                    <p id="emiRatioError" class="text-red-600 text-sm mt-1 hidden">
                        EMI Ratio total cannot be greater then tenure.
                    </p>

                </div>

                <div class="flex-2 col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6 min-w-[300px]">
                    {{-- Customer Info Box --}}
                    <div id="memberBox" class="w-full hidden"> {{-- hidden by default --}}
                        <div class="flex justify-between items-center bg-secondary/5  rounded-10 px-4 py-3 dark:bg-bg3">
                            <h3 class="text-base font-semibold md:text-lg uppercase">Customer Info</h3>
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
                                            <td class="font-semibold py-2 pr-4 uppercase">Customer Name</td>
                                            <td class="py-2 capitalize" id="memberName">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold py-2 pr-4 uppercase">Mobile No</td>
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
                            <h3 class="text-base font-semibold md:text-lg uppercase">Scheme Info</h3>
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
                                            <td class="font-semibold py-2 pr-4 uppercase">Scheme Code</td>
                                            <td class="py-2" id="schemeCode">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold py-2 pr-4 uppercase">Scheme Name</td>
                                            <td class="py-2" id="schemeName">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold py-2 pr-4 uppercase">Max Tenure</td>
                                            <td class="py-2" id="schemeTenure">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold py-2 pr-4 uppercase">Maximum Loan Amount</td>
                                            <td class="py-2" id="schemeMax">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold py-2 pr-4 uppercase">Maximum Loan Limit Against
                                                Security</td>
                                            <td class="py-2" id="schemeLimit">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold py-2 pr-4 uppercase">Minimum Loan Amount</td>
                                            <td class="py-2" id="schemeMin">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold py-2 pr-4 uppercase">Annual Interest Rate</td>
                                            <td class="py-2" id="schemeInterest">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold py-2 pr-4 uppercase">Interest Type</td>
                                            <td class="py-2" id="schemeType">-</td>
                                        </tr>

                                        <tr class="border-b">
                                            <td class="font-semibold py-2 pr-4 uppercase">Active</td>
                                            <td class="py-2" id="schemeActive">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold py-2 pr-4 uppercase">Fore Closure Charges</td>
                                            <td class="py-2" id="schemeCharge">-</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Ornaments -->
            <div class="w-full overflow-x-auto mt-5">
                <table class="w-full rounded-10 whitespace-nowrap text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="text-center px-2 py-2 bg-secondary/5">#</th>
                            <th class="text-center px-2 py-2 bg-secondary/5 uppercase">Item Type <span
                                    class="text-red-500">*</span>
                            </th>
                            <th class="text-center px-2 py-2 bg-secondary/5 uppercase">Item Name <span
                                    class="text-red-500">*</span>
                            </th>
                            <th class="text-center px-2 py-2 bg-secondary/5 uppercase">No of Item <span
                                    class="text-red-500">*</span>
                            </th>
                            <th class="text-center px-2 py-2 bg-secondary/5 uppercase">Value per Gram (A) (₹)
                                <span class="text-red-500">*</span>
                            </th>
                            <th class="text-center px-2 py-2 bg-secondary/5 uppercase">Gross Weight (gm) <span
                                    class="text-red-500">*</span></th>
                            <th class="text-center px-2 py-2 bg-secondary/5 uppercase">Net Weight (B) (gm) <span
                                    class="text-red-500">*</span></th>
                            <th class="text-center px-2 py-2 bg-secondary/5 uppercase">Tunch (C) (%)<span
                                    class="text-red-500">*</span></th>
                            <th class="text-center px-2 py-2 bg-secondary/5 uppercase">
                                Fine Weight *(D = C% of B) (gm)
                                <span class="text-red-500">*</span>
                            </th>
                            <th class="text-center px-2 py-2 bg-secondary/5 uppercase">Total Value (A * D)(₹)
                            </th>
                            <th class="text-center px-2 py-2 bg-secondary/5 uppercase">Item Image</th>
                            <th class="px-2 py-2 bg-secondary/5"></th>
                        </tr>
                    </thead>

                    <tbody id="itemsBody" class="whitespace-nowrap">
                        @if(isset($ornaments) && count($ornaments))
                        @foreach($ornaments as $key => $item)
                        <tr>
                            <td class="text-center px-2 py-2">{{ $key + 1 }}</td>
                            <td class="px-2 py-2">
                                <select name="item_type[]" class="itemType w-full rounded px-2 py-2 border bg-secondary/5 text-sm">
                                    <option {{ $item->item_type == 'Gold Jewelery' ? 'selected' : '' }}>Gold Jewelery</option>
                                    <option {{ $item->item_type == 'Gold Coin' ? 'selected' : '' }}>Gold Coin</option>
                                    <option {{ $item->item_type == 'Gold Biscuit' ? 'selected' : '' }}>Gold Biscuit</option>
                                    <option {{ $item->item_type == 'Silver Jewelery' ? 'selected' : '' }}>Silver Jewelery</option>
                                    <option {{ $item->item_type == 'Silver Coin' ? 'selected' : '' }}>Silver Coin</option>
                                    <option {{ $item->item_type == 'Silver Biscuit' ? 'selected' : '' }}>Silver Biscuit</option>
                                    <option {{ $item->item_type == 'Platinum' ? 'selected' : '' }}>Platinum</option>
                                    <option {{ $item->item_type == 'Diamond' ? 'selected' : '' }}>Diamond</option>
                                    <option {{ $item->item_type == 'Stone' ? 'selected' : '' }}>Stone</option>
                                </select>
                            </td>
                            <td class="px-2 py-2">
                                <input type="text" name="item_name[]" class="itemName w-full bg-secondary/5 rounded px-2 py-2 border text-center text-sm"
                                    value="{{ $item->item_name }}">
                            </td>
                            <td class="px-2 py-2">
                                <input type="number" name="no_of_items[]" class="noOfItem w-full bg-secondary/5 rounded px-2 py-2 border text-center text-sm"
                                    value="{{ $item->no_of_items }}">
                            </td>
                            <td class="px-2 py-2">
                                <input type="number" name="value_per_gram[]" class="valuePerGram w-full bg-secondary/5 rounded px-2 py-2 border text-center text-sm"
                                    value="{{ $item->value_per_gram }}">
                            </td>
                            <td class="px-2 py-2">
                                <input type="number" name="gross_weight[]" class="grossWeight w-full rounded px-2 py-2 border bg-secondary/5 text-center text-sm"
                                    value="{{ $item->gross_weight }}">
                            </td>
                            <td class="px-2 py-2">
                                <input type="number" name="net_weight[]" class="netWeight w-full bg-secondary/5 rounded px-2 py-2 border text-center text-sm"
                                    value="{{ $item->net_weight }}">
                            </td>
                            <td class="px-2 py-2">
                                <input type="number" name="tunch[]" class="tunch w-full rounded bg-secondary/5 px-2 py-2 border text-center text-sm"
                                    value="{{ $item->tunch }}">
                            </td>
                            <td class="px-2 py-2">
                                <input type="number" name="fine_weight[]" class="fineWeight w-full rounded px-2 py-2 border bg-secondary/5 text-center text-sm bg-gray-100"
                                    value="{{ $item->fine_weight }}" readonly>
                            </td>
                            <td class="px-2 py-2">
                                <input type="number" name="total_value[]" class="totalValue w-full rounded px-2 py-2 border bg-secondary/5 text-center text-sm bg-gray-100"
                                    value="{{ $item->total_value }}" readonly>
                            </td>
                            <td class="px-2 py-2">
                                @if($item->item_image)
                                <a href="{{ asset('storage/'.$item->item_image) }}" target="_blank" class="text-blue-600 underline block mb-1">View</a>
                                @endif
                                <input type="file" name="item_image[]" class="w-full rounded px-2 py-2 border bg-secondary/5 text-center text-sm">
                            </td>
                            <td class="px-2 py-2 text-center">
                                <button type="button" class="text-red-500 removeRowBtn"><i class="las la-times"></i></button>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        {{-- Default row for create page --}}
                        @endif
                    </tbody>


                    <tfoot class="bg-gray-100 border">
                        <tr>
                            <td colspan="7" class="text-center font-semibold border px-2 py-2 ">TOTAL</td>
                            <td class="px-2 py-2 ">
                                {{-- <input type="text" class="w-full  rounded px-2 py-1 text-center bg-secondary/5"
                                        disabled> --}}
                            </td>
                            <td class="px-2 py-2 ">
                                {{-- <input type="text" class="w-full  rounded px-2 py-1 text-center bg-secondary/5"
                                        disabled> --}}
                            </td>
                            <td class="px-2 py-2 ">
                                <input
                                    type="number"
                                    id="grandTotal"
                                    readonly
                                    class="w-full border rounded-10 px-2 py-1 text-center bg-secondary/5"
                                    placeholder="0">
                            </td>
                            <td colspan="2" class=" pe-2">
                                {{-- <input type="number" readonly
                                        class="w-full  rounded px-2 py-1 text-center bg-secondary/5"> --}}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-3">
                <button type="button" id="addRowBtn" class="btn-primary rounded-10 px-4 py-2">
                    + Add Gold Items
                </button>
            </div>

            <!-- Calculation Result Box -->
            <div id="calculationBox" class="mt-5 p-4 bg-secondary/5 rounded-10 hidden">
                <h3 class="text-lg font-semibold mb-3 uppercase">Calculation Result</h3>
                <table class="w-full text-sm">
                    <tbody>
                        <tr>
                            <td class="font-semibold py-1 uppercase">Net Loan Amount</td>
                            <td id="resNetLoan">-</td>
                        </tr>
                        <tr>
                            <td class="font-semibold py-1 uppercase">Security Value</td>
                            <td id="resSecurity">-</td>
                        </tr>
                        <tr>
                            <td class="font-semibold py-1 uppercase">Max Loan Amount</td>
                            <td id="resMaxLoan">-</td>
                        </tr>
                        <tr>
                            <td class="font-semibold py-1 uppercase">Max Loan Limit</td>
                            <td id="resLimit">-</td>
                        </tr>
                        <tr>
                            <td class="font-semibold py-1 uppercase">Maximum Approvable Amount</td>
                            <td id="resApprovable">-</td>
                        </tr>
                        <tr>
                            <td class="font-semibold py-1 uppercase">Approved Loan Amount</td>
                            <td id="resApproved">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                <button type="button" id="calculateBtn" class="btn-outline justify-center">
                    {{ isset($application) ? 'Update Application' : 'Calculate' }}
                </button>
                <button class="btn-outline justify-center" type="reset">
                    <a href="{{route('gold-loan.applications.index')}}"> Back</a>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- calculation submit buttons -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("loanForm");
    const calculateBtn = document.getElementById("calculateBtn");
    const calculationBox = document.getElementById("calculationBox");

    let isCalculated = false;
    let isValidOrnament = false;

    // GLOBAL CHANGE DETECTION (works for dynamic rows too)
    form.addEventListener("input", function (e) {

        // Only trigger recalculation for important fields
        if (
            e.target.classList.contains("valuePerGram") ||
            e.target.classList.contains("netWeight") ||
            e.target.classList.contains("tunch") ||
            e.target.classList.contains("grossWeight") ||
            e.target.classList.contains("noOfItem") ||
            e.target.id === "loanAmount" ||
            e.target.id === "insuranceAmount" ||
            e.target.id === "scheme_id"
        ) {
            if (isCalculated) {
                calculateBtn.textContent = "Re-Calculate";
                calculateBtn.type = "button";
                isCalculated = false;
                isValidOrnament = false;
            }
        }
    });

    calculateBtn.addEventListener("click", function (e) {

        if (!isCalculated) {

            e.preventDefault();

            let rows = document.querySelectorAll("#itemsBody tr");
            let totalSecurity = 0;

            rows.forEach(row => {
                let valuePerGram = parseFloat(row.querySelector(".valuePerGram")?.value) || 0;
                let netWeight = parseFloat(row.querySelector(".netWeight")?.value) || 0;
                let tunch = parseFloat(row.querySelector(".tunch")?.value) || 0;

                let fineWeight = (netWeight * tunch) / 100;
                let totalValue = valuePerGram * fineWeight;

                totalSecurity += totalValue;
            });

            let loanAmount = parseFloat(document.getElementById("loanAmount").value) || 0;
            let insurance = parseFloat(document.getElementById("insuranceAmount").value) || 0;
            let netLoan = loanAmount + insurance;

            let scheme = document.getElementById("scheme_id");
            let selected = scheme.options[scheme.selectedIndex];
            let maxLoan = parseFloat(selected.getAttribute("data-max")) || 0;
            let limit = parseFloat(selected.getAttribute("data-limit")) || 0;

            let approvable = (totalSecurity * limit) / 100;

            let approvedLoan = netLoan;
            if (approvedLoan > maxLoan) approvedLoan = maxLoan;
            if (approvedLoan > approvable) approvedLoan = approvable;

            // Show Results
            document.getElementById("resNetLoan").textContent = netLoan.toFixed(2);
            document.getElementById("resSecurity").textContent = totalSecurity.toFixed(2);
            document.getElementById("resMaxLoan").textContent = maxLoan.toFixed(2);
            document.getElementById("resLimit").textContent = limit + "%";
            document.getElementById("resApprovable").textContent = approvable.toFixed(2);
            document.getElementById("resApproved").textContent = approvedLoan.toFixed(2);

            // Hidden fields
            document.getElementById("security_value").value = totalSecurity.toFixed(2);
            document.getElementById("max_loan_amount").value = maxLoan;
            document.getElementById("max_loan_limit").value = limit;
            document.getElementById("maximum_approvable_amount").value = approvable.toFixed(2);
            document.getElementById("approved_loan_amount").value = approvedLoan.toFixed(2);

            calculationBox.classList.remove("hidden");

            calculateBtn.textContent = "Submit";
            calculateBtn.type = "submit";

            isCalculated = true;
            isValidOrnament = true;
        }
    });

    form.addEventListener("submit", function (e) {
        if (!isValidOrnament) {
            e.preventDefault();
            alert("Please calculate first.");
        }
    });

});
</script>

<!-- for check box while in edit mode  -->
<script>
document.addEventListener("DOMContentLoaded", function() {

    const ratioEnabled = document.getElementById('ratio_enabled').value;

    if (ratioEnabled === 'Yes') {
        document.getElementById('ratioFields').style.display = 'block';
        document.getElementById('reduce_ratio_box').style.display = 'flex';
        document.getElementById('divide_emi_ratio').checked = true;
    }

});
</script>

<script>
    //No Duplicate Customer In Droupown
    document.addEventListener("DOMContentLoaded", function () {

    // All related dropdowns
    const dropdownIds = [
        "member_id",
        "co_applicant_1_id",
        "co_applicant_2_id",
        "guarantor_1_id",
        "guarantor_2_id",
        "guarantor_3_id",
        "guarantor_4_id"
    ];

    const dropdowns = dropdownIds
        .map(id => document.getElementById(id))
        .filter(el => el !== null);

    function updateDropdownOptions() {

        // Collect all selected values
        const selectedValues = dropdowns
            .map(select => select.value)
            .filter(value => value !== "");

        dropdowns.forEach(select => {

            const currentValue = select.value;

            Array.from(select.options).forEach(option => {

                if (option.value === "") return;

                // If selected in another dropdown → hide
                if (
                    selectedValues.includes(option.value) &&
                    option.value !== currentValue
                ) {
                    option.style.display = "none";
                } else {
                    option.style.display = "block";
                }

            });
        });
    }

    // Attach change event
    dropdowns.forEach(select => {
        select.addEventListener("change", updateDropdownOptions);
    });

    // Run once on page load (for edit mode)
    updateDropdownOptions();

});
</script>

<!-- checkbox show when scheme select -->
<script>
    document.addEventListener("DOMContentLoaded", function() {

    const schemeSelect = document.getElementById("scheme_id");

        const interestOptions = document.getElementById("interestOptions");
        const chkEmiBox = document.getElementById("chk_emi_box");
        const chkFirstBox = document.getElementById("chk_first_box");
        const chkEmiText = document.getElementById("chk_emi_text");
        // NEW: Checkbox variables
        const optEmi = document.getElementById("option_interest_emi");
        const optFirst = document.getElementById("option_interest_first");

        const reduceBox = document.getElementById("reduce_ratio_box");
        const ratioFields = document.getElementById("ratioFields");

        const emi1 = document.getElementById("emi_ratio_1");
        const emi2 = document.getElementById("emi_ratio_2");

        const amt1 = document.getElementById("amt_ratio_1");
        const amt2 = document.getElementById("amt_ratio_2");

        const chkDivide = document.getElementById("divide_emi_ratio");
        const emiTotalText = document.getElementById("emi_total_text");

        // -----------------------------------------------
        //  MANUAL ENTRY → INTEREST TYPE CHECKBOX LOGIC
        // -----------------------------------------------
        function applyManualCheckboxLogic() {

            let selected = document.querySelector('input[name="interest_type"]:checked');
            if (!selected) return;

            let type = selected.value.toLowerCase();

            // RESET
            interestOptions.style.display = "none";
            chkEmiBox.style.display = "none";
            chkFirstBox.style.display = "none";
            reduceBox.style.display = "none";
            ratioFields.style.display = "none";
            chkDivide.checked = false;

            // FLAT EMI
            if (type === "flat_emi") {
                interestOptions.style.display = "block";
                chkEmiText.innerText = "Collect Interest as EMI & Principal after tenure";
                chkEmiBox.style.display = "flex";
                chkFirstBox.style.display = "flex";
            }

            // FLAT ADVANCED
            if (type === "flat_advanced" || type === "flat_advanced_interest") {
                interestOptions.style.display = "block";
                chkEmiText.innerText = "Collect Principal Amount as EMI";
                chkEmiBox.style.display = "flex";
                chkFirstBox.style.display = "none";
            }

            // REDUCING EMI
            if (type === "reducing" || type === "reducing_emi") {
                reduceBox.style.display = "flex";
            }

            // NO EMI
            if (type === "no_emi") {
                interestOptions.style.display = "none";
                chkEmiBox.style.display = "none";
                chkFirstBox.style.display = "none";
                reduceBox.style.display = "none";
            }
        }

        // Attach listener
        document.querySelectorAll('input[name="interest_type"]').forEach(r => {
            r.addEventListener("change", applyManualCheckboxLogic);
        });

        
        let totalEmi = 0;

        function manualInterestTypeCheck() {
            let selected = document.querySelector('input[name="interest_type"]:checked');
            if (!selected) return;

            if (selected.value === "no_emi") {
                interestOptions.style.display = "none";
            }
        }

        document.querySelectorAll('input[name="interest_type"]')
            .forEach(r => r.addEventListener("change", manualInterestTypeCheck));

        manualInterestTypeCheck();

        schemeSelect.addEventListener("change", function() {
            let selected = this.options[this.selectedIndex];
            let type = (selected.dataset.type || "").toLowerCase();

            totalEmi = parseInt(selected.dataset.tenure || 0);
            emiTotalText.innerText = `(Total EMI : ${totalEmi})`;

            if (type === "flat_emi" || type === "flat_advanced_interest") {
                interestOptions.style.display = "block";

                if (type === "flat_advanced_interest") {
                    chkEmiText.innerText = "Collect Principal Amount as EMI";
                    chkEmiBox.style.display = "flex";
                    chkFirstBox.style.display = "none";
                } else {
                    chkEmiText.innerText = "Collect Interest as EMI & Principal after tenure";
                    chkEmiBox.style.display = "flex";
                    chkFirstBox.style.display = "flex";
                }
            } else {
                interestOptions.style.display = "none";
                document.getElementById("option_interest_emi").checked = false;
                document.getElementById("option_interest_first").checked = false;
            }

            if (type === "reducing_emi") {
                reduceBox.style.display = "flex";
            } else {
                reduceBox.style.display = "none";
                ratioFields.style.display = "none";
                chkDivide.checked = false;
            }
        });

        // NEW: Allow ONLY ONE checkbox at a time
        optEmi.addEventListener("change", function() {
            if (this.checked) optFirst.checked = false;
        });

        optFirst.addEventListener("change", function() {
            if (this.checked) optEmi.checked = false;
        });


        chkDivide.addEventListener("change", function() {
            ratioFields.style.display = this.checked ? "block" : "none";
        });

        emi1.addEventListener("input", function() {
            let v = parseInt(this.value || 0);

            if (v > totalEmi) {
                this.value = totalEmi;
                v = totalEmi;
            }
            emi2.value = totalEmi - v;
        });

        amt1.addEventListener("input", function() {
            let v = parseInt(this.value || 0);
            if (v > 100) {
                this.value = 100;
                v = 100;
            }
            amt2.value = 100 - v;
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("loanForm");
    const chkDivide = document.getElementById("divide_emi_ratio");
    const emi1 = document.getElementById("emi_ratio_1");
    const amt1 = document.getElementById("amt_ratio_1");
    const tenureInput = document.getElementById("tenure_value");
    const emi2 = document.getElementById("emi_ratio_2");
    const errorBox = document.getElementById("emiRatioError");

    form.addEventListener("submit", function (e) {

        errorBox.classList.add("hidden");

        if (chkDivide.checked) {
            const tenure = parseInt(tenureInput.value) || 0;
            const r1 = parseInt(emi1.value) || 0;
            const r2 = parseInt(emi2.value) || 0;

            if ((r1 + r2) !== tenure) {
                e.preventDefault();
                errorBox.classList.remove("hidden");
                errorBox.innerText =
                    `EMI Ratio total (${r1 + r2}) must equal tenure (${tenure})`;
                return;
            }
        }

        // 🔥 Set hidden values once only
        document.getElementById("ratio_enabled").value =
            chkDivide.checked ? "Yes" : "No";

        document.getElementById("ratio_first_emi").value =
            emi1.value || "";

        document.getElementById("ratio_first_percentage").value =
            amt1.value || "";
    });

});
</script>


<!-- Calculation & Submit Button  -->
<!-- <script>
    let isCalculated = false; // flag set karte hain
    let isValidOrnament = false;
    document.getElementById("calculateBtn").addEventListener("click", function(e) {
        if (!isCalculated) {
            //  Pehli click pe calculation karo
            document.getElementById("calculationBox").classList.remove("hidden");

            // Button ko submit bana do
            this.textContent = "Submit";
            this.type = "submit";
            //    this.type = "button";

            // Flag update karo
            isCalculated = true;

            // Prevent form submit on first click
            e.preventDefault();
        } else {
            //  Ab button "Submit" hai → normal form submit hone do
            // Yahan kuch extra code ki zarurat nahi hai
        }
    });
</script> -->

<!-- Memeber Box -->
<script>
    document.getElementById('member_id').addEventListener('change', function() {
        let selected = this.options[this.selectedIndex];
        let name = selected.getAttribute('data-name') || '-';
        let mobile = selected.getAttribute('data-mobile') || '-';

        document.getElementById('memberName').textContent = name;
        document.getElementById('memberMobile').textContent = mobile;

        document.getElementById('memberBox').classList.remove('hidden');
    });
</script>

<!-- Member Info details -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const memberSelect = document.getElementById("member_id");
        const memberBox = document.getElementById("memberBox");
        const memberName = document.getElementById("memberName");
        const memberMobile = document.getElementById("memberMobile");

        memberSelect.addEventListener("change", function() {
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

<!-- Scheme Info Details -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
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

        schemeSelect.addEventListener("change", function() {
            // ✅ Loan Amount Validation Based On Scheme
            const loanAmountInput = document.getElementById("loanAmount");

            loanAmountInput.addEventListener("input", function() {
                let max = parseFloat(schemeSelect.options[schemeSelect.selectedIndex].getAttribute("data-max")) || 0;
                let min = parseFloat(schemeSelect.options[schemeSelect.selectedIndex].getAttribute("data-min")) || 0;
                let val = parseFloat(loanAmountInput.value) || 0;

                if (val > max) {
                    alert("Loan Amount cannot be greater than Maximum Loan Amount (" + max + ")");
                    loanAmountInput.value = max;
                }

                // if (val < min) {
                //     alert("Loan Amount cannot be less than Minimum Loan Amount (" + min + ")");
                //     loanAmountInput.value = min;
                // }

                calculateNetLoan();
            });

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

<!-- Net + insurance = net loan amount calculation -->
<script>
    function calculateNetLoan() {
        let loan = parseFloat(document.getElementById('loanAmount').value) || 0;
        let insurance = parseFloat(document.getElementById('insuranceAmount').value) || 0;
        document.getElementById('netLoanAmount').value = loan + insurance;
    }

    document.getElementById('loanAmount').addEventListener('input', calculateNetLoan);
    document.getElementById('insuranceAmount').addEventListener('input', calculateNetLoan);
</script>

<!-- pay Mode -->
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

        // ---- FIX: Set default date as d-m-Y ----
        function getDMY() {
            const d = new Date();
            let day = String(d.getDate()).padStart(2, '0');
            let month = String(d.getMonth() + 1).padStart(2, '0');
            let year = d.getFullYear();
            return `${day}-${month}-${year}`;
        }

        const chequeDateInput = document.getElementById("cheque_date");
        if (chequeDateInput && !chequeDateInput.value) {
            chequeDateInput.value = getDMY();
        }

        const transferDateInput = document.getElementById("transfer_date");
        if (transferDateInput && !transferDateInput.value) {
            transferDateInput.value = getDMY();
        }

    });
</script>

<!-- Final wight Ornaments calculation -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        //  Step 1: Form को पहले select करो (form id = loanForm)
        const form = document.getElementById("loanForm");

        //  Step 2: Calculate button click listener

        document.getElementById("calculateBtn").addEventListener("click", function(e) {

            // If not valid yet, prevent submission
            if (!isValidOrnament) {
                e.preventDefault();
            }

            let rows = document.querySelectorAll("#itemsBody tr");
            let totalSecurity = 0;

            rows.forEach(row => {
                let valuePerGram = parseFloat(row.querySelector(".valuePerGram")?.value) || 0;
                let netWeight = parseFloat(row.querySelector(".netWeight")?.value) || 0;
                let tunch = parseFloat(row.querySelector(".tunch")?.value) || 0;

                // Fine Weight (D) = (C% of B)
                let fineWeight = (netWeight * tunch) / 100;

                // Total Value = A × D
                let totalValue = valuePerGram * fineWeight;

                // Row ke Total Value column me show karo
                let totalValueCell = row.querySelector(".totalValue");
                if (totalValueCell) {
                    totalValueCell.textContent = totalValue.toFixed(2);
                }

                totalSecurity += totalValue;
            });

            // Loan amount aur insurance ke input se values lo
            let loanAmount = parseFloat(document.getElementById("loanAmount")?.value) || 0;
            let insurance = parseFloat(document.getElementById("insuranceAmount")?.value) || 0;
            let netLoan = loanAmount + insurance;
            document.getElementById("netLoanAmount").value = netLoan;

            // Scheme ka data
            let scheme = document.getElementById("scheme_id");
            let selected = scheme.options[scheme.selectedIndex];
            let maxLoan = selected.getAttribute("data-max") || "0"; //  CHANGED from "-" to "0"
            let limit = parseFloat(selected.getAttribute("data-limit")) || 0;

            // Maximum approvable amount = (totalSecurity × Limit%) / 100
            let approvable = (totalSecurity * limit) / 100;

            // Show results in result box
            document.getElementById("resNetLoan").textContent = netLoan;
            document.getElementById("resSecurity").textContent = totalSecurity.toFixed(2);
            document.getElementById("resMaxLoan").textContent = maxLoan;
            document.getElementById("resLimit").textContent = limit + "%";
            document.getElementById("resApprovable").textContent = approvable.toFixed(2);
            //document.getElementById("resApproved").textContent = approvable.toFixed(2);

            //  Step 3: Hidden inputs me assign karo
            document.getElementById("security_value").value = totalSecurity.toFixed(2);
            document.getElementById("max_loan_amount").value = maxLoan;
            document.getElementById("max_loan_limit").value = limit;
            document.getElementById("maximum_approvable_amount").value = approvable.toFixed(2);
            //document.getElementById("approved_loan_amount").value = approvable.toFixed(2);
            // Ornament value must cover Net Loan
            // if (totalSecurity < netLoan) {
            //     alert("Total Ornament Security Value must be greater than or equal to Net Loan Amount!");

            //     isValidOrnament = false;

            //     // Submit Button disable + back to Calculate
            //     const btn = document.getElementById("calculateBtn");
            //     btn.type = "button";
            //     btn.textContent = "Re-Calculate";
            //     btn.disabled = false;

            //     return;
            // }

            // Agar yahan pohonch gaye means no error
            isValidOrnament = true;

            // Change button back to Submit if now valid
            const btn = document.getElementById("calculateBtn");
            btn.type = "submit";
            btn.textContent = "Submit";
            btn.disabled = false;

            // Approved Loan Logic
            let approvedLoan = netLoan;

            // Rule: Net loan max loan se upar? → cap it to max loan
            if (approvedLoan > maxLoan) {
                approvedLoan = parseFloat(maxLoan);
            }

            // Rule: Limit se upar? → cap it to approvable
            if (approvedLoan > approvable) {
                approvedLoan = approvable;
            }

            // Final Approved Loan Display
            document.getElementById("resApproved").textContent = approvedLoan.toFixed(2);
            document.getElementById("approved_loan_amount").value = approvedLoan.toFixed(2);

            //  Step 4: Debug console (optional)
            console.log("Hidden Inputs Updated:", {
                security_value: totalSecurity.toFixed(2),
                max_loan_amount: maxLoan,
                max_loan_limit: limit,
                maximum_approvable_amount: approvable.toFixed(2),
                approved_loan_amount: approvable.toFixed(2),
            });

            // Step 5: Calculation box visible
            document.getElementById("calculationBox").classList.remove("hidden");
        });

        form.addEventListener("submit", function(e) {
            if (!isValidOrnament) {
                e.preventDefault();
                alert("Please correct Ornament Security Value first!");
                return false;
            }
        });

    });
</script>

<!-- Credit Score -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const cibilBody = document.getElementById("cibilBody");
        const addRowBtn = document.getElementById("addRow");

        // Template for new row
        function newRow() {
            // Get current date in DD/MM/YYYY format
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
        cibilBody.addEventListener("click", function(e) {
            if (e.target.closest(".removeRow")) {
                e.target.closest("tr").remove();
            }
        });

        // Add one default row when page loads
        //cibilBody.insertAdjacentHTML("beforeend", newRow());
        if (cibilBody.querySelectorAll("tr").length === 0) {
            cibilBody.insertAdjacentHTML("beforeend", newRow());
        }
    });

    //== Add Gold Items== 

    document.addEventListener("DOMContentLoaded", function() {
        const tbody = document.getElementById("itemsBody");
        const addRowBtn = document.getElementById("addRowBtn");

        // === Function: Update row numbers ===
        function updateRowNumbers() {
            [...tbody.querySelectorAll("tr")].forEach((row, index) => {
                row.querySelector("td").textContent = index + 1;
            });
        }


        // === Function: Create a new row ===
        function createRow() {
            const row = document.createElement("tr");
            row.innerHTML = `
                                    <td class="text-center px-2 py-2">1</td>
                                    <td class="px-2 py-2">
                                        <select name="item_type[]" class="itemType w-full rounded px-2 py-2 rounded-10 border bg-secondary/5 text-sm" style="width:150px;">
                                            <option>Gold Jewelery</option>
                                            <option>Gold Coin</option>
                                            <option>Gold Biscuit</option>
                                            <option>Silver Jewelery</option>
                                            <option>Silver Coin</option>
                                            <option>Silver Biscuit</option>
                                            <option>Platinum</option>
                                            <option>Diamond</option>
                                            <option>Stone</option>
                                        </select>
                                    </td>
                                    <td class="px-2 py-2">
                                        <input type="text" name="item_name[]" placeholder="Enter Item Name" class="itemName w-full bg-secondary/5 rounded px-2 py-2 rounded-10 border text-center text-sm">
                                    </td>
                                    <td class="px-2 py-2">
                                        <input type="number" name="no_of_items[]" placeholder="No of Items" class="noOfItem w-full bg-secondary/5 rounded px-2 py-2 rounded-10 border text-center text-sm">
                                    </td>
                                    <td class="px-2 py-2">
                                        <input type="number" name="value_per_gram[]" placeholder="Value per Gram" class="valuePerGram w-full bg-secondary/5 rounded px-2 py-2 rounded-10 border text-center text-sm">
                                    </td>
                                    <td class="px-2 py-2">
                                        <input type="number" name="gross_weight[]" placeholder="Gross Weight" class="grossWeight w-full rounded px-2 py-2 rounded-10 border bg-secondary/5 text-center text-sm">
                                    </td>
                                    <td class="px-2 py-2">
                                        <input type="number" name="net_weight[]" placeholder="Net Weight" class="netWeight w-full bg-secondary/5 rounded px-2 py-2 rounded-10 border text-center text-sm">
                                    </td>
                                    <td class="px-2 py-2">
                                        <input type="number" name="tunch[]" placeholder="Tunch %" value="100" class="tunch w-full rounded bg-secondary/5 px-2 py-2 rounded-10 border text-center text-sm">
                                    </td>
                                    <td class="px-2 py-2">
                                        <input type="number" name="fine_weight[]" placeholder="Fine Weight" readonly class="fineWeight w-full rounded px-2 py-2 rounded-10 border bg-secondary/5 text-center text-sm bg-gray-100">
                                    </td>
                                    <td class="px-2 py-2">
                                        <input type="number" name="total_value[]" placeholder="Total Value" readonly class="totalValue w-full rounded px-2 py-2 rounded-10 border bg-secondary/5 text-center text-sm bg-gray-100">
                                    </td>
                                    <td class="px-2 py-2 text-center">
                                        <button type="button" class="text-red-500 removeRowBtn"><i class="las la-times"></i></button>
                                    </td>
                                    `;

            // === Select key elements from this row ===
            const valuePerGram = row.querySelector(".valuePerGram");
            const netWeight = row.querySelector(".netWeight");
            const tunch = row.querySelector(".tunch");
            const fineWeight = row.querySelector(".fineWeight");
            const totalValue = row.querySelector(".totalValue");

            // === Function to calculate fine weight & total value ===
            function calculate() {
                const net = parseFloat(netWeight.value) || 0;
                const t = parseFloat(tunch.value) || 0;
                const vpg = parseFloat(valuePerGram.value) || 0;

                const fine = (net * t) / 100;
                fineWeight.value = fine.toFixed(2);
                totalValue.value = (fine * vpg).toFixed(2);

                updateGrandTotal();
            }

            // Attach input listeners
            [valuePerGram, netWeight, tunch].forEach(input => {
                input.addEventListener("input", calculate);
            });

            return row;
        }

        // === Function: Update Grand Total in tfoot ===
        function updateGrandTotal() {
            let grandTotal = 0;
            document.querySelectorAll("#itemsBody .totalValue").forEach(input => {
                grandTotal += parseFloat(input.value) || 0;
            });

            const totalInput = document.querySelector("tfoot input[type='number']");
            if (totalInput) {
                totalInput.value = grandTotal.toFixed(2);
            }
        }

        // === Add one default row on page load ===
        //tbody.appendChild(createRow());
        if (tbody.querySelectorAll("tr").length === 0) {
            tbody.appendChild(createRow());
            updateRowNumbers();
        }
        //updateRowNumbers();

        // === Add Row button click ===
        addRowBtn.addEventListener("click", function() {
            tbody.appendChild(createRow());
            updateRowNumbers();
        });

        // === Remove Row (event delegation) ===
        tbody.addEventListener("click", function(e) {
            if (e.target.closest(".removeRowBtn")) {
                e.target.closest("tr").remove();
                updateRowNumbers();
                updateGrandTotal();
            }
        });

        let rows = document.querySelectorAll("#itemsBody tr");
        let items = [];

        rows.forEach(row => {
            let item_type = row.querySelector(".itemType")?.value || '';
            let item_name = row.querySelector(".itemName")?.value || '';
            let no_of_items = row.querySelector(".noOfItem")?.value || 0;
            let value_per_gram = row.querySelector(".valuePerGram")?.value || 0;
            let gross_weight = row.querySelector(".grossWeight")?.value || 0;
            let net_weight = row.querySelector(".netWeight")?.value || 0;
            let tunch = row.querySelector(".tunch")?.value || 0;
            let fine_weight = row.querySelector(".fineWeight")?.value || 0;
            let total_value = row.querySelector(".totalValue")?.value || 0;

            items.push({
                item_type,
                item_name,
                no_of_items,
                value_per_gram,
                gross_weight,
                net_weight,
                tunch,
                fine_weight,
                total_value
            });
        });

        console.log(items);
    });

    // <!-- collapsed logic + - button-->
    function toggleSection(button, sectionId) {
        const section = document.getElementById(sectionId);
        const icon = button.querySelector('.toggle-icon');

        section.classList.toggle('hidden');
        icon.textContent = section.classList.contains('hidden') ? '+' : '−';
    }

    //=== Grab all radios in Tenure Type ===
    const radios = document.querySelectorAll('input[name="tenure_type"]');
    const label = document.getElementById('tenureLabel');

    radios.forEach(radio => {
        radio.addEventListener('change', () => {
            label.textContent = `( ${radio.value} )`;
        });
    });
</script>

<!-- Ornaments calculation -->
<script>
    // Function: Calculate total of all total_value[] fields
    function calculateGrandTotal() {
        let total = 0;
        document.querySelectorAll('input[name="total_value[]"]').forEach(input => {
            const val = parseFloat(input.value) || 0;
            total += val;
        });
        const grandTotalInput = document.getElementById('grandTotal');
        if (grandTotalInput) {
            grandTotalInput.value = total.toFixed(2);
        }
    }

    // When page loads — calculate once
    window.addEventListener('DOMContentLoaded', calculateGrandTotal);

    // When any total_value changes dynamically — recalculate
    document.addEventListener('input', function(e) {
        if (e.target && e.target.name === 'total_value[]') {
            calculateGrandTotal();
        }
    });

    // Optional: if you have row add/remove buttons, call this function after each such event
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeRowBtn')) {
            setTimeout(calculateGrandTotal, 100);
        }
    });

    // === Recalculate for already existing rows (edit mode) ===
    document.querySelectorAll("#itemsBody tr").forEach(row => {
        const valuePerGram = row.querySelector(".valuePerGram");
        const netWeight = row.querySelector(".netWeight");
        const tunch = row.querySelector(".tunch");
        const fineWeight = row.querySelector(".fineWeight");
        const totalValue = row.querySelector(".totalValue");

        function calculate() {
            const net = parseFloat(netWeight.value) || 0;
            const t = parseFloat(tunch.value) || 0;
            const vpg = parseFloat(valuePerGram.value) || 0;

            const fine = (net * t) / 100;
            fineWeight.value = fine.toFixed(2);
            totalValue.value = (fine * vpg).toFixed(2);

            calculateGrandTotal(); // 👈 update footer total also
        }

        // attach listeners for existing rows
        [valuePerGram, netWeight, tunch].forEach(input => {
            input.addEventListener("input", calculate);
        });
    });
</script>

<!-- branch Auto populate when select customer -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const memberSelect = document.getElementById("member_id");
        const branchSelect = document.getElementById("branch_id");

        memberSelect.addEventListener("change", function() {
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

<!-- Subtext Massage show -->
<script>
    // Number to Words Convert Function (Indian Format)
    function numberToWords(num) {
        if (num === 0) return "Zero Rupees Only";

        const a = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten",
            "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen",
            "Seventeen", "Eighteen", "Nineteen"
        ];
        const b = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy",
            "Eighty", "Ninety"
        ];

        function inWords(num) {
            if (num < 20) return a[num];
            if (num < 100) return b[Math.floor(num / 10)] + " " + a[num % 10];
            if (num < 1000) return a[Math.floor(num / 100)] + " Hundred " + inWords(num % 100);
            if (num < 100000) return inWords(Math.floor(num / 1000)) + " Thousand " + inWords(num % 1000);
            if (num < 10000000) return inWords(Math.floor(num / 100000)) + " Lakh " + inWords(num % 100000);
            return inWords(Math.floor(num / 10000000)) + " Crore " + inWords(num % 10000000);
        }

        return inWords(num).trim() + " Rupees Only";
    }

    // Function to update text in words
    function updateWords(inputId, textId) {
        const input = document.getElementById(inputId);
        const text = document.getElementById(textId);
        if (input && text) {
            input.addEventListener("input", function() {
                let amount = parseInt(this.value) || 0;
                text.textContent = amount > 0 ? numberToWords(amount) : "";
            });
        }
    }

    // Attach for all fields
    updateWords("loanAmount", "amountInWords");
    updateWords("insuranceAmount", "insuranceInWords");
    updateWords("netLoanAmount", "netAmountInWords");
</script>

<!-- Max Tenure & tenure vaule Validation -->
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const schemeSelect = document.getElementById("scheme_id");
        const tenureInput = document.getElementById("tenure_value");
        const tenureRadios = document.querySelectorAll('input[name="tenure_type"]');
        const tenureLabel = document.getElementById("tenureLabel");

        let maxMonths = parseInt(schemeSelect.options[schemeSelect.selectedIndex]?.getAttribute("data-tenure")) || 0;

        // Update Tenure label on type change
        function updateTenureLabel(type) {
            if (type === "months") tenureLabel.textContent = "( MONTHS )";
            else if (type === "weeks") tenureLabel.textContent = "( WEEKS )";
            else if (type === "days") tenureLabel.textContent = "( DAYS )";
        }

        // Compute max based on type
        function getMaxTenure(type) {
            if (type === "months") return maxMonths;
            else if (type === "weeks") return maxMonths * 4; // approx 4 weeks per month
            else if (type === "days") return maxMonths * 30; // approx 30 days per month
            return maxMonths;
        }

        // Validate Tenure input
        function validateTenure() {
            const type = document.querySelector('input[name="tenure_type"]:checked')?.value || "months";
            const maxVal = getMaxTenure(type);
            const val = parseInt(tenureInput.value) || 0;

            // Remove previous error
            document.getElementById("tenureError")?.remove();
            tenureInput.classList.remove("border-red-500");

            if (val > maxVal) {
                tenureInput.classList.add("border-red-500");

                const errorMsg = document.createElement("p");
                errorMsg.id = "tenureError";
                errorMsg.className = "text-error text-sm mt-1";
                errorMsg.textContent = `Tenure cannot exceed ${maxVal} ${type.toUpperCase()}.`;
                tenureInput.insertAdjacentElement("afterend", errorMsg);

                tenureInput.value = maxVal; // optional: auto cap to max
            }
        }

        // Event listener: scheme change
        schemeSelect.addEventListener("change", function() {
            maxMonths = parseInt(this.options[this.selectedIndex]?.getAttribute("data-tenure")) || 0;
            validateTenure();
        });

        // Event listener: tenure input
        tenureInput.addEventListener("input", validateTenure);

        // Event listener: tenure type change
        tenureRadios.forEach(radio => {
            radio.addEventListener("change", function() {
                updateTenureLabel(this.value);
                validateTenure();
            });

            // Initial load
            if (radio.checked) updateTenureLabel(radio.value);
        });

        // Initial validation
        validateTenure();

            // 🔥 Trigger on page load (edit mode fix)
if (schemeSelect.value) {
    schemeSelect.dispatchEvent(new Event('change'));
}

    });
</script>

<!-- OLD CODE Max Tenure & tenure vaule Validation -->
<!-- <script>
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
    </script> -->


<!-- change tunuer type and emi collcetion -->
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const tenureRadios = document.querySelectorAll('input[name="tenure_type"]');
        const emiSelect = document.getElementById("emi_collection");

        function updateEMIOptions(type) {
            type = type.toLowerCase(); // normalize
            emiSelect.innerHTML = `<option value="">Select EMI Collection</option>`;

            let options = [];

            if (type === "months") {
                options = [{
                        value: "monthly",
                        text: "Monthly"
                    },
                    {
                        value: "quarterly",
                        text: "Quarterly"
                    },
                    {
                        value: "half_yearly",
                        text: "Half-Yearly"
                    },
                    {
                        value: "yearly",
                        text: "Yearly"
                    }
                ];
                document.getElementById("tenureLabel").textContent = "( MONTHS )";
            } else if (type === "weeks") {
                options = [{
                        value: "weekly",
                        text: "Weekly"
                    },
                    {
                        value: "bi_weekly",
                        text: "Bi-Weekly"
                    },
                    {
                        value: "4_weekly",
                        text: "4-Weekly"
                    }
                ];
                document.getElementById("tenureLabel").textContent = "( WEEKS )";
            } else if (type === "days") {
                options = [{
                    value: "daily",
                    text: "Daily"
                }];
                document.getElementById("tenureLabel").textContent = "( DAYS )";
            }

            // Preserve old selected value if exists
            const oldValue = "{{ old('emi_collection', $application->emi_collection ?? '') }}";

            options.forEach(opt => {
                const selected = (oldValue.toLowerCase() === opt.value) ? "selected" : "";
                emiSelect.innerHTML += `<option value="${opt.value}" ${selected}>${opt.text}</option>`;
            });
        }

        tenureRadios.forEach(radio => {
            radio.addEventListener("change", function() {
                updateEMIOptions(this.value);
            });

            // Initial load for edit page
            if (radio.checked) {
                updateEMIOptions(radio.value);
            }
        });

    });
</script>



@endsection