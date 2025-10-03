@extends('layout.main')

@section('page-title', isset($member) ? 'MEMBERS - ' . $member->member_info_first_name . ' TRANSACTIONS' : 'MEMBERS
    TRANSACTIONS')

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
                        <label class="block font-medium mb-2 uppercase" for="charges_due">
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
                        <label class="block font-medium mb-2 uppercase" for="waived_amount">
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
                        <label class="block font-medium mt-3 mb-2 uppercase">Amount <span class="text-red-500">*</span></label>
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
                        <label class="block font-medium mb-2 uppercase" for="rounding_off">
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
                        <label class="block font-medium mb-2 uppercase" for="net_amount">
                            Net Amount
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="flex flex-wrap gap-4">
                            <input type="number" name="net_amount" id="net_amount"
                                value="{{ old('net_amount', $netAmount) }}"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="0.0" step="0.01" min="0" readonly>
                        <p><span id="net_amount_words" class="red-text text-error" >{{ ucfirst($netAmountInWords ?? '') }}</span></p>

                            @error('net_amount')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Remarks -->
                    <div class="w-full mt-4">
                        <label class="block font-medium mb-2 uppercase" for="clear_due_remarks">
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
                        <label class="block font-medium mb-2 uppercase" for="transaction_date">
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

                    <!-- Pay Mode -->
                    <div class="w-full">
                        <label class="block font-medium mt-3 uppercase" for="pay_mode">
                            Pay Mode
                            <span class="text-red-500">*</span>
                        </label>
                        <x-paymode :showSaving="false" id="pay_mode" :readonly="false" :amountClass="true" :bgColor="false"
                            :hiddenheading="true" :hiddensubhead="true" />

                        @error('pay_mode')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
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
                '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
                'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
            ];
            const b = [
                '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'
            ];
            const n = ('000000000' + num).substr(-9).match(/^(\d{3})(\d{3})(\d{3})$/);
            if (!n) return;
            const str = (
                (n[1] != 0 ? a[+n[1]] + ' Hundred ' : '') +
                (n[2] != 0 ? (n[2] < 20 ? a[+n[2]] : b[+n[2][0]] + ' ' + a[+n[2][1]]) + ' ' : '') +
                (n[3] != 0 ? (n[3] < 20 ? a[+n[3]] : b[+n[3][0]] + ' ' + a[+n[3][1]]) + ' ' : '')
            ).replace(/\s+/g, ' ').trim();
            return str + ' Only';
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

@endsection
