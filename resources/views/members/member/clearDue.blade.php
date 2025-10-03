@extends('layout.main')
@push('style')
    <style>
        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;
        }
    </style>
@endpush
@section('page-title',
    isset($member)
    ? 'Members - ' . $member->member_info_first_name . ' Transactions'
    : 'Members
    Transactions')

@section('content')

    <div class="main-inner">
        <div class="grid grid-cols-2 md:grid-cols-12 gap-6 p-6 min-h-screen">
            <div class="col-span-1 md:col-span-2 box dark:bg-bg3 rounded-10 p-6">
                <div>
                    <h3 class="text-xl font-semibold mb-4">CHARGES - CLEAR DUES</h3>
                    <hr class="mb-6 border-gray-300">
                </div>

                <form
                    action="{{ route('members.other-charges.clearDue.form', ['id' => $memberId, 'chargeId' => $chargeId]) }}"
                    method="POST" class="space-y-6">
                    @csrf

                    <!-- Charges / Penalty Due -->
                    <div class="w-full mt-4">
                        <label class="block font-medium mb-2" for="charges_due">
                            Charges / Penalty Due
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="flex flex-wrap gap-4">
                            <input type="number" name="charges_due" id="charges_due"
                                value="{{ old('charges_due', $totalChargesDue) }}"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="0.0" readonly>
                            @error('charges_due')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Waived Amount -->
                    <div class="w-full mt-4">
                        <label class="block font-medium mb-2" for="waived_amount">
                            Waived Amount
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="flex flex-wrap gap-4">
                            <input type="number" name="waived_amount" id="waived_amount"
                                value="{{ old('waived_amount', 0.0) }}"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="Enter Amount to Waived Off" required="required">
                            @error('waived_amount')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Amount / GST / Total Amount Table -->
                    <div>
                        <label class="block font-medium mt-3 mb-2">Amount <span class="text-red-500">*</span></label>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm rounded-lg overflow-hidden">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-2 py-2 text-center">Amount</th>
                                        <th class="px-2 py-2 text-center">GST Rate (%)</th>
                                        <th class="px-2 py-2 text-center">Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-2 py-2 border rounded-10 bg-secondary/5 text-center" id="amount">
                                            {{ number_format($totalChargesDue, 2) }}
                                        </td>
                                        <td class="px-2 py-2  border rounded-10 bg-secondary/5 text-center" id="gst_rate">
                                            {{ number_format($gstRate, 2) }}
                                        </td>
                                        <td class="border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3 text-center"
                                            id="total_amount">
                                            {{ number_format($totalChargesDue * (1 + $gstRate / 100), 2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Rounding Off -->
                    <div class="w-full mt-4">
                        <label class="block font-medium mb-2" for="rounding_off">
                            Rounding Off
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="flex flex-wrap gap-4">
                            <input type="number" name="rounding_off" id="rounding_off" value="{{ old('rounding_off', 0) }}"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="0.0" min="0" readonly>
                            @error('rounding_off')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Net Amount -->
                    <div class="w-full mt-4">
                        <label class="block font-medium mb-2" for="net_amount">
                            Net Amount
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="flex flex-wrap gap-4">
                            <input type="number" name="net_amount" id="net_amount"
                                value="{{ old('net_amount', $netAmount) }}"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="0.0" step="0.01" min="0" readonly>
                            <p><span id="net_amount_words"
                                    class="red-text text-error">{{ ucfirst($netAmountInWords ?? '') }}</span></p>

                            @error('net_amount')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Remarks -->
                    <div class="w-full mt-4">
                        <label class="block font-medium mb-2" for="clear_due_remarks">
                            Remarks (if any)
                        </label>
                        <div class="flex flex-wrap gap-4">
                            <textarea id="clear_due_remarks" name="clear_due_remarks"
                                class="w-full border bg-secondary/5 rounded-10 px-3 py-2 text-sm" placeholder="Enter Remarks (if any)">{{ old('clear_due_remarks') }}</textarea>
                            @error('clear_due_remarks')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Transaction Date -->
                    <div class="w-full mt-4">
                        <label class="block font-medium mb-2" for="transaction_date">
                            Transaction Date
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="flex flex-wrap gap-4">
                            <input type="text" name="transaction_date" id="date"
                                value="{{ old('transaction_date') }}"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="DD/MM/YYYY">
                            @error('transaction_date')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 mt-6 xl:mt-8 2xl:gap-6">
                        <div class="col-span-1 mt-4">
                            <label class="block font-medium mb-2">
                                Payment Mode <span class="text-red-500">*</span>
                            </label>

                            <!-- Payment Mode Radios -->
                            <div class="flex flex-wrap gap-4 mt-4">
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="radio" name="pay_mode" value="Cash"
                                        onclick="togglePaymentMode('Cash')" checked>
                                    <span>Cash</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="pay_mode" value="Online"
                                        onclick="togglePaymentMode('Online')">
                                    <span>Online Tr.</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="pay_mode" value="Cheque"
                                        onclick="togglePaymentMode('Cheque')">
                                    <span>Cheque</span>
                                </label>
                            </div>

                            <!-- Cash (no fields) -->
                            <div id="Cash" class="hidden"></div>

                            <!-- Online Transfer Fields -->
                            <div id="Online" class="hidden grid grid-cols-2 gap-4 xl:mt-8 2xl:gap-6 mt-4">
                                <!-- Transfer Date -->
                                <x-datepicker-disabled label="Transfer Date" name="transfer_date"
                                    value="{{ old('transfer_date') }}" inputId="transfer_date" />

                                <!-- UTR / Transaction No -->
                                <div class="col-span-2 md:col-span-1 mt-4">
                                    <label class="font-medium block mb-1">UTR / Transaction No <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="utr_no" placeholder="Enter UTR / Transaction No"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                    @error('utr_no')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
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
                                    @error('transfer_mode')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-span-2 md:col-span-1 mt-4">
                                    <label class="font-medium block mb-1">
                                        Credited in Company Account? <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex items-center gap-4 mt-1">
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="credited_in_account" value="1"
                                                {{ old('credited_in_account', $model->credited_in_account ?? '') == '1' ? 'checked' : '' }}>
                                            <span>Yes</span>
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="credited_in_account" value="0"
                                                {{ old('credited_in_account', $model->credited_in_account ?? '') == '0' ? 'checked' : '' }}>
                                            <span>No</span>
                                        </label>
                                    </div>
                                    @error('credited_in_account')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>


                            </div>

                            <!-- Cheque Fields -->
                            <div id="Cheque" class="hidden mt-2 flex flex-col md:flex-row flex-wrap gap-4 mt-4">
                                <div class="cheque-row flex flex-wrap justify-start gap-4">
                                    <div class="flex-center flex-1 min-w-[300px] max-w-full">
                                        <label class="font-medium block mb-1">Bank Name<span
                                                class="text-red-500">*</span></label>
                                        <x-searchable-dropdown :items="$banks" label="Select Bank" name="bank_id"
                                            display-field="name" value-field="id" event="Bank-selected"
                                            :selected="null" />
                                        @error('bank_id')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="flex-center flex-1 min-w-[300px] max-w-full">
                                        <label class="font-medium block mb-1">Cheque No<span
                                                class="text-red-500">*</span></label>
                                        <input type="text" placeholder="Enter Cheque No" name="cheque_no"
                                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                        @error('cheque_no')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <x-datepicker-disabled label="Cheque Date" name="cheque_date"
                                        value="{{ old('cheque_date') }}" inputId="cheque_date" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-center gap-3 space-x-4 pt-6">
                        <button type="submit" class="btn-primary">
                            CLEAR DUE
                        </button>

                        <a href="{{ url()->previous() }}" class="btn-outline inline-flex items-center justify-center">
                            Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const chargesDue = parseFloat(document.getElementById('charges_due').value);
            const gstRate = 18;
            const waivedInput = document.getElementById('waived_amount');
            const roundingInput = document.getElementById('rounding_off');
            const amountTd = document.getElementById('amount');
            const totalAmountTd = document.getElementById('total_amount');
            const netAmountInput = document.getElementById('net_amount');
            const netAmountWords = document.getElementById('net_amount_words');

            // Function to convert number to words
            function numberToWords(num) {
                const a = [
                    '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
                    'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen',
                    'Seventeen', 'Eighteen', 'Nineteen'
                ];
                const b = [
                    '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'
                ];

                function inWords(n) {
                    if (n < 20) return a[n];
                    if (n < 100) return b[Math.floor(n / 10)] + (n % 10 ? ' ' + a[n % 10] : '');
                    if (n < 1000) return a[Math.floor(n / 100)] + ' Hundred' + (n % 100 ? ' ' + inWords(n % 100) :
                        '');
                    return '';
                }

                if (num === 0) return 'Zero Only';

                let crore = Math.floor(num / 10000000);
                let lakh = Math.floor((num % 10000000) / 100000);
                let thousand = Math.floor((num % 100000) / 1000);
                let hundred = Math.floor((num % 1000));

                let result = '';
                if (crore > 0) result += inWords(crore) + ' Crore ';
                if (lakh > 0) result += inWords(lakh) + ' Lakh ';
                if (thousand > 0) result += inWords(thousand) + ' Thousand ';
                if (hundred > 0) result += inWords(hundred);

                return result.trim() + ' Only';
            }

            // Calculate the net amount
            function calculate() {
                let waived = parseFloat(waivedInput.value) || 0;
                let rounding = parseInt(roundingInput.value) || 0;

                if (waived >= chargesDue) {
                    alert("Waived amount can't be greater than or equal to Charges Due.");
                    waivedInput.value = "";
                    amountTd.textContent = (chargesDue).toFixed(2);
                    totalAmountTd.textContent = '';
                    netAmountInput.value = '';
                    netAmountWords.textContent = '';
                    return;
                }

                let amount = chargesDue - waived;
                amountTd.textContent = amount.toFixed(2);

                let gstAmount = amount * (gstRate / 100);
                let totalAmount = amount + gstAmount;

                let totalAmountRounded = Math.ceil(totalAmount);
                totalAmountTd.textContent = totalAmountRounded.toFixed(2);

                let netAmount = totalAmountRounded + rounding;
                netAmountInput.value = netAmount.toFixed(0);

                // Convert Net Amount to words
                let netAmountWordsText = numberToWords(netAmount);
                netAmountWords.textContent = netAmountWordsText;
            }

            waivedInput.addEventListener('input', calculate);
            roundingInput.addEventListener('input', calculate);

            calculate(); // Initial calculation
        });
    </script>

    <script>
        function togglePaymentMode(type) {
            // Hide all sections first
            const sections = ['Cash', 'Online', 'Cheque'];
            sections.forEach(id => {
                document.getElementById(id).classList.add('hidden');
            });

            // Show the selected section based on payment mode
            const selectedSection = document.getElementById(type);
            if (selectedSection) {
                selectedSection.classList.remove('hidden');
            }
        }

        // Initialize the visibility on page load for the default selected payment mode
        window.addEventListener('DOMContentLoaded', function() {
            const selectedMode = document.querySelector('input[name="pay_mode"]:checked')?.value;
            if (selectedMode) {
                togglePaymentMode(selectedMode);
            }
        });
    </script>
@endsection
