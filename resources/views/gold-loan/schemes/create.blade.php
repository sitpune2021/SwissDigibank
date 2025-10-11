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
                    <input type="text" name="scheme_name"
                        value="{{ old('scheme_name', $scheme->scheme_name ?? '') }}"
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

                    <input type="number" id="" name="min_loan_amount" value="{{ old('min_loan_amount', $scheme->min_loan_amount ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="0.0">
                     @error('min_loan_amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Maximum Loan Amount (₹)
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="number" id=""  max="200000" name="max_loan_amount" value="{{ old('max_loan_amount', $scheme->max_loan_amount ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="0.0">
                         @error('max_loan_amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Maximum Loan Limit (%)
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="number" id="maxLoanLimit" name="max_loan_limit" value="{{ old('max_loan_limit', $scheme->max_loan_limit ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter Maximum Loan Limit">
                         @error('max_loan_limit')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <!-- This will show the words -->
                    <x-number-to-word for="maxLoanLimit" />
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="tenure" class="md:text-lg font-medium block mb-4">
                        Max. Tenure <span class="text-red-500">*</span>
                    </label>

                    <select id="tenure" name="tenure" value="{{ old('tenure', $scheme->tenure ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3">
                        <option value="1">1 Month</option>
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
                        <option value="180">15 Years</option>
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

                    <input type="number" id="annual_interest_rate" name="annual_interest_rate" value="{{ old('annual_interest_rate', $scheme->annual_interest_rate ?? '') }}"
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
                            <select name="" id=""
                                class="w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">
                                <option value="TYPE_1">TYPE_1</option>
                                <option value="TYPE_2">TYPE_2</option>
                            </select>

                            <!-- Main Input -->
                            <input type="number" id="overdue_interest_rate" name="overdue_interest_rate" value="{{ old('overdue_interest_rate', $scheme->overdue_interest_rate ?? '') }}"
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

                            <option value="">%</option>
                            <option class="uppercase" value="">Fixed</option>
                        </select>

                        <!-- Main Input -->
                        <input type="number" id="penalty_charge" name="penalty_charge" value="{{ old('penalty_charge', $scheme->penalty_charge ?? '') }}"
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

                            <option value="">%</option>
                            <option class="uppercase" value="">Fixed</option>
                        </select>

                        <!-- Main Input -->
                        <input type="number" id="processing_fee" name="processing_fee" value="{{ old('processing_fee', $scheme->processing_fee ?? '') }}"
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
                            <option value="">%</option>
                            <option class="uppercase" value="">Fixed</option>          
                        </select>

                        <!-- Main Input -->
                        <input type="number" id="stamp_duty_charge" name="stamp_duty_charge" value="{{ old('stamp_duty_charge', $scheme->stamp_duty_charge ?? '') }}"
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
                            <option value="">%</option>
                            <option class="uppercase" value="">Fixed</option>
                        </select>

                        <!-- Main Input -->
                        <input type="number" id="insurance_fee" name="insurance_fee" value="{{ old('insurance_fee', $scheme->insurance_fee ?? '') }}"
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
                                <option value="">%</option>
                                <option class="uppercase" value="">Fixed</option>                           
                            </select>

                            <!-- Main Input -->
                            <input type="number" id="fore_closer_charge" name="fore_closer_charge" value="{{ old('fore_closer_charge', $scheme->fore_closer_charge ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                                placeholder="Enter Fore Closure Charges">
                        </div>

                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Credit Period
                    </label>

                    <input type="number" id="credit_period" name="credit_period" value="{{ old('credit_period', $scheme->credit_period ?? '') }}"
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
                        <input type="radio" 
                            name="gold_loan_setting" 
                            value="reducing_emi"
                            class="text-green-600 focus:ring-green-500"
                            data-target="charges-per-emi"
                            {{ old('gold_loan_setting', $scheme->gold_loan_setting ?? '') == 'reducing_emi' ? 'checked' : '' }} checked>
                        <span>Reducing EMI</span>
                    </label>

                    <!-- Flat EMI -->
                    <label class="flex items-center gap-2 p-2">
                        <input type="radio" 
                            name="gold_loan_setting" 
                            value="flat_emi"
                            class="text-green-600 focus:ring-green-500"
                            data-target="charges-per-emi"
                            {{ old('gold_loan_setting', $scheme->gold_loan_setting ?? '') == 'flat_emi' ? 'checked' : '' }}>
                        <span>Flat EMI</span>
                    </label>

                    <!-- Flat Advanced Interest Deduction -->
                    <label class="flex items-center gap-2 p-2">
                        <input type="radio" 
                            name="gold_loan_setting" 
                            value="flat_advanced_interest"
                            class="text-green-600 focus:ring-green-500"
                            data-target="charges-per-emi"
                            {{ old('gold_loan_setting', $scheme->gold_loan_setting ?? '') == 'flat_advanced_interest' ? 'checked' : '' }}>
                        <span>Flat Advanced Interest</span>
                    </label>

                    <!-- No EMI -->
                    <label class="flex items-center gap-2 p-2">
                        <input type="radio" 
                            name="gold_loan_setting" 
                            value="no_emi"
                            class="text-green-600 focus:ring-green-500"
                            data-target="no-emi"
                            {{ old('gold_loan_setting', $scheme->gold_loan_setting ?? '') == 'no_emi' ? 'checked' : '' }}>
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

                    <!-- Yes -->
                    <label class="flex items-center gap-2 p-2">
                        <input type="radio" 
                            name="is_active" 
                            value="1"
                            class="text-green-600 focus:ring-green-500"
                            {{ old('is_active', $scheme->is_active ?? '') == 1 ? 'checked' : '' }}>
                        <span>Yes</span>
                    </label>

                    <!-- No -->
                    <label class="flex items-center gap-2 p-2">
                        <input type="radio" 
                            name="is_active" 
                            value="0"
                            class="text-green-600 focus:ring-green-500"
                            {{ old('is_active', $scheme->is_active ?? '') == 0 ? 'checked' : '' }} checked>
                        <span>No</span>
                    </label>

                    @error('is_active')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>


        {{-- Charges Per EMI Inputs --}}
        <div id="charges-per-emi" hidden>
            <div class="w-full my-4">
                <hr class="border-gray-300">
                <h4
                    class="text-center font-semibold text-lg sm:text-xl md:text-2xl mt-4 flex items-center justify-center gap-2">
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
                            <option value="fixed" {{ old('sms_charge_type', $scheme->sms_charge_type ?? '') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                            <option value="percent" {{ old('sms_charge_type', $scheme->sms_charge_type ?? '') == 'percent' ? 'selected' : '' }}>%</option>
                        </select>

                        <!--  Keep this input same (it’s fine) -->
                        <input type="number" name="sms_charge" value="{{ old('sms_charge', $scheme->sms_charge ?? '') }}" id="sms_charge"
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
                            <option value="">%</option>
                        </select>

                        <input type="number" name="fuel_charge" value="{{ old('fuel_charge', $scheme->fuel_charge ?? '') }}" id="fuel_charge"
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
                            <option value="">%</option>
                        </select>
                        <input type="number" name="stationary_charge" value="{{ old('stationary_charge', $scheme->stationary_charge ?? '') }}" id="stationary_charge"
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
                            <option value="">%</option>
                        </select>

                        <input type="number" name="maintenace_charge" value="{{ old('maintenace_charge', $scheme->maintenace_charge ?? '') }}" id="maintenace_charge"
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
                            <option value="">%</option>
                        </select>
                        <input type="number" name="collcetion" value="{{ old('collcetion', $scheme->collcetion ?? '') }}" id="collcetion"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Collection Charges">
                    </div>
                </div>

                <!-- Blank  Block (do not remove ) -->
                <div class="col-span-2 md:col-span-1">

                </div>

            </div>

        </div>



        {{-- No-EMI Inputs --}}
        <div id="no-emi" hidden>
            <div class="mt-4 ">
                <label class="md:text-lg font-medium block mb-2 capitalize">
                    Charge Floating Interest Rate Per Slab
                    <span class="text-red-600">*</span>
                </label>
                <div class="mt-1 flex flex-wrap gap-3">
                    <!-- Yes -->
                    <label class="flex items-center gap-2 space-x-2 p-2">
                        <input type="radio" name="charge_floting" value="{{ old('charge_floting', $scheme->charge_floting ?? '') }}" class="text-green-600 focus:ring-green-500" checked>
                        <span class="text-gray-70 uppercase">yes</span>
                    </label>
                    <!-- NO -->
                    <label class="flex items-center gap-2 space-x-2 p-2">
                        <input type="radio" name="charge_floting" value="{{ old('charge_floting', $scheme->charge_floting ?? '') }}" class="text-green-600 focus:ring-green-500 "
                            checked>
                        <span class="text-gray-700 uppercase">no</span>
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
                            <tr>
                                <td class="border border-gray-300 p-1">
                                    <input type="number" name="from_date" value="{{ old('from_date', $scheme->from_date ?? '') }}" placeholder="From"
                                        class="w-full  border border-gray-300 rounded p-1">
                                </td>
                                <td class="border border-gray-300 p-1"><input type="number" name="to_date" value="{{ old('to_date', $scheme->to_date ?? '') }}" placeholder="To"
                                        class="w-full border  border-gray-300 rounded p-1"></td>
                                <td class="border border-gray-300 p-1"><input type="number" name="penal_rate_intererst" value="{{ old('penal_rate_intererst', $scheme->penal_rate_intererst ?? '') }}"
                                        placeholder="Penal Interest(%)"
                                        class="w-full  border border-gray-300 rounded p-1"></td>
                                <td class="border border-gray-300 p-1"><input type="number" name="annual_rate_interest" value="{{ old('annual_rate_interest', $scheme->annual_rate_interest ?? '') }}"
                                        placeholder="Annual Interest Rate(%) "
                                        class="w-full border border-gray-300 rounded p-1"></td>
                            </tbody>
                    </table>


                </div>
            </div>

        </div>


        <!-- Buttons -->
        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
           <button type="submit"
                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                {{ isset($scheme) ? 'Update Scheme' : 'Create Scheme' }}
            </button>

            <button class="btn-outline uppercase justify-center" type="reset">
                <a href="{{route('rdschemes.index')}}"> BAck</a>
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

    // Auto-show correct section on page load
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const maxInput = document.querySelector('input[name="max_loan_amount"]');
    maxInput.addEventListener('input', function() {
        if (parseFloat(this.value) > 200000) {
            alert("Maximum loan amount cannot exceed ₹2,00,000!");
            this.value = 200000;
        }
    });
    });
</script>

@endsection