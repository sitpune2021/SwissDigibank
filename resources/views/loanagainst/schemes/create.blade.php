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
            <h1 class="text-xl font-semibold">NEW LOAN AGAINST DEPOSITE SCHEME</h1>
        </div>
    </div>
    
    <div class="box">
        <div class="col-span-12  lg:col-span-12">
            <form class="grid grid-cols-2 gap-4 mt-6" action="{{ isset($scheme) ? route('loanagainst.schemes.update', $scheme->id) : route('loanagainst.schemes.store') }}" method="POST">
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
                        placeholder="Enter Scheme Name " >
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
                        placeholder="Enter Scheme Code" >
                    @error('scheme_code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="deposit_loan_setting_security_type" class="md:text-lg font-medium block mb-4">
                        Security Type
                        <span class="text-red-500">*</span>
                    </label>
                    <select class="form-control w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        name="security_type"
                        id="deposit_loan_setting_security_type">
                        <option value="">Please Select</option>
                        <option value="FD_OF_SELF" {{ old('security_type', $scheme->security_type ?? '') == 'FD_OF_SELF' ? 'selected' : '' }}>FD of Self</option>
                        <option value="RD_OF_SELF" {{ old('security_type', $scheme->security_type ?? '') == 'RD_OF_SELF' ? 'selected' : '' }}>RD of Self</option>
                        <option value="DAILY_DEPOSIT_OF_SELF" {{ old('security_type', $scheme->security_type ?? '') == 'DAILY_DEPOSIT_OF_SELF' ? 'selected' : '' }}>DD of Self</option>
                        <option value="FD_OF_BANK" {{ old('security_type', $scheme->security_type ?? '') == 'FD_OF_BANK' ? 'selected' : '' }}>FD of Bank</option>
                        <option value="RD_OF_BANK" {{ old('security_type', $scheme->security_type ?? '') == 'RD_OF_BANK' ? 'selected' : '' }}>RD of Bank</option>
                        <option value="LIC" {{ old('security_type', $scheme->security_type ?? '') == 'LIC' ? 'selected' : '' }}>LIC</option>
                        <option value="NSC" {{ old('security_type', $scheme->security_type ?? '') == 'NSC' ? 'selected' : '' }}>NSC</option>
                        <option value="OTHER_GOVT_SECURITY" {{ old('security_type', $scheme->security_type ?? '') == 'OTHER_GOVT_SECURITY' ? 'selected' : '' }}>Other Govt. Security</option>
                    </select>
                    @error('security_type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="maxLoanAmount" class="md:text-lg font-medium block mb-4">
                        Maximum Loan Amount (₹)
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="number" id="maxLoanAmount" name="max_loan_amount"
                            min="0" max="200000"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 focus:outline-none transition duration-200"
                            value="{{ old('max_loan_amount', $scheme->max_loan_amount ?? '') }}"
                            placeholder="0.0">
                        <p id="maxLoanWords" class="text-sm mt-1 font-semibold"></p>
                        <p id="maxLoanError" class="text-sm mt-1 font-semibold hidden"></p>
                        @error('max_loan_amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="max_loan_limit" class="md:text-lg font-medium block mb-4">
                        Maximum Loan Limit (%)
                        <span class="text-red-500">*</span>
                    </label>

                    <select id="max_loan_limit" name="max_loan_limit"
                        class="form-control w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 
                            dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 focus:outline-none transition duration-200">
                        <option value="">Please Select</option>
                        <option value="50.0" {{ old('max_loan_limit', $scheme->max_loan_limit ?? '') == '50.0' ? 'selected' : '' }}>50%</option>
                        <option value="60.0" {{ old('max_loan_limit', $scheme->max_loan_limit ?? '') == '60.0' ? 'selected' : '' }}>60%</option>
                        <option value="70.0" {{ old('max_loan_limit', $scheme->max_loan_limit ?? '') == '70.0' ? 'selected' : '' }}>70%</option>
                        <option value="75.0" {{ old('max_loan_limit', $scheme->max_loan_limit ?? '') == '75.0' ? 'selected' : '' }}>75%</option>
                        <option value="80.0" {{ old('max_loan_limit', $scheme->max_loan_limit ?? '') == '80.0' ? 'selected' : '' }}>80%</option>
                        <option value="90.0" {{ old('max_loan_limit', $scheme->max_loan_limit ?? '') == '90.0' ? 'selected' : '' }}>90%</option>
                        <option value="100.0" {{ old('max_loan_limit', $scheme->max_loan_limit ?? '') == '100.0' ? 'selected' : '' }}>100%</option>
                    </select>
                    @error('max_loan_limit')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="tenure" class="md:text-lg font-medium block mb-4">
                        Max. Tenure <span class="text-red-500">*</span>
                    </label>
                    <select id="tenure" name="tenure"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3">
                        <option value="">Please Select</option>
                        <option value="1" {{ old('tenure', $scheme->tenure ?? '') == '1' ? 'selected' : '' }}>1 Month</option>
                        <option value="3" {{ old('tenure', $scheme->tenure ?? '') == '3' ? 'selected' : '' }}>3 Months</option>
                        <option value="6" {{ old('tenure', $scheme->tenure ?? '') == '6' ? 'selected' : '' }}>6 Months</option>
                        <option value="9" {{ old('tenure', $scheme->tenure ?? '') == '9' ? 'selected' : '' }}>9 Months</option>
                        <option value="12" {{ old('tenure', $scheme->tenure ?? '') == '12' ? 'selected' : '' }}>12 Months</option>
                        <option value="18" {{ old('tenure', $scheme->tenure ?? '') == '18' ? 'selected' : '' }}>18 Months</option>
                        <option value="24" {{ old('tenure', $scheme->tenure ?? '') == '24' ? 'selected' : '' }}>2 Years</option>
                        <option value="36" {{ old('tenure', $scheme->tenure ?? '') == '36' ? 'selected' : '' }}>3 Years</option>
                        <option value="48" {{ old('tenure', $scheme->tenure ?? '') == '48' ? 'selected' : '' }}>4 Years</option>
                        <option value="60" {{ old('tenure', $scheme->tenure ?? '') == '60' ? 'selected' : '' }}>5 Years</option>
                        <option value="72" {{ old('tenure', $scheme->tenure ?? '') == '72' ? 'selected' : '' }}>6 Years</option>
                        <option value="84" {{ old('tenure', $scheme->tenure ?? '') == '84' ? 'selected' : '' }}>7 Years</option>
                        <option value="96" {{ old('tenure', $scheme->tenure ?? '') == '96' ? 'selected' : '' }}>8 Years</option>
                        <option value="108" {{ old('tenure', $scheme->tenure ?? '') == '108' ? 'selected' : '' }}>9 Years</option>
                        <option value="120" {{ old('tenure', $scheme->tenure ?? '') == '120' ? 'selected' : '' }}>10 Years</option>
                        <option value="180" {{ old('tenure', $scheme->tenure ?? '') == '180' ? 'selected' : '' }}>15 Years</option>
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
                        placeholder="Enter Annual Interest Rate" >
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
                                placeholder="Enter Overdue Interest Rate (%) " >
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
                            {{-- <option value="">%</option> --}}
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

        {{--intersetTypeRadio --}}
        <div class="w-full">
                <div class="mb-4" id="intersetTypeRadio">
                    <label class="md:text-lg font-medium mt-3 block mb-2">
                        Interest Type <span class="text-red-600">*</span>
                    </label>

                    <div class="mt-1 flex flex-wrap gap-3">
                        <!-- Reducing EMI -->
                        <label class="flex items-center gap-2 p-2">
                            <input type="radio" name="gold_loan_setting" 
                                value="reducing_emi"
                                class="text-green-600 focus:ring-green-500"
                                data-target="charges-per-emi"
                                {{ old('gold_loan_setting', $scheme->gold_loan_setting ?? '') == 'reducing_emi' ? 'checked' : '' }}
                                 required checked>
                            <span>Reducing EMI</span>
                        </label>

                        <!-- Flat EMI -->
                        <label class="flex items-center gap-2 p-2">
                            <input type="radio" name="gold_loan_setting" 
                                value="flat_emi"
                                class="text-green-600 focus:ring-green-500"
                                data-target="charges-per-emi"
                                {{ old('gold_loan_setting', $scheme->gold_loan_setting ?? '') == 'flat_emi' ? 'checked' : '' }}
                                required>
                            <span>Flat EMI</span>
                        </label>

                        <!-- Flat Advanced Interest Deduction -->
                        <label class="flex items-center gap-2 p-2">
                            <input type="radio" name="gold_loan_setting" 
                                value="flat_advanced_interest"
                                class="text-green-600 focus:ring-green-500"
                                data-target="charges-per-emi"
                                {{ old('gold_loan_setting', $scheme->gold_loan_setting ?? '') == 'flat_advanced_interest' ? 'checked' : '' }}
                                required>
                            <span>Flat Advanced Interest Deduction</span>
                        </label>

                        <!-- No EMI -->
                        <!-- <label class="flex items-center gap-2 p-2">
                            <input type="radio" name="gold_loan_setting" 
                                value="no_emi"
                                {{ old('gold_loan_setting', $scheme->gold_loan_setting ?? '') == 'no_emi' ? 'checked' : '' }}
                                >
                            <span>No EMI</span>
                        </label> -->
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
                    <label class="flex items-center gap-2 space-x-2 p-2">
                        <input 
                            type="radio" 
                            name="is_active" 
                            value="1" 
                            class="text-green-600 focus:ring-green-500"
                            {{ old('is_active', $scheme->is_active ?? '') == 1 ? 'checked' : '' }}>
                        <span class="text-gray-700 capitalize">Yes</span>
                    </label>

                    <!-- No -->
                    <label class="flex items-center gap-2 space-x-2 p-2">
                        <input 
                            type="radio" 
                            name="is_active" 
                            value="0" 
                            class="text-green-600 focus:ring-green-500"
                            {{ old('is_active', $scheme->is_active ?? '') == 0 ? 'checked' : '' }}
                             checked>
                        <span class="text-gray-700 capitalize">No</span>
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
                    class="text-center font-semibold text-lg sm:text-xl md:text-2xl mt-4 flex items-center justify-center uppercase gap-2">
                    Charges Per EMI
                    <i class="las la-info-circle"></i>
                    </button>
                </h4>
            </div>

            <div class=" md:gap-5 gap-4 w-full  grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

                <!-- SMS Charges (if any)Block -->
                <div class=" col-span-2 md:col-span-1 ">
                    <label class="md:text-lg font-medium mb-2">
                        SMS Charges (if any)
                    </label>

                    <div class="flex items-center gap-2 w-full mt-2">
                        <select name="" id=""
                            class="w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-4 py-2 md:py-3">
                            <option class="uppercase" value="">Fixed</option>
                            <option value="">%</option>
                        </select>
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
                            placeholder="Enter fuel Charges">
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

                        <input type="number" name="maintenance_charge" value="{{ old('maintenance_charge', $scheme->maintenance_charge ?? '') }}" id="maintenance_charge"
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
                        <input type="number" name="collection" value="{{ old('collection', $scheme->collection ?? '') }}" id="collection"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Collection Charges">
                    </div>
                </div>

                <!-- Blank  Block (do not remove ) -->
                <div class="col-span-2 md:col-span-1">

                </div>

            </div>

        </div>

        <!-- Buttons -->
        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
           <button type="submit"
                class="px-6 py-3 btn-primary uppercase">
                {{ isset($scheme) ? 'Update Scheme' : 'Create Scheme' }}
            </button>

            <button class="btn-outline uppercase justify-center" type="reset">
                <a href="{{route('loanagainst.schemes.index')}}">BACK</a>
            </button>
        </div>

    </div>

    </form>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const maxLoanInput = document.querySelector('input[name="max_loan_amount"]');

    maxLoanInput.addEventListener('input', function () {
        if (parseFloat(this.value) > 200000) {
            alert('Maximum loan amount cannot exceed ₹2,00,000.');
            this.value = 200000; // Auto reset to max value
        }
    });
});
</script>

<script>
    // =====logic for Interest Type  radio  which opens charges Per EMI and No Emi=====
    const intersetTypeRadio = document.getElementById('intersetTypeRadio');
    intersetTypeRadio.addEventListener("change", e => {
        if (e.target.name === "gold_loan_setting") {
            document.querySelectorAll("#charges-per-emi,#no-emi")
                .forEach(f => f.hidden = true);
            document.getElementById(e.target.dataset.target).hidden = false;
        }
    })
    //==== Auto-select the checked radio on page load===
    window.addEventListener("DOMContentLoaded", () => {
        const checkedRadio = document.querySelector('input[name="gold_loan_setting"]:checked');
        if (checkedRadio) {
            document.querySelectorAll("#charges-per-emi,#no-emi").forEach(f => f.hidden = true);
            const targetEl = document.getElementById(checkedRadio.dataset.target);
            if (targetEl) targetEl.hidden = false;
        }
    });
</script>

<script>
// Convert numbers to words
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

document.addEventListener("DOMContentLoaded", function() {
    const maxInput = document.getElementById('maxLoanAmount');
    const maxWords = document.getElementById('maxLoanWords');
    const maxError = document.getElementById('maxLoanError');

    // Prevent typing "-" or "e"
    maxInput.addEventListener("keypress", function(e) {
        if (e.key === "-" || e.key === "e" || e.key === "E") {
            e.preventDefault();
        }
    });

    // Handle input
    maxInput.addEventListener("input", function() {
        const val = this.value.trim();

        // If negative or invalid
        if (val.startsWith('-') || val < 0) {
            this.value = '';
            maxWords.textContent = 'Invalid input! Negative values not allowed.';
            maxWords.style.color = 'red';
            maxError.classList.add('hidden');
            return;
        }

        // If valid number
        if (val && !isNaN(val)) {
            maxError.classList.add('hidden');
            maxWords.textContent = numberToWords(parseInt(val));
            maxWords.style.color = '#d8871dff'; // Tailwind "text-blue-700"
        } else {
            maxWords.textContent = '';
            maxError.classList.add('hidden');
        }
    });
});
</script>


@endsection