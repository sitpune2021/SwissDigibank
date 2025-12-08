@extends('layout.main')

@section('content')

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
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <div class="flex items-end gap-2">
                <h1 class="text-lg font-semibold uppercase">
                    Gold Loan

                    </h3>
                    <!-- <p>Pay Due EMIs</p> -->
            </div>
            <!-- <p class="text-gray-500">
                    <a href="#" class="text-gray-500">Gold Loans</a> >
                    <a href="#" class="text-gray-500">00063</a> >
                    <a href="#" class="text-gray-500">Pay Due EMIs</a>
                </p> -->
        </div>
    </div>
    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <!-- Left: Details -->
        <div class="w-full overflow-hidden">
            <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                <form action="{{ route('goldloan.payEmiLoan', $goldLoan->id) }}" method="POST" enctype="multipart/form-data">
                    <!-- Header -->
                    @csrf
                    <div class="px-4 py-3">
                        <h3 class="text-lg border-b font-semibold text-black">EMI DETAILS</h3>
                    </div>
                    <!-- Body -->
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4">
                            Remaining Due Amount (A)
                            <span class="text-error">*</span>
                        </label>

                        <input type="number" id="remaining_due" name="remaining_due" value="{{ $emiAmount ?? 0 }}"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0" readonly>
                        <x-number-to-word for="remaining_due_amount" />
                    </div>

                    <label for="previous_due" class="md:text-lg font-medium block ">
                        Previous Dues
                    </label>
                    <div class=" flex mb-2 overflow-x-auto">
                        <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                            <tbody>
                                <!-- Column Labels -->
                                <tr class="">
                                    <th class="text-center uppercase px-3 py-2 ">Overdue Interest(B)</th>
                                    <th class="text-center uppercase px-3 py-2 ">Other Charges (C)</th>

                                </tr>

                                <!-- Input Row -->
                                <tr class="">
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="overdueInterest" id="overdueInterest" placeholder="0.0" value="{{ $overdueInterest ?? 0 }}" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="otherCharges" id="otherCharges" placeholder="0.0" value="{{ $otherCharges ?? 0 }}" readonly
                                            class="w-full px-2 py-2 text-center  bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>

                    <label for="overdue_interest" class="md:text-lg font-medium block mt-4 ">
                        Overdue Interest (D)
                        <span class="text-error">*</span>
                    </label>
                    <div class=" flex mb-2 overflow-x-auto">
                        <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                            <tbody>
                                <!-- Column Labels -->
                                <tr class="">
                                    <th class="text-center uppercase px-3 py-2 ">Amount</th>
                                    <th class="text-center uppercase px-3 py-2 ">GST Rate (%) </th>
                                    <th class="text-center uppercase px-3 py-2 ">Total Amount</th>
                                </tr>

                                <!-- Input Row -->
                                <tr class="">
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="amount" value="{{ $overdueInterest ?? 0 }}" id="amount" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="gstRate" id="gstRate" value="{{ $gstRate ?? 0 }}" placeholder="0.0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <td class="px-2 py-2 ">
                                        <input type="text" name="totalAmount" id="totalAmount" value="{{ $totalOverdueWithGst ?? 0 }}" placeholder="0.0"
                                            class="w-full px-2 py-2 text-center border  rounded-10 text-sm md:text-base" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4">
                            Total Amount(F = A + B + C + D + E)
                            <span class="text-error">*</span>
                        </label>

                        <input type="number" id="t_Amount" name="t_Amount" value="{{ $emiAmount ?? 0 }}"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0" readonly>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4">
                            Rounding Off (G)
                            <span class="text-error">*</span>
                        </label>

                        <input type="number" id="rounding" name="rounding" value="{{ $rounding ?? 0 }}"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0" readonly>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4">
                            Net Amount to Collect (H = F - G)
                            <span class="text-error">*</span>
                        </label>

                        <input type="number" id="netAmount" name="netAmount" value="{{ $emiAmount ?? 0 }}"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0" readonly>
                        <x-number-to-word for="netAmount" />
                    </div>
                    <hr>


                    <div class="mt-4 mb-4">
                        <p id="noteMessage" class="text-error text-sm block mt-3 mb-4 hidden">
                            Note: If you are change transaction date then above data will be reflected according to the transaction date.
                        </p>
                        <label class="md:text-lg font-medium block mb-4">Transaction Date</label>
                        <div class="relative flex items-center">
                            <input type="text" name="transaction_date" class="datepicker-field w-full rounded-10 bg-secondary/5 dark:bg-bg3 border border-n30  dark:border-n500 border-gray-300 px-3 md:px-6 py-2 md:py-3" readonly>
                            <i class="las la-calendar absolute right-3 text-gray-500 cursor-pointer"></i>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="md:text-lg font-medium block mb-4">Amount Collected<span class="text-error">*</span></label>
                        <div class="relative flex items-center">
                            <input type="text" name="amount_collected"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" placeholder="Enter Amount">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="md:text-lg font-medium block mb-4">Remarks (if any)</label>
                        <div class="relative flex items-center">
                            <textarea name="remarks"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" placeholder="Enter Remarks (if any)"></textarea>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="md:text-lg font-medium block mb-4">
                            T. Receipt
                        </label>
                        <div class="relative flex items-center">
                            <input type="file" name="receipt"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        </div>
                    </div>

                    <div class="mt-3">
                                        <div class="flex grid col-span-1">
                                        <div class="flex gap-3">
                                             <label class="flex gap-2">
                                            <input type="radio" name="fee_mode" value="cash" checked> 
                                            <p>Cash</p>
                                            </label>
                                            <label class="flex gap-2">
                                            <input type="radio" name="fee_mode" value="cheque">
                                            <p>Cheque</p> 
                                            </label>
                                            <label class="flex gap-2">
                                            <input type="radio" name="fee_mode" value="online"> 
                                            <p>Online Transfer</p>
                                            </label>
                                        </div>
                                        <div class="flex gap-3 mt-3">
                                            <label class="flex gap-2">
                                            <input type="radio" name="fee_mode" value="saving"> 
                                            <p>Saving Account</p>
                                            </label>
                                        </div>

                                        </div>
                                        <!-- Fields for Cheque -->
                                        <div id="cheque_fields" style="display:none; margin-top:10px;">
                                            <label for="bank_id" class="block mb-2 text-sm font-medium">Select Bank</label>
                                            <select id="bank_id" name="bank_id"
                                                    class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                                    <option value="">-- Select Bank --</option>
                                                    @foreach($banks as $id => $name)
                                                        <option value="{{ $id }}">
                                                            {{ $name }}
                                                        </option>
                                                    @endforeach
                                            </select>
                                            <!-- Cheque No -->
                                            <div class="mt-3">
                                                <label class="block text-sm font-medium text-gray-700">Cheque No.</label>
                                                <input type="text" name="cheque_no"
                                                    class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3"
                                                    placeholder="Enter Cheque No">
                                            </div>

                                            <!-- Cheque Date -->
                                            <div class="mt-3">
                                                <label class="block text-sm font-medium text-gray-700">Cheque Date</label>
                                                <input type="text" id="cheque_date" name="cheque_date"
                                                value="{{ old('cheque_date', date('d-m-Y')) }}"
                                                    class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                            </div>
                                        </div>

                                        <!-- Fields for Online -->
                                        <div id="online_fields" style="display:none; margin-top:10px;">
                                            <div class="mt-3">
                                                <label class="block text-sm font-medium text-gray-700">
                                                    Transfer Date <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" id="transfer_date" name="transfer_date" 
                                                value="{{ old('transfer_date', date('d-m-Y')) }}"
                                                    class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">
                                                    UTR / Transaction No. <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" id="utr_no" name="utr_no" placeholder="Enter Transaction No."
                                                    class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">
                                                    Transfer Mode <span class="text-red-500">*</span>
                                                </label>
                                                <div class="flex gap-4 mt-2">
                                                    <label class="flex items-center gap-2">
                                                        <input type="radio" name="transfer_mode" value="imps">
                                                        <span>IMPS</span>
                                                    </label>
                                                    <label class="flex items-center gap-2">
                                                        <input type="radio" name="transfer_mode" value="vpa">
                                                        <span>VPA</span>
                                                    </label>
                                                    <label class="flex items-center gap-2">
                                                        <input type="radio" name="transfer_mode" value="neft_rtgs">
                                                        <span>NEFT/RTGS</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Fields for Saving Account -->
                                        <div id="saving_fields" style="display:none; margin-top:10px;">
                                            <label>Saving Account:</label>
                                            <select id="saving" name="saving"
                                                class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">

                                                <option value="">-- Select Saving Acc. --</option>

                                                @foreach ($savingAccounts as $acc)
                                                    <option value="{{ $acc }}">{{ $acc }}</option>
                                                @endforeach
                                            </select>
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
            <!--  Application Info -->
            <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg mb-4">
                <!-- Header -->
                <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                    <h3 class="text-black uppercase font-semibold text-lg">Gold Loan Account Info</h3>

                    <!-- Toggle Button -->
                    <button
                        class="p-1 rounded transition"
                        onclick="toggleSection(this)">
                        <span class="toggle-icon text-lg font-bold">+</span>
                    </button>

                </div>

                <!-- Content (Initially Hidden) -->
                <div class="overflow-x-auto p-4 hidden">
                    <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2 w-1/3">Loan No.</td>
                                <td class="px-3 py-2">{{$goldLoan->id??''}}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2 w-1/3">Member</td>
                                <td class="px-3 py-2">{{$goldLoan->member->member_no??''}} - {{$goldLoan->member->member_info_first_name??''}}</td>
                            </tr>

                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Open Date</td>
                                <td class="px-3 py-2">{{ \Carbon\Carbon::parse($goldLoan->application_date)->format('d-m-Y') }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Scheme</td>
                                <td class="px-3 py-2">{{$goldLoan->scheme->scheme_name??''}}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold  uppercase px-3 py-2">Loan Amount</td>
                                <td class="px-3 py-2"> ₹ {{$goldLoan->loan_amount??'0'}}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Current Debt</td>
                                <td class="px-3 py-2">{{ number_format($goldLoan->current_debt, 2) }}</td>
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
                                <td class="font-semibold  uppercase px-3 py-2">Status </td>
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

            <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg">
                <!-- Header -->
                <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                    <h3 class="text-black font-semibold  uppercase text-lg">EMIs Info</h3>

                    <!-- Toggle Button -->
                    <button
                        class="p-1 rounded transition"
                        onclick="toggleSection(this)">
                        <span class="toggle-icon text-lg font-bold">+</span>
                    </button>

                </div>

                <!-- Content (Initially Hidden) -->
                <div class="overflow-x-auto p-4 hidden">
                    <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 uppercase py-2 w-1/3">No. of EMIs</td>
                                <td class="px-3 py-2">000</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 uppercase py-2 w-1/3">PAID</td>
                                <td class="px-3 py-2">2</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 uppercase py-2">LEFT</td>
                                <td class="px-3 py-2">0</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 uppercase py-2">DUE</td>
                                <td class="px-3 py-2">0</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 uppercase py-2">OVER DUE</td>
                                <td class="px-3 py-2">0</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
</div>


<script>
document.querySelectorAll('input[name="fee_mode"]').forEach((elem) => {
  elem.addEventListener("change", function(event) {
    let value = event.target.value;

    // hide all first
    document.getElementById("cheque_fields").style.display = "none";
    document.getElementById("online_fields").style.display = "none";
    document.getElementById("saving_fields").style.display = "none";

    // show according to selection
    if (value === "cheque") {
      document.getElementById("cheque_fields").style.display = "block";
    } else if (value === "online") {
      document.getElementById("online_fields").style.display = "block";
    } else if (value === "saving") {
      document.getElementById("saving_fields").style.display = "block";
    }
  });
});
</script>


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
            const today = new Date();
            const yesterday = new Date();
            yesterday.setDate(today.getDate() - 1);

            const formattedToday = today.toLocaleDateString('en-GB').split('/').join('-');
            const formattedYesterday = yesterday.toLocaleDateString('en-GB').split('/').join('-');

            // Default fill today's date
            dateInput.value = formattedToday;

            // Init datepicker
            const picker = new Datepicker(dateInput, {
                autohide: true,
                format: 'dd-mm-yyyy',
                minDate: yesterday,
                maxDate: today
            });

            // Show calendar on icon click
            const calendarIcon = dateInput.parentElement.querySelector('.la-calendar');
            if (calendarIcon) {
                calendarIcon.addEventListener('click', () => picker.show());
            }

            // Correct way: listen on parent of input
            dateInput.parentElement.addEventListener('changeDate', function(e) {
                const selected = e.detail.date; // <-- get selected date
                const selectedFormatted = selected.toLocaleDateString('en-GB').split('/').join('-');
                const note = document.getElementById("noteMessage");

                if (selectedFormatted === formattedYesterday) {
                    note.classList.remove("hidden");
                } else {
                    note.classList.add("hidden");
                }
            });
        });
    });
</script>

@endsection