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
    ? 'Members - ' .
    ($member->member_info_first_name ?? $member->member_code) .
    '
    Transactions'
    : 'Members Transactions')

@section('content')
    <div class="main-inner">
        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="bg-white dark:bg-bg3 shadow-md rounded-2xl p-6 w-full max-w-2xl mx-auto">
            <!-- Title -->
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-6">

                Share Amount Collected
            </h2>

            <!-- Form -->
            <form action="{{ route('members.transactions.share-amount.store', ['id' => $member->id]) }}" method="POST">

                @csrf

                <!-- Transaction Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">

                        Transaction Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="transaction_date" value="{{ now()->format('Y-m-d') }}"
                        class="w-full rounded-10 border border-n30 dark:border-n500 px-3 py-2 bg-secondary/5 dark:bg-bg3 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-primary focus:outline-none">
                </div>

                <!-- Share Amount -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">

                        Share Amount <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.01" name="membership_fee" placeholder="Enter Share Amount"
                        class="w-full rounded-10 border border-n30 dark:border-n500 px-3 py-2 bg-secondary/5 dark:bg-bg3 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-primary focus:outline-none">
                </div>

                <!-- Remarks -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">

                        Remarks (if any)
                    </label>
                    <input type="text" name="remarks" placeholder="Enter Remarks"
                        class="w-full rounded-10 border border-n30 dark:border-n500 px-3 py-2 bg-secondary/5 dark:bg-bg3 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-primary focus:outline-none">
                </div>

                <!-- Pay Mode -->
                <!-- Pay Mode -->
                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Pay Mode <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2 flex flex-wrap gap-4 text-sm text-gray-700 dark:text-gray-300">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="charges_pay_mode" value="cash" class="text-green-600" checked>
                            Cash
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="charges_pay_mode" value="online" class="text-green-600"> Online
                            Tr.
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="charges_pay_mode" value="cheque" class="text-green-600"> Cheque
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="charges_pay_mode" value="saving" class="text-green-600"> Saving
                            Ac.
                        </label>
                    </div>
                    @error('payment_mode')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Online Fields -->
                <div id="onlineFields" class="space-y-4 mt-2 hidden">
                    <label class="block text-sm font-medium text-gray-700">Transfer Date <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="transfer_date" id="date2"
                        class="w-full border rounded-10 px-3 py-3 bg-secondary/5">

                    @error('transfer_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    <label class="block text-sm font-medium text-gray-700">
                        UTR / Transaction No.
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="online_utr_no" class="w-full border rounded-10 px-3 py-3 bg-secondary/5"
                        placeholder="Enter UTR/Transaction No.">
                    @error('online_utr_no')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    <label class="block text-sm font-medium text-gray-700">
                        Transfer Mode
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="flex gap-3">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="transfer_mode" value="IMPS" class="text-green-600"> IMPS
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="transfer_mode" value="VPA" class="text-green-600"> VPA
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="transfer_mode" value="NEFT/RTGS" class=""> NEFT/RTGS
                        </label>
                        @error('transfer_mode')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <!-- Cheque Fields -->
                <div id="chequeFields" class="space-y-4 mt-2 hidden">
                    <label class="block text-sm font-medium text-gray-700">Bank Name <span
                            class="text-red-500">*</span></label>
                    <select name="bank_id" class="w-full border rounded-10 px-3 py-3 bg-secondary/5">
                        <option value="">Select Bank</option>
                    </select>
                    @error('bank_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                    <label class="block text-sm font-medium text-gray-700">Cheque No. <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="cheque_no" class="w-full border rounded-10 px-3 py-3 bg-secondary/5"
                        placeholder="Enter Cheque No.">
                    @error('cheque_no')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                    <label class="block text-sm font-medium text-gray-700">Cheque Date <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="date3" name="cheque_date" placeholder="DD/MM/YYYY"
                        class="w-full border rounded-10 px-3 py-3 bg-secondary/5">
                    @error('cheque_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Saving Fields -->
                <div id="savingFields" class="space-y-4 mt-2 hidden">
                    <label class="block text-sm font-medium text-gray-700">Select Saving Account <span
                            class="text-red-500">*</span></label>
                    <select id="savingAccountSelect" name="saving_account_id"
                        class="w-full border rounded-10 px-3 py-3 bg-secondary/5">
                        <option value="">Select Account</option>
                    </select>
                    @error('saving_account_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-4">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg  font-medium">

                        SAVE
                    </button>
                    <a href="{{ url()->previous() }}"
                        class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg  font-medium">

                        CANCEL
                    </a>
                </div>
            </form>
        </div>
    @endsection
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const chequeFields = document.getElementById("chequeFields");
            const onlineFields = document.getElementById("onlineFields");
            const savingFields = document.getElementById("savingFields");

            function hideAllFields() {
                chequeFields.classList.add("hidden");
                onlineFields.classList.add("hidden");
                savingFields.classList.add("hidden");
            }

            const radios = document.querySelectorAll("input[name='charges_pay_mode']");
            radios.forEach(radio => {
                radio.addEventListener("change", function() {
                    hideAllFields();
                    switch (this.value) {
                        case "cheque":
                            chequeFields.classList.remove("hidden");
                            break;
                        case "online":
                            onlineFields.classList.remove("hidden");
                            break;
                        case "saving":
                            savingFields.classList.remove("hidden");
                            break;
                            // default is "cash" — keep all hidden
                    }
                });
            });

            // Trigger correct section on page load
            const selectedRadio = document.querySelector("input[name='charges_pay_mode']:checked");
            if (selectedRadio) {
                selectedRadio.dispatchEvent(new Event("change"));
            }
        });
    </script>
