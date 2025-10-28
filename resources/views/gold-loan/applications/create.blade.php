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

    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col  gap-2">
                <h1 class="text-xl font-semibold">NEW GOLD LOAN APPLICATION</h1>

            </div>
        </div>

        <div class="box">

            <form method="POST" enctype="multipart/form-data"
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
                                <label for="member_id" class="md:text-lg font-medium block mb-4 uppercase">
                                    Customer <span class="text-red-500">*</span>
                                </label>

                                <select name="member_id" id="member_id"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Search Customer No or Name</option>
                                   @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ old('member_id', $application->member_id ?? '')
                                        == $member->id ? 'selected' : '' }}
                                        data-name="{{ $member->member_info_first_name }}"
                                        data-mobile="{{ $member->member_info_mobile_no }}">
                                        {{ $member->member_info_first_name }}
                                    </option>
                                    @endforeach 
                                </select>

                                @error('member_id')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
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
                                <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                    Branch
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="branch_id" id="branch_id"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Search Branch No or Name</option>
                                    @foreach($branch as $member)
                                    <option value="{{ $member->id }}" {{ old('member_id', $application->branch_id ?? '')
                                        == $member->id ? 'selected' : '' }}>
                                        {{ $member->branch_name }}
                                    </option>

                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
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
                                @error('branch_id')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
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
                                            {{ $sc->scheme_code }}
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
                                            'checked' : '' }} >
                                            <span class="text-gray-70 capitalize">DAYS</span>
                                        </label>
                                        <label class="flex items-center gap-2 space-x-2 p-1">
                                            <input type="radio" name="tenure_type" value="weeks" {{ old('tenure_type',
                                                $application->tenure_type ?? '') == 'weeks' ?
                                            'checked' : '' }} >
                                            <span class="text-gray-70 capitalize">WEEKS</span>
                                        </label>
                                        <label class="flex items-center gap-2 space-x-2 p-1">
                                            <input type="radio" name="tenure_type" value="months" {{ old('tenure_type',
                                                $application->tenure_type ?? '') == 'months' ?
                                            'checked' : '' }} >
                                            
                                            <span class="text-gray-70 capitalize">MONTHS</span>
                                        </label>
                                    </div>
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
                                <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                                    EMI Collection <span class="text-error">* </span>
                                </label>
                                <select name="emi_collection"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option value="">Please Select</option>
                                    <option value="Monthaly" {{ old('emi_collection', $application->emi_collection
                                        ?? '') == 'Monthaly' ? 'selected' : '' }}
                                        >Monthaly</option>
                                    <option value="Qaurterly" {{ old('emi_collection', $application->emi_collection
                                        ?? '') == 'Qaurterly' ? 'selected' : '' }}
                                        >Qaurterly</option>
                                    <option value="Half_yearly" {{ old('emi_collection', $application->
                                        emi_collection ?? '') == 'Half_yearly' ? 'selected' : '' }}
                                        >Half_yearly</option>
                                    <option value="Yearly" {{ old('emi_collection', $application->emi_collection ??
                                        '') == 'Yearly' ? 'selected' : '' }} >Yearly</option>
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
                                                        <select name="cibil_type[]" required
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
                                                            value="{{ $score->cibil_score }}" required/>
                                                    </td>

                                                    <td class="px-2 py-2 relative">
                                                        <input type="text" name="report_date[]" 
                                                            value="{{ \Carbon\Carbon::parse($score->report_date)->format('d/m/Y') }}"
                                                            class="w-full text-center dark:bg-bg3 rounded-10 px-2 py-2 text-sm md:text-base border bg-secondary/5"
                                                            required/>
                                                    </td>

                                                    <!-- <td class="px-2 py-2">
                                                        @if($score->report_file)
                                                            <a href="{{ asset('storage/'.$score->report_file) }}" target="_blank" class="text-blue-600 underline">
                                                                View File
                                                            </a><br>
                                                        @endif
                                                        <input type="file" name="report_file[]" 
                                                            class="w-full text-center dark:bg-bg3 rounded-10 px-2 py-2 text-sm md:text-base border bg-secondary/5"/>
                                                    </td> -->

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
                                                            class="w-full text-center dark:bg-bg3 rounded-10 px-2 py-2 text-sm md:text-base border bg-secondary/5"/>
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
                                <button type="button" id="addRow" class="btn-primary rounded-10 px-4 py-2">
                                    + Add New Score
                                </button>
                            </div>
                            
                        </div>

                        <!-- Collect Advance Processing Fee -->
                        <div class="col-span-12  lg:col-span-12 ">
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
                                    Pay Mode :
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
                                            $application->fee_mode ?? '') == 'online' ? 'checked' : '' }}  > Online Tr.
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
                                        <input type="date" id="cheque_date" name="cheque_date" value="    {{ old('cheque_date', $application->cheque_date ?? '') }}"
                                            class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>
                                </div>

                                <!-- Online Transaction Fields -->
                                <div id="onlineFields" class="space-y-4 hidden">
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700 uppercase">
                                            Transfer Date <span class="text-red-500">*</span>
                                        </label>
                                        <input type="date" id="transfer_date" name="transfer_date" value=" {{ old('transfer_date', $application->transfer_date ?? '') }} "
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
                                                <input type="radio" name="transfer_mode" value="imps" {{
                                                    old('transfer_mode', $application->transfer_mode ?? '') == 'imps' ?
                                                'checked' : '' }} >
                                                <span>IMPS</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="transfer_mode" value="vpa" {{
                                                    old('transfer_mode', $application->transfer_mode ?? '') == 'vpa' ?
                                                'checked' : '' }} >

                                                <span>VPA</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="transfer_mode" value="neft_rtgs" {{
                                                    old('transfer_mode', $application->transfer_mode ?? '') == 'neft_rtgs' ?
                                                'checked' : '' }} >
                                                <span>NEFT/RTGS</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 uppercase">
                                            Credited in Company Account <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex gap-4 mt-2">
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="credited" value="yes" {{ old('credited',
                                                    $application->credited ?? '') == 'yes' ? 'checked' : '' }} >
                                                <span>Yes</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="credited" value="no" {{ old('credited',
                                                    $application->credited ?? '') == 'no' ? 'checked' : '' }} >
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
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Scheme Code</td>
                                                <td class="py-2" id="schemeCode">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Scheme Name</td>
                                                <td class="py-2" id="schemeName">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Max Tenure</td>
                                                <td class="py-2" id="schemeTenure">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Maximum Loan Amount</td>
                                                <td class="py-2" id="schemeMax">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Maximum Loan Limit Against
                                                    Security</td>
                                                <td class="py-2" id="schemeLimit">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Minimum Loan Amount</td>
                                                <td class="py-2" id="schemeMin">-</td>
                                            </tr>
                                            <tr>
                                                <td class="font-semibold py-2 pr-4 uppercase">Annual Interest Rate</td>
                                                <td class="py-2" id="schemeInterest">-</td>
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
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


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
                        Calculate
                    </button>
                    <button class="btn-outline justify-center" type="reset">
                        <a href="{{route('gold-loan.applications.index')}}"> Back</a>
                    </button>
                </div>
            </form>
        </div>
    </div>



    <script>
        let isCalculated = false; // flag set karte hain

        document.getElementById("calculateBtn").addEventListener("click", function (e) {
            if (!isCalculated) {
                //  Pehli click pe calculation karo
                document.getElementById("calculationBox").classList.remove("hidden");

                // Button ko submit bana do
                this.textContent = "Submit";
                this.type = "submit";

                // Flag update karo
                isCalculated = true;

                // Prevent form submit on first click
                e.preventDefault();
            } else {
                //  Ab button "Submit" hai → normal form submit hone do
                // Yahan kuch extra code ki zarurat nahi hai
            }
        });
    </script>

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
        function calculateNetLoan() {
            let loan = parseFloat(document.getElementById('loanAmount').value) || 0;
            let insurance = parseFloat(document.getElementById('insuranceAmount').value) || 0;
            document.getElementById('netLoanAmount').value = loan + insurance;
        }

        document.getElementById('loanAmount').addEventListener('input', calculateNetLoan);
        document.getElementById('insuranceAmount').addEventListener('input', calculateNetLoan);
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
    document.addEventListener("DOMContentLoaded", function () {
    //  Step 1: Form को पहले select करो (form id = loanForm)
    const form = document.getElementById("loanForm");

    //  Step 2: Calculate button click listener
    document.getElementById("calculateBtn").addEventListener("click", function () {
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
        let maxLoan = selected.getAttribute("data-max") || "0";   //  CHANGED from "-" to "0"
        let limit = parseFloat(selected.getAttribute("data-limit")) || 0;

        // Maximum approvable amount = (totalSecurity × Limit%) / 100
        let approvable = (totalSecurity * limit) / 100;

        // Show results in result box
        document.getElementById("resNetLoan").textContent = netLoan;
        document.getElementById("resSecurity").textContent = totalSecurity.toFixed(2);
        document.getElementById("resMaxLoan").textContent = maxLoan;
        document.getElementById("resLimit").textContent = limit + "%";
        document.getElementById("resApprovable").textContent = approvable.toFixed(2);
        document.getElementById("resApproved").textContent = approvable.toFixed(2);

        //  Step 3: Hidden inputs me assign karo
        document.getElementById("security_value").value = totalSecurity.toFixed(2);
        document.getElementById("max_loan_amount").value = maxLoan;
        document.getElementById("max_loan_limit").value = limit;
        document.getElementById("maximum_approvable_amount").value = approvable.toFixed(2);
        document.getElementById("approved_loan_amount").value = approvable.toFixed(2);

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

    //  Step 6: Form submit hone से पहले debug check (optional)
    form.addEventListener("submit", function () {
        console.log("Submitting with values:", {
            security_value: document.getElementById("security_value").value,
            max_loan_amount: document.getElementById("max_loan_amount").value,
            max_loan_limit: document.getElementById("max_loan_limit").value,
            maximum_approvable_amount: document.getElementById("maximum_approvable_amount").value,
            approved_loan_amount: document.getElementById("approved_loan_amount").value,
        });
    });
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

            // Add one default row when page loads
            //cibilBody.insertAdjacentHTML("beforeend", newRow());
             if (cibilBody.querySelectorAll("tr").length === 0) {
                cibilBody.insertAdjacentHTML("beforeend", newRow());
            }
        });

        //== Add Gold Items== 

        document.addEventListener("DOMContentLoaded", function () {
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
            addRowBtn.addEventListener("click", function () {
                tbody.appendChild(createRow());
                updateRowNumbers();
            });

            // === Remove Row (event delegation) ===
            tbody.addEventListener("click", function (e) {
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

@endsection