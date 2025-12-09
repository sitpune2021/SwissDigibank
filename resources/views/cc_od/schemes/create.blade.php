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
            <h1 class="text-xl font-semibold">{{ isset($scheme) ? 'Update CC / OD LIMIT APPLICATION' : 'NEW CC / OD LIMIT APPLICATION' }}</h1>
        </div>
    </div>
    
    <div class="box">
        <div class="col-span-12  lg:col-span-12">
            <form class="grid grid-cols-2 gap-4 mt-6" action="{{ isset($scheme) ? route('cc_od.schemes.update', $scheme->id) : route('cc_od.schemes.store') }}" method="POST">
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
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Maximum Credit Limit (₹)
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="maxLoanAmount" name="max_loan_amount" value="{{ old('max_loan_amount', $scheme->max_loan_amount ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="0.0" max="200000" >
                        <p id="maxLoanAmountWords" class="text-red-500 text-xs mt-1"></p>
                        <!-- Laravel Error Message -->
                        @error('max_loan_amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="tenure" class="md:text-lg font-medium block mb-4">
                        Max. Tenure <span class="text-red-500">*</span>
                    </label>
                    <select id="tenure" name="tenure"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                        >
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
                    <label for="gold_loan_setting" class="md:text-lg font-medium block mb-4">
                        Interest Payout Type <span class="text-red-500">*</span>
                    </label>

                    <select id="gold_loan_setting" name="gold_loan_setting" value="{{ old('gold_loan_setting', $scheme->gold_loan_setting ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3">
                        <option value="Monthly">Monthly</option>
                    </select>
                </div>

        </div>

           
        
        {{-- Active field Yes/No --}}
        <div class="w-full">
            <div class="mb-4">
                <label class="md:text-lg font-medium block mt-3 ">
                    Active <span class="text-red-600">*</span>
                </label>

                <div class="mt-1 flex flex-wrap gap-3">
                    <!-- Yes -->
                    <label class="flex items-center gap-2 p-2">
                        <input 
                            type="radio" 
                            name="is_active" 
                            value="1"
                            class="text-green-600 focus:ring-green-500"
                            {{ old('is_active', $scheme->is_active ?? '') == 1 ? 'checked' : '' }}>
                        <span class="text-gray-700 capitalize">Yes</span>
                    </label>

                    <!-- No -->
                    <label class="flex items-center gap-2 p-2">
                        <input 
                            type="radio" 
                            name="is_active" 
                            value="0"
                            class="text-green-600 focus:ring-green-500"
                            {{ old('is_active', $scheme->is_active ?? '') == 0 ? 'checked' : '' }}>
                        <span class="text-gray-700 capitalize">No</span>
                    </label>
                </div>

                @error('is_active')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>



        <!-- Buttons -->
        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
            <button type="submit"
                class="btn-primary uppercase justify-center">
                {{ isset($scheme) ? 'Update Scheme' : 'Create Scheme' }}
            </button>

            <button class="btn-outline uppercase justify-center" type="reset">
                <a href="{{route('cc_od.schemes.index')}}"> BAck</a>
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
   document.addEventListener("DOMContentLoaded", function () {

    function numberToWords(num) {
        const a = [
            '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
            'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen',
            'Eighteen', 'Nineteen'
        ];
        const b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

        if ((num = num.toString()).length > 9) return 'Overflow';

        let n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{3})$/);
        if (!n) return;

        let str = '';
        str += n[1] != 0 ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + ' Crore ' : '';
        str += n[2] != 0 ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + ' Lakh ' : '';
        str += n[3] != 0 ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + ' Thousand ' : '';
        str += n[4] != 0 ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + ' ' : '';
        return str.trim();
    }

    const maxLoanInput = document.getElementById("maxLoanAmount");
    const maxLoanWords = document.getElementById("maxLoanAmountWords");

    maxLoanInput.addEventListener("input", function () {
        const value = this.value;

        if (value && !isNaN(value)) {
            maxLoanWords.textContent = numberToWords(parseInt(value)) + " Rupees Only";
        } else {
            maxLoanWords.textContent = "";
        }
    });

});
</script>
@endsection