@extends('layout.main')

<style>
    .breadcrumb {
        list-style: none;
        display: flex;
        padding: 0;
        margin-bottom: 1rem;
        font-size: 14px;
    }

    .breadcrumb li+li::before {
        content: "/";
        padding: 0 8px;
        color: #888;
    }

    .breadcrumb li a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb li.active {
        color: #555;
    }

    .custom-thead {
        background-color: #e6f4ea;
        color: #14532d;
    }

    .custom-thead th {
        font-weight: 600;
        border-bottom: 1px solid #ccc;
    }

    @media (prefers-color-scheme: dark) {
        .custom-thead {
            background-color: #14532d;
            color: #d1fae5;
        }
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

    input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: green;
        /* Modern browser support */
    }
</style>

@section('content')
    @php
        $isEdit = isset($ddsAccount);
    @endphp

    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
            <div class="flex items-center flex-col  gap-2">
                <h1 class="text-xl font-semibold">
                    {{ $isEdit ? 'Update DD Account' : 'Open New DD Account' }}
                </h1>
                <p class="text-gray-500">
                    <a href="{{ route('dds-accounts.index') }}" class="text-gray-500">Daily Deposits</a> >
                    <span class="text-gray-500">{{ $isEdit ? 'Edit' : 'New' }}</span>
                </p>
            </div>
        </div>

        <div class="col-span-12 box lg:col-span-12">
            <form action="{{ $isEdit ? route('dds-accounts.update', $ddsAccount->id) : route('dds-accounts.store') }}"
                method="POST">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 2xl:gap-6">
                    <div class="col-span-2 md:col-span-1">
                        <label for="memberDropdown" class="md:text-lg font-medium block mb-4">
                            Member <span class="text-red-500">*</span>
                        </label>
                        <select id="memberDropdown" name="member_id" data-url="{{ route('ajax.members.show', ':id') }}"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border 
               border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3
               @error('member_id') border-red-500 @enderror">
                            <option value="">Search Member No or Name</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->member_info_first_name }} {{ $member->member_info_last_name }}
                                </option>
                            @endforeach
                        </select>

                        @error('member_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="memberName" class="md:text-lg font-medium block mb-4">
                            Member Name
                        </label>
                        <input type="text" id="memberName" name="member_name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="" value="" readonly>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="memberAddress" class="md:text-lg font-medium block mb-4">
                            Member Address
                        </label>
                        <input type="text" id="memberAddress" name="member_address"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="" value="" readonly>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="memberMobile" class="md:text-lg font-medium block mb-4">
                            Member Mobile No
                        </label>
                        <div class="flex gap-2">
                            <input type="text"
                                class="text-sm bg-secondary/5 w-20 dark:bg-bg3 border border-green-500 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                                value="+91" readonly>
                            <input type="text" id="memberMobile" name="member_mobile"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-green-500 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                                placeholder="Enter Mobile No" readonly>
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1"></div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="minor_id" class="md:text-lg font-medium block mb-4">
                            Minor (if any)
                        </label>
                        <select id="minor_id" name="minor_id"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Minor</option>
                            @foreach ($minors as $minor)
                                <option value="{{ $minor->id }}">
                                    {{ $minor->first_name }} {{ $minor->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('minor_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="branch_id" class="md:text-lg font-medium block mb-4">
                            Branch <span class="text-red-500">*</span>
                        </label>
                        <select id="branch_id" name="branch_id" required
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->branch_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="advisor_id" class="md:text-lg font-medium block mb-4">
                            Advisor / Staff
                        </label>
                        <select id="advisor_id" name="advisor_id"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Advisor / Staff</option>
                            <option value="all" {{ old('advisor_id') == 'all' ? 'selected' : '' }}>ALL</option>
                            <option value="head_office" {{ old('advisor_id') == 'head_office' ? 'selected' : '' }}>Head
                                Office</option>

                            {{-- जर DB मधून Advisor/Staff येत असतील तर --}}
                            @if (!empty($advisors))
                                @foreach ($advisors as $advisor)
                                    <option value="{{ $advisor->id }}"
                                        {{ old('advisor_id') == $advisor->id ? 'selected' : '' }}>
                                        {{ $advisor->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('advisor_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1"></div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="font-medium block mb-2">Collection Advisor/ Staff </label>
                        <select id="" name="collection_advisor_id"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                            <option value="">Select Collection Advisor Staff</option>
                            <option value="head_office">Head Office</option>
                        </select>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="font-medium block mb-2">
                            Scheme <span class="text-red-500">*</span> :
                        </label>
                        <select id="scheme_id" name="scheme_id"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Scheme</option>
                            @foreach ($schemes as $scheme)
                                <option value="{{ $scheme->id }}"
                                    {{ old('scheme_id') == $scheme->id ? 'selected' : '' }}>
                                    {{ $scheme->scheme_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('scheme_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="font-medium block mb-2">
                            DD Amount <span class="text-red-500">*</span>:
                        </label>
                        <input type="number" id="dd_amount" name="dd_amount"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border 
               border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3
               @error('dd_amount') border-red-500 @enderror"
                            placeholder="Enter DD Amount" value="{{ old('dd_amount') }}">

                        {{-- Laravel Validation Error --}}
                        @error('dd_amount')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p id="minAmountMsg" class="text-blue-600 text-xs mt-1 hidden">
                            Minimum amount to be deposited ₹ 100.0
                        </p>
                    </div>
                    <div class="col-span-2 md:col-span-1 relative">
                        <label class="font-medium block mb-2">
                            Open Date <span class="text-red-500">*</span> :
                        </label>
                        <input type="text" id="date5" name="open_date"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 
               rounded-10 px-3 md:px-6 py-2 md:py-3 pr-10"
                            placeholder="DD/MM/YYYY" value="">
                        <i
                            class="absolute -translate-y-1/2 cursor-pointer las la-calendar ltr:right-4 rtl:left-4 top-1/2"></i>
                        <!-- <i class="las la-calendar absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-2xlg pointer-events-none"></i> -->
                    </div>
                    <div class="col-span-2 md:col-span-1"></div>

                    <!-- TDS -->
                    <div class="col-span-2 md:col-span-1 mt-4">
                        <label class="font-medium block mb-2">TDS Deduction<span class="text-red-500">*</span></label>
                        <div class="flex items-center  gap-2">
                            <label class="flex items-center gap-2"><input class="ms-4" type="radio" name="tds"
                                    value="yes"> Yes</label>
                            <label class="flex items-center gap-2"><input class="ms-4" type="radio" name="tds"
                                    value="no"> No</label>
                        </div>
                    </div>

                    <div class="col-span-2 md:col-span-1"></div>

                    <div class="col-span-2 md:col-span-1 mt-4">
                        <label class="font-medium block mb-2">Account Type <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="account_type" value="single"
                                    onclick="toggleAccountType('single')" class="accent-primary">
                                <span>Single</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="account_type" value="joint"
                                    onclick="toggleAccountType('joint')" class="accent-primary">
                                <span>Joint A/C</span>
                            </label>
                        </div>
                        <!-- single (no fields) -->
                        <div id="single" class="hidden"></div>
                    </div>

                    <div class="col-span-2 md:col-span-1 mt-4">
                        <div id="joint" class="hidden mt-4">
                            <label class="font-medium block mb-1">Joint A/C Member <span
                                    class="text-red-500">*</span></label>
                            <select
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 
                       rounded-10 px-3 md:px-6 py-2 md:py-3">
                                <option value="">Search member no or name</option>
                                <option value="1001">Account 1001 - Akask Doshi</option>
                                <option value="1002">Account 1002 - vijay Smith</option>
                                <option value="1003">Account 1003 - Alex Kumar</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Nominee -->
                <div class="col-span-2 md:col-span-1 mt-4">
                    <label class="font-medium block mb-2">Nominee <span class="text-red-500">*</span></label>
                    <div class="flex items-center  gap-2">
                        <label class="flex items-center gap-2"><input class="ms-4" type="radio" name="nominee"
                                value="yes" onclick="toggleAddMore(true)">Yes</label>
                        <label class="flex items-center gap-2"><input class="ms-4" type="radio" name="nominee"
                                value="no" onclick="toggleAddMore(false)"> No</label>
                    </div>

                    <!-- Add More Button -->
                    <div id="addMoreContainer" class="mt-2 hidden">
                        <button type="button" onclick="addNominee()" class="text-blue-600 font-medium">
                            + ADD MORE NOMINEE
                        </button>
                    </div>

                    <!-- Nominee Forms Container -->
                    <div id="nomineeContainer"
                        class="hidden mt-2 flex flex-col md:flex-row flex-wrap gap-4 items-end p-3 rounded-10 bg-gray-50 dark:bg-bg3">
                        <!-- Forms will be added here -->
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1"></div>
                <!-- Payment Mode -->
                <div class="grid grid-cols-1 gap-4 mt-6 xl:mt-8 2xl:gap-6">

                    <div class="col-span-1 mt-4">
                        <label class="block font-medium mb-2">
                            Payment Mode <span class="text-red-500">*</span>
                        </label>

                        <!-- Payment Mode Radios -->
                        <div class="flex flex-wrap gap-4 mt-4">
                            <label class="flex items-center gap-2 text-sm">
                                <input type="radio" name="pay_mode" value="cash"
                                    onclick="togglePaymentMode('cash')">
                                <span>Cash</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="pay_mode" value="onlineTr"
                                    onclick="togglePaymentMode('onlineTr')">
                                <span>Online Tr.</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="pay_mode" value="cheque"
                                    onclick="togglePaymentMode('cheque')">
                                <span>Cheque</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="pay_mode" value="saving"
                                    onclick="togglePaymentMode('saving')">
                                <span>Saving</span>
                            </label>
                        </div>
                        <!-- Cash (no fields) -->
                        <div id="cash" class="hidden"></div>
                        <!-- Online Transfer Fields -->
                        <div id="onlineTr" class="hidden grid grid-cols-2 gap-4 mt-6 xl:mt-8 2xl:gap-6 mt-4">
                            <!-- Transfer Date -->
                            <div class="col-span-2 md:col-span-1 mt-4">
                                <label class="font-medium block mb-1">Transfer Date <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="date2" placeholder="dd/mm/yyyy"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                <i
                                    class="absolute -translate-y-1/2 cursor-pointer las la-calendar ltr:right-4 rtl:left-4 top-1/2"></i>
                            </div>
                            <!-- UTR / Transaction No -->
                            <div class="col-span-2 md:col-span-1 mt-4">
                                <label class="font-medium block mb-1">UTR / Transaction No <span
                                        class="text-red-500">*</span></label>
                                <input type="text" placeholder="Enter UTR / Transaction No"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            </div>
                            <!-- Transfer Mode -->
                            <div class="col-span-2 md:col-span-1 mt-4">
                                <label class="font-medium block mb-1">Transfer Mode <span
                                        class="text-red-500">*</span></label>
                                <div class="flex flex-wrap gap-4 mt-2">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="transfer_mode" value="IMPS"
                                            class="accent-primary">
                                        <span>IMPS</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="transfer_mode" value="VPA"
                                            class="accent-primary">
                                        <span>VPA</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="transfer_mode" value="NEFT/RTGS"
                                            class="accent-primary">
                                        <span>NEFT/RTGS</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Credited in Company Account -->
                            <div class="col-span-2 md:col-span-1 mt-4">
                                <label class="font-medium block mb-1">Credited in Company Account? <span
                                        class="text-red-500">*</span></label>
                                <div class="flex items-center gap-4 mt-1">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="credited_in_company" value="yes"> <span>Yes</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="credited_in_company" value="no"> <span>No</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Cheque Fields -->
                        <div id="cheque" class="hidden mt-2 flex flex-col md:flex-row flex-wrap gap-4 mt-4">
                            <div class="cheque-row flex flex-wrap justify-start gap-4">
                                <div class="flex-center flex-1 min-w-[300px] max-w-full">
                                    <label class="font-medium block mb-1">Bank Name<span
                                            class="text-red-500">*</span></label>
                                    <input type="text" placeholder="Enter Bank Name"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                </div>
                                <div class="flex-center flex-1 min-w-[300px] max-w-full">
                                    <label class="font-medium block mb-1">Cheque No<span
                                            class="text-red-500">*</span></label>
                                    <input type="text" placeholder="Enter Cheque No"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                </div>
                                <div class="flex-center flex-1 min-w-[300px] max-w-full">
                                    <label class="font-medium block mb-1">Cheque Date<span
                                            class="text-red-500">*</span></label>
                                    <input type="date" id="date3"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                    <i
                                        class="absolute -translate-y-1/2 cursor-pointer las la-calendar ltr:right-4 rtl:left-4 top-1/2"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Saving Account Fields -->
                        <div id="saving" class="hidden mt-4">
                            <label class="font-medium block mb-1">Select Saving Account<span
                                    class="text-red-500">*</span></label>
                            <select id="saving_account_id" name="saving_account_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                <option value="">Choose Account</option>
                                @foreach ($savingAccounts as $account)
                                    <option value="{{ $account->id }}">
                                        {{ $account->account_no }}
                                        {{ $account->member->first_name ?? '' }} {{ $account->member->last_name ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Date & Amount -->
                <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 2xl:gap-6">
                    <div class="col-span-2 md:col-span-1">
                        <label class="font-medium block mb-2">
                            T.Date <span class="text-red-500">*</span> </label>
                        @php
                            $today = \Carbon\Carbon::now()->format('d/m/Y');
                        @endphp
                        <input type="text" name="transaction_date" id="date4"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="DD/MM/YYYY" value="{{ old('t_date', $today) }}">
                        <i
                            class="absolute -translate-y-1/2 cursor-pointer las la-calendar ltr:right-4 rtl:left-4 top-1/2"></i>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="font-medium block mb-2">
                            Amount <span class="text-red-500">*</span> </label>
                        <input type="number" name="amount"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-center col-span-2 gap-4 mt-2 md:gap-6">
                    <button class="btn-primary" type="submit">{{ $isEdit ? 'Update DD' : 'Open DD' }}</button>
                    <a href="{{ route('dds-accounts.index') }}" class="btn-outline">Back</a>
                    @if (!$isEdit)
                        <button class="btn-outline" type="reset">Reset</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
    </div>

    <script>
        // Nominee functions
        function toggleAddMore(show) {
            document.getElementById('addMoreContainer').style.display = show ? 'block' : 'none';
            if (!show) document.getElementById('nomineeContainer').style.display = 'hidden';
        }

        function addNominee() {
            const container = document.getElementById("nomineeContainer");
            container.style.display = "flex"; // make visible

            const newNominee = document.createElement("div");
            newNominee.className = "w-full nominee-item columns-4 gap-4 items-end bg-white p-4 rounded dark:bg-bg3";

            newNominee.innerHTML = `
        
<div class="nominee-row flex flex-wrap justify-start gap-6">
    <div class="flex-center flex-1 min-w-[300px] max-w-full">
        <label class="font-medium block mb-2">Relation <span class="text-red-500">*</span></label>
        <select name="nominee_relation[]" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 
                           rounded-10 px-3 md:px-6 py-2 md:py-3">
            <option value="">Select Relation</option>

            <!-- Immediate Family -->
            <option>Father</option>
            <option>Mother</option>
            <option>Spouse</option>
            <option>Son</option>
            <option>Daughter</option>

            <!-- Siblings -->
            <option>Brother</option>
            <option>Sister</option>

            <!-- Extended Family -->
            <option>Grandfather</option>
            <option>Grandmother</option>
            <option>Uncle</option>
            <option>Aunt</option>
            <option>Cousin</option>
            <option>Nephew</option>
            <option>Niece</option>

            <!-- In-Laws -->
            <option>Father-in-law</option>
            <option>Mother-in-law</option>
            <option>Brother-in-law</option>
            <option>Sister-in-law</option>
            <option>Son-in-law</option>
            <option>Daughter-in-law</option>

            <!-- Others -->
            <option>Guardian</option>
            <option>Friend</option>
            <option>Other</option>
        </select>


    </div>

    <div class="flex-1 min-w-[300px] max-w-full">
        <label class="font-medium block mb-2">Name <span class="text-red-500">*</span></label>
        <input type="text" name="nominee_name[]" placeholder="Enter Nominee Name"
            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 
                        rounded-10 px-3 md:px-6 py-2 md:py-3">
    </div>

    <div class="flex-1 min-w-[300px] max-w-full"> 
        <label class="font-medium block mb-2">Address <span class="text-red-500">*</span></label>
        <input type="text" name="nominee_address[]"  placeholder="Enter Nominee Address"
            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 
                         rounded-10 px-3 md:px-6 py-2 md:py-3">
    </div>

    <div class="flex-1 min-w-[60px] max-w-full flex justify-end items-center">
        <button type="button" onclick="removeNominee(this)"
            class="text-red-500 mt-8 font-bold text-lg hover:text-red-700">✕</button>
    </div>
</div>
          
        `;

            container.appendChild(newNominee);
        }

        function removeNominee(button) {
            const item = button.closest(".nominee-item");
            item.remove();

            // Hide container if no nominee left
            const container = document.getElementById("nomineeContainer");
            if (container.children.length === 0) {
                container.style.display = "none";
            }
        }

        function togglePaymentMode(type) {
            ['cash', 'onlineTr', 'cheque', 'saving'].forEach(id => {
                document.getElementById(id).classList.add('hidden');
            });
            if (type === 'onlineTr') document.getElementById('onlineTr').classList.remove('hidden');
            if (type === 'cheque') document.getElementById('cheque').classList.remove('hidden');
            if (type === 'saving') document.getElementById('saving').classList.remove('hidden');
        }


        function toggleAccountType(type) {

            ['single', 'joint'].forEach(id => {
                document.getElementById(id).classList.add('hidden');
            });
            // Show the selected section
            if (type === 'joint') {
                document.getElementById('joint').classList.remove('hidden');
            } else {
                document.getElementById('single').classList.remove('hidden');
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const schemeSelect = document.querySelector('select[name="scheme"]');
            const minAmountMsg = document.getElementById('minAmountMsg');

            schemeSelect.addEventListener('change', function() {
                if (schemeSelect.value) {
                    minAmountMsg.classList.remove('hidden');
                } else {
                    minAmountMsg.classList.add('hidden');
                }
            });
        });
    </script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Auto fill Name, Address, Mobile
        $(document).ready(function() {
            $('#memberDropdown').on('change', function() {
                let memberId = $(this).val();

                if (memberId) {
                    $.ajax({
                        url: `/members/${memberId}`,
                        type: 'GET',
                        success: function(response) {

                            $('#memberName').val(response.member.member_info_first_name);
                            $('#memberAddress').val(response.member.address
                                .member_address_line_1 ?? '');
                            $('#memberMobile').val(response.member.member_info_mobile_no);
                            $('#branch_id').val(response.member.branch.id);

                            const $branchSelect = $('#branch_id');
                            //   console.log($branchSelect);
                            $branchSelect.empty(); // clear options

                            if (response.member.branch.id) {

                                // If a single branch
                                $branchSelect.append(
                                    `<option value="${response.member.branch.id}">${response.member.branch.branch_name}</option>`
                                );
                            } else if (response.member.branch && response.member.branch.length >
                                0) {
                                // If multiple branches
                                member.branch.forEach(branch => {
                                    $branchSelect.append(
                                        `<option value="${response.member.branch.id}">${response.member.branch.branch_name}</option>`
                                    );
                                });
                            } else {
                                $branchSelect.append(
                                    '<option value="">No branches available</option>');
                            }
                        },
                        error: function() {
                            alert('Member details could not be fetched.');
                        }
                    });
                } else {
                    // Reset fields if no member selected
                    $('#memberName').val('');
                    $('#memberAddress').val('');
                    $('#memberMobile').val('');
                    $('#branch_id').empty().append('<option value="">Select branch</option>');
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.getElementById('memberDropdown').addEventListener('change', function() {
            let memberId = this.value;
            let url = this.getAttribute('data-url').replace(':id', memberId);

            if (memberId) {
                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        // ✅ Auto fill
                        document.getElementById('memberName').value = data.member_info_first_name + ' ' + (data
                            .member_info_last_name ?? '');
                        document.getElementById('memberAddress').value = data.member_address_line_1 ?? '';
                        document.getElementById('memberMobile').value = data.member_info_mobile_no ?? '';

                        // ✅ Branch auto select
                        if (data.branch_id) {
                            $('#branch_id').val(data.branch_id).trigger('change');
                        }


                        // ✅ Open Date auto fill
                        document.getElementById('date5').value = data.open_date ?? '';
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Member details could not be fetched.');
                    });
            } else {
                // Reset fields if no member selected
                document.getElementById('memberName').value = '';
                document.getElementById('memberAddress').value = '';
                document.getElementById('memberMobile').value = '';
                document.getElementById('branch_id').value = '';
                document.getElementById('date5').value = '';
            }
        });
    </script>


@endsection
