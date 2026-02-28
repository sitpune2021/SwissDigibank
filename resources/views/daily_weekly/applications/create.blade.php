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
                <h1 class="text-xl font-semibold">DAILY / WEEKLY LOAN APPLICATION</h1>
            </div>
        </div>

        <div class="box">
            <form method="POST"
                action="{{ isset($application) ? route('daily_weekly.applications.update', $application->id) : route('daily_weekly.store') }}"
                enctype="multipart/form-data">
                @csrf
                @if (isset($application))
                    @method('PUT')
                @endif

                <div class="flex flex-col lg:flex-row mb-3 gap-4 ">
                    <div class="w-full col-span-12 px-3 py-1 rounded-10 lg:col-span-12">
                        <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

                            <div class="col-span-2 md:col-span-1">
                                {{-- Application Date --}}
                                <label class="md:text-lg font-medium block mb-4">
                                    Application Date <span class="text-red-500">*</span>
                                </label>

                                <input type="text" name="application_date"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                    value="{{ \Carbon\Carbon::parse(old('application_date', $application->application_date ?? date('Y-m-d')))->format('d-m-Y') }}">
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="member_id" class="md:text-lg font-medium block mb-4">
                                    CUSTOMER <span class="text-red-500">*</span>
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
                                                data-tenure="{{ $sc->no_of_emi }} {{ strtoupper($sc->gold_loan_setting) }}"
                                                data-max="{{ $sc->max_loan_amount ?? '-' }}"
                                                data-interest="{{ $sc->annual_interest_rate ?? '-' }}"
                                                data-type="{{ strtoupper($sc->gold_loan_setting) ?? '-' }}"
                                                data-active="{{ $sc->is_active ? 'Yes' : 'No' }}"
                                                data-charge="{{ $sc->fore_closer_charge ?? '-' }}"
                                                data-sms="{{ $sc->sms_charge ?? 0 }}"
                                                data-fuel="{{ $sc->fuel_charge ?? 0 }}"
                                                data-stationary="{{ $sc->stationary_charge ?? 0 }}"
                                                data-maintenance="{{ $sc->maintenance_charge ?? 0 }}"
                                                data-collection="{{ $sc->collection ?? 0 }}"
                                                data-processing="{{ $sc->processing_fee ?? 0 }}"
                                                data-stamp="{{ $sc->stamp_duty_charge ?? 0 }}"
                                                data-insurance="{{ $sc->insurance_fee ?? 0 }}"
                                                data-penalty="{{ $sc->penalty_charge ?? 0 }}"
                                                data-overdue="{{ $sc->overdue_rate ?? 0 }}"
                                                data-overdue-type="{{ $sc->overdue_type ?? '' }}"
                                                data-created="{{ $sc->created_at ? $sc->created_at->format('d/m/Y H:i') : '-' }}"
                                                data-updated="{{ $sc->updated_at ? $sc->updated_at->format('d/m/Y H:i') : '-' }}"
                                                data-emi="{{ $sc->no_of_emi }}"
                                                data-processing="{{ $sc->processing_fee ?? 0 }}"
                                                data-stamp="{{ $sc->stamp_duty_charge ?? 0 }}"
                                                data-insurance="{{ $sc->insurance_fee ?? 0 }}"
                                                data-collection-setting="{{ strtolower($sc->gold_loan_setting) }}"
                                                data-max-loan="{{ $sc->max_loan_amount }}">
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
                                    No of EMIs <span id="tenureLabel" class="text-black uppercase"></span>
                                    <span class="text-error">*</span>
                                </label>
                                <input type="number" id="tenure_value" name="tenure_value"
                                    value="{{ old('tenure_value', $application->tenure_value ?? '') }}"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    readonly>
                                @error('tenure_value')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="" class="md:text-lg font-medium block mb-4">
                                    Loan Amount <span id="" class="text-black uppercase"></span>
                                    <span class="text-error">*</span>
                                </label>
                                <input type="number" id="loan_amount" name="loan_amount"
                                    value="{{ old('loan_amount', $application->loan_amount ?? '') }}"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    readonly>
                                @error('loan_amount')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="emi_collection" class="md:text-lg font-medium block mb-4">
                                    EMI Collection <span class="text-red-500">*</span>
                                </label>

                                <select id="emi_collection" name="emi_collection"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3">

                                    @php
                                        $selectedValue = old('emi_collection', $application->emi_collection ?? '');
                                    @endphp

                                    <option value="">Select EMI Collection</option>
                                    <option value="daily" {{ $selectedValue == 'daily' ? 'selected' : '' }}>DAILY
                                    </option>
                                    <option value="weekly" {{ $selectedValue == 'weekly' ? 'selected' : '' }}>WEEKLY
                                    </option>
                                    <option value="bi_weekly" {{ $selectedValue == 'bi_weekly' ? 'selected' : '' }}>BI
                                        WEEKLY
                                    </option>
                                    <option value="4_weekly" {{ $selectedValue == '4_weekly' ? 'selected' : '' }}>4 WEEKLY
                                    </option>
                                    <option value="Monthaly" {{ $selectedValue == 'Monthaly' ? 'selected' : '' }}>MONTHALY
                                    </option>
                                </select>
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="" class="md:text-lg font-medium block mb-6">
                                    EMI Amount <span id="" class="text-black uppercase"></span>
                                    <span class="text-error">*</span>
                                </label>
                                <input type="number" id="emi_amount" name="emi_amount"
                                    value="{{ old('emi_amount', $application->emi_amount ?? '') }}"
                                    class="w-full text-sm mt-5 bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                @error('emi_amount')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="" class="md:text-lg font-medium block mb-4">
                                    Processing Fee (INC GST 18 %) <span id=""
                                        class="text-black uppercase"></span>
                                    <span class="text-error">*</span>
                                </label>
                                <input type="number" id="processing_fee" name="processing_fee"
                                    value="{{ old('processing_fee', $application->processing_fee ?? '') }}"
                                    class="w-full text-sm bg-secondary/5 mt-7 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    readonly>
                                @error('processing_fee')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="" class="md:text-lg font-medium block mb-4">
                                    Stamp Duty (INC GST 18 %)<span id="" class="text-black uppercase"></span>
                                    <span class="text-error">*</span>
                                </label>
                                <input type="number" id="stamp_duty" name="stamp_duty"
                                    value="{{ old('stamp_duty', $application->stamp_duty ?? '') }}"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    readonly>
                                @error('stamp_duty')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="" class="md:text-lg font-medium block mb-4">
                                    Fitness Fee (INC GST 18 %) <span id="" class="text-black uppercase"></span>
                                    <span class="text-error">*</span>
                                </label>
                                <input type="number" id="fitness_fee" name="fitness_fee"
                                    value="{{ old('fitness_fee', $application->fitness_fee ?? '') }}"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                @error('fitness_fee')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="" class="md:text-lg font-medium block mb-6">
                                    Insurance Fee <span id="" class="text-black uppercase"></span>
                                    <span class="text-error">*</span>
                                </label>
                                <input type="number" id="insurance_fee" name="insurance_fee"
                                    value="{{ old('insurance_fee', $application->insurance_fee ?? '') }}"
                                    class="w-full text-sm mt-5 bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    readonly>
                                @error('insurance_fee')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
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

                            <div class="col-span-2 md:col-span-1 mb-3">
                                <label for="" class="md:text-lg font-medium block mb-4">
                                    Purpose of Loan
                                    <span class="text-error">*</span>
                                </label>
                                <input type="text" id="purpose_of_loan" name="purpose_of_loan"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    placeholder="Enter Purpose of CC Limit"
                                    value="{{ old('purpose_of_loan', $application->purpose_of_loan ?? '') }}">
                                @error('purpose_of_loan')
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
                                        @if (isset($application) && $application->creditScores)
                                            @foreach ($application->creditScores as $score)
                                                <tr>
                                                    <td class="px-2 py-2">
                                                        <select name="cibil_type[]"
                                                            class="w-full text-center rounded-10 px-2 py-2 border">
                                                            <option value="transunion"
                                                                {{ $score->cibil_type == 'transunion' ? 'selected' : '' }}>
                                                                TransUnion</option>
                                                            <option value="equifax"
                                                                {{ $score->cibil_type == 'equifax' ? 'selected' : '' }}>
                                                                Equifax</option>
                                                            <option value="experian"
                                                                {{ $score->cibil_type == 'experian' ? 'selected' : '' }}>
                                                                Experian</option>
                                                            <option value="crif_highmark"
                                                                {{ $score->cibil_type == 'crif_highmark' ? 'selected' : '' }}>
                                                                Crif Highmark</option>
                                                        </select>
                                                    </td>

                                                    <td class="px-2 py-2">
                                                        <input type="number" name="cibil_score[]"
                                                            value="{{ $score->cibil_score }}"
                                                            class="w-full text-center rounded-10 px-2 py-2 border" />
                                                    </td>

                                                    <td class="px-2 py-2">
                                                        <input type="text" name="report_date[]"
                                                            value="{{ $score->report_date ? \Carbon\Carbon::parse($score->report_date)->format('d-m-Y') : '' }}"
                                                            class="w-full text-center rounded-10 px-2 py-2 border" />
                                                    </td>


                                                    <td class="px-2 py-2">
                                                        <input type="file" name="report_file[]"
                                                            class="w-full text-center rounded-10 px-2 py-2 border" />
                                                        @if ($score->report_file_path)
                                                            <a href="{{ asset('storage/' . $score->report_file_path) }}"
                                                                target="_blank"
                                                                class="text-blue-500 underline text-sm">View File</a>
                                                        @endif
                                                    </td>

                                                    {{-- <td class="px-2 py-2 text-center">
                                                        <button type="button"
                                                            class="removeRow text-red-500 hover:text-red-700">
                                                            <i class="las la-times"></i>
                                                        </button>
                                                    </td> --}}
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>

                                </table>
                            </div>

                            {{-- <div class="mt-3">
                            <button type="button" id="addRow" class="btn-primary rounded-10 px-4 py-2">
                                + Add New Score
                            </button>
                        </div> --}}

                            {{-- calculator checkbox- --}}
                            <!-- <x-checkbox-calculator id="manualEntry" name="manual_entry" label="Collect Principal Amount as EMI"
                                sublabel="(Check this if you want to collect principal amount as EMIs.)" /> -->
                        </div>

                        <!-- Collect Advance Processing Fee -->
                        {{-- <div class="col-span-12  lg:col-span-12 ">
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
                                <div class="mt-3 flex fle-row gap-3">
                                    <!-- Pay Mode -->
                                    <label class="mr-4 flex fle-row gap-3 items-center">
                                        <input type="radio" name="fee_mode" value="cash"
                                            {{ old('fee_mode', $application->fee_mode ?? '') == 'cash' ? 'checked' : '' }}
                                            checked>
                                        <p>
                                            Cash
                                        </p>
                                    </label>
                                    <label class="mr-4 flex fle-row gap-3 items-center">
                                        <input type="radio" name="fee_mode" value="cheque"
                                            {{ old('fee_mode', $application->fee_mode ?? '') == 'cheque' ? 'checked' : '' }}>
                                        <p>Cheque</p>
                                    </label>
                                    <label class="mr-4 flex fle-row gap-3 items-center">
                                        <input type="radio" name="fee_mode" value="online"
                                            {{ old('fee_mode', $application->fee_mode ?? '') == 'online' ? 'checked' : '' }}>
                                        <p>Online Tr.</p>
                                    </label>
                                </div>

                                <!-- Bank + Cheque Fields -->
                                <div id="bankDropdownWrapper" class="mt-3 hidden">
                                    <label for="bank_id" class="block mb-2 text-sm font-medium">Select Bank</label>
                                    <select id="bank_id" name="bank_id"
                                        class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
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
                                            class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3"
                                            placeholder="Enter Cheque No"
                                            value="{{ old('cheque_no', $application->cheque_no ?? '') }}">
                                    </div>

                                    <!-- Cheque Date -->
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">Cheque Date</label>
                                        <input type="text" id="cheque_date" name="cheque_date"
                                            value="{{ old('cheque_date', $application->cheque_date ?? '') }}"
                                            class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>
                                </div>

                                <!-- Online Transaction Fields -->
                                <div id="onlineFields" class="space-y-4 hidden">
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">
                                            Transfer Date <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="transfer_date" name="transfer_date"
                                            value="{{ old('transfer_date', $application->transfer_date ?? '') }}"
                                            class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">
                                            UTR / Transaction No. <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="utr_no" name="utr_no"
                                            placeholder="Enter Transaction No."
                                            value="{{ old('utr_no', $application->utr_no ?? '') }}"
                                            class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
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
                                    Note: If you wish to collect processing fee at the time of disbursement, then enter 0.
                                    Fees
                                    will be calculated accordingly.
                                </p>

                            </div>
                        </div> --}}
                    </div>

                    <div class="flex-2 col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6 min-w-[300px]">
                        {{-- Member Info Box --}}
                        <div id="memberBox" class="w-full hidden"> {{-- hidden by default --}}
                            <div
                                class="flex justify-between items-center bg-secondary/5  rounded-10 px-4 py-3 dark:bg-bg3">
                                <h3 class="text-base capitalize font-semibold md:text-lg">CUSTOMER INFO</h3>
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
                                <h3 class="text-base font-semibold md:text-lg uppercase">SCHEME INFO</h3>
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
                                                <td class="font-semibold py-2 pr-4 uppercase">Scheme Code</td>
                                                <td class="py-2" id="schemeCode">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Scheme Name</td>
                                                <td class="py-2" id="schemeName">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Tenure</td>
                                                <td class="py-2" id="schemeTenure">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Maximum Loan Amount</td>
                                                <td class="py-2" id="schemeMax">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Annual Interest Rate</td>
                                                <td class="py-2" id="schemeInterest">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Overdue Interest Rate (%)
                                                </td>
                                                <td class="py-2" id="schemeOverdue">-</td>
                                            </tr>

                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Interest Type</td>
                                                <td class="py-2" id="schemeType">-</td>
                                            </tr>

                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Active</td>
                                                <td class="py-2" id="schemeActive">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Fore Closure Charges</td>
                                                <td class="py-2" id="schemeCharge">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">SMS Charges per EMI</td>
                                                <td class="py-2" id="schemeSMS">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Fuel Charges per EMI</td>
                                                <td class="py-2" id="schemeFuel">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Stationary Charges per EMI
                                                </td>
                                                <td class="py-2" id="schemeStationary">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Maintenance Charges per EMI
                                                </td>
                                                <td class="py-2" id="schemeMaintenance">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Collection Charges per EMI
                                                </td>
                                                <td class="py-2" id="schemeCollection">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Credit Period</td>
                                                <td class="py-2" id="schemePeriod">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Processing Fee</td>
                                                <td class="py-2" id="schemeProcessing">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Stamp Duty Fee</td>
                                                <td class="py-2" id="schemeStamp">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Insurance Charges</td>
                                                <td class="py-2" id="schemeInsurance">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Penalty Charge</td>
                                                <td class="py-2" id="schemePenalty">-</td>
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
                <!-- Hidden fields for backend -->
                <input type="hidden" id="inputChargesPerEmi" name="charges_per_emi">
                <input type="hidden" id="inputNetEmiWithCharges" name="net_emi_with_charges">
                <input type="hidden" id="inputTotalRecovered" name="total_recovered_amount">

                <!-- ADD THESE -->
                <input type="hidden" id="inputMaxLoan" name="max_loan_amount">
                <input type="hidden" id="inputMaxApprovable" name="maximum_approvable_amount">
                <input type="hidden" id="inputApprovedLoan" name="approved_loan_amount">

                <div id="calculationBox" class="mt-5 p-4 bg-secondary/5 rounded-10 hidden">
                    <h3 class="text-lg font-semibold mb-3">Calculation Result</h3>
                    <table class="w-full text-sm">
                        <tbody>
                            <tr>
                                <td class="font-semibold py-1">Requested Loan Amount</td>
                                <td id="reqLoan">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold py-1">Charges Per EMI</td>
                                <td id="chargesPerEmi">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold py-1">Net EMI Amount with Charges</td>
                                <td id="netEmiWithCharges">-</td>
                            </tr>
                            <tr>
                                <td class="font-semibold py-1">Total Amount Recovered (Net EMI * No of EMIs)</td>
                                <td id="totalRecovered">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <!-- Buttons -->
                <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                    <button type="button" id="calculateBtn" class="btn-primary uppercase justify-center">
                        Calculate
                    </button>
                    <button class="btn-outline uppercase justify-center" type="reset">
                        <a href="{{ route('daily_weekly.applications.index') }}"> BAck</a>
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Memeber / Customer info -->
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

    <!-- Memeber / Customer Details -->
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

    <!-- Scheme details info -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // ⭐⭐⭐ ADD THIS FUNCTION AT THE TOP ⭐⭐⭐
            function formatDate(dateStr) {
                if (!dateStr) return "-";

                let d = new Date(dateStr);

                let day = String(d.getDate()).padStart(2, '0');
                let month = String(d.getMonth() + 1).padStart(2, '0');
                let year = d.getFullYear();

                return `${day}-${month}-${year}`;
            }

            const schemeSelect = document.getElementById("scheme_id");
            const schemeBox = document.getElementById("schemeBox");

            const schemeCode = document.getElementById("schemeCode");
            const schemeName = document.getElementById("schemeName");
            const schemeTenure = document.getElementById("schemeTenure");
            const schemeMax = document.getElementById("schemeMax");

            const schemeInterest = document.getElementById("schemeInterest");
            const schemeOverdue = document.getElementById("schemeOverdue");
            const schemeType = document.getElementById("schemeType");

            const schemeActive = document.getElementById("schemeActive");
            const schemeCharge = document.getElementById("schemeCharge");

            const schemeSMS = document.getElementById("schemeSMS");
            const schemeFuel = document.getElementById("schemeFuel");
            const schemeStationary = document.getElementById("schemeStationary");
            const schemeMaintenance = document.getElementById("schemeMaintenance");
            const schemeCollection = document.getElementById("schemeCollection");
           

            const schemePeriod = document.getElementById("schemePeriod");
            const schemeProcessing = document.getElementById("schemeProcessing");
            const schemeStamp = document.getElementById("schemeStamp");
            const schemeInsurance = document.getElementById("schemeInsurance");
            const schemePenalty = document.getElementById("schemePenalty");

            const tenureValue = document.getElementById("tenure_value");
            const loanAmount = document.getElementById("loan_amount");
            const emiAmount = document.getElementById("emi_amount");
            const emiCollection = document.getElementById("emi_collection");
            const inputProcessing = document.getElementById("processing_fee");
            const inputStamp = document.getElementById("stamp_duty");
            const inputInsurance = document.getElementById("insurance_fee");

            schemeSelect.addEventListener("change", function() {
                const selected = this.options[this.selectedIndex];

                if (!this.value) {
                    schemeBox.classList.add("hidden");
                    return;
                }

                const addGST = (amount) => {
                    return (parseFloat(amount) + (parseFloat(amount) * 0.18)).toFixed(2);
                };

                schemeCode.textContent = selected.getAttribute("data-code");
                schemeName.textContent = selected.getAttribute("data-name");
                schemeTenure.textContent = selected.getAttribute("data-tenure");
                schemeMax.textContent = selected.getAttribute("data-max");
                schemeInterest.textContent = selected.getAttribute("data-interest");

                let overdueRate = selected.getAttribute("data-overdue") || 0;
                let overdueType = selected.getAttribute("data-overdue-type") || '';

                if (overdueType !== '') {
                    schemeOverdue.textContent = overdueRate + " % of " + overdueType;
                } else {
                    schemeOverdue.textContent = overdueRate + " %";
                }

                schemeType.textContent = selected.getAttribute("data-type");
                schemeActive.textContent = selected.getAttribute("data-active");
                schemeCharge.textContent = "₹ " + selected.getAttribute("data-charge");

                schemeSMS.textContent = "₹ " + selected.getAttribute("data-sms");
                schemeFuel.textContent = "₹ " + selected.getAttribute("data-fuel");
                schemeStationary.textContent = "₹ " + selected.getAttribute("data-stationary");
                schemeMaintenance.textContent = "₹ " + selected.getAttribute("data-maintenance");
                schemeCollection.textContent = "₹ " + selected.getAttribute("data-collection");

                schemePeriod.textContent = selected.getAttribute("data-tenure") || "-";

                schemeProcessing.textContent = "₹ " + selected.getAttribute("data-processing");
                schemeStamp.textContent = "₹ " + selected.getAttribute("data-stamp");
                schemeInsurance.textContent = "₹ " + selected.getAttribute("data-insurance");
                schemePenalty.textContent = selected.getAttribute("data-penalty") + " %";
                tenureValue.value = selected.getAttribute("data-emi") || "";
                loanAmount.setAttribute("max", selected.getAttribute("data-max"));
                loanAmount.value = selected.getAttribute("data-max");
                emiCollection.value = selected.getAttribute("data-collection-setting");
                inputProcessing.value = addGST(selected.getAttribute("data-processing"));
                inputStamp.value = addGST(selected.getAttribute("data-stamp"));
                inputInsurance.value = addGST(selected.getAttribute("data-insurance"));

                //////////////////////////////////////////////////
                // AUTO EMI CALCULATION ADDED HERE
                const maxLoanAmount = parseFloat(selected.getAttribute("data-max")) || 0;
                const emis = parseInt(selected.getAttribute("data-emi")) || 1;
                const emiAmountCalc = maxLoanAmount / emis;

                emiAmount.value = emiAmountCalc.toFixed(2);
                emiAmount.setAttribute("readonly", true);
                //////////////////////////////////////////////////

                schemeBox.classList.remove("hidden");
            });
        });
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

    <!-- Calculation and auto populate when select scheme -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let isCalculated = false;
            const calcBtn = document.getElementById("calculateBtn");
            calcBtn.type = "button";

            calcBtn.addEventListener("click", function(e) {
                const button = this;

                const loanAmount = parseFloat(document.getElementById("loan_amount")?.value) || 0;

                const scheme = document.getElementById("scheme_id");
                const selected = scheme.options[scheme.selectedIndex];

                const maxLoan = parseFloat(selected.getAttribute("data-max")) || loanAmount;
                const approvable = Math.min(loanAmount, maxLoan);
                // 🔥 Set hidden approval values
                document.getElementById("inputMaxLoan").value = maxLoan.toFixed(2);
                document.getElementById("inputMaxApprovable").value = approvable.toFixed(2);
                document.getElementById("inputApprovedLoan").value = approvable.toFixed(2);
                const processingFee = parseFloat(selected.getAttribute("data-processing")) || 0;
                const stampDuty = parseFloat(selected.getAttribute("data-stamp")) || 0;
                const insuranceFee = parseFloat(selected.getAttribute("data-insurance")) || 0;
                const smsFee = parseFloat(selected.getAttribute("data-sms")) || 0;
                const fuelFee = parseFloat(selected.getAttribute("data-fuel")) || 0;
                const stationaryFee = parseFloat(selected.getAttribute("data-stationary")) || 0;
                const maintenanceFee = parseFloat(selected.getAttribute("data-maintenance")) || 0;

                const noOfEmi = parseInt(document.getElementById("tenure_value")?.value) ||
                    parseInt(selected.getAttribute("data-emi")) ||
                    1;

                const totalCharges = processingFee + stampDuty + insuranceFee + smsFee + fuelFee +
                    stationaryFee + maintenanceFee;
                const chargesPerEmi = totalCharges / noOfEmi;

                const netEmiWithCharges = (loanAmount / noOfEmi) + chargesPerEmi;
                const totalRecovered = netEmiWithCharges * noOfEmi;

                document.getElementById("reqLoan").textContent = loanAmount.toFixed(2);
                document.getElementById("chargesPerEmi").textContent = chargesPerEmi.toFixed(2);
                document.getElementById("netEmiWithCharges").textContent = netEmiWithCharges.toFixed(2);
                document.getElementById("totalRecovered").textContent = totalRecovered.toFixed(2);

                const emiInput = document.getElementById("emi_amount");
                if (emiInput) {
                    emiInput.value = netEmiWithCharges.toFixed(2);
                    emiInput.setAttribute("readonly", true);
                }

                document.getElementById("inputChargesPerEmi").value = chargesPerEmi.toFixed(2);
                document.getElementById("inputNetEmiWithCharges").value = netEmiWithCharges.toFixed(2);
                document.getElementById("inputTotalRecovered").value = totalRecovered.toFixed(2);

                document.getElementById("calculationBox").classList.remove("hidden");

                if (!isCalculated) {
                    e.preventDefault();
                    button.textContent = "Submit";
                    button.type = "submit";
                    isCalculated = true;
                }
            });
        });
    </script>

    <!-- Cibil Score info -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const cibilBody = document.getElementById("cibilBody");
            const addRowBtn = document.getElementById("addRow");

            // Template for new row
            function newRow() {
                const today = new Date();
                const day = String(today.getDate()).padStart(2, '0');
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const year = today.getFullYear();
                //const formattedDate = `${day}/${month}/${year}`;
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
              
            </tr>
        `;
            }

            // // Add new row
            // addRowBtn.addEventListener("click", () => {
            //     cibilBody.insertAdjacentHTML("beforeend", newRow());
            // });

            // Remove row (event delegation)
            cibilBody.addEventListener("click", function(e) {
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

    <script>
        // <!-- collapsed logic + - button-->
        function toggleSection(button, sectionId) {
            const section = document.getElementById(sectionId);
            const icon = button.querySelector('.toggle-icon');

            section.classList.toggle('hidden');
            icon.textContent = section.classList.contains('hidden') ? '+' : '−';
        }
    </script>


@endsection
