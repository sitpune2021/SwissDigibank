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
    <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col  gap-2">
            <h1 class="text-xl font-semibold">FIXED LOAN APPLICATION</h1>
        </div>
    </div>

    <div class="box">
        <form method="POST"
            action="{{ isset($application) ? route('fixed_loan.applications.update', $application->id) : route('fixed_loan.store') }}"
            enctype="multipart/form-data">
            @csrf
            @if(isset($application))
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
    <label class="md:text-lg font-medium block mb-4">
        Application No <span class="text-red-500">*</span>
    </label>

    <input type="text" name="application_no"
        value="{{ old('application_no', $application->application_no ?? '') }}"
        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
        placeholder="Enter Application No">
        
    @error('application_no')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>


                        <div class="col-span-2 md:col-span-1">
                            <label for="member_id" class="md:text-lg font-medium block mb-4">
                                CUSTOMER <span class="text-red-500">*</span>
                            </label>

                            <select name="member_id" id="member_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                <option value="">Search Member No or Name</option>
                                @foreach($members as $member)
                                <option value="{{ $member->id }}" data-branch="{{ $member->general_branch }}" {{
                                    old('member_id', $application->member_id ?? '') == $member->id ? 'selected' : '' }}
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
    <label class="md:text-lg font-medium block mb-4">
        1st Co-Applicant Relationship <span class="text-red-500">*</span>
    </label>

    <select name="relationship"
        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
        
        <option value="">Select Relationship</option>
        <option value="father" {{ old('relationship', $application->relationship ?? '') == 'father' ? 'selected' : '' }}>Father</option>
        <option value="mother" {{ old('relationship', $application->relationship ?? '') == 'mother' ? 'selected' : '' }}>Mother</option>
        <option value="son" {{ old('relationship', $application->relationship ?? '') == 'son' ? 'selected' : '' }}>Son</option>
        <option value="daughter" {{ old('relationship', $application->relationship ?? '') == 'daughter' ? 'selected' : '' }}>Daughter</option>
        <option value="spouse" {{ old('relationship', $application->relationship ?? '') == 'spouse' ? 'selected' : '' }}>Spouse</option>
        <option value="brother" {{ old('relationship', $application->relationship ?? '') == 'brother' ? 'selected' : '' }}>Brother</option>
        <option value="sister" {{ old('relationship', $application->relationship ?? '') == 'sister' ? 'selected' : '' }}>Sister</option>
        <option value="other" {{ old('relationship', $application->relationship ?? '') == 'other' ? 'selected' : '' }}>Other</option>
    </select>

    @error('relationship')
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
                                <option value="{{ $member->id }}" {{ old('member_id', $application->co_applicant_1_id ??
                                    '') == $member->id ? 'selected' : '' }}>
                                    {{ $member->member_info_first_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
  <div class="col-span-2 md:col-span-1">
    <label class="md:text-lg font-medium block mb-4">
        2nd Co-Applicant Relationship <span class="text-red-500">*</span>
    </label>

    <select name="relationship"
        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
        
        <option value="">Select Relationship</option>
        <option value="father" {{ old('relationship', $application->relationship ?? '') == 'father' ? 'selected' : '' }}>Father</option>
        <option value="mother" {{ old('relationship', $application->relationship ?? '') == 'mother' ? 'selected' : '' }}>Mother</option>
        <option value="son" {{ old('relationship', $application->relationship ?? '') == 'son' ? 'selected' : '' }}>Son</option>
        <option value="daughter" {{ old('relationship', $application->relationship ?? '') == 'daughter' ? 'selected' : '' }}>Daughter</option>
        <option value="spouse" {{ old('relationship', $application->relationship ?? '') == 'spouse' ? 'selected' : '' }}>Spouse</option>
        <option value="brother" {{ old('relationship', $application->relationship ?? '') == 'brother' ? 'selected' : '' }}>Brother</option>
        <option value="sister" {{ old('relationship', $application->relationship ?? '') == 'sister' ? 'selected' : '' }}>Sister</option>
        <option value="other" {{ old('relationship', $application->relationship ?? '') == 'other' ? 'selected' : '' }}>Other</option>
    </select>

    @error('relationship')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4">
                                2nd Co-Applicant Member</label>
                            <select name="co_applicant_2_id" id="co_applicant_2_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                <option value="">Search Member No or Name</option>
                                @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id', $application->co_applicant_2_id ??
                                    '') == $member->id ? 'selected' : '' }}>
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
                                <option value="{{ $member->id }}" {{ old('member_id', $application->branch_id ?? '') ==
                                    $member->id ? 'selected' : '' }}>
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
    <label class="md:text-lg font-medium block mb-4">
        1st Guarantor Relationship <span class="text-red-500">*</span>
    </label>

    <select name="relationship"
        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
        
        <option value="">Select Relationship</option>
        <option value="father" {{ old('relationship', $application->relationship ?? '') == 'father' ? 'selected' : '' }}>Father</option>
        <option value="mother" {{ old('relationship', $application->relationship ?? '') == 'mother' ? 'selected' : '' }}>Mother</option>
        <option value="son" {{ old('relationship', $application->relationship ?? '') == 'son' ? 'selected' : '' }}>Son</option>
        <option value="daughter" {{ old('relationship', $application->relationship ?? '') == 'daughter' ? 'selected' : '' }}>Daughter</option>
        <option value="spouse" {{ old('relationship', $application->relationship ?? '') == 'spouse' ? 'selected' : '' }}>Spouse</option>
        <option value="brother" {{ old('relationship', $application->relationship ?? '') == 'brother' ? 'selected' : '' }}>Brother</option>
        <option value="sister" {{ old('relationship', $application->relationship ?? '') == 'sister' ? 'selected' : '' }}>Sister</option>
        <option value="other" {{ old('relationship', $application->relationship ?? '') == 'other' ? 'selected' : '' }}>Other</option>
    </select>

    @error('relationship')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg font-medium block mb-4">
                                Guarantor 1 </label>
                            <select name="guarantor_1_id" id="guarantor_1_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                <option value="">Search Member No or Name</option>
                                @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id', $application->guarantor_1_id ??
                                    '') == $member->id ? 'selected' : '' }}>
                                    {{ $member->member_info_first_name }}
                                </option>

                                @endforeach
                            </select>
                        </div>
                         <div class="col-span-2 md:col-span-1">
    <label class="md:text-lg font-medium block mb-4">
        2nd Guarantor Relationship <span class="text-red-500">*</span>
    </label>

    <select name="relationship"
        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
        
        <option value="">Select Relationship</option>
        <option value="father" {{ old('relationship', $application->relationship ?? '') == 'father' ? 'selected' : '' }}>Father</option>
        <option value="mother" {{ old('relationship', $application->relationship ?? '') == 'mother' ? 'selected' : '' }}>Mother</option>
        <option value="son" {{ old('relationship', $application->relationship ?? '') == 'son' ? 'selected' : '' }}>Son</option>
        <option value="daughter" {{ old('relationship', $application->relationship ?? '') == 'daughter' ? 'selected' : '' }}>Daughter</option>
        <option value="spouse" {{ old('relationship', $application->relationship ?? '') == 'spouse' ? 'selected' : '' }}>Spouse</option>
        <option value="brother" {{ old('relationship', $application->relationship ?? '') == 'brother' ? 'selected' : '' }}>Brother</option>
        <option value="sister" {{ old('relationship', $application->relationship ?? '') == 'sister' ? 'selected' : '' }}>Sister</option>
        <option value="other" {{ old('relationship', $application->relationship ?? '') == 'other' ? 'selected' : '' }}>Other</option>
    </select>

    @error('relationship')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

                        <div class="col-span-2 md:col-span-1">
                            <div class="col-sm-7">
                                <label for="" class="md:text-lg font-medium block mb-4">
                                    Guarantor 2</label>
                                <select name="guarantor_2_id" id="guarantor_2_id"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Search Member No or Name</option>
                                    @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ old('member_id', $application->guarantor_2_id
                                        ?? '') == $member->id ? 'selected' : '' }}>
                                        {{ $member->member_info_first_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                         <div class="col-span-2 md:col-span-1">
    <label class="md:text-lg font-medium block mb-4">
        3rd Guarantor Relationship <span class="text-red-500">*</span>
    </label>

    <select name="relationship"
        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
        
        <option value="">Select Relationship</option>
        <option value="father" {{ old('relationship', $application->relationship ?? '') == 'father' ? 'selected' : '' }}>Father</option>
        <option value="mother" {{ old('relationship', $application->relationship ?? '') == 'mother' ? 'selected' : '' }}>Mother</option>
        <option value="son" {{ old('relationship', $application->relationship ?? '') == 'son' ? 'selected' : '' }}>Son</option>
        <option value="daughter" {{ old('relationship', $application->relationship ?? '') == 'daughter' ? 'selected' : '' }}>Daughter</option>
        <option value="spouse" {{ old('relationship', $application->relationship ?? '') == 'spouse' ? 'selected' : '' }}>Spouse</option>
        <option value="brother" {{ old('relationship', $application->relationship ?? '') == 'brother' ? 'selected' : '' }}>Brother</option>
        <option value="sister" {{ old('relationship', $application->relationship ?? '') == 'sister' ? 'selected' : '' }}>Sister</option>
        <option value="other" {{ old('relationship', $application->relationship ?? '') == 'other' ? 'selected' : '' }}>Other</option>
    </select>

    @error('relationship')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
                        <div class="col-span-2 md:col-span-1">
                            <div class="col-sm-7">
                                <label for="" class="md:text-lg font-medium block mb-4">
                                    Guarantor 3 </label>
                                <select name="guarantor_3_id" id="guarantor_3_id"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Search Member No or Name</option>
                                    @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ old('member_id', $application->guarantor_3_id
                                        ?? '') == $member->id ? 'selected' : '' }}>
                                        {{ $member->member_info_first_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                         <div class="col-span-2 md:col-span-1">
    <label class="md:text-lg font-medium block mb-4">
        4th Guarantor Relationship <span class="text-red-500">*</span>
    </label>

    <select name="relationship"
        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
        
        <option value="">Select Relationship</option>
        <option value="father" {{ old('relationship', $application->relationship ?? '') == 'father' ? 'selected' : '' }}>Father</option>
        <option value="mother" {{ old('relationship', $application->relationship ?? '') == 'mother' ? 'selected' : '' }}>Mother</option>
        <option value="son" {{ old('relationship', $application->relationship ?? '') == 'son' ? 'selected' : '' }}>Son</option>
        <option value="daughter" {{ old('relationship', $application->relationship ?? '') == 'daughter' ? 'selected' : '' }}>Daughter</option>
        <option value="spouse" {{ old('relationship', $application->relationship ?? '') == 'spouse' ? 'selected' : '' }}>Spouse</option>
        <option value="brother" {{ old('relationship', $application->relationship ?? '') == 'brother' ? 'selected' : '' }}>Brother</option>
        <option value="sister" {{ old('relationship', $application->relationship ?? '') == 'sister' ? 'selected' : '' }}>Sister</option>
        <option value="other" {{ old('relationship', $application->relationship ?? '') == 'other' ? 'selected' : '' }}>Other</option>
    </select>

    @error('relationship')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
                        <div class="col-span-2 md:col-span-1">
                            <div class="col-sm-7">
                                <label for="" class="md:text-lg font-medium block mb-4">
                                    Guarantor 4 </label>
                                <select name="guarantor_4_id" id="guarantor_4_id"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Search Member No or Name</option>
                                    @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ old('member_id', $application->guarantor_4_id
                                        ?? '') == $member->id ? 'selected' : '' }}>
                                        {{ $member->member_info_first_name }}
                                    </option>
                                    @endforeach
                                </select>
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
                                <option value="daily" {{ $selectedValue=='daily' ? 'selected' : '' }}>DAILY</option>
                                <option value="weekly" {{ $selectedValue=='weekly' ? 'selected' : '' }}>WEEKLY</option>
                                <option value="bi_weekly" {{ $selectedValue=='bi_weekly' ? 'selected' : '' }}>BI WEEKLY
                                </option>
                                <option value="4_weekly" {{ $selectedValue=='4_weekly' ? 'selected' : '' }}>4 WEEKLY
                                </option>
                                <option value="Monthaly" {{ $selectedValue=='Monthaly' ? 'selected' : '' }}>MONTHALY
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
                                Processing Fee (INC GST 18 %) <span id="" class="text-black uppercase"></span>
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

                    <!-- scheme info -->
                    <div class="flex-2 col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6 min-w-[300px]">
                        {{-- Member Info Box --}}
                        <div id="memberBox" class="w-full hidden"> {{-- hidden by default --}}
                            <div class="flex justify-between items-center bg-secondary/5  rounded-10 px-4 py-3 dark:bg-bg3">
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

                    </div>

                </div>
            </div>

            <!-- Calculation Result Box -->
            <!-- Hidden fields for backend -->
            <input type="hidden" id="inputChargesPerEmi" name="charges_per_emi">
            <input type="hidden" id="inputNetEmiWithCharges" name="net_emi_with_charges">
            <input type="hidden" id="inputTotalRecovered" name="total_recovered_amount">

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
                    <a href="{{route('fixed_loan.applications.index')}}">BACK</a>
                </button>
            </div>
        </form>
    </div>
</div>


<!-- Memeber / Customer info -->
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

<!-- Memeber / Customer Details -->
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

<!-- Calculation and auto populate when select scheme -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
    let isCalculated = false;
    const calcBtn = document.getElementById("calculateBtn");
    calcBtn.type = "button";

    calcBtn.addEventListener("click", function (e) {
        const button = this;

        const loanAmount = parseFloat(document.getElementById("loan_amount")?.value) || 0;

        const scheme = document.getElementById("scheme_id");
        const selected = scheme.options[scheme.selectedIndex];

        const maxLoan = parseFloat(selected.getAttribute("data-max")) || loanAmount;
        const approvable = Math.min(loanAmount, maxLoan);

        const processingFee = parseFloat(selected.getAttribute("data-processing")) || 0;
        const stampDuty = parseFloat(selected.getAttribute("data-stamp")) || 0;
        const insuranceFee = parseFloat(selected.getAttribute("data-insurance")) || 0;
        const smsFee = parseFloat(selected.getAttribute("data-sms")) || 0;
        const fuelFee = parseFloat(selected.getAttribute("data-fuel")) || 0;
        const stationaryFee = parseFloat(selected.getAttribute("data-stationary")) || 0;
        const maintenanceFee = parseFloat(selected.getAttribute("data-maintenance")) || 0;

        const noOfEmi = parseInt(document.getElementById("tenure_value")?.value) 
                        || parseInt(selected.getAttribute("data-emi")) 
                        || 1;

        const totalCharges = processingFee + stampDuty + insuranceFee + smsFee + fuelFee + stationaryFee + maintenanceFee;
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