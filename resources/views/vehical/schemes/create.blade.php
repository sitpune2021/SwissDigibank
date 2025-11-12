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
            <h1 class="text-xl font-semibold">VEHICAL LOAN SCHEME</h1>
        </div>
    </div>

    <div class="box">
        <div class="col-span-12  lg:col-span-12">

            <form class="grid grid-cols-2 gap-4 mt-6" action="{{ isset($scheme) ? route('vehical.schemes.update', $scheme->id) : route('vehical.schemes.store') }}" method="POST">
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
                        placeholder="Enter Scheme Name">
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
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Maximum Loan Amount (₹)
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="maxLoanAmount" name="max_loan_amount" value="{{ old('max_loan_amount', $scheme->max_loan_amount ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="0.0" min="0" max="200000" >
                        <p id="maxLoanAmountWords" class="text-red-500 text-sm mt-1"></p>
                        <!-- Laravel Error Message -->
                        @error('max_loan_amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                </div>

               
                <div class="col-span-2 md:col-span-1">
                    <label for="maxLoanLimit" class="md:text-lg font-medium block mb-4">
                        Maximum Loan Limit (%) <span class="text-red-500">*</span>
                    </label>
                    <select id="maxLoanLimit" name="max_loan_limit"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">-- Select Maximum Loan Limit --</option>
                        <option value="50" {{ old('max_loan_limit', $scheme->max_loan_limit ?? '') == 50 ? 'selected' : '' }}>50%</option>
                        <option value="60" {{ old('max_loan_limit', $scheme->max_loan_limit ?? '') == 60 ? 'selected' : '' }}>60%</option>
                        <option value="70" {{ old('max_loan_limit', $scheme->max_loan_limit ?? '') == 70 ? 'selected' : '' }}>70%</option>
                        <option value="80" {{ old('max_loan_limit', $scheme->max_loan_limit ?? '') == 80 ? 'selected' : '' }}>80%</option>
                        <option value="90" {{ old('max_loan_limit', $scheme->max_loan_limit ?? '') == 90 ? 'selected' : '' }}>90%</option>
                        <option value="95" {{ old('max_loan_limit', $scheme->max_loan_limit ?? '') == 95 ? 'selected' : '' }}>95%</option>
                    </select>

                    @error('max_loan_limit')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
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
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
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
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Overdue Interest Rate (%)
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">
                            <!-- Left Select -->
                             <select name="overdue_type" id="overdue_type"
                            class="w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">
                            <option value="">Select Type</option>
                            <option value="TYPE_1" {{ old('overdue_type', $scheme->overdue_type ?? '') == 'TYPE_1' ? 'selected' : '' }}>TYPE_1</option>
                            <option value="TYPE_2" {{ old('overdue_type', $scheme->overdue_type ?? '') == 'TYPE_2' ? 'selected' : '' }}>TYPE_2</option>
                        </select>
                            <!-- Main Input -->
                            <input type="number" id="overdue_interest_rate" name="overdue_interest_rate" value="{{ old('overdue_interest_rate', $scheme->overdue_interest_rate ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                                placeholder="Enter Overdue Interest Rate (%)">
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
                    <input type="number" id="credit_period" value = '1' name="credit_period" value="{{ old('credit_period', $scheme->credit_period ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter Credit Period">
                </div>

        </div>

        {{--intersetTypeRadio --}}
        <div class="w-full">
                <div class="mb-4" id="intersetTypeRadio">
                    <label class="md:text-lg font-medium block mb-2">
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
                                 checked>
                            <span>Reducing EMI</span>
                        </label>
                        <!-- Flat EMI -->
                        <label class="flex items-center gap-2 p-2">
                            <input type="radio" name="gold_loan_setting" 
                                value="flat_emi"
                                class="text-green-600 focus:ring-green-500"
                                data-target="charges-per-emi"
                                {{ old('gold_loan_setting', $scheme->gold_loan_setting ?? '') == 'flat_emi' ? 'checked' : '' }}>
                            <span>Flat EMI</span>
                        </label>

                        <!-- Flat Advanced Interest Deduction -->
                        <label class="flex items-center gap-2 p-2">
                            <input type="radio" name="gold_loan_setting" 
                                value="flat_advanced_interest"
                                class="text-green-600 focus:ring-green-500"
                                data-target="charges-per-emi"
                                {{ old('gold_loan_setting', $scheme->gold_loan_setting ?? '') == 'flat_advanced_interest' ? 'checked' : '' }}>
                            <span>Flat Advanced Interest Deduction</span>
                        </label>

                        <!-- No EMI -->
                        <!-- <label class="flex items-center gap-2 p-2">
                            <input type="radio" name="gold_loan_setting" 
                                value="no_emi"
                                class="text-green-600 focus:ring-green-500"
                                data-target="no-emi"
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
                            {{ old('is_active', $scheme->is_active ?? '') == 1 ? 'checked' : '' }}
                             checked
                        >
                        <span class="text-gray-700 capitalize">Yes</span>
                    </label>

                    <!-- No -->
                    <label class="flex items-center gap-2 space-x-2 p-2">
                        <input 
                            type="radio" 
                            name="is_active" 
                            value="0" 
                            class="text-green-600 focus:ring-green-500"
                            {{ old('is_active', $scheme->is_active ?? '') == 0 ? 'checked' : '' }}>
                        <span class="text-gray-700 capitalize">No</span>
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
                <a href="{{ route('vehical.schemes.index') }}"> BAck</a>
            </button>
        </div>
    </div>
    </form>
</div>
{{-- </div> --}}

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

<!-- Max loan amount and loan limit sub text massage -->
<script>
function numberToWords(num) {

    if (!num) return "";

    const a = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten",
        "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen",
        "Seventeen", "Eighteen", "Nineteen"
    ];
    const b = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];

    const convert = (n) => {
        if (n < 20) return a[n];
        if (n < 100) return b[Math.floor(n / 10)] + (n % 10 ? " " + a[n % 10] : "");
        if (n < 1000) return a[Math.floor(n / 100)] + " Hundred " + (n % 100 ? a[n % 100] : "");
        if (n < 100000) return convert(Math.floor(n / 1000)) + " Thousand " + (n % 1000 ? convert(n % 1000) : "");
        if (n < 10000000) return convert(Math.floor(n / 100000)) + " Lakh " + (n % 100000 ? convert(n % 100000) : "");
        return "";
    };

    return convert(num).trim();
}

function attachListener(inputId, outputId) {
    const input = document.getElementById(inputId);
    const output = document.getElementById(outputId);

    if (!input || !output) return;

    input.addEventListener("input", function() {
        const num = parseInt(this.value);
        output.textContent = num ? numberToWords(num) + " Only" : "";
    });
}

attachListener("maxLoanAmount", "maxLoanAmountWords");
attachListener("maxLoanLimit", "maxLoanLimitWords");
</script>

<!-- Stop Negative value -->
<script>
  function blockMinus(inputId) {
    const input = document.getElementById(inputId);

    // Keyboard se minus block 
    input.addEventListener("keydown", function(event) {
        if (event.key === "-" || event.key === "Minus") {
            event.preventDefault();
        }
    });

    // Copy-paste se minus remove 
    input.addEventListener("input", function() {
        this.value = this.value.replace(/-/g, "");
    });
}

blockMinus("maxLoanAmount");
blockMinus("maxLoanLimit");
</script>

@endsection