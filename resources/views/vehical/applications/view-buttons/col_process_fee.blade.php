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
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-lg font-semibold capitalize">Vehical Processing Fee</h1>
        </div>
    </div>
    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <!-- Left: Details -->
        <div class="w-full overflow-hidden">
            <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                <form action="{{ route('vehical.col_process_fee.store', $application->id) }}" method="POST">
                    @csrf

                    <input type="hidden" name="value" value="0">
                    <input type="hidden" name="gst_percent" value="18.0">
                    <input type="hidden" name="sgst" value="0">
                    <input type="hidden" name="cgst" value="0">
                    <input type="hidden" name="igst" value="0">

                    <!-- Header -->
                    <div class="px-4 py-3">
                        <h3 class="text-lg border-b font-semibold text-black">COLLECT ADVANCE PROCESSING FEE</h3>
                    </div>
                    <!-- Body -->
                    <div class=" flex p-4 overflow-x-auto">
                        <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                            <tbody>
                                <tr>
                                    <th class="text-center px-3 py-2">Value</th>
                                    <th class="text-center px-3 py-2">GST (%)</th>
                                    <th class="text-center px-3 py-2">SGST</th>
                                    <th class="text-center px-3 py-2">CGST</th>
                                    <th class="text-center px-3 py-2">IGST</th>
                                    <th class="text-center px-3 py-2">Total</th>
                                </tr>

                                @php
                                    // First define all needed values
                                    $inclAmount = $application->processing_fee;
                                    $baseAmount = round($inclAmount / 1.18, 2);
                                    $gstPercent = 18;

                                    $sgst = round($baseAmount * 0.09, 2);
                                    $cgst = round($baseAmount * 0.09, 2);
                                    $igst = 0; 
                                    $total = round($baseAmount + $sgst + $cgst + $igst, 2);
                                @endphp

                                <tr>
                                    <!-- Value -->
                                    <td class="px-2 py-2">
                                        <input type="text" value="{{ number_format($baseAmount, 2) }}" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- GST (%) -->
                                    <td class="px-2 py-2">
                                        <input type="text" value="18.0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- SGST -->
                                    <td class="px-2 py-2">
                                        <input type="text" value="{{ $sgst }}" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- CGST -->
                                    <td class="px-2 py-2">
                                        <input type="text" value="{{ $cgst }}" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- IGST -->
                                    <td class="px-2 py-2">
                                        <input type="text" value="{{ $igst }}" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border rounded-10 text-sm md:text-base" />
                                    </td>

                                    <!-- Total -->
                                    <td class="px-2 py-2">
                                        <input type="number" name="total" value="{{ $total }}" readonly
                                            class="w-full px-2 py-2 text-center border rounded-10 text-sm md:text-base" />
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>

                    <label for="" class="md:text-lg font-medium block mt-3 mb-4">
                            Pay Mode :</label>
                            <!-- Radio Buttons -->
                            <div class="mt-3">
                                <!-- Pay Mode -->
                                <label class="mr-4">
                                    <input type="radio" name="fee_mode" value="cash"
                                        {{ old('fee_mode', $application->fee_mode ?? 'cash') == 'cash' ? 'checked' : '' }}> Cash
                                </label>
                                <label class="mr-4">
                                    <input type="radio" name="fee_mode" value="cheque"
                                        {{ old('fee_mode', $application->fee_mode ?? '') == 'cheque' ? 'checked' : '' }}> Cheque
                                </label>
                                <label>
                                    <input type="radio" name="fee_mode" value="online"
                                        {{ old('fee_mode', $application->fee_mode ?? '') == 'online' ? 'checked' : '' }}> Online Tr.
                                </label>
                            </div>

                            <!-- Bank + Cheque Fields -->
                            <div id="bankDropdownWrapper" class="mt-3 hidden">
                                <label for="bank_id" class="block mb-2 text-sm font-medium">Select Bank</label>
                               <select id="bank_id" name="bank_id"
                                    class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                    <option value="">-- Select Bank --</option>
                                    @foreach($banks as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ old('bank_id', $application->bank_id ?? '') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Cheque No -->
                                <div class="mt-3">
                                    <label class="block text-sm font-medium text-gray-700">Cheque No.</label>
                                    <input type="text" name="cheque_no"
                                        class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3"
                                        placeholder="Enter Cheque No" value="{{ old('cheque_no', $application->cheque_no ?? '') }}">
                                </div>

                                <!-- Cheque Date -->
                                <div class="mt-3">
                                    <label class="block text-sm font-medium text-gray-700">Cheque Date</label>
                                    <input type="date" id="cheque_date" name="cheque_date" value="{{ old('cheque_date', $application->cheque_date ?? '') }}"
                                        class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                </div>
                            </div>

                            <!-- Online Transaction Fields -->
                            <div id="onlineFields" class="space-y-4 hidden">
                                <div class="mt-3">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Transfer Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="transfer_date" name="transfer_date" value="{{ old('transfer_date', $application->transfer_date ?? '') }}"
                                        class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        UTR / Transaction No. <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="utr_no" name="utr_no" placeholder="Enter Transaction No." value="{{ old('utr_no', $application->utr_no ?? '') }}"
                                        class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Transfer Mode <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex gap-4 mt-2">
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="transfer_mode" value="imps"
                                                {{ old('transfer_mode', $application->transfer_mode ?? '') == 'imps' ? 'checked' : '' }}>
                                            <span>IMPS</span>
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="transfer_mode" value="vpa"
                                                {{ old('transfer_mode', $application->transfer_mode ?? '') == 'vpa' ? 'checked' : '' }}>

                                            <span>VPA</span>
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="transfer_mode" value="neft_rtgs"
                                                {{ old('transfer_mode', $application->transfer_mode ?? '') == 'neft_rtgs' ? 'checked' : '' }}>
                                            <span>NEFT/RTGS</span>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Credited in Company Account <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex gap-4 mt-2">
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="credited" value="yes"
                                                {{ old('credited', $application->credited ?? '') == 'yes' ? 'checked' : '' }}>
                                            <span>Yes</span>
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="credited" value="no"
                                                {{ old('credited', $application->credited ?? '') == 'no' ? 'checked' : '' }}>
                                            <span>No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        
                        <p for="" class=" text-error text-sm block mt-3 mb-4">
                            Note: If you wish to collect processing fee at the time of disbursement, then enter 0. Fees
                            will be calculated accordingly.
                        </p>

                    <!-- Buttons -->
                    <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                        <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                            Update
                        </button>

                        <button class="btn-outline uppercase justify-center" type="reset">
                            <a href="{{ route('vehical.applications.view', $application->id) }}"> BACK</a>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="w-full">
            <!--  Application Info -->
            <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg">
                <!-- Header -->
                <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                    <h3 class="text-black font-semibold text-lg">Mortgage Application Info</h3>

                    <!-- Toggle Button -->
                    <button
                        class="p-1 rounded transition"
                        onclick="toggleSection(this)">
                        <span class="toggle-icon text-lg font-bold">+</span>
                    </button>

                </div>

                <!-- Content (Initially Hidden) -->
                <div class="overflow-x-auto p-4 hidden">
                   <table class="w-full border-collapse rounded-lg overflow-hidden  bg-white dark:bg-bg3">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">
                                    Branch
                                </td>
                                <td class="px-4 py-2 text-right md:text-left uppercase">
                                    {{ $application->branch->branch_name ?? 'N/A' }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Amount Requested</td>
                                <td class="px-4 py-2 text-right md:text-left">₹ {{ $application->net_loan_amount }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Amount Approvable
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    ₹ {{ $application->approved_loan_amount }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Annual Interest Rate
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ $application->scheme->annual_interest_rate }} %
                                </td>
                            </tr>
                             <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                   EMI Payout
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    MONTHLY
                                </td>
                            </tr>
                             <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                   No. of EMIs
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ $application->scheme->tenure }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                   Credit Period
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ $application->credit_period }} Days
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    Total Amount to Recover
                                </td>
                                <td class="px-4 py-2  text-right md:text-left">
                                   ₹ {{ $application->total_recovered_amount }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    Processing Fee
                                </td>
                                <td class="px-4 py-2   text-right md:text-left">
                                    ₹ {{ $application->scheme->processing_fee }} (Incl. 18 % GST)
                                </td>
                            </tr>                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- collapsed logic + - button-->
<script>
    function toggleSection(button) {
        const section = button.closest('.box').querySelector('.overflow-x-auto');
        const icon = button.querySelector('.toggle-icon');
        section.classList.toggle('hidden');
        icon.textContent = section.classList.contains('hidden') ? '+' : '−';
    }
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
    let today = new Date().toISOString().split('T')[0];
    document.getElementById("cheque_date").value = today;
    document.getElementById("transfer_date").value = today;
});
</script>

@endsection