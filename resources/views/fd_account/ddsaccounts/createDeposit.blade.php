@extends('layout.main')
@section('content')
    <style>
        .custom-thead {
            background-color: #e6f4ea;
            color: #14532d;
        }

        .custom-thead th {
            font-weight: 600;
            border-bottom: 1px solid #ccc;
        }

        @media (prefers-color-scheme: dark) {
            .custom-thead {
                background-color: #14532d;
                color: #d1fae5;
            }
        }

        input[type="checkbox"] {
            width: 28px;
            height: 28px;
            accent-color: green;
        }

        input[type="checkbox"]:checked {
            background-color: green;
            border: none;
        }

        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;
        }

        .tableWidth {
            width: 90%;
            margin: auto;
        }

        .bg-yellow {
            background-color: #F1BA07;
        }
    </style>
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col gap-2">
                <div class="flex items-center gap-3 ">
                    <h1 class="text-2xl font-semibold dark:text-white">DD - {{ $ddAccount->id }}</h1>
                </div>
            </div>
        </div>
        <!-- Table -->
        <div class=" dark:bg-bg3 mt-5 shadow rounded-lg overflow-hidden">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Deposit Form -->
                <div class=" w-full box dark:bg-bg3 shadow rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:bg-bg3 dark:text-white uppercase ">DEPOSIT</h3>
                    <hr class="my-4 border-gray-300 dark:border-gray-700">

                    <form class="space-y-6" action="{{ route('ddsaccounts.deposit', $ddAccount->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                    
                        <!-- Member Signature -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer's
                                Sign</label>
                            <div class=" text-gray-600 dark:text-gray-400 text-sm">
                                No Signature Present <br> (Upload in Customer Documents)
                            </div>
                        </div>

                        <!-- Member Photo -->
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer's
                                Photo</label>
                            <div class=" text-gray-600 dark:text-gray-400 text-sm">
                                No Photo Present <br> (Upload in Customer Documents)
                            </div>
                        </div>

                        <!-- Collected By -->
                        <div class="mt-3">
                            <label class="block text-sm font-medium dark:bg-bg3 uppercase">Collected By</label>
                            <select name="collected_by"
                                class="w-full rounded-10 border bg-secondary/5 border-gray-300 dark:bg-bg3 px-3 py-3 text-sm">
                                <option value="">Select Advisor / Staff</option>
                                {{-- Example options (replace with dynamic data) --}}
                                <option value="staff_1">Staff 1</option>
                                <option value="staff_2">Staff 2</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">
                                Amount to Deposit <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="amount" id="amount" placeholder="Enter Amount to Deposit"
                                class="w-full rounded-10 border bg-secondary/5 border-gray-300 dark:bg-bg3 px-3 py-3 text-sm"
                                min="{{ $ddAccount->dd_amount }}" required>
                            <x-number-to-word for="amount" />

                            <span id="balanceError" class="text-red-500 hidden">
                                Amount can't be less than the DDS installment amount.
                            </span>
                        </div>

                        @error('amount')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:bg-bg3  mt-3 uppercase">Remarks (if
                                any)</label>
                            <textarea name="remarks" placeholder="Enter Remarks"
                                class="w-full rounded-10 border bg-secondary/5 border-gray-300 dark:bg-bg3 px-3 py-3 text-sm"></textarea>
                        </div>

                        <!-- Transaction Date -->
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">
                                Transaction Date <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="transaction_date" placeholder="DD/MM/YYYY" id="date4"
                                class="w-full rounded-10 border bg-secondary/5 border-gray-300 dark:bg-bg3 px-3 py-3 text-sm"
                                readonly>
                        </div>
                        <!-- Receipt -->
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">T.
                                Receipt</label>
                            <input type="file" name="t_receipt" disabled
                                class="w-full rounded-10 border bg-secondary/5 border-gray-300 dark:bg-bg3 px-3 py-3 text-sm">
                        </div>
                        <!-- Pay Mode -->
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">
                                Pay Mode <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-2 flex flex-wrap gap-4 text-sm text-gray-700 dark:text-gray-300">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="pay_mode" value="cash" class="text-green-600" checked >
                                    Cash
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="pay_mode" value="onlineTr" class="text-green-600"> Online
                                    Tr.
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="pay_mode" value="cheque" class="text-green-600"> Cheque
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="pay_mode" value="saving" class="text-green-600"> Saving
                                    Ac.
                                </label>
                            </div>
                        </div>
                        <!-- Online Fields -->
                        <div id="onlineFields" class="space-y-4 mt-2 hidden">
                            <label class="block text-sm font-medium text-gray-700">Transfer Date <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="transfer_date" id="date2" placeholder="DD/MM/YYYY"
                                class="w-full border rounded-10 px-3 py-3 bg-secondary/5">

                            <label class="block text-sm font-medium text-gray-700">
                                UTR / Transaction No.
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="utr_no" value=""
                                class="w-full border rounded-10 px-3 py-3 bg-secondary/5"
                                placeholder="Enter UTR/Transaction No.">
                            <label class="block text-sm font-medium text-gray-700">
                                Transfer Mode.
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-3">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="IMPS" class="text-green-600">
                                    IMPS
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="VPA" class="text-green-600">
                                    VPA
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="NEFT/RTGS" class="">
                                    NEFT/RTGS
                                </label>
                            </div>

                        </div>

                        <!-- Cheque Fields -->
                        <div id="chequeFields" class="space-y-4 mt-2 hidden">
                            <!-- Bank Name -->
                            <label class="block text-sm font-medium text-gray-700">
                                Bank Name <span class="text-red-500">*</span>
                            </label>
                            <x-searchable-dropdown :items="$banks" label="BANK NAME" name="bank_name"
                                display-field="name" value-field="id" :selected="old('bank_name')" />

                            <!-- Cheque No -->
                            <label class="block text-sm font-medium text-gray-700">Cheque No. <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="cheque_no"
                                class="w-full border rounded-10 px-3 py-3 bg-secondary/5" placeholder="Enter Cheque No.">

                            <!-- Cheque Date -->
                            <label class="block text-sm font-medium text-gray-700">Cheque Date <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="date5" name="cheque_date" placeholder="DD/MM/YYYY"
                                class="w-full border rounded-10 px-3 py-3 bg-secondary/5 date-input">
                        </div>

                        <!-- Saving Fields -->
                        <div id="savingFields" class="space-y-4 mt-2">
                            <label class="block text-sm font-medium text-gray-700">Select Saving Account <span
                                    class="text-red-500">*</span></label>
                            <select id="saving_account_id" name="saving_account_id"
                                class="w-full border rounded-10 px-3 py-3 bg-secondary/5">
                                <option value="">Select Account</option>
                                @forelse ($savingAccounts as $account)
                                    <option value="{{ $account->id }}">
                                        {{ $account->account_no }} ({{ $account->members->full_name ?? '' }}
                                        )({{ $account->amount_deposit ?? '' }})
                                    </option>
                                @empty
                                    <option value="">No accounts found</option>
                                @endforelse
                            </select>
                        </div>

                        <div class="flex justify-center gap-4 pt-4">
                            <button type="submit" class="btn-primary  ">
                                DEPOSIT
                            </button>
                            <a href="#" class="btn-outline ">
                                CANCEL
                            </a>
                        </div>
                    </form>
                </div>

                <div class="w-full box">
                    <div
                        class="flex justify-between items-center bg-secondary/5 rounded-10 px-4 py-3 border-b border-green-200 dark:bg-bg3">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white dark:bg-bg3 uppercase">DD Info</h3>
                    </div>
                    <div class="p-4">
                        <table class="w-full text-sm">
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                <tr class="border-b">
                                    <td class="font-semibold pr-4 py-3 uppercase">CUSTOMER</td>
                                    <td>{{ ($ddAccount->member?->member_no ??
                                        ($ddAccount->member?->id ? str_pad($ddAccount->member->id, 6, '0', STR_PAD_LEFT) : '')) .
                                        ' - ' .
                                        $ddAccount->member->member_info_first_name ??
                                        'N/A' }}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold pr-4 py-3 uppercase">DD No.</td>
                                    <td> DDA{{ $ddAccount->id ?? 'N/A' }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold pr-4 py-3 uppercase">Scheme</td>
                                    <td>{{ $ddAccount->scheme->scheme_name ?? '-' }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold pr-4 py-3 uppercase">Tenure</td>
                                    <td>{{ $ddAccount->scheme->tenure_of_rd_dd_value }}
                                        {{ $ddAccount->scheme->tenure_of_rd_dd_type }}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold pr-4 py-3 uppercase">Frequency</td>
                                    <td>{{ $ddAccount->scheme->rd_dd_frequency ?? '-' }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold pr-4 py-3 uppercase">Principal Amt.</td>
                                    <td>{{ number_format($ddAccount->dd_amount, 2) }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold pr-4 py-3 uppercase">Amount Received</td>
                                    {{-- <td>{{ number_format($installmentReceived, 2) }}</td> --}}
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold pr-4 py-3 uppercase">Balance Available</td>
                                    <td>{{ number_format($balanceAvailable, 2) }}</td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const amountInput = document.getElementById('amountToDeposit');
            const amountError = document.getElementById('amountError');
            const installmentAmount = {
                {
                    $installmentAmount
                }
            };
            amountInput.addEventListener('input', function() {
                if (parseFloat(amountInput.value) < installmentAmount) {
                    amountError.classList.remove('hidden');
                } else {
                    amountError.classList.add('hidden');
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date();
            const day = String(today.getDate()).padStart(2, '0');
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const year = today.getFullYear();

            const currentDate = day + '/' + month + '/' + year;

            document.getElementById('date').value = currentDate;
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const payModeInputs = document.querySelectorAll('input[name="pay_mode"]');

            const onlineFields = document.getElementById('onlineFields');
            const chequeFields = document.getElementById('chequeFields');
            const savingFields = document.getElementById('savingFields');

            function togglePayModeFields(selectedMode) {
                // Hide all by default
                onlineFields.classList.add('hidden');
                chequeFields.classList.add('hidden');
                savingFields.classList.add('hidden');

                // Show only the selected one
                switch (selectedMode) {
                    case 'onlineTr':
                        onlineFields.classList.remove('hidden');
                        break;
                    case 'cheque':
                        chequeFields.classList.remove('hidden');
                        break;
                    case 'saving':
                        savingFields.classList.remove('hidden');
                        break;
                        // cash doesn't need any extra fields
                }
            }

            // Bind change event to all radio buttons
            payModeInputs.forEach(input => {
                input.addEventListener('change', function() {
                    togglePayModeFields(this.value);
                });
            });

            // If a mode is already selected (like on form resubmit), show its fields
            const selectedInput = document.querySelector('input[name="pay_mode"]:checked');
            if (selectedInput) {
                togglePayModeFields(selectedInput.value);
            }
        });
    </script>
    <script>
        const amountInput = document.getElementById('balance_available');
        const amountError = document.getElementById('balanceError');

        const ddInstallmentAmount = parseFloat({{ $ddAccount->dd_amount }});

        amountInput.addEventListener('input', function() {
            const value = parseFloat(this.value);

            if (value < ddInstallmentAmount) {
                amountError.classList.remove('hidden'); // show error
                this.setCustomValidity(`Amount must be at least ${ddInstallmentAmount}`);
            } else {
                amountError.classList.add('hidden'); // hide error
                this.setCustomValidity('');
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const payModeSelect = document.getElementById('pay_mode');
            const savingFields = document.getElementById('savingFields');

            function toggleSavingFields() {
                if (payModeSelect.value === 'saving') {
                    savingFields.style.display = 'block';
                } else {
                    savingFields.style.display = 'none';
                    document.getElementById('saving_account_id').value = '';
                }
            }

            payModeSelect.addEventListener('change', toggleSavingFields);
            toggleSavingFields(); // initialize
        });
    </script>
@endsection
