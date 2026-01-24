@extends('layout.main')

@section('content')
@php
$setting = $goldLoan->scheme->gold_loan_setting ?? '';
switch ($setting) {
case 'reducing_emi':
$settingLabel = 'Reducing Emi';
break;
case 'flat_advanced_interest':
$settingLabel = 'Flat Advanced Interest';
break;
case 'flat_emi':
$settingLabel = 'Flat Emi';
break;
case 'no_emi':
$settingLabel = 'No Emi';
break;
default:
$settingLabel = '';
}
@endphp

<head>
    <style>
        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;
            /* Modern browser support */
        }
    </style>
</head>
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <div class="flex items-center gap-2">
                <h3 class="text-lg font-semibold uppercase ">
                    Gold Loan Payment - 
                </h3> 
                <p class="text-gray-500 uppercase" >Pay</p>
            </div>
        </div>
    </div>
    
    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <!-- Left: Details -->
        <div class="w-full overflow-hidden">
            <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                <form action="{{ route('goldloan.payEmi') }}" method="POST">
                    @csrf
                    <input type="hidden" name="loan_id" value="{{$goldLoan->id}}">
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium uppercase block mb-4">
                            Transaction Date
                            <span class="text-error">*</span>
                        </label>

                        <input type="text" id="transaction_date" name="transaction_date"
                            class=" datepicker-field w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="DD/MM/YYYY">

                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium mt-4 uppercase block mb-4">
                            Current Debt (A)
                            <span class="text-error">*</span>
                        </label>
                        <input type="text" id="current_debt" name="current_debt" readonly value="{{ $currentDebt ?? 0 }}"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.00">
                        <x-number-to-word for="" />
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium uppercase block mb-4">
                            Total Amount to Payable (A + B)
                            <span class="text-error">*</span>
                        </label>

                        <input type="text" id="total_payable" name="total_payable" readonly value="{{$currentDebt??0}}"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.00">
                        <x-number-to-word for="" />
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium uppercase block mb-4">
                            Amount Collected
                            <span class="text-error">*</span>
                        </label>

                        <input type="number" id="amount_collected" name="amount_collected"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.00">
                        <x-number-to-word for="" />
                    </div>

                    <div class="mb-4">
                        <label class="md:text-lg font-medium uppercase block mb-4">
                            Remarks (if any)
                        </label>
                        <div class="relative flex items-center">
                            <textarea
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" placeholder="Enter Remarks (if any)"></textarea>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="md:text-lg font-medium uppercase block ">
                            Pay Mode
                            <span class="text-error">*</span>
                        </label>
                        <div class="relative flex items-center">
                            {{-- paymode here --}}
                        </div>
                    </div>

                    {{-- <x-paymode :mode_2="$misaccount->amount ?? '' " :showSaving="true" id="amount" :readonly="false"
                        :amountClass="true" :bgColor="false" :hiddenheading="false" :checkedDefault="'cash'"
                        groupName="disburse_Mode_two" :rdShowing="true" /> --}}

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
                                            $application->fee_mode ?? '') == 'online' ? 'checked' : '' }}> Online Tr.
                        </label>
                    </div>

                    <!-- Bank + Cheque Fields -->
                    <div id="bankDropdownWrapper" class="mt-3 hidden">

                        <label for="bank_id" class="block mb-2 text-sm font-medium">Select Bank</label>
                        <!-- <select id="bank_id" name="bank_id"
                            class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                            <option value="">-- Select Bank --</option>
                            @foreach($banks as $bank)
                            <option value="{{ $bank->id }}"
                                {{ old('bank_id', $application->bank_id ?? '') == $bank->id ? 'selected' : '' }}>
                                {{ $bank->name }}
                            </option>
                            @endforeach

                        </select> -->

                        <select id="bank_id" name="bank_id"
                            class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                            <option value="">-- Select Bank --</option>

                            @forelse($banks as $bank)
                            <option value="{{ $bank->id }}"
                                {{ old('bank_id', $application->bank_id ?? '') == $bank->id ? 'selected' : '' }}>
                                {{ $bank->name ?? $bank->bank_name ?? 'Unnamed Bank' }}
                            </option>
                            @empty
                            <option value="">No banks available</option>
                            @endforelse
                        </select>


                        <!-- Cheque No -->
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700">Cheque No.</label>
                            <input type="text" name="cheque_no"
                                class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="Enter Cheque No" value="  {{ old('cheque_no', $application->cheque_no ?? '') }}">
                        </div>

                        <!-- Cheque Date -->
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700">Cheque Date</label>
                            <input type="text" id="cheque_date" name="cheque_date" value="{{ old('cheque_date', $application->cheque_date ?? '') }}"
                                class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                        </div>
                    </div>

                    <!-- Online Transaction Fields -->
                    <div id="onlineFields" class="space-y-4 hidden">
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700 uppercase">
                                Transfer Date <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="transfer_date" name="transfer_date" value=" {{ old('transfer_date', $application->transfer_date ?? '') }} "
                                class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 uppercase">
                                UTR / Transaction No. <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="utr_no" name="utr_no" placeholder="Enter Transaction No."
                                value="{{ old('utr_no', $application->utr_no ?? '') }}"
                                class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 uppercase">
                                Transfer Mode <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4 mt-2">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="imps" {{
                                                    old('transfer_mode', $application->transfer_mode ?? '') == 'imps' ?
                                                'checked' : '' }}>
                                    <span>IMPS</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="vpa" {{
                                                    old('transfer_mode', $application->transfer_mode ?? '') == 'vpa' ?
                                                'checked' : '' }}>

                                    <span>VPA</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="neft_rtgs" {{
                                                    old('transfer_mode', $application->transfer_mode ?? '') == 'neft_rtgs' ?
                                                'checked' : '' }}>
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
                                    <input type="radio" name="credited" value="yes">
                                    <span>Yes</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="credited" value="no">
                                    <span>No</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                        <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                            PAY
                        </button>
                        <button class="btn-outline uppercase justify-center" type="reset">
                            <a href="{{ route('gold-loan.account.show', $goldLoan->id) }}"> BACK</a>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="w-full">
            <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg mb-4">
                <!-- Header -->
                <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                    <h3 class="text-black font-semibold uppercase text-lg">Gold Loan Account Info</h3>
                    <!-- Toggle Button -->
                    <button
                        class="p-1 rounded transition"
                        onclick="toggleSection(this)">
                        <span class="toggle-icon text-lg font-bold">+</span>
                    </button>
                </div>

                <!-- Content (Initially Hidden) -->
                <div class="overflow-x-auto p-4 ">
                    <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 uppercase py-2 w-1/3">Loan No.</td>
                                <td class="px-3 py-2">{{$goldLoan->id??''}}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3  uppercase py-2 w-1/3">Member</td>
                                <td class="px-3 py-2">{{$goldLoan->member->member_no??''}} - {{$goldLoan->member->member_info_first_name??''}}</td>
                            </tr>

                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Open Date</td>
                                <td class="px-3 py-2">{{ \Carbon\Carbon::parse($goldLoan->application_date)->format('d-m-Y') }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Scheme</td>
                                <td class="px-3 py-2">{{$goldLoan->scheme->scheme_name??''}} </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Loan Amount</td>
                                <td class="px-3 py-2"> ₹ {{$goldLoan->loan_amount??''}}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Current Debt</td>
                                <td class="px-3 py-2"></td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Annual Interest Rate</td>
                                <td class="px-3 py-2"> {{$goldLoan->scheme->annual_interest_rate??''}} %</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Interest Type</td>
                                <td class="px-3 py-2">
                                    {{$settingLabel }}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Tenure </td>
                                <td class="px-3 py-2">
                                    {{$goldLoan->tenure_value??''}} {{$goldLoan->tenure_type??''}}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Status</td>
                                <td class="px-3 py-2">
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                        ACTIVE
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    const totalAmount = document.getElementById("totalAmount");
    const amount = document.getElementById("amount");
    const netAmount = document.getElementById("netAmount");
    const t_Amount = document.getElementById("t_Amount");

    totalAmount.addEventListener("input", function() {
        const value = this.value;
        amount.value = value;
        netAmount.value = value;
        t_Amount.value = value;
    });


    function toggleSection(button) {
        const section = button.closest('.box').querySelector('.overflow-x-auto');
        const icon = button.querySelector('.toggle-icon');
        section.classList.toggle('hidden');
        icon.textContent = section.classList.contains('hidden') ? '+' : '−';
    }
</script>


<!-- Datepicker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

<!-- Datepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.datepicker-field').forEach(function(dateInput) {
            const picker = new Datepicker(dateInput, {
                autohide: true,
                format: 'dd-mm-yyyy',
                maxDate: new Date(),
            });

            if (!dateInput.value) {
                const today = new Date();
                const formattedDate = today.toLocaleDateString('en-GB').split('/').join('-');
                dateInput.value = formattedDate;
            }

            const calendarIcon = dateInput.parentElement.querySelector('.la-calendar');
            if (calendarIcon) {
                calendarIcon.addEventListener('click', () => picker.show());
            }
        });
    });
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
        let d = new Date();
        let day = String(d.getDate()).padStart(2, '0');
        let month = String(d.getMonth() + 1).padStart(2, '0');
        let year = d.getFullYear();

        let formatted = `${day}-${month}-${year}`;

        document.getElementById("cheque_date").value = formatted;
        document.getElementById("transfer_date").value = formatted;

    });

    document.addEventListener('DOMContentLoaded', function() {
        const debt = document.getElementById('current_debt');
        const other = document.getElementById('other_charges');
        const total = document.getElementById('total_payable');

        function calcTotal() {
            const a = parseFloat(debt.value) || 0;
            const b = parseFloat(other.value) || 0;
            total.value = (a + b).toFixed(2);
        }

        other.addEventListener('input', calcTotal);
        calcTotal(); // initial calculation
    });
</script>
@endsection