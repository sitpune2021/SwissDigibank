@extends('layout.main')
@section('page-title',
    isset($member)
    ? 'Members - ' . $member->member_info_first_name . ' Transactions'
    : 'Members
    Transactions')

    <head>
        <style>
            input[type="radio"] {

                width: 24px !important;

                height: 24px !important;

                accent-color: green !important;

            }
        </style>
    </head>
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
                                    @php
                                        $totalAmount = 0;
                                        $totalCharges = 0;
                                        $gstRate = 18; // Assuming GST is 18% for all charges, adjust if dynamic
                                    @endphp

                                    @foreach ($dueCharges as $charge)
                                        @php
                                            $totalCharges += $charge->charges;
                                            $totalAmount += $charge->charges * (1 + $charge->gst_rate / 100);
                                        @endphp
                                    @endforeach

                                    <!-- Single row for total amount -->
                                    <tr>
                                        <td class="px-2 py-2 border rounded-10 bg-secondary/5 text-center">
                                            {{ number_format($totalCharges, 2) }}</td>
                                        <td class="px-2 py-2  border rounded-10 bg-secondary/5 text-center">
                                            {{ number_format($gstRate, 2) }}</td>
                                        <td
                                            class="border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3 text-center">
                                            {{ number_format($totalAmount, 2) }}</td>
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
                            <input type="number" name="rounding_off" id="rounding_off" value="{{ old('rounding_off') }}"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="0.0">
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

                    <!-- Pay Mode -->
                    <div class="w-full">
                        <div class="mb-4" id="intersetTypeRadio">
                            <label class="block font-medium mt-3" for="pay_mode">
                                Pay Mode
                                <span class="text-red-500">*</span>
                            </label>
                            <x-paymode :showSaving="false" id="pay_mode" :readonly="false" :amountClass="true"
                                :bgColor="false" :hiddenheading="true" :hiddensubhead="true" />
                            @error('pay_mode')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-center gap-3 space-x-4 pt-6">
                        <button type="submit" class="btn-primary rounded-10">
                            CLEAR DUE
                        </button>
                        <a href="#" class="btn-outline rounded-10">
                            CANCEL
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
