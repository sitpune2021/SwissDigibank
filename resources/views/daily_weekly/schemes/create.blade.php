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
            <h1 class="text-xl font-semibold">New DAILY WEEKLY LOAN SCHEME</h1>
        </div>
    </div>
    
    <div class="box">
        <div class="col-span-12  lg:col-span-12">
            <form class="grid grid-cols-2 gap-4 mt-6" action="{{ isset($scheme) ? route('daily_weekly.schemes.update', $scheme->id) : route('daily_weekly.schemes.store') }}" method="POST">
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
                        Loan Amount (₹)
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
                    <label for="gold_loan_setting" class="md:text-lg font-medium block mb-4">
                        EMI Collection <span class="text-red-500">*</span>
                    </label>

                    <select id="gold_loan_setting" name="gold_loan_setting"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3">

                        @php
                            $selectedValue = old('gold_loan_setting', $scheme->gold_loan_setting ?? '');
                        @endphp

                        <option value="">Select EMI Collection</option>
                        <option value="daily"      {{ $selectedValue == 'daily' ? 'selected' : '' }}>DAILY</option>
                        <option value="weekly"     {{ $selectedValue == 'weekly' ? 'selected' : '' }}>WEEKLY</option>
                        <option value="bi_weekly"  {{ $selectedValue == 'bi_weekly' ? 'selected' : '' }}>BI WEEKLY</option>
                        <option value="4_weekly"   {{ $selectedValue == '4_weekly' ? 'selected' : '' }}>4 WEEKLY</option>
                        <option value="Monthaly"   {{ $selectedValue == 'Monthly' ? 'selected' : '' }}>MONTHALY</option>
                    </select>

                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        No of EMIs
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="no_of_emi" name="no_of_emi" value="{{ old('no_of_emi', $scheme->no_of_emi ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter No of EMIs" >
                    @error('no_of_emi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror                      
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        EMI Amount 
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="emi_amount" name="emi_amount" value="{{ old('emi_amount', $scheme->emi_amount ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter EMI Amount" >
                    @error('emi_amount')
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
                    <div class="flex items-center gap-2">
                        <!-- Left Select -->
                        <select name="overdue_type" id="overdue_type"
                            class="w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">
                            <option value="">Select Type</option>
                            <option value="TYPE_1" {{ old('overdue_type', $scheme->overdue_type ?? '') == 'TYPE_1' ? 'selected' : '' }}>TYPE_1</option>
                            <option value="TYPE_2" {{ old('overdue_type', $scheme->overdue_type ?? '') == 'TYPE_2' ? 'selected' : '' }}>TYPE_2</option>
                        </select>
                        <!-- Main Input -->
                        <input type="number" id="overdue_rate" name="overdue_rate" value="{{ old('overdue_rate', $scheme->overdue_rate ?? '') }}"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                            placeholder="Enter Penalty Charges ">
                        @error('overdue_rate')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror 
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
        
                            <!-- Main Input -->
                            <input type="number" id="fore_closer_charge" name="fore_closer_charge" value="{{ old('fore_closer_charge', $scheme->fore_closer_charge ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                                placeholder="Enter Fore Closure Charges">
                        </div>
                    </div>
                </div> 
                <div class="col-span-2 md:col-span-1">
                    <div class="col-sm-7">
                        <label for="" class="md:text-lg font-medium block mb-4">
                            Fitness Fee
                        </label>
                        <div class="flex items-center gap-2">
                            <!-- Left Select -->     
                            <!-- Main Input -->
                            <input type="number" id="fitness_fee" name="fitness_fee" value="{{ old('fitness_fee', $scheme->fitness_fee ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                                placeholder="Enter Fore Closure Charges">
                        </div>
                    </div>
                </div>     
                <div class="col-span-2 md:col-span-1">
                    <div class="col-sm-7">
                        <label for="" class="md:text-lg font-medium block mb-4">
                            Credit Period
                        </label>
                        <div class="flex items-center gap-2">
                            <!-- Left Select -->        
                            <!-- Main Input -->
                            <input type="number" id="credit_period" name="credit_period" value="{{ old('credit_period', $scheme->credit_period ?? '1') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                                placeholder="Enter Fore Closure Charges">
                        </div>
                    </div>
                </div>                  

                {{-- Active field Yes/No --}}
                <div class="col-span-2 md:col-span-1">
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
                        {{ old('is_active', $scheme->is_active ?? '') == 1 ? 'checked' : '' }}>Yes
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
                        @error('is_active')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
       

        </div>

           
        

        {{-- Charges Per EMI Inputs --}}
        <div id="" >
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

                <!-- SMS Charges (if any)Block -->
                <div class=" col-span-2 md:col-span-1 ">
                    <label class="md:text-lg font-medium mb-2">
                        SMS Charges (if any)
                    </label>

                    <div class="flex items-center gap-2 w-full mt-2">
                        <select name="" id=""
                            class="w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-4 py-2 md:py-3">
                            <option class="uppercase" value="">Fixed</option>
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
                        </select>
                        <input type="number" name="collection" value="{{ old('collection', $scheme->collection ?? '') }}" id="collection"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Collection Charges">
                    </div>
                </div>

            </div>

        </div>


        <!-- Buttons -->
        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
            <button type="submit"
                class="btn-primary uppercase justify-center">
                {{ isset($scheme) ? 'Update Scheme' : 'Create Scheme' }}
            </button>

            <button class="btn-outline uppercase justify-center" type="reset">
                <a href="{{route('daily_weekly.schemes.index')}}">BACK</a>
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