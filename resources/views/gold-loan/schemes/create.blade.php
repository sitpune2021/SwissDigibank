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
            <h1 class="text-xl font-semibold">NEW GOLD LOAN SCHEME</h1>
        </div>
    </div>

    <div class="box">
        <div class="col-span-12  lg:col-span-12">

            <form class="grid grid-cols-2 gap-4 mt-6"
                action="{{ isset($scheme) ? route('gold-loan.schemes.update', $scheme->id) : route('gold-loan.schemes.store') }}"
                method="POST">
                @csrf
                @if(isset($scheme))
                @method('PUT')
                @endif

                {{-- Scheme Name --}}
                <div class="col-span-2 md:col-span-1">
                    <label for="scheme_name" class="md:text-lg font-medium block mb-4">
                        Scheme Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="scheme_name" value="{{ old('scheme_name', $scheme->scheme_name ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter Scheme Name ">
                    @error('scheme_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="scheme_code" class="md:text-lg font-medium block mb-4">
                        Scheme Code
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="text" name="scheme_code" value="{{ old('scheme_code', $scheme->scheme_code ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 uppercase"
                        placeholder="Enter Scheme Code">
                    @error('scheme_code')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Minimum Loan Amount (₹)
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="number" id="minLoanAmount" min="0" max="200000" name="min_loan_amount"
                        value="{{ old('min_loan_amount', $scheme->min_loan_amount ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 focus:outline-none transition duration-200"
                        placeholder="0.0">
                    <p id="minLoanWords" class="text-red-600 text-sm mt-1 font-semibold"></p>
                    @error('min_loan_amount')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Maximum Loan Amount (₹)
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="number" id="maxLoanAmount" min="0" max="200000" name="max_loan_amount"
                        value="{{ old('max_loan_amount', $scheme->max_loan_amount ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 focus:outline-none transition duration-200"
                        placeholder="0.0">
                    <p id="maxLoanWords" class="text-red-600 text-sm mt-1 font-semibold"></p>
                    @error('max_loan_amount')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="maxLoanLimit" class="md:text-lg font-medium block mb-4">
                        Maximum Loan Limit (%)
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="number" id="maxLoanLimit" name="max_loan_limit"
                        value="{{ old('max_loan_limit', $scheme->max_loan_limit ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter Maximum Loan Limit" max="100"
                        oninput="this.value = Math.min(Math.max(this.value, 0), 100)">

                    @error('max_loan_limit')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <x-number-to-word for="maxLoanLimit" />
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="tenure" class="md:text-lg font-medium block mb-4">
                        Max. Tenure <span class="text-red-500">*</span>
                    </label>

                    <select id="tenure" name="tenure" {{-- value="{{ old('tenure',  $scheme->tenure ?? '') }}" --}}
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3">
                        @php
                        $selectedTenure = old('tenure', $scheme->tenure ?? '');
                        @endphp

                       <option value="1"  {{ $selectedTenure == 1 ? 'selected' : '' }}>1 Month</option>
                        <option value="3"  {{ $selectedTenure == 3 ? 'selected' : '' }}>3 Months</option>
                        <option value="6"  {{ $selectedTenure == 6 ? 'selected' : '' }}>6 Months</option>
                        <option value="9"  {{ $selectedTenure == 9 ? 'selected' : '' }}>9 Months</option>
                        <option value="12" {{ $selectedTenure == 12 ? 'selected' : '' }}>12 Months</option>
                        <option value="18" {{ $selectedTenure == 18 ? 'selected' : '' }}>18 Months</option>
                        <option value="24" {{ $selectedTenure == 24 ? 'selected' : '' }}>2 Years</option>
                        <option value="36" {{ $selectedTenure == 36 ? 'selected' : '' }}>3 Years</option>
                        <option value="48" {{ $selectedTenure == 48 ? 'selected' : '' }}>4 Years</option>
                        <option value="60" {{ $selectedTenure == 60 ? 'selected' : '' }}>5 Years</option>
                        <option value="72" {{ $selectedTenure == 72 ? 'selected' : '' }}>6 Years</option>
                        <option value="84" {{ $selectedTenure == 84 ? 'selected' : '' }}>7 Years</option>
                        <option value="96" {{ $selectedTenure == 96 ? 'selected' : '' }}>8 Years</option>
                        <option value="108" {{ $selectedTenure == 108 ? 'selected' : '' }}>9 Years</option>
                        <option value="120" {{ $selectedTenure == 120 ? 'selected' : '' }}>10 Years</option>
                        <option value="180" {{ $selectedTenure == 180 ? 'selected' : '' }}>15 Years</option>

                        {{-- <option value="1" >1 Month</option>
                        <option selected="selected" value="3">3 Months</option>
                        <option value="6">6 Months</option>
                        <option value="9">9 Months</option>
                        <option value="12">12 Months</option>
                        <option value="18">18 Months</option>
                        <option value="24">2 Years</option>
                        <option value="36">3 Years</option>
                        <option value="48">4 Years</option>
                        <option value="60">5 Years</option>
                        <option value="72">6 Years</option>
                        <option value="84">7 Years</option>
                        <option value="96">8 Years</option>
                        <option value="108">9 Years</option>
                        <option value="120">10 Years</option>
                        <option value="180">15 Years</option> --}}
                    </select>
                    @error('tenure')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Annual Interest Rate (%)
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="number" id="annual_interest_rate" name="annual_interest_rate"
                        value="{{ old('annual_interest_rate', $scheme->annual_interest_rate ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter Annual Interest Rate">
                    @error('annual_interest_rate')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Overdue Interest Rate (%)
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">

                            <!-- Left Select -->
                            <select name="overdue_interest_type" id="overdue_interest_type"
                                class="w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">
                                <option value="TYPE_1" {{ old('overdue_interest_type', $scheme->overdue_interest_type ??
                                    '') == 'TYPE_1' ? 'selected' : '' }}>TYPE_1</option>
                                <option value="TYPE_2" {{ old('overdue_interest_type', $scheme->overdue_interest_type ??
                                    '') == 'TYPE_2' ? 'selected' : '' }}>TYPE_2</option>
                            </select>

                            <!-- Main Input -->
                            <input type="number" id="overdue_interest_rate" name="overdue_interest_rate"
                                value="{{ old('overdue_interest_rate', $scheme->overdue_interest_rate ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                                placeholder="Enter Overdue Interest Rate (%) ">
                            @error('overdue_interest_rate')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Penalty Charges
                    </label>

                    <div class="flex items-center gap-2">

                        <!-- Left Select -->
                        <select name="" id=""
                            class="w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">

                            {{-- <option value="">%</option> --}}
                            <option class="uppercase" value="">Fixed</option>
                        </select>

                        <!-- Main Input -->
                        <input type="number" id="penalty_charge" name="penalty_charge"
                            value="{{ old('penalty_charge', $scheme->penalty_charge ?? '') }}"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                            placeholder="Enter Penalty Charges ">
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Processing Fee
                    </label>

                    <div class="flex items-center gap-2">

                        <!-- Left Select -->
                        <select name="" id=""
                            class="w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">

                            {{-- <option value="">%</option> --}}
                            <option class="uppercase" value="">Fixed</option>
                        </select>

                        <!-- Main Input -->
                        <input type="number" id="processing_fee" name="processing_fee"
                            value="{{ old('processing_fee', $scheme->processing_fee ?? '') }}"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                            placeholder="Enter Processing Fee ">
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Stamp Duty Charge
                    </label>

                    <div class="flex items-center gap-2">
                        <!-- Left Select -->
                        <select name="" id=""
                            class="w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">
                            {{-- <option value="">%</option> --}}
                            <option class="uppercase" value="">Fixed</option>
                        </select>

                        <!-- Main Input -->
                        <input type="number" id="stamp_duty_charge" name="stamp_duty_charge"
                            value="{{ old('stamp_duty_charge', $scheme->stamp_duty_charge ?? '') }}"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                            placeholder="Enter Stamp Duty Charge ">
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Insurance Fee
                    </label>

                    <div class="flex items-center gap-2">

                        <!-- Left Select -->
                        <select name="" id=""
                            class="w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">
                            {{-- <option value="">%</option> --}}
                            <option class="uppercase" value="">Fixed</option>
                        </select>

                        <!-- Main Input -->
                        <input type="number" id="insurance_fee" name="insurance_fee"
                            value="{{ old('insurance_fee', $scheme->insurance_fee ?? '') }}"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                            placeholder="Enter Insurance Fee ">
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <div class="col-sm-7">
                        <label for="" class="md:text-lg font-medium block mb-4">
                            Fore Closure Charges
                        </label>

                        <div class="flex items-center gap-2">

                            <!-- Left Select -->
                            <select name="" id=""
                                class="w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">
                                {{-- <option value="">%</option> --}}
                                <option class="uppercase" value="">Fixed</option>
                            </select>

                            <!-- Main Input -->
                            <input type="number" id="fore_closer_charge" name="fore_closer_charge"
                                value="{{ old('fore_closer_charge', $scheme->fore_closer_charge ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                                placeholder="Enter Fore Closure Charges">
                        </div>

                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Credit Period
                    </label>

                    <input type="number" id="credit_period" name="credit_period"
                        value="{{ old('credit_period', $scheme->credit_period ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter Credit Period">
                </div>

        </div>

        {{-- Interest Type --}}
        <div class="w-full">
            <div class="mb-4" id="intersetTypeRadio">
                <label class="md:text-lg font-medium block mb-2">
                    Interest Type <span class="text-red-600">*</span>
                </label>

                <div class="mt-1 flex flex-wrap gap-3">

                    <!-- Reducing EMI -->
                    <label class="flex items-center gap-2 p-2">
                        <input type="radio" name="gold_loan_setting" value="reducing_emi"
                            class="text-green-600 focus:ring-green-500" data-target="charges-per-emi" {{
                            old('gold_loan_setting', $scheme->gold_loan_setting ?? '') == 'reducing_emi' ? 'checked' :
                        '' }} checked>
                        <span>Reducing EMI</span>
                    </label>

                    <!-- Flat EMI -->
                    <label class="flex items-center gap-2 p-2">
                        <input type="radio" name="gold_loan_setting" value="flat_emi"
                            class="text-green-600 focus:ring-green-500" data-target="charges-per-emi" {{
                            old('gold_loan_setting', $scheme->gold_loan_setting ?? '') == 'flat_emi' ? 'checked' : ''
                        }}>
                        <span>Flat EMI</span>
                    </label>

                    <!-- Flat Advanced Interest Deduction -->
                    <label class="flex items-center gap-2 p-2">
                        <input type="radio" name="gold_loan_setting" value="flat_advanced_interest"
                            class="text-green-600 focus:ring-green-500" data-target="charges-per-emi" {{
                            old('gold_loan_setting', $scheme->gold_loan_setting ?? '') == 'flat_advanced_interest' ?
                        'checked' : '' }}>
                        <span>Flat Advanced Interest</span>
                    </label>

                    <!-- No EMI -->
                    <label class="flex items-center gap-2 p-2">
                        <input type="radio" name="gold_loan_setting" value="no_emi"
                            class="text-green-600 focus:ring-green-500" data-target="no-emi" {{ old('gold_loan_setting',
                            $scheme->gold_loan_setting ?? '') == 'no_emi' ? 'checked' : '' }}>
                        <span>No EMI</span>
                    </label>

                    @error('gold_loan_setting')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>


        {{-- Active field Yes/No --}}
        <div class="w-full">
            <div class="mb-4">
                <label class="md:text-lg font-medium block mb-2">
                    Active <span class="text-red-600">*</span>
                </label>

                <div class="mt-1 flex flex-wrap gap-3">

                    <!-- YES -->
                    <label class="flex items-center gap-2 p-2">
                        <input type="radio" name="is_active" value="1" {{ old('is_active', $scheme->is_active ?? null)
                        == 1 ? 'checked' : '' }}>
                        <span>Yes</span>
                    </label>

                    <!-- NO -->
                    <label class="flex items-center gap-2 p-2">
                        <input type="radio" name="is_active" value="0" {{ old('is_active', $scheme->is_active ?? null)
                        == 0 ? 'checked' : '' }}>
                        <span>No</span>
                    </label>
                </div>

            </div>
        </div>


        {{-- Charges Per EMI Inputs --}}
        <div id="charges-per-emi" hidden>

            <div class="w-full my-4">
                <hr class="border-gray-300">
                <h4
                    class="text-center uppercase font-semibold text-lg sm:text-xl md:text-2xl mt-4 flex items-center justify-center gap-2">
                    Charges Per EMI
                    <i class="las la-info-circle"></i>
                    </button>
                </h4>
            </div>

            <div class=" md:gap-5 gap-4 w-full  grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

                <!-- SMS Charges (if any) Block -->
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium mb-2">
                        SMS Charges (if any)
                    </label>

                    <div class="flex items-center gap-2 w-full mt-2">
                        <!-- Add proper name -->
                        <select name="sms_charge_type" id="sms_charge_type"
                            class="w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-4 py-2 md:py-3">
                            <option value="fixed" {{ old('sms_charge_type', $scheme->sms_charge_type ?? '') == 'fixed' ?
                                'selected' : '' }}>Fixed</option>
                            <!-- <option value="percent" {{ old('sms_charge_type', $scheme->sms_charge_type ?? '') ==
                                'percent' ? 'selected' : '' }}>%</option> -->
                        </select>

                        <!--  Keep this input same (it’s fine) -->
                        <input type="number" name="sms_charge"
                            value="{{ old('sms_charge', $scheme->sms_charge ?? '') }}" id="sms_charge"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter SMS Charges">
                    </div>
                </div>

                <!-- Fuel Charges Block -->
                <div class=" col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium mb-2">
                        Fuel Charges (if any)
                    </label>

                    <div class="flex items-center gap-2 w-full mt-2">
                        <select name="" id=""
                            class="w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-4 py-2 md:py-3">
                            <option class="uppercase" value="">Fixed</option>
                            <!-- <option value="">%</option> -->
                        </select>

                        <input type="number" name="fuel_charge"
                            value="{{ old('fuel_charge', $scheme->fuel_charge ?? '') }}" id="fuel_charge"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Penalty Charges">
                    </div>
                </div>

            </div>

            <div class="  md:gap-5 gap-4 w-full  grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

                <!-- Stationary Charges (if any)Block -->
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium mb-2">
                        Stationary Charges (if any)
                    </label>

                    <div class="flex items-center gap-2 w-full mt-2">
                        <select name="" id=""
                            class="w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-4 py-2 md:py-3">
                            <option class="uppercase" value="">Fixed</option>
                            <!-- <option value="">%</option> -->
                        </select>
                        <input type="number" name="stationary_charge"
                            value="{{ old('stationary_charge', $scheme->stationary_charge ?? '') }}"
                            id="stationary_charge"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Stationary Charges">
                    </div>
                </div>

                <!-- Maintenance Charges (if any) Block -->
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium mb-2">
                        Maintenance Charges (if any)
                    </label>

                    <div class="flex items-center gap-2 w-full mt-2">
                        <select name="" id=""
                            class="w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-4 py-2 md:py-3">
                            <option class="uppercase" value="">Fixed</option>
                            <!-- <option value="">%</option> -->
                        </select>

                        <input type="number" name="maintenance_charge"
                            value="{{ old('maintenance_charge', $scheme->maintenance_charge ?? '') }}"
                            id="maintenance_charge"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Maintenance Charges">
                    </div>
                </div>

            </div>

            <div class="md:gap-5 gap-4 w-full  grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

                <!--Collection Charges (if any) #007bffBlock -->
                <div class=" col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium mb-2">
                        Collection Charges (if any)
                    </label>

                    <div class="flex items-center gap-2 w-full mt-2">
                        <select name="" id=""
                            class="w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-4 py-2 md:py-3">
                            <option class="uppercase" value="">Fixed</option>
                            <!-- <option value="">%</option> -->
                        </select>
                        <input type="number" name="collection"
                            value="{{ old('collection', $scheme->collection ?? '') }}" id="collection"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Collection Charges">
                    </div>
                </div>

                <!-- Blank  Block (do not remove ) -->
                <div class="col-span-2 md:col-span-1">

                </div>

            </div>

        </div>

        {{-- Put this ABOVE your <div id="no-emi"> --}}
            @php
            if(isset($scheme) && $scheme->gold_loan_setting == 'no_emi')
            {
            //$noEmiData = $scheme->no_emi_slabs ?? [];
            $noEmiData = is_array($scheme->no_emi_slabs)
            ? $scheme->no_emi_slabs
            : (json_decode($scheme->no_emi_slabs, true) ?? []);

            $showNoEmi = true;
            }
            else
            {
            $noEmiData = array_fill(0, 12, [
            'from_date' => '',
            'to_date' => '',
            'penal_rate_interest' => '',
            'annual_rate_interest' => ''
            ]);
            $showNoEmi = false;
            }
            @endphp

            {{-- No-EMI Inputs --}}
            <div id="no-emi" hidden>
                <div class="mt-4">
                    <label class="md:text-lg font-medium block mb-2 capitalize">
                        Charge Floating Interest Rate Per Slab
                        <span class="text-red-600">*</span>
                    </label>

                    <div class="mt-1 flex flex-wrap gap-3">
                        <!-- YES -->
                        <label class="flex items-center gap-2 space-x-2 p-2">
                            <input type="radio" name="charge_floting" value="1" {{ old('charge_floting',
                                $scheme->charge_floting ?? null) == 1 ? 'checked' : '' }}>
                            <span class="text-gray-700 uppercase">YES</span>
                        </label>

                        <!-- NO -->
                        <label class="flex items-center gap-2 space-x-2 p-2">
                            <input type="radio" name="charge_floting" value="0" {{ old('charge_floting',
                                $scheme->charge_floting ?? null) == 0 ? 'checked' : '' }}>
                            <span class="text-gray-700 uppercase">NO</span>
                        </label>
                    </div>
                </div>

                <div class=" tableWidth mt-2 px-4">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-secondary/5  text-black">
                                <tr class="">
                                    <th colspan="2" class="text-center py-3 ">DAYS</th>
                                    <th rowspan="2" class="text-center">PENAL INTEREST
                                        <br> RATE (%) (MONTHLY)
                                    </th>
                                    <th rowspan="2" class="text-center py-3 ">
                                        ANNUAL INTEREST
                                        RATE (%)
                                    </th>
                                </tr>
                                <tr class="">
                                    <th class="text-center ">FROM (Start From Day 1)</th>
                                    <th class="text-center  ">TO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i = 0; $i < 12; $i++) <tr>
                                    <td class="border p-1">
                                        <input type="number" name="no_emi[{{ $i }}][from_date]" value="{{ old("
                                            no_emi.$i.from_date", $noEmiData[$i]['from_date'] ?? '' ) }}"
                                            class="w-full border rounded p-1">
                                    </td>

                                    <td class="border p-1">
                                        <input type="number" name="no_emi[{{ $i }}][to_date]" value="{{ old("
                                            no_emi.$i.to_date", $noEmiData[$i]['to_date'] ?? '' ) }}"
                                            class="w-full border rounded p-1">
                                    </td>

                                    <td class="border p-1">
                                        <input type="number" name="no_emi[{{ $i }}][penal_rate_interest]"
                                            value="{{ old(" no_emi.$i.penal_rate_interest",
                                            $noEmiData[$i]['penal_rate_interest'] ?? '' ) }}"
                                            class="w-full border rounded p-1">
                                    </td>

                                    <td class="border p-1">
                                        <input type="number" name="no_emi[{{ $i }}][annual_rate_interest]"
                                            value="{{ old(" no_emi.$i.annual_rate_interest",
                                            $noEmiData[$i]['annual_rate_interest'] ?? '' ) }}"
                                            class="w-full border rounded p-1">
                                    </td>
                                    </tr>
                                    @endfor
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                <button type="submit" class="px-6 py-3 btn-primary uppercase">
                    {{ isset($scheme) ? 'Update Scheme' : 'Create Scheme' }}
                </button>

                <button class="btn-outline uppercase justify-center" type="reset">
                    <a href="{{route('gold-loan.schemes.index')}}"> BAck</a>
                </button>
            </div>

        </div>

        </form>

    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {

        const radioGroup = document.getElementById('intersetTypeRadio');
        const sections = ["charges-per-emi", "no-emi"];

        // Hide/Show logic on change
        radioGroup.addEventListener("change", function (e) {
            if (e.target.name === "gold_loan_setting") {
                sections.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.hidden = true;
                });

                const target = document.getElementById(e.target.dataset.target);
                if (target) target.hidden = false;
            }
        });

        // ✅ Auto show correct section on page load (Edit case)
        const checkedRadio = document.querySelector('input[name="gold_loan_setting"]:checked');
        if (checkedRadio) {
            sections.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.hidden = true;
            });

            const targetEl = document.getElementById(checkedRadio.dataset.target);
            if (targetEl) targetEl.hidden = false;
        }
    });
    </script>

    <!-- Stop Negative Value -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const inputs = document.querySelectorAll("#minLoanAmount, #maxLoanAmount");

    inputs.forEach(input => {
        // Prevent typing "-" (minus sign)
        input.addEventListener("keypress", function(e) {
            if (e.key === "-" || e.key === "e" || e.key === "E") {
                e.preventDefault();
            }
        });

        // Prevent pasting negative or invalid values
        input.addEventListener("input", function() {
            if (this.value < 0) {
                this.value = '';
            }
        });
    });
});
    </script>

    <!-- max & min loan amount validation with sub text -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const minInput = document.getElementById('minLoanAmount');
    const maxInput = document.getElementById('maxLoanAmount');
    const minText = document.getElementById('minLoanWords');
    const maxText = document.getElementById('maxLoanWords');
    const form = document.getElementById('loanForm');
    const LIMIT = 200000; // Max limit

    // Convert number to words
    function numberToWords(num) {
        const a = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
            'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen',
            'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        const b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

        if ((num = num.toString()).length > 9) return 'Overflow';
        const n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        if (!n) return '';

        let str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + ' Crore ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + ' Lakh ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + ' Thousand ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + ' Hundred ' : '';
        str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + 
                (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + ' ' : '';
        return str.trim() + ' Rupees Only';
    }

    // Validation + Display Function
    function validateAndDisplay() {
        let min = parseFloat(minInput.value) || 0;
        let max = parseFloat(maxInput.value) || 0;
        let valid = true;

        // Reset old styles/messages
        minText.textContent = '';
        maxText.textContent = '';
        minInput.classList.remove('border-red-500');
        maxInput.classList.remove('border-red-500');

        // Limit check (₹2,00,000) + auto cap
        if (min > LIMIT) {
            minInput.value = LIMIT;
            min = LIMIT;
            minText.textContent = "Minimum loan amount cannot exceed ₹2,00,000.";
            minInput.classList.add('border-red-500');
            valid = false;
        }

        if (max > LIMIT) {
            maxInput.value = LIMIT;
            max = LIMIT;
            maxText.textContent = "Maximum loan amount cannot exceed ₹2,00,000.";
            maxInput.classList.add('border-red-500');
            valid = false;
        }

        // Show amount in words (after corrections)
        if (min > 0) minText.textContent += "\n" + numberToWords(min);
        if (max > 0) maxText.textContent += "\n" + numberToWords(max);

        // Comparison check (max > min)
        if (min > 0 && max > 0 && min >= max) {
            maxText.textContent = "Maximum amount must be greater than minimum amount.";
            minInput.classList.add('border-red-500');
            maxInput.classList.add('border-red-500');
            valid = false;
        }

        return valid;
    }

    // Real-time validation & display
    minInput.addEventListener('input', validateAndDisplay);
    maxInput.addEventListener('input', validateAndDisplay);

    // Prevent submit if invalid
    form.addEventListener('submit', function(e) {
        if (!validateAndDisplay()) e.preventDefault();
    });
});
    </script>



    @endsection