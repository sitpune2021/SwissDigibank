@extends('layout.main')

@section('content')

    <style>
        input[type="checkbox"] {
            width: 28px;
            height: 28px;
            accent-color: green;
        }

        input[type="checkbox"]:checked {
            background-color: green;
            border: none;
        }

        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;
        }
         button[type="reset"]:active {
                transform: scale(0.95);
                opacity: 0.7;
                transition: 0.1s;
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
                    {{ $isEdit ? 'UPDATE DD ACCOUNT' : 'OPEN NEW DD ACCOUNT' }}
                </h1>
            </div>
        </div>

        <div class="col-span-12 box lg:col-span-12">
            <form action="{{ $isEdit ? route('dds-accounts.update', $ddsAccount->id) : route('dds-accounts.store') }}"
                method="POST" id="DDForm">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 2xl:gap-6">
                    <div class="col-span-2 md:col-span-1">
                        <label for="memberDropdown" class="md:text-lg font-medium block mb-4 uppercase">
                            Customer <span class="text-red-500">*</span>
                        </label>
                        <select id="memberDropdown" name="member_id" data-url="{{ route('ajax.members.show', ':id') }}"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border 
               border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3
               @error('member_id') border-red-500 @enderror">
                            <option value="">Search Customer No or Name</option>
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
                        <label for="memberName" class="md:text-lg font-medium block mb-4 uppercase">
                            Customer Name
                        </label>
                        <input type="text" id="memberName" name="member_name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Customer Name" value="" readonly>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="memberAddress" class="md:text-lg font-medium block mb-4 uppercase">
                            Customer Address
                        </label>
                        <input type="text" id="memberAddress" name="member_address"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="" value="" readonly>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="memberMobile" class="md:text-lg font-medium block mb-4 uppercase">
                            Customer Mobile No
                        </label>
                        <div class="flex gap-2">
                            <input type="text"
                                class="text-sm bg-secondary/5 w-20 dark:bg-bg3 border border-green-500 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                                value="+91" readonly>
                            <input id="memberMobile" name="member_mobile" type="number" , maxlength="10" , minlength="10" ,
                                pattern=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-green-500 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                                placeholder="Enter Mobile No" readonly>
                        </div>
                    </div>
                    {{-- </div> --}}
                    <div class="col-span-2 md:col-span-1"></div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="minor_id" class="md:text-lg font-medium block mb-4 uppercase">
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
                        <label for="branch_id" class="md:text-lg font-medium block mb-4 uppercase">
                            Branch <span class="text-red-500">*</span>
                        </label>
                        <select id="branch_id" name="branch_id"
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
                        <label for="advisor_id" class="md:text-lg font-medium block mb-4 uppercase">
                            Advisor / Staff
                        </label>
                        <select id="advisor_id" name="advisor_id"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Advisor / Staff</option>
                            <option value="all" {{ old('advisor_id') == 'all' ? 'selected' : '' }}>ALL</option>
                            <option value="head_office" {{ old('advisor_id') == 'head_office' ? 'selected' : '' }}>Head
                                Office</option>

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
                        <label class="font-medium block mb-2 uppercase">Collection Advisor/ Staff </label>
                        <select id="" name="collection_advisor_id"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                            <option value="">Select Collection Advisor Staff</option>
                            <option value="head_office">Head Office</option>
                        </select>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="scheme_id" class="font-medium block mb-2 uppercase">
                            Scheme <span class="text-red-500">*</span> :
                        </label>
                        <select id="scheme_id" name="scheme_id"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Scheme</option>
                            @php
                                $allowedFrequencies = ['daily', 'weekly', 'bi_weekly'];
                            @endphp

                            @foreach ($schemes as $scheme)
                                @php
                                    $frequency = strtolower(trim($scheme->rd_dd_frequency));
                                @endphp

                                @if (in_array($frequency, $allowedFrequencies))
                                    <option data-min="{{ $scheme->min_rd_dd_amount }}"
                                        data-frequency="{{ $frequency }}" value="{{ $scheme->id }}"
                                        {{ old('scheme_id') == $scheme->id ? 'selected' : '' }}>
                                        {{ $scheme->scheme_name }}
                                    </option>
                                @endif
                            @endforeach


                        </select>
                        @error('scheme_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <span class="text-gray-500 text-xs mt-1 block" style="color:green" id="minAmountNote"></span>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="font-medium block mb-2 uppercase">
                            DD Amount <span class="text-red-500">*</span>:
                        </label>
                        <input type="number" id="dd_amount" name="dd_amount"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border 
        border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter DD Amount" value="">
                        <x-number-to-word for="dd_amount" />
                        @error('dd_amount')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <p id="minAmountMsg" class="text-green-600 text-xs mt-1 hidden">
                        </p>
                    </div>


                    <div class="col-span-2 md:col-span-1 relative">
                        <label class="font-medium block mb-2 uppercase">
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

                    <div class="col-span-2 md:col-span-1 relative">
                        {{-- do not remove this div --}}
                    </div>

                    <div class="col-span-2 md:col-span-1 relative">
                        <label for="remarks"
                            class="w-full md:w-1/4 text-sm font-medium text-gray-700 mb-2 md:mb-0 uppercase">
                            Remarks (if any)
                        </label>
                        <div class="w-full md:w-3/4 mt-2">
                            <textarea name="remarks" id="remarks" placeholder="Enter Remarks (if any)"
                                class="w-full px-4 py-2 border border-gray-300 rounded-10 dark:bg-bg3 bg-secondary/5 resize-none" maxlength="254"
                                rows="2"></textarea>
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1"></div>
                    <!-- TDS -->
                    <div class="col-span-2 md:col-span-1 mt-4">
                        <label class="font-medium block mb-2 uppercase">TDS Deduction<span
                                class="text-red-500">*</span></label>
                        <div class="flex items-center  gap-2">
                            <label class="flex items-center gap-2"><input class="ms-4" type="radio" name="tds"
                                    value="yes"> Yes</label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="tds" value="no" checked>
                                No
                            </label>
                        </div>
                    </div>

                    <div class="col-span-2 md:col-span-1"></div>

                    <div class="col-span-2 md:col-span-1 mt-4">
                        <label class="font-medium block mb-2 uppercase">Account Type <span
                                class="text-red-500">*</span></label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="account_type" value="single"
                                    onclick="toggleAccountType('single')" class="accent-primary" checked>
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
                            <label class="font-medium block mb-1 uppercase">Joint A/C Member <span
                                    class="text-red-500">*</span></label>
                            <select
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 
                       rounded-10 px-3 md:px-6 py-2 md:py-3">
                                <option value="">Search Customer No or Name</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}"
                                        {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->member_info_first_name }} {{ $member->member_info_last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1"></div>
                <!-- Nominee -->
                <div class="col-span-2 md:col-span-1 mt-4">
                    <label class="font-medium block mb-2 uppercase">Nominee <span class="text-red-500">*</span></label>
                    <div class="flex items-center  gap-2">
                        <label class="flex items-center gap-2"><input class="ms-4" type="radio" name="nominee"
                                value="yes" onclick="toggleAddMore(true)">Yes</label>
                        <label class="flex items-center gap-2"><input class="ms-4" type="radio" name="nominee"
                                value="no" checked onclick="toggleAddMore(false)"> No</label>
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
                        <label class="block font-medium mb-2 uppercase">
                            Payment Mode <span class="text-red-500">*</span>
                        </label>

                        <!-- Payment Mode Radios -->
                        <div class="flex flex-wrap gap-4 mt-4">
                            <label class="flex items-center gap-2 text-sm">
                                <input type="radio" name="pay_mode" value="cash" onclick="togglePaymentMode('cash')"
                                    checked>
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
                                <input type="text" name="transfer_date" id="date2" placeholder="dd/mm/yyyy"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                <i
                                    class="absolute -translate-y-1/2 cursor-pointer las la-calendar ltr:right-4 rtl:left-4 top-1/2"></i>
                            </div>
                            <!-- UTR / Transaction No -->
                            <div class="col-span-2 md:col-span-1 mt-4">
                                <label class="font-medium block mb-1">UTR / Transaction No <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="utr_no" placeholder="Enter UTR / Transaction No"
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
                                        <input type="radio" name="credited_in_company" value="1"> <span>Yes</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="credited_in_company" value="0"> <span>No</span>
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
                                    <x-searchable-dropdown :items="$banks" label="Select Bank" name="bank_name"
                                        display-field="name" value-field="id" event="Bank-selected" :selected="null" />
                                    {{-- <input type="text" name="bank_name" placeholder="Enter Bank Name"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"> --}}
                                </div>
                                <div class="flex-center flex-1 min-w-[300px] max-w-full">
                                    <label class="font-medium block mb-1">Cheque No<span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="cheque_no" placeholder="Enter Cheque No"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                </div>
                                <div class="flex-center flex-1 min-w-[300px] max-w-full">
                                    <label class="font-medium block mb-1">Cheque Date<span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="cheque_date" id="date3"
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
                                        {{ $account->members->full_name ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Date & Amount -->
                <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 2xl:gap-6">
                    <div class="col-span-2 md:col-span-1">
                        <label class="font-medium block mb-2 uppercase">
                            T.Date <span class="text-red-500">*</span> </label>
                        @php
                            $today = \Carbon\Carbon::now()->format('d-m-Y');
                        @endphp
                        <input type="text" name="transaction_date" id="date4"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="DD/MM/YYYY" value="{{ old('t_date', $today) }}">
                        <i class="absolute -translate-y-1/2 cursor-pointer l ltr:right-4 rtl:left-4 top-1/2"></i>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="font-medium block mb-2 uppercase">
                            Amount <span class="text-red-500">*</span>
                        </label>

                        <input type="number" id="amount" name="amount" placeholder="Enter Amount"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border 
        border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <x-number-to-word for="amount" />

                    </div>
                </div>
                <!-- Buttons -->
                <div class="flex justify-center col-span-2 gap-4 mt-2 md:gap-6">

                    <!-- OPEN / UPDATE -->
                    <button class="btn-primary" type="submit">
                        {{ $isEdit ? 'UPDATE DD' : 'OPEN DD' }}
                    </button>

                    <!-- RESET (only in Create mode) -->
                    @if (!$isEdit)
                        <button class="btn-outline" type="reset" onclick="document.getElementById('DDForm').reset();">
                            RESET
                        </button>
                    @endif

                    <!-- BACK (always visible) -->
                    <a href="{{ route('dds-accounts.index') }}" class="btn-outline">
                        BACK
                    </a>

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
            container.style.display = "flex";

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <script>
        document.getElementById('memberDropdown').addEventListener('change', function() {
            const memberId = this.value;
            const url = this.getAttribute('data-url').replace(':id', memberId);

            if (!memberId) {
                document.getElementById('memberName').value = '';
                document.getElementById('memberAddress').value = '';
                document.getElementById('memberMobile').value = '';
                document.getElementById('branch_id').selectedIndex = 0;
                document.getElementById('minor_id').innerHTML = '<option value="">Select Minor</option>';
                return;
            }

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    // Auto-fill customer info
                    document.getElementById('memberName').value =
                        `${data.member_info_first_name ?? ''} ${data.member_info_last_name ?? ''}`;
                    document.getElementById('memberAddress').value = data.member_address_line_1 ?? '';
                    document.getElementById('memberMobile').value = data.member_info_mobile_no ?? '';

                    // Auto-select branch
                    const branchSelect = document.getElementById('branch_id');
                    const branchId = data.branch_id ? String(data.branch_id) : '';
                    branchSelect.value = branchId;

                    // Populate minors
                    const minorSelect = document.getElementById('minor_id');
                    minorSelect.innerHTML = '<option value="">Select Minor</option>';
                    if (data.minors && data.minors.length > 0) {
                        data.minors.forEach(minor => {
                            const opt = document.createElement('option');
                            opt.value = minor.id;
                            opt.textContent = `${minor.first_name} ${minor.last_name}`;
                            minorSelect.appendChild(opt);
                        });
                    } else {
                        const opt = document.createElement('option');
                        opt.textContent = 'No minors found';
                        minorSelect.appendChild(opt);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Failed to fetch customer details.');
                });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const schemeSelect = document.getElementById('scheme_id');
            const ddAmountInput = document.getElementById('dd_amount');
            const amountInput = document.getElementById('amount');
            const minAmountMsg = document.getElementById('minAmountMsg');

            let currentMinAmount = 0;

            schemeSelect.addEventListener('change', function() {
                const selectedOption = schemeSelect.options[schemeSelect.selectedIndex];
                const minAmount = selectedOption.getAttribute('data-min');

                currentMinAmount = (minAmount && !isNaN(minAmount)) ? parseFloat(minAmount) : 0;
                minAmountMsg.textContent = currentMinAmount ?
                    `Minimum amount to be deposited ₹${currentMinAmount.toFixed(2)}` :
                    '';
                minAmountMsg.classList.remove('hidden');
                minAmountMsg.style.color = "green";
            });

            ddAmountInput.addEventListener('input', function() {
                let value = parseFloat(ddAmountInput.value) || 0;
                amountInput.value = value ? value.toFixed(2) : '';
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileFields = ['memberMobile'];

            mobileFields.forEach(function(id) {
                const input = document.getElementById(id);
                if (input) {
                    input.addEventListener('input', function() {
                        this.value = this.value.replace(/\D/g, '');

                        if (this.value.length > 10) {
                            this.value = this.value.slice(0, 10);
                        }
                    });
                }
            });
        });
    </script>
@endsection
