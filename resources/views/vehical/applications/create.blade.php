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
            <h1 class="text-xl font-semibold uppercase">NEW VEHICAL LOAN APPLICATION</h1>
        </div>
    </div>

    <div class="box">
        <form method="POST" 
                        action="{{ isset($application) ? route('vehical.applications.update', $application->id) : route('vehical.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($application))
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
                            <label for="" class="md:text-lg font-medium block mb-6">
                                EMI Collection <span class="text-error">* </span>
                            </label>
                            <select name="emi_collection" class="w-full mt-5 text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">>
                                <option value="">Please Select</option>
                                <option value="Monthaly" {{ old('emi_collection', $application->emi_collection ?? '') == 'Monthaly' ? 'selected' : '' }}>Monthaly</option>
                                <option value="Qaurterly" {{ old('emi_collection', $application->emi_collection ?? '') == 'Qaurterly' ? 'selected' : '' }}>Qaurterly</option>
                                <option value="Half_yearly" {{ old('emi_collection', $application->emi_collection ?? '') == 'Half_yearly' ? 'selected' : '' }}>Half_yearly</option>
                                <option value="Yearly" {{ old('emi_collection', $application->emi_collection ?? '') == 'Yearly' ? 'selected' : '' }}>Yearly</option>
                            </select>
                             @error('emi_collection')
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
                                placeholder="Enter Insurance Amount (₹)" value="{{ old('insurance_amount', $application->insurance_amount ?? 0) }}">
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
                                    @if(isset($application) && $application->creditScores->count() > 0)
                                        @foreach($application->creditScores as $cibil)
                                            <tr class="nested-fields">
                                                <!-- Type -->
                                                <td class="px-2 py-2 border border-gray-300">
                                                    <select name="cibil_type[]" required
                                                        class="w-full text-center border border-gray-300 rounded-10 px-2 py-2">
                                                        <option value="">Select</option>
                                                        <option value="transunion" {{ $cibil->cibil_type == 'transunion' ? 'selected' : '' }}>TransUnion</option>
                                                        <option value="equifax" {{ $cibil->cibil_type == 'equifax' ? 'selected' : '' }}>Equifax</option>
                                                        <option value="experian" {{ $cibil->cibil_type == 'experian' ? 'selected' : '' }}>Experian</option>
                                                        <option value="crif_highmark" {{ $cibil->cibil_type == 'crif_highmark' ? 'selected' : '' }}>Crif Highmark</option>
                                                    </select>
                                                </td>

                                                <!-- Score -->
                                                <td class="px-2 py-2 border border-gray-300">
                                                    <input type="number" name="cibil_score[]" value="{{ $cibil->cibil_score }}"
                                                        placeholder="Enter CIBIL Score"
                                                        class="w-full text-center border border-gray-300 rounded-10 px-2 py-2" required/>
                                                </td>

                                                <!-- Date -->
                                                <td class="px-2 py-2 border border-gray-300 relative">
                                                    <input type="text" name="report_date[]"
                                                        value="{{ \Carbon\Carbon::parse($cibil->report_date)->format('d/m/Y') }}"
                                                        placeholder="DD/MM/YYYY"
                                                        class="w-full text-center border border-gray-300 rounded-10 px-2 py-2" required/>
                                                </td>

                                                <!-- File -->
                                                <td class="px-2 py-2 border border-gray-300">
                                                    <input type="file" name="report_file[]"
                                                        class="w-full text-center border border-gray-300 rounded-10 px-2 py-2"/>
                                                    @if($cibil->report_file_path)
                                                        <a href="{{ asset('storage/'.$cibil->report_file_path) }}" target="_blank"
                                                            class="text-blue-500 underline text-sm">View</a>
                                                    @endif
                                                </td>

                                                <!-- Remove -->
                                                <td class="px-2 py-2 border border-gray-300 text-center">
                                                    <button type="button" class="removeRow text-red-500 hover:text-red-700">
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
                                <button type="button" id="addRow" class="btn-primary px-4 py-2 text-sm rounded-md">
                                    + Add Row
                                </button>
                            </div>
                        </div>
                    </div>

                    </div>

                    <!-- Vehicle Info -->
                    <br>
                        <div class="mt-6">
                            <p class="uppercase  text-xl ">Vehicle Info</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mt-3 xxxxxl:gap-6">
                            {{-- Distributor --}}
                            <div class="col-span-2 md:col-span-1">
                                <label for="distributor_id" class="md:text-lg uppercase font-medium block mb-2">
                                    Distributor <span class="text-red-500">*</span>
                                </label>
                                <select name="distributor_id" id="distributor_id"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Please Select</option>
                                    <option value="1"
                                        {{ old('distributor_id', $application->distributor_id ?? '') == 1 ? 'selected' : '' }}>
                                        OSL BAJAJ LTD
                                    </option>
                                </select>
                                @error('distributor_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Vehicle Type --}}
                            <div class="col-span-2 md:col-span-1">
                                <label for="vehicle_type" class="md:text-lg uppercase font-medium block mb-4">
                                    Vehicle Type <span class="text-red-500">*</span>
                                </label>
                                <select name="vehicle_type" id="vehicle_type"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Please Select Vehicle Type</option>
                                    <option value="used" {{ old('vehicle_type', $application->vehicle_type ?? '') == 'used' ? 'selected' : '' }}>Used</option>
                                    <option value="new" {{ old('vehicle_type', $application->vehicle_type ?? '') == 'new' ? 'selected' : '' }}>New</option>
                                </select>
                                @error('vehicle_type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Vehicle Segment --}}
                            <div class="col-span-2 md:col-span-1">
                                <label for="vehicle_segment" class="uppercase md:text-lg font-medium block mb-4">
                                    Vehicle Segment <span class="text-red-500">*</span>
                                </label>
                                <select name="vehicle_segment" id="vehicle_segment"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Please Select Vehicle Segment</option>
                                    <option value="commercial" {{ old('vehicle_segment', $application->vehicle_segment ?? '') == 'commercial' ? 'selected' : '' }}>Commercial</option>
                                    <option value="non_commercial" {{ old('vehicle_segment', $application->vehicle_segment ?? '') == 'non_commercial' ? 'selected' : '' }}>Non Commercial</option>
                                </select>
                            </div>

                            {{-- Vehicle Category --}}
                            <div class="col-span-2 md:col-span-1">
                                <label for="vehicle_category" class="uppercase md:text-lg font-medium block mb-4">
                                    Vehicle Category <span class="text-red-500">*</span>
                                </label>
                                <select name="vehicle_category" id="vehicle_category"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Please Select Vehicle Category</option>
                                    <option value="two_wheeler" {{ old('vehicle_category', $application->vehicle_category ?? '') == 'two_wheeler' ? 'selected' : '' }}>Two Wheeler</option>
                                    <option value="three_wheeler" {{ old('vehicle_category', $application->vehicle_category ?? '') == 'three_wheeler' ? 'selected' : '' }}>Three Wheeler</option>
                                    <option value="four_wheeler" {{ old('vehicle_category', $application->vehicle_category ?? '') == 'four_wheeler' ? 'selected' : '' }}>Four Wheeler</option>
                                </select>
                            </div>

                            {{-- Vehicle Brand --}}
                            <div class="col-span-2 md:col-span-1">
                                <label for="vehicle_brand" class="uppercase md:text-lg font-medium block mb-4">
                                    Vehicle Brand <span class="text-red-500">*</span>
                                </label>
                                <select name="vehicle_brand" id="vehicle_brand"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Please Select Vehicle Brand</option>
                                    @foreach(['SAMPOORN_EV', 'YAMAHA', 'HONDA', 'DUCATI', 'HARLEY_DAVIDSON', 'SUZUKI', 'BAJAJ', 'TVS', 'PIAGGIO', 'ATUL', 'MAHINDRA', 'TOYOTA', 'FORD', 'BMW', 'MERCEDES', 'HYUNDAI', 'TATA'] as $brand)
                                        <option value="{{ $brand }}" {{ old('vehicle_brand', $application->vehicle_brand ?? '') == $brand ? 'selected' : '' }}>
                                            {{ ucfirst(strtolower(str_replace('_', ' ', $brand))) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Vehicle Model --}}
                            <div class="col-span-2 md:col-span-1">
                                <label for="vehicle_model" class="uppercase md:text-lg font-medium block mb-4">
                                    Vehicle Model <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="vehicle_model" id="vehicle_model"
                                    value="{{ old('vehicle_model', $application->vehicle_model ?? '') }}"
                                    placeholder="Enter Vehicle Model"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            </div>

                            {{-- Vehicle Color --}}
                            <div class="col-span-2 md:col-span-1">
                                <label for="vehicle_color" class="uppercase md:text-lg font-medium block mb-4">
                                    Vehicle Color <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="vehicle_color" id="vehicle_color"
                                    value="{{ old('vehicle_color', $application->vehicle_color ?? '') }}"
                                    placeholder="Enter Vehicle Color"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                            </div>

                            {{-- Manufacture Year --}}
                            <div class="col-span-2 md:col-span-1">
                                <label for="manufacture_year" class="uppercase md:text-lg font-medium block mb-4">
                                    Manufacture Year <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="manufacture_year" id="manufacture_year"
                                    value="{{ old('manufacture_year', $application->manufacture_year ?? '') }}"
                                    placeholder="Enter Manufacture Year"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            </div>

                            {{-- Vehicle No --}}
                            <div class="col-span-2 md:col-span-1">
                                <label for="vehicle_no" class="uppercase md:text-lg font-medium block mb-4">Vehicle No</label>
                                <input type="text" name="vehicle_no" id="vehicle_no"
                                    value="{{ old('vehicle_no', $application->vehicle_no ?? '') }}"
                                    placeholder="Enter Vehicle No"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            </div>

                            {{-- Chassis No --}}
                            <div class="col-span-2 md:col-span-1">
                                <label for="chassis_no" class="uppercase md:text-lg font-medium block mb-4">Chassis No</label>
                                <input type="text" name="chassis_no" id="chassis_no"
                                    value="{{ old('chassis_no', $application->chassis_no ?? '') }}"
                                    placeholder="Enter Chassis No"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            </div>

                            {{-- Engine No --}}
                            <div class="col-span-2 md:col-span-1">
                                <label for="engine_no" class="uppercase md:text-lg font-medium block mb-4">Engine No</label>
                                <input type="text" name="engine_no" id="engine_no"
                                    value="{{ old('engine_no', $application->engine_no ?? '') }}"
                                    placeholder="Enter Engine No"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            </div>

                            {{-- Vehicle Price --}}
                            <div class="col-span-2 md:col-span-1 mb-3">
                                <label for="vehicle_price" class="uppercase md:text-lg font-medium block mb-4">
                                    Vehicle Price <span class="text-error">*</span>
                                </label>
                                <input type="number" name="vehicle_price" id="vehicle_price"
                                    value="{{ old('vehicle_price', $application->vehicle_price ?? '') }}"
                                    placeholder="Enter Vehicle Price"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                <x-number-to-word for="vehicle_price" />
                            </div>

                            {{-- Down Payment --}}
                            <div class="col-span-2 md:col-span-1 mb-3">
                                <label for="down_payment" class="uppercase md:text-lg font-medium block mb-4">
                                    Down Payment <span class="text-error">*</span>
                                </label>
                                <input type="number" name="down_payment" id="down_payment"
                                    value="{{ old('down_payment', $application->down_payment ?? '') }}"
                                    placeholder="Enter Down Payment"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                <x-number-to-word for="down_payment" />
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
                            Note: If you wish to collect processing fee at the time of disbursement, then enter 0. Fees
                            will be calculated accordingly.
                        </p>

                    </div>
                </div>
            </div>

            <div class="flex-2 col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6 min-w-[300px]">
                    {{--memberBox info --}}
                    <div id="memberBox" class="w-full hidden"> {{-- hidden by default --}}
                    <div class="flex justify-between items-center bg-secondary/5  rounded-10 px-4 py-3 dark:bg-bg3">
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


                 {{-- Vehical Table  --}}
                        <div id="distributorBox"
                            class="hidden bg-white overflow-hidden mt-4">
                            <!-- Header -->
                            <div class="flex items-center justify-between rounded-10 bg-secondary/5  px-4 py-3">
                                <h3 class="text-lg font-semibold uppercase">Distributor Info</h3>
                                <button type="button" class="text-white hover:text-gray-200 transition"
                                    onclick="toggleDistributorBox()">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>

                            <!-- Body -->
                            <div id="distributorBody" class="p-4 overflow-x-auto">
                                <table class="w-full whitespace-nowrap p-3 border-collapse text-sm md:text-base">
                                    <tbody class="divide-y divide-gray-200">
                                        <tr class="border-b">
                                            <td class="font-semibold uppercase w-1/3 py-2">Distributor Code</td>
                                            <td id="distCode" class="py-2">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">Distributor Name</td>
                                            <td id="distName" class="py-2">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">Active</td>
                                            <td id="distActive" class="py-2"><span
                                                    class="inline-block px-2 py-1 text-xs font-semibold text-white bg-gray-400 rounded">
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">Distribution Type</td>
                                            <td id="distType" class="py-2">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">Contact No</td>
                                            <td id="distContact" class="py-2">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">Email</td>
                                            <td id="distEmail" class="py-2">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">City</td>
                                            <td id="distCity" class="py-2">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">State</td>
                                            <td id="distState" class="py-2">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">Pincode</td>
                                            <td id="distPincode" class="py-2">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">Address</td>
                                            <td id="distAddress" class="py-2">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">GST No</td>
                                            <td id="distGST" class="py-2">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">License No</td>
                                            <td id="distLicense" class="py-2">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">Created At</td>
                                            <td id="distCreated" class="py-2">-</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="font-semibold uppercase py-2">Updated At</td>
                                            <td id="distUpdated" class="py-2">-</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

            </div>
        </div>
 

            <!-- Loan Calculation Summary Table -->
         <!-- Hidden fields for saving calculation result -->
        <input type="hidden" name="security_value" id="inputSecurity">
        <input type="hidden" name="max_loan_amount" id="inputMaxLoan">
        <input type="hidden" name="max_loan_limit" id="inputLimit">
        <input type="hidden" name="maximum_approvable_amount" id="inputApprovable">
        <input type="hidden" name="approved_loan_amount" id="inputApproved"> 

           <!-- Calculation Box -->
            <div id="calculationBox" class="flex justify-center hidden">
                <table class="w-1/2 overflow-x-auto mt-6 bg-primary/20 rounded-lg text-sm">
                    <tbody>
                        <tr class="border-b border-gray-300">
                            <th class="uppercase text-center font-semibold p-2 w-1/2">Requested Loan Amount</th>
                            <th class="text-start font-medium p-2 w-1/2" id="request-amt">-</th>
                        </tr>
                        <tr class="border-b border-gray-300">
                            <th class="uppercase text-center font-semibold p-2">Security Value</th>
                            <th class="text-start font-medium p-2" id="security-amt">-</th>
                        </tr>
                        <tr class="border-b border-gray-300">
                            <th class="uppercase text-center font-semibold p-2">Max Loan Amount</th>
                            <th class="text-start font-medium p-2" id="max-loan-amount">-</th>
                        </tr>
                        <tr class="border-b border-gray-300">
                            <th class="uppercase text-center font-semibold p-2">Max Loan Limit</th>
                            <th class="text-start font-medium p-2" id="max-loan-limit">-</th>
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
                    <a href="{{ route('vehical.applications.index') }}">BACK</a>
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
document.getElementById('member_id').addEventListener('change', function () {
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

<!-- scheme info -->
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

<!-- Calculation box -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    let isCalculated = false;
    const calcBtn = document.getElementById("calculateBtn");

    calcBtn.addEventListener("click", function (e) {
        e.preventDefault();

        // Step 1: Perform your calculation logic
        let totalSecurity = 0;
        document.querySelectorAll(".expectedValue").forEach(input => {
            totalSecurity += parseFloat(input.value) || 0;
        });

        let loanAmount = parseFloat(document.getElementById("loanAmount")?.value) || 0;
        let scheme = document.getElementById("scheme_id");
        let selected = scheme.options[scheme.selectedIndex];
        let maxLoan = parseFloat(selected.getAttribute("data-max")) || 0;
        let limit = parseFloat(selected.getAttribute("data-limit")) || 0;

        if (loanAmount > maxLoan) {
            alert("Requested Loan Amount cannot exceed Maximum Loan Limit of ₹" + maxLoan);
            document.getElementById("loanAmount").value = maxLoan.toFixed(2);
            loanAmount = maxLoan;
        }

        let approvable = (totalSecurity * limit) / 100;
        let approved = Math.min(loanAmount, approvable);

        // Step 2: Display calculation result
        document.getElementById("request-amt").textContent = loanAmount.toFixed(2);
        document.getElementById("security-amt").textContent = totalSecurity.toFixed(2);
        document.getElementById("max-loan-amount").textContent = maxLoan.toFixed(2);
        document.getElementById("max-loan-limit").textContent = limit + "%";
        document.getElementById("m-approval-amt").textContent = approvable.toFixed(2);
        document.getElementById("approval-amt").textContent = approved.toFixed(2);

        // Step 3: Update hidden input values
        document.getElementById("inputSecurity").value = totalSecurity.toFixed(2);
        document.getElementById("inputMaxLoan").value = maxLoan.toFixed(2);
        document.getElementById("inputLimit").value = limit;
        document.getElementById("inputApprovable").value = approvable.toFixed(2);
        document.getElementById("inputApproved").value = approved.toFixed(2);

        document.getElementById("calculationBox").classList.remove("hidden");

        // Step 4: Change button text to submit
        if (!isCalculated) {
            calcBtn.textContent = "Submit Application";
            calcBtn.removeEventListener("click", arguments.callee);
            calcBtn.addEventListener("click", function () {
                calcBtn.closest("form").submit(); // actual submit
            });
            isCalculated = true;
        }
    });
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

document.getElementById("loanAmount").addEventListener("input", function () {
    updateWords("loanAmount", "loanAmountWords");
});

document.getElementById("insuranceAmount").addEventListener("input", function () {
    updateWords("insuranceAmount", "insuranceAmountWords");
});
</script>

<!-- side box minimize -->
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

{{-- Vehicle Info Distributer --}}

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const select = document.getElementById("distributor_id");
            const box = document.getElementById("distributorBox");

            const fields = {
                code: document.getElementById("distCode"),
                name: document.getElementById("distName"),
                active: document.getElementById("distActive"),
                type: document.getElementById("distType"),
                contact: document.getElementById("distContact"),
                email: document.getElementById("distEmail"),
                city: document.getElementById("distCity"),
                state: document.getElementById("distState"),
                pincode: document.getElementById("distPincode"),
                address: document.getElementById("distAddress"),
                gst: document.getElementById("distGST"),
                license: document.getElementById("distLicense"),
                created: document.getElementById("distCreated"),
                updated: document.getElementById("distUpdated"),
            };

            select.addEventListener("change", function () {
                const selected = this.options[this.selectedIndex];
                if (this.value) {
                    fields.code.textContent = selected.getAttribute("data-code") || "-";
                    fields.name.textContent = selected.getAttribute("data-name") || "-";

                    const activeValue = selected.getAttribute("data-active") || "-";
                    const activeEl = fields.active.querySelector("span");
                    activeEl.textContent = activeValue;
                    activeEl.className = `inline-block px-2 py-1 text-xs font-semibold text-white rounded ${activeValue.toLowerCase() === "yes" ? "bg-green-600" : "bg-red-500"
                        }`;

                    fields.type.textContent = selected.getAttribute("data-type") || "-";
                    fields.contact.textContent = selected.getAttribute("data-contact") || "-";
                    fields.email.textContent = selected.getAttribute("data-email") || "-";
                    fields.city.textContent = selected.getAttribute("data-city") || "-";
                    fields.state.textContent = selected.getAttribute("data-state") || "-";
                    fields.pincode.textContent = selected.getAttribute("data-pincode") || "-";
                    fields.address.textContent = selected.getAttribute("data-address") || "-";
                    fields.gst.textContent = selected.getAttribute("data-gst") || "-";
                    fields.license.textContent = selected.getAttribute("data-license") || "-";
                    fields.created.textContent = selected.getAttribute("data-created") || "-";
                    fields.updated.textContent = selected.getAttribute("data-updated") || "-";

                    box.classList.remove("hidden");
                } else {
                    box.classList.add("hidden");
                }
            });
        });

        // optional collapse button function
        function toggleDistributorBox() {
            const body = document.getElementById("distributorBody");
            body.classList.toggle("hidden");
        }
    </script>

@endsection