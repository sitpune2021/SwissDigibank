@extends('layout.main')

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

@section('content')

    @if (session('error'))
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
                <h1 class="text-xl font-semibold uppercase">PERSONAL LOAN APPLICATION</h1>
            </div>
        </div>

        @if (session('success'))
            <div id="successMessage"
                class="max-w-md mx-auto mt-4 bg-green-100 border border-green-300 text-green-800 text-center px-4 py-3 rounded-lg shadow-md transition-opacity duration-500 ease-in-out">
                {{ session('success') }}
            </div>

            <script>
                // Auto hide after 30 seconds (30000 ms)
                setTimeout(() => {
                    const msg = document.getElementById('successMessage');
                    if (msg) {
                        msg.style.opacity = '0';
                        setTimeout(() => msg.remove(), 500); // smooth fade-out
                    }
                }, 30000);
            </script>
        @endif

        <div class="box">
            <form method="POST"
                action="{{ isset($application) ? route('personal.applications.update', $application->id) : route('personal.store') }}"
                enctype="multipart/form-data">
                @csrf
                @if (isset($application))
                    @method('PUT')
                @endif

                <div class=" flex flex-col lg:flex-row  gap-2">
                    <div class="w-full col-span-12 bg-primary/5 px-3 py-1 rounded-10 lg:col-span-12">
                        <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
                            <div class="col-span-2 md:col-span-1">
                                <x-datepicker-disabled label="Application Date" name="application_date" />
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="member_id" class="md:text-lg font-medium block mb-2">
                                    Customer <span class="text-red-500">*</span>
                                </label>
                                <select name="member_id" id="member_id"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Search Member No or Name</option>
                                    @foreach ($members as $member)
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
                                    Branch
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="branch_id" id="branch_id"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Search Branch No or Name</option>
                                    @foreach ($branch as $member)
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
                                <label for="" class="uppercase md:text-lg font-medium block mb-4">
                                    Advisor/ Staff
                                </label>
                                <select
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                    placeholder="Enter Scheme Code">
                                    <option value="">select Advisor/ Staff </option>
                                </select>
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="" class="md:text-lg font-medium block mb-4">
                                    1st Co-Applicant Member</label>
                                <select name="co_applicant_1_id" id="co_applicant_1_id"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Search Member No or Name</option>
                                    @foreach ($members as $member)
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
                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}"
                                            {{ old('member_id', $application->co_applicant_2_id ?? '') == $member->id ? 'selected' : '' }}>
                                            {{ $member->member_info_first_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="" class="md:text-lg font-medium block mb-4">
                                    Guarantor 1 </label>
                                <select name="guarantor_1_id" id="guarantor_1_id"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Search Member No or Name</option>
                                    @foreach ($members as $member)
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
                                        @foreach ($members as $member)
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
                                        @foreach ($members as $member)
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
                                        @foreach ($members as $member)
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
                                        @foreach ($scheme as $sc)
                                            <option value="{{ $sc->id }}"
                                                {{ old('scheme_id', $application->scheme_id ?? '') == $sc->id ? 'selected' : '' }}
                                                data-code="{{ $sc->scheme_code }}" data-name="{{ $sc->scheme_name }}"
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
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
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
                                        <label class="flex items-center gap-2 space-x-2 p-1">
                                            <input type="radio" name="tenure_type" value="days"
                                                {{ old('tenure_type', $application->tenure_type ?? '') == 'days' ? 'checked' : '' }}>
                                            <span class="text-gray-70 capitalize">DAYS</span>
                                        </label>
                                        <label class="flex items-center gap-2 space-x-2 p-1">
                                            <input type="radio" name="tenure_type" value="weeks"
                                                {{ old('tenure_type', $application->tenure_type ?? '') == 'weeks' ? 'checked' : '' }}>
                                            <span class="text-gray-70 capitalize">WEEKS</span>
                                        </label>
                                        <label class="flex items-center gap-2 space-x-2 p-1">
                                            <input type="radio" name="tenure_type" value="months"
                                                {{ old('tenure_type', $application->tenure_type ?? '') == 'months' ? 'checked' : '' }}>
                                            <span class="text-gray-70 capitalize">MONTHS</span>
                                        </label>
                                    </div>
                                    @error('tenure_type')
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
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                @error('tenure_value')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="md:text-lg font-medium block mb-4 uppercase">
                                    EMI Collection <span class="text-error">* </span>
                                </label>
                                <select id="emi_collection" name="emi_collection"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Please Select</option>
                                    {{-- options will be dynamically added --}}
                                </select>
                                @error('emi_collection')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="" class="md:text-lg font-medium block mb-4">
                                    Credit Period ( EMI Grace Period ) ( Days )
                                    <span class="text-error">*</span>
                                </label>
                                <input type="number" id="credit_period" name="credit_period"
                                    value="{{ old('credit_period', $application->credit_period ?? 0) }}"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    placeholder="0">
                                @error('credit_period')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="loanAmount" class="md:text-lg font-medium block mb-4">
                                    Loan Amount (₹) <span class="text-error">*</span>
                                </label>
                                <input type="number" id="loanAmount" name="loan_amount"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    placeholder="0" value="{{ old('loan_amount', $application->loan_amount ?? 0) }}">
                                <p id="loanAmountWords" class="text-red-500 text-xs mt-1"></p>
                                @error('loan_amount')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="insuranceAmount" class="md:text-lg font-medium block mb-4">
                                    Insurance Amount (₹) <span class="text-error">*</span>
                                </label>
                                <input type="number" id="insuranceAmount" name="insurance_amount"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    placeholder="Enter Insurance Amount (₹)"
                                    value="{{ old('insurance_amount', $application->insurance_amount ?? 0) }}">
                                <p id="insuranceAmountWords" class="text-red-500 text-xs mt-1"></p>
                                @error('insurance_amount')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="netLoanAmount" class="md:text-lg font-medium block mb-4">
                                    Net Loan Amount (₹) <span class="text-error">*</span>
                                </label>
                                <input type="number" id="netLoanAmount" name="net_loan_amount" readonly
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 bg-gray-100"
                                    placeholder="0"
                                    value="{{ old('net_loan_amount', $application->net_loan_amount ?? 0) }}">
                            </div>

                            <div class="col-span-2 md:col-span-1 mb-3">
                                <label for="" class="md:text-lg font-medium block mb-4">
                                    Purpose of Loan
                                    <span class="text-error">*</span>
                                </label>
                                <input type="text" id="purpose_of_loan" name="purpose_of_loan"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    placeholder="Enter Purpose of Loan"
                                    value="{{ old('purpose_of_loan', $application->purpose_of_loan ?? '') }}">
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label class="md:text-lg font-medium block mb-2">
                                    Charges Per EMI Type <span class="text-red-600">*</span>
                                </label>

                                <div class="mt-1 flex gap-4">
                                    <label class="flex items-center gap-2 p-2">
                                        <input type="radio" name="charges_per_emi_type" value="ON EMI"
                                            class="text-green-600 focus:ring-green-500"
                                            {{ old('charges_per_emi_type') == 'ON EMI' ? 'checked' : '' }} checked>
                                        <span class="text-gray-700">ON EMI</span>
                                    </label>

                                    <label class="flex items-center gap-2 p-2">
                                        <input type="radio" name="charges_per_emi_type" value="ON PRINCIPAL"
                                            class="text-green-600 focus:ring-green-500"
                                            {{ old('charges_per_emi_type') == 'ON PRINCIPAL' ? 'checked' : '' }}>
                                        <span class="text-gray-700">ON PRINCIPAL</span>
                                    </label>
                                </div>

                                @error('charges_per_emi_type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <!-- Credit Score Details -->
                        <div class="col-span-12 lg:col-span-12 mb-5">
                            <hr>
                            <label class="uppercase md:text-lg font-medium block mt-3 mb-4">
                                Credit Score Details
                            </label>
                            <div class="col-span-12 lg:col-span-12 mb-5">

                                <div class="overflow-x-auto">
                                    <table class="w-full border-collapse border border-gray-300">
                                        <thead>
                                            <tr class="bg-gray-100">
                                                <th class="border border-gray-300 px-2 py-2 text-center">CIBIL Type</th>
                                                <th class="border border-gray-300 px-2 py-2 text-center">Score</th>
                                                <th class="border border-gray-300 px-2 py-2 text-center">Report Date</th>
                                                <th class="border border-gray-300 px-2 py-2 text-center">File</th>
                                                <th class="border border-gray-300 px-2 py-2 text-center">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody id="cibilBody">
                                            @if (isset($application) && $application->creditScores->count() > 0)
                                                @foreach ($application->creditScores as $cibil)
                                                    <tr class="nested-fields">
                                                        <!-- Type -->
                                                        <td class="px-2 py-2 border border-gray-300">
                                                            <select name="cibil_type[]" required
                                                                class="w-full text-center border border-gray-300 rounded-10 px-2 py-2">
                                                                <option value="">Select</option>
                                                                <option value="transunion"
                                                                    {{ $cibil->cibil_type == 'transunion' ? 'selected' : '' }}>
                                                                    TransUnion</option>
                                                                <option value="equifax"
                                                                    {{ $cibil->cibil_type == 'equifax' ? 'selected' : '' }}>
                                                                    Equifax</option>
                                                                <option value="experian"
                                                                    {{ $cibil->cibil_type == 'experian' ? 'selected' : '' }}>
                                                                    Experian</option>
                                                                <option value="crif_highmark"
                                                                    {{ $cibil->cibil_type == 'crif_highmark' ? 'selected' : '' }}>
                                                                    Crif Highmark</option>
                                                            </select>
                                                        </td>

                                                        <!-- Score -->
                                                        <td class="px-2 py-2 border border-gray-300">
                                                            <input type="number" name="cibil_score[]"
                                                                value="{{ $cibil->cibil_score }}"
                                                                placeholder="Enter CIBIL Score"
                                                                class="w-full text-center border border-gray-300 rounded-10 px-2 py-2"
                                                                required />
                                                        </td>

                                                        <!-- Date -->
                                                        <td class="px-2 py-2 border border-gray-300 relative">
                                                            <input type="text" name="report_date[]"
                                                                value="{{ \Carbon\Carbon::parse($cibil->report_date)->format('d/m/Y') }}"
                                                                placeholder="DD/MM/YYYY"
                                                                class="w-full text-center border border-gray-300 rounded-10 px-2 py-2"
                                                                required />
                                                        </td>

                                                        <!-- File -->
                                                        <td class="px-2 py-2 border border-gray-300">
                                                            <input type="file" name="report_file[]"
                                                                class="w-full text-center border border-gray-300 rounded-10 px-2 py-2" />
                                                            @if ($cibil->report_file_path)
                                                                <a href="{{ asset('storage/' . $cibil->report_file_path) }}"
                                                                    target="_blank"
                                                                    class="text-blue-500 underline text-sm">View</a>
                                                            @endif
                                                        </td>

                                                        <!-- Remove -->
                                                        <td class="px-2 py-2 border border-gray-300 text-center">
                                                            <button type="button"
                                                                class="removeRow text-red-500 hover:text-red-700">
                                                                <i class="las la-times"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <!-- Default blank row if no data -->
                                            @endif
                                        </tbody>
                                    </table>

                                    <!-- Add Row Button -->
                                    <div class="mt-3 text-right">
                                        <button type="button" id="addRow"
                                            class="btn-primary px-4 py-2 text-sm rounded-md">
                                            + Add Row
                                        </button>
                                    </div>
                                </div>
                            </div>

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
                                                <input type="text" name="" id="" value="0"
                                                    readonly
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
                                                <input type="number" name="processing_fee_total"
                                                    id="processing_fee_total" placeholder="0"
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
                                            {{ old('fee_mode', $application->fee_mode ?? '') == 'cash' ? 'checked' : '' }}>
                                        Cash
                                    </label>
                                    <label class="mr-4">
                                        <input type="radio" name="fee_mode" value="cheque"
                                            {{ old('fee_mode', $application->fee_mode ?? '') == 'cheque' ? 'checked' : '' }}>
                                        Cheque
                                    </label>
                                    <label>
                                        <input type="radio" name="fee_mode" value="online"
                                            {{ old('fee_mode', $application->fee_mode ?? '') == 'online' ? 'checked' : '' }}>
                                        Online Tr.
                                    </label>
                                </div>

                                <!-- Bank + Cheque Fields -->
                                <div id="bankDropdownWrapper" class="mt-3 hidden">
                                    <label for="bank_id" class="block mb-2 text-sm font-medium">Select Bank</label>
                                    <select id="bank_id" name="bank_id"
                                        class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                        <option value="">-- Select Bank --</option>
                                        @foreach ($banks as $id => $name)
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
                                            placeholder="Enter Cheque No"
                                            value="{{ old('cheque_no', $application->cheque_no ?? '') }}">
                                    </div>

                                    <!-- Cheque Date -->
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">Cheque Date</label>
                                        <input type="date" id="cheque_date" name="cheque_date"
                                            value="{{ old('cheque_date', $application->cheque_date ?? '') }}"
                                            class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>
                                </div>

                                <!-- Online Transaction Fields -->
                                <div id="onlineFields" class="space-y-4 hidden">
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">
                                            Transfer Date <span class="text-red-500">*</span>
                                        </label>
                                        <input type="date" id="transfer_date" name="transfer_date"
                                            value="{{ old('transfer_date', $application->transfer_date ?? '') }}"
                                            class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">
                                            UTR / Transaction No. <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="utr_no" name="utr_no"
                                            placeholder="Enter Transaction No."
                                            value="{{ old('utr_no', $application->utr_no ?? '') }}"
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
                                                <input type="radio" name="credited" value="1"
                                                    {{ old('credited', $application->credited ?? '') == '1' ? 'checked' : '' }}>
                                                <span>Yes</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="credited" value="1"
                                                    {{ old('credited', $application->credited ?? '') == '1' ? 'checked' : '' }}>
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
                        <!-- REDUCING EMI SPECIAL CHECKBOX -->
                        <div class="flex gap-2" id="reduce_ratio_box" style="display:none;">
                            <label class="flex gap-2 items-center">
                                <input type="checkbox" name="divide_emi_ratio" id="divide_emi_ratio" value="1"
                                    {{ old('ratio_enabled', $application->ratio_enabled ?? '') == 'Yes' ? 'checked' : '' }}
                                    style="width:20px !important; height:20px !important;">
                            </label>
                            <span>Check this if you want to divide loan EMIs in ratio.</span>
                        </div>


                        <!-- RATIO FIELDS -->
                        <div id="ratioFields"
                            style="display: {{ old('ratio_enabled', $application->ratio_enabled ?? 'No') == 'Yes' ? 'block' : 'none' }}; margin-top:10px;">


                            <!-- EMI Ratio -->
                            <label class="block mb-2 font-semibold">EMI Ratio <span id="emi_total_text"></span> </label>

                            <div class="flex gap-3">
                                <input type="number" id="emi_ratio_1"
                                    class="w-full rounded-10 bg-secondary/5 border p-2"
                                    value="{{ old('ratio_first_emi', $application->ratio_first_emi ?? '') }}"
                                    min="1">
                                <input type="number" id="emi_ratio_2"
                                    class="w-full rounded-10 bg-secondary/5 border p-2 bg-gray-100" readonly>
                            </div>

                            <!-- Loan Amount Ratio -->
                            <label class="block mt-4 mb-2 font-semibold">Loan Amount % Ratio</label>

                            <div class="flex gap-3">
                                <input type="number" name="ratio_first_percentage" id="amt_ratio_1"
                                    class="w-full border bg-secondary/5 rounded-10 p-2"
                                    value="{{ old('ratio_first_percentage', $application->ratio_first_percentage ?? '') }}"
                                    min="1" max="100">
                                <input type="number" id="amt_ratio_2"
                                    class="w-full border bg-secondary/5 rounded-10 p-2 bg-gray-100" readonly>
                            </div>

                        </div>
                        <p id="emiRatioError" class="text-red-600 text-sm mt-1 hidden">
                            EMI Ratio total cannot be greater then tenure.
                        </p>
                    </div>

                    <div class="w-64 flex-2 col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6 min-w-[300px]">
                        {{-- memberBox info --}}
                        <div id="memberBox" class="w-full hidden"> {{-- hidden by default --}}
                            <div
                                class="flex justify-between items-center bg-secondary/5  rounded-10 px-4 py-3 dark:bg-bg3">
                                <h3 class="text-base capitalize font-semibold md:text-lg">Customer Info</h3>
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
                                                <td class="font-semibold py-2 pr-4">Customer Name</td>
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

                        {{-- schemeBox info --}}
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
                                    <table class="w-full text-sm text-left whitespace-nowrap">
                                        <tbody>
                                            <tr class="border-b">
                                                <td class="font-semibold py-2 pr-4">Scheme Code</td>
                                                <td class="py-2" id="schemeCode">-</td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="font-semibold py-2 pr-4">Scheme Name</td>
                                                <td class="py-2" id="schemeName">-</td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="font-semibold py-2 pr-4">Max Tenure</td>
                                                <td class="py-2" id="schemeTenure">-</td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="font-semibold py-2 pr-4">Maximum Loan Amount</td>
                                                <td class="py-2" id="schemeMax">-</td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="font-semibold py-2 pr-4">Maximum Loan Limit Against Security
                                                </td>
                                                <td class="py-2" id="schemeLimit">-</td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="font-semibold py-2 pr-4">Minimum Loan Amount</td>
                                                <td class="py-2" id="schemeMin">-</td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="font-semibold py-2 pr-4">Annual Interest Rate</td>
                                                <td class="py-2" id="schemeInterest">-</td>
                                            </tr>
                                            <tr class="border-b">
                                                <td class="font-semibold py-2 pr-4">Interest Type</td>
                                                <td class="py-2" id="schemeType">-</td>
                                            </tr>

                                            <tr class="border-b">
                                                <td class="font-semibold py-2 pr-4">Active</td>
                                                <td class="py-2" id="schemeActive">-</td>
                                            </tr>
                                            <tr class="border-b">
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


                <!-- Calculation Result Box -->
                <!-- Hidden fields for saving calculation result -->
                <input type="hidden" name="max_loan_amount" id="inputMaxLoan">
                <input type="hidden" name="max_loan_limit" id="inputLimit">
                <input type="hidden" name="maximum_approvable_amount" id="inputApprovable">
                <input type="hidden" name="approved_loan_amount" id="inputApproved">


                <!-- Calculation Box -->
                <div id="calculationBox" class="flex justify-center hidden">
                    <table class="w-1/2 overflow-x-auto mt-6 bg-primary/20 rounded-lg text-sm">
                        <tbody>
                            <tr class="border-b border-gray-300">
                                <th class="uppercase text-center font-semibold p-2 w-1/2">Net Loan Amount</th>
                                <th class="text-start font-medium p-2 w-1/2" id="net-loan-amt">-</th>
                            </tr>
                            <tr class="border-b border-gray-300">
                                <th class="uppercase text-center font-semibold p-2">Maximum Approvable Amount</th>
                                <th class="text-start font-medium p-2" id="m-approval-amt">-</th>
                            </tr>
                            <tr>
                                <th class="uppercase text-center font-semibold p-2">Approved Loan Amount</th>
                                <th class="text-start font-medium p-2" id="approval-amt">-</th>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <!-- Buttons -->
                <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                    <button id="calculateBtn" class="btn-primary uppercase justify-center" type="button">
                        Calculate
                    </button>

                    <button class="btn-outline uppercase justify-center" type="reset">
                        <a href="{{ route('personal.applications.index') }}">BACK</a>
                    </button>
                </div>

            </form>
        </div>
    </div>


    <!-- tenure t0ggel -->
    <script>
        const radios = document.querySelectorAll('input[name="tenure_type"]');
        const label = document.getElementById('tenureLabel');

        radios.forEach(radio => {
            radio.addEventListener('change', () => {
                label.textContent = `( ${radio.value} )`;
            });
        });
    </script>

    <!-- collapsed logic + - button-->
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

    <!-- member info -->
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

    <!-- scheme info -->
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

    <!-- // =====logic for dynamic cibil rows===== -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const cibilBody = document.getElementById("cibilBody");
            const addRowBtn = document.getElementById("addRow");

            // Function to return a new row HTML
            function newRow() {
                return `
        <tr class="nested-fields">
            <!-- Cibil Type -->
            <td class="px-2 py-2 border border-gray-300" style="width:220px">
                <select name="cibil_type[]" required
                    class="w-full text-center dark:bg-bg3 border border-gray-300 rounded-10 px-2 py-2 text-sm md:text-base bg-secondary/5">
                    <option value="">Select</option>
                    <option value="transunion">TransUnion</option>
                    <option value="equifax">Equifax</option>
                    <option value="experian">Experian</option>
                    <option value="crif_highmark">Crif Highmark</option>
                </select>
            </td>

            <!-- Cibil Score -->
            <td class="px-2 py-2 border border-gray-300">
                <input type="number" name="cibil_score[]" placeholder="Enter CIBIL Score"
                    class="w-full text-center dark:bg-bg3 border border-gray-300 rounded-10 px-2 py-2 text-sm md:text-base bg-secondary/5" required/>
            </td>

            <!-- Report Date -->
            <td class="px-2 py-2 border border-gray-300 relative">
                <input type="text" name="report_date[]" value="{{ now()->format('d/m/Y') }}" placeholder="DD/MM/YYYY"
                    class="w-full text-center dark:bg-bg3 border border-gray-300 rounded-10 px-2 py-2 text-sm md:text-base bg-secondary/5" required/>
            </td>

            <!-- Upload File -->
            <td class="px-2 py-2 border border-gray-300">
                <input type="file" name="report_file[]"
                    class="w-full text-center dark:bg-bg3 border border-gray-300 rounded-10 px-2 py-2 text-sm md:text-base bg-secondary/5"/>
            </td>

            <!-- Remove button -->
            <td class="px-2 py-2 md:px-4 md:py-2 border border-gray-300 text-center">
                <button type="button" class="removeRow text-red-500 hover:text-red-700">
                    <i class="las la-times" aria-hidden="true"></i>
                </button>
            </td>
        </tr>`;
            }

            // Add default row only once
            if (cibilBody.children.length === 0 && !window.defaultCibilRowAdded) {
                cibilBody.insertAdjacentHTML("beforeend", newRow());
                window.defaultCibilRowAdded = true;
            }

            // Add new row when "Add Row" button is clicked
            addRowBtn.addEventListener("click", function() {
                cibilBody.insertAdjacentHTML("beforeend", newRow());
            });

            // Remove row when X is clicked
            cibilBody.addEventListener("click", function(e) {
                if (e.target.closest(".removeRow")) {
                    e.target.closest("tr").remove();
                }
            });
        });
    </script>

    <!-- pay mode -->
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

    <!-- loan amount + insurance amount = net loan amoun -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loanInput = document.getElementById('loanAmount');
            const insuranceInput = document.getElementById('insuranceAmount');
            const netLoanInput = document.getElementById('netLoanAmount');

            function updateNetLoanAmount() {
                const loanAmount = parseFloat(loanInput.value) || 0;
                const insuranceAmount = parseFloat(insuranceInput.value) || 0;
                const total = loanAmount + insuranceAmount;
                netLoanInput.value = total.toFixed(2); // two decimal precision
            }

            // Event listeners
            loanInput.addEventListener('input', updateNetLoanAmount);
            insuranceInput.addEventListener('input', updateNetLoanAmount);

            // Run on page load (in case of old values)
            updateNetLoanAmount();
        });
    </script>

    <!-- Calculation Script with multiple recalculate and after submit data-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const calcBtn = document.getElementById("calculateBtn");
            const calcBox = document.getElementById("calculationBox");
            const form = calcBtn.closest("form");

            let mode = "calculate"; // calculate | submit

            function runCalculation(e) {
                e.preventDefault();

                let loanAmount = parseFloat(document.getElementById("loanAmount").value) || 0;
                let insuranceAmount = parseFloat(document.getElementById("insuranceAmount").value) || 0;
                let netLoanAmount = loanAmount + insuranceAmount;

                let scheme = document.getElementById("scheme_id");
                let selected = scheme.options[scheme.selectedIndex];
                let maxLoan = parseFloat(selected.getAttribute("data-max")) || 0;

                if (netLoanAmount > maxLoan) {
                    alert("Requested Loan Amount (₹" + netLoanAmount + ") cannot exceed Maximum Loan Limit of ₹" +
                        maxLoan);
                    netLoanAmount = maxLoan;
                }

                document.getElementById("net-loan-amt").textContent = netLoanAmount.toFixed(2);
                document.getElementById("m-approval-amt").textContent = maxLoan.toFixed(2);
                document.getElementById("approval-amt").textContent = Math.min(netLoanAmount, maxLoan).toFixed(2);

                calcBox.classList.remove("hidden");

                // Button ko submit mode me convert
                calcBtn.textContent = "Submit Application";
                calcBtn.type = "submit";
                mode = "submit";
            }

            // MAIN BUTTON CLICK
            calcBtn.addEventListener("click", function(e) {
                if (mode === "calculate") {
                    runCalculation(e); // prevent submit
                }
                // mode === submit → form naturally submit hoga (no JS submit)
            });


            // RESET LOGIC
            function resetCalculation() {
                if (mode === "calculate") return;

                calcBox.classList.add("hidden");
                calcBtn.textContent = "Calculate";
                calcBtn.type = "button";
                mode = "calculate";
            }

            const fieldsToWatch = [
                "loanAmount", "insuranceAmount", "scheme_id",
                "tenure", "interestRate", "emiPayout"
            ];

            fieldsToWatch.forEach(id => {
                const f = document.getElementById(id);
                if (f) {
                    f.addEventListener("input", resetCalculation);
                    f.addEventListener("change", resetCalculation);
                }
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

    <!-- loan amount & insurance amount sub text massage -->
    <script>
        function numberToWords(num) {
            const a = [
                '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
                'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen',
                'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
            ];
            const b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

            if (num === 0) return '';
            if (num < 20) return a[num];
            if (num < 100) return b[Math.floor(num / 10)] + (num % 10 ? ' ' + a[num % 10] : '');
            if (num < 1000) return a[Math.floor(num / 100)] + ' Hundred ' + numberToWords(num % 100);

            if (num < 100000)
                return numberToWords(Math.floor(num / 1000)) + ' Thousand ' + numberToWords(num % 1000);

            if (num < 10000000)
                return numberToWords(Math.floor(num / 100000)) + ' Lakh ' + numberToWords(num % 100000);

            return numberToWords(Math.floor(num / 10000000)) + ' Crore ' + numberToWords(num % 10000000);
        }

        function updateWords(inputId, outputId) {
            const value = document.getElementById(inputId).value;
            const wordsContainer = document.getElementById(outputId);

            if (value && !isNaN(value)) {
                wordsContainer.textContent = numberToWords(parseInt(value)) + " Rupees Only";
            } else {
                wordsContainer.textContent = "";
            }
        }

        document.getElementById("loanAmount").addEventListener("input", function() {
            updateWords("loanAmount", "loanAmountWords");
        });

        document.getElementById("insuranceAmount").addEventListener("input", function() {
            updateWords("insuranceAmount", "insuranceAmountWords");
        });
    </script>

    <script>
        // <!-- collapsed logic + - button-->
        function toggleSection(button, sectionId) {
            const section = document.getElementById(sectionId);
            const icon = button.querySelector('.toggle-icon');

            section.classList.toggle('hidden');
            icon.textContent = section.classList.contains('hidden') ? '+' : '−';
        }
    </script>

    <!-- Max Tenure & tenure vaule Validation -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const schemeSelect = document.getElementById("scheme_id");
            const tenureInput = document.getElementById("tenure_value");
            const tenureRadios = document.querySelectorAll('input[name="tenure_type"]');
            const tenureLabel = document.getElementById("tenureLabel");

            let maxMonths = parseInt(schemeSelect.options[schemeSelect.selectedIndex]?.getAttribute(
                "data-tenure")) || 0;

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

        });
    </script>

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
        document.addEventListener("DOMContentLoaded", function() {

            const divideCheckbox = document.getElementById("divide_emi_ratio");
            const ratioFields = document.getElementById("ratioFields");
            const emiRatio1 = document.getElementById("emi_ratio_1");
            const emiRatio2 = document.getElementById("emi_ratio_2");
            const amtRatio1 = document.getElementById("amt_ratio_1");
            const amtRatio2 = document.getElementById("amt_ratio_2");

            const hiddenRatioEnabled = document.getElementById("ratio_enabled");
            const hiddenRatioFirstEmi = document.getElementById("ratio_first_emi");

            const tenureValueInput = document.querySelector("input[name='tenure_value']");

            function calculateRatio() {

                let tenure = parseInt(tenureValueInput?.value) || 0;
                let firstEmi = parseInt(emiRatio1?.value) || 0;

                if (firstEmi > tenure) {
                    document.getElementById("emiRatioError").classList.remove("hidden");
                    emiRatio2.value = 0;
                    return;
                } else {
                    document.getElementById("emiRatioError").classList.add("hidden");
                }

                emiRatio2.value = tenure - firstEmi;

                let firstPercent = parseFloat(amtRatio1?.value) || 0;
                amtRatio2.value = 100 - firstPercent;

                hiddenRatioFirstEmi.value = firstEmi;
            }

            if (divideCheckbox) {
                divideCheckbox.addEventListener("change", function() {
                    if (this.checked) {
                        ratioFields.style.display = "block";
                        hiddenRatioEnabled.value = "Yes";
                    } else {
                        ratioFields.style.display = "none";
                        hiddenRatioEnabled.value = "No";
                    }
                });
            }

            emiRatio1?.addEventListener("input", calculateRatio);
            amtRatio1?.addEventListener("input", calculateRatio);

        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const schemeSelect = document.getElementById("scheme_id");

            const reduceBox = document.getElementById("reduce_ratio_box");
            const ratioFields = document.getElementById("ratioFields");
            const divideCheckbox = document.getElementById("divide_emi_ratio");
            const hiddenRatioEnabled = document.getElementById("ratio_enabled");

            function resetAll() {
                reduceBox.style.display = "none";
                ratioFields.style.display = "none";
                divideCheckbox.checked = false;
                hiddenRatioEnabled.value = "No";
            }

            function applyInterestLogic(type) {

                resetAll();

                type = (type || "").toLowerCase();

                // ==========================
                // 1️⃣ REDUCING EMI
                // ==========================
                if (type === "reducing_emi") {

                    reduceBox.style.display = "flex";

                    if (hiddenRatioEnabled.value === "Yes") {
                        divideCheckbox.checked = true;
                        ratioFields.style.display = "block";
                    }
                }

                // ==========================
                // 2️⃣ FLAT EMI
                // ==========================
                else if (type === "flat_emi") {

                    // No ratio allowed
                    reduceBox.style.display = "none";
                    ratioFields.style.display = "none";

                    // Here you can show flat EMI related options if needed
                    console.log("Flat EMI Selected");
                }

                // ==========================
                // 3️⃣ FLAT ADVANCED INTEREST
                // ==========================
                else if (type === "flat_advanced_interest") {

                    // No ratio allowed
                    reduceBox.style.display = "none";
                    ratioFields.style.display = "none";

                    console.log("Flat Advanced Selected");
                }

            }

            schemeSelect.addEventListener("change", function() {
                const selected = this.options[this.selectedIndex];
                const type = selected.getAttribute("data-type");

                applyInterestLogic(type);
            });

            // Trigger on page load
            if (schemeSelect.value) {
                schemeSelect.dispatchEvent(new Event("change"));
            }

            // Ratio checkbox toggle
            divideCheckbox.addEventListener("change", function() {
                if (this.checked) {
                    ratioFields.style.display = "block";
                    hiddenRatioEnabled.value = "Yes";
                } else {
                    ratioFields.style.display = "none";
                    hiddenRatioEnabled.value = "No";
                }
            });

        });
    </script>

@endsection
