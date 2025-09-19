@extends('layout.main')

<style>
    .breadcrumb {
        list-style: none;
        display: flex;
        padding: 0;
        margin-bottom: 1rem;
        font-size: 14px;
    }

    .breadcrumb li+li::before {
        content: "/";
        padding: 0 8px;
        color: #888;
    }

    .breadcrumb li a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb li.active {
        color: #555;
    }

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

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <div class="flex items-center gap-3 ">
                <h1 class="text-2xl font-semibold dark:text-white">RD - {{$rdAccount->id}}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Deposit Money (Installments)</p>
            </div>
            <p class="text-gray-500 dark:text-gray-400">
                <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">Recurring Deposits </a> >
                <a href="#" class="text-gray-500 dark:text-gray-400 text-sm"> RD{{$rdAccount->id}}</a> >
                <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">Deposit Money</a>
            </p>
        </div>
    </div>

    <!-- Table -->
    <div class=" dark:bg-bg3 mt-5 shadow rounded-lg overflow-hidden">


        <div class="flex flex-col lg:flex-row gap-6">

            <!-- Deposit Form -->
            <div class=" w-full box dark:bg-bg3 shadow rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:bg-bg3 dark:text-white uppercase ">DEPOSIT</h3>
                <hr class="my-4 border-gray-300 dark:border-gray-700">
                @if(session('success'))
                <div class="p-3 mb-3 text-green-800 bg-green-200 rounded">
                    {{ session('success') }}
                </div>
                @endif
                <form class="space-y-6" action="{{ route('rd.deposit.store', $rdAccount->id) }}" method="POST">
                    @csrf

                    <!-- Member Signature -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Member's Sign</label>
                        <div class=" text-gray-600 dark:text-gray-400 text-sm">
                            No Signature Present <br> (Upload in Member Documents)
                        </div>
                    </div>

                    <!-- Member Photo -->
                    <div class="mt-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Member's Photo</label>
                        <div class=" text-gray-600 dark:text-gray-400 text-sm">
                            No Photo Present <br> (Upload in Member Documents)
                        </div>
                    </div>

                    <!-- Collected By -->
                    <div class="mt-3">
                        <label class="block text-sm font-medium  dark:bg-bg3">Collected By</label>
                        <select
                            class="w-full rounded-10 border bg-secondary/5 border-gray-300 dark:bg-bg3 px-3 py-3 text-sm">
                            <option value="">Select Advisor / Staff</option>

                        </select>
                    </div>

                    <!-- Amount -->
                    <div class="mt-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Amount to Deposit <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="amount" min="0" placeholder="Enter Amount to Deposit"
                            class="w-full rounded-10 border bg-secondary/5 border-gray-300 dark:bg-bg3 px-3 py-3 text-sm">
                    </div>
                    @error('amount')
                     <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                    <!-- Remarks -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:bg-bg3  mt-3">Remarks (if
                            any)</label>
                        <textarea placeholder="Enter Remarks"
                            class="w-full rounded-10 border bg-secondary/5 border-gray-300 dark:bg-bg3 px-3 py-3 text-sm"></textarea>
                    </div>

                    <!-- Transaction Date -->
                    <div class="mt-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Transaction Date <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="t_date" name="t_date"
                            class="w-full rounded-10 border bg-secondary/5 border-gray-300 dark:bg-bg3 px-3 py-3 text-sm">
                    </div>
                      @error('t_date')
                     <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror


                    <!-- Receipt -->
                    <div class="mt-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">T. Receipt</label>
                        <input type="file" disabled
                            class="w-full rounded-10 border bg-secondary/5 border-gray-300 dark:bg-bg3 px-3 py-3 text-sm">

                    </div>


                    <!-- Pay Mode -->
                    <div class="mt-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Pay Mode <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-2 flex flex-wrap gap-4 text-sm text-gray-700 dark:text-gray-300">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="payment_mode" value="cash" class="text-green-600" checked>
                                Cash
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="payment_mode" value="online" class="text-green-600"> Online
                                Tr.
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="payment_mode" value="cheque" class="text-green-600"> Cheque
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="payment_mode" value="saving" class="text-green-600"> Saving
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
                        <input type="text" name="transfer_date" id="date2" placeholder="DD/MM/YYYY"
                            class="w-full border rounded-10 px-3 py-3 bg-secondary/5">
                        @error('transfer_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <label class="block text-sm font-medium text-gray-700">
                            UTR / Transaction No.
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="utr_no" class="w-full border rounded-10 px-3 py-3 bg-secondary/5"
                            placeholder="Enter UTR/Transaction No.">
                        @error('utr_no')
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

                        <!-- <div id="accountBalanceDiv" class="mt-3 hidden">
                                <label class="block text-sm font-medium text-gray-700">Account Balance</label>
                                <div id="accountBalance" class="p-3 text-sm font-semibold text-primary">₹0.00</div>
                            </div> -->
                    </div>




                    <!-- Buttons -->
                    <div class="flex justify-center gap-4 pt-4">
                        <button type="submit" class="btn-primary  rounded-10">
                            DEPOSIT
                        </button>
                        <a href="#" class="btn-outline rounded-10">
                            CANCEL
                        </a>
                    </div>
                </form>
            </div>

            <!-- Side Info -->
            <div class="w-full box">
                <div
                    class="flex justify-between items-center bg-secondary/5 rounded-10 px-4 py-3 border-b border-green-200 dark:bg-bg3">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white dark:bg-bg3">RD Info</h3>

                </div>
                <div class="p-4">
                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr class="border-b">
                                <td class="font-semibold pr-4 py-3">Member</td>
                                <td>
                                    {{ $rdAccount->member->id ?? 'N/A' }} -
                                {{ $rdAccount->member->member_info_first_name ?? '' }}
                                {{ $rdAccount->member->member_info_last_name ?? '' }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold pr-4 py-3">RD No.</td>
                                <td>{{ $rdAccount->id ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold pr-4 py-3">Scheme</td>
                                <td>{{ $rdAccount->rdscheme->scheme_name ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold pr-4 py-3">Tenure</td>
                                <td>{{ $rdAccount->rdscheme->tenure_of_rd_dd_value ?? 'N/A' }} {{ $rdAccount->rdscheme->tenure_of_rd_dd_type ?? '' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold pr-4 py-3">Frequency</td>
                                <td>{{ ucfirst($rdAccount->rdscheme->rd_dd_frequency ?? 'N/A') }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold pr-4 py-3">Principal Amt.</td>
                                <td>{{ number_format($rdAccount->rd_amount, 2) }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold pr-4 py-3">Amount Received</td>
                                <td>{{ number_format($totalReceived, 2) }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold pr-4 py-3">Balance Available</td>
                                <td>
                                    {{ number_format(
                                    ($rdAccount->rdTransactions->whereNotNull('paid_on')->where('transaction_type', 'credit')->sum('amount')) -
                                    ($rdAccount->rdTransactions->where('transaction_type', 'debit')->sum('amount')),2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>




    </div>
</div>


<!-- JS paymode -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chequeFields = document.getElementById("chequeFields");
        const onlineFields = document.getElementById("onlineFields");
        const savingFields = document.getElementById("savingFields");

        // Hide all sections
        function hideAll() {
            chequeFields.classList.add("hidden");
            onlineFields.classList.add("hidden");
            savingFields.classList.add("hidden");
        }
        const radios = document.querySelectorAll("input[name='payment_mode']")
        // Listen for radio button changes
        radios.forEach(radio => {
            radio.addEventListener("change", function() {
                hideAll(); // Hide all first
                if (this.value === "cheque") {
                    chequeFields.classList.remove("hidden");
                } else if (this.value === "online") {
                    onlineFields.classList.remove("hidden");
                } else if (this.value === "saving") {
                    savingFields.classList.remove("hidden");
                }
            });
        });
    });
</script>

<!-- Datepicker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

<!-- Datepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>



<!-- Datepicker Initialization -->
<script>
    //start
    const dateInput = document.getElementById('t_date');

    if (dateInput) {
        // Initialize datepicker
        const picker = new Datepicker(dateInput, {
            autohide: true,
            format: 'd-m-Y', // Format: day-month-year
            maxDate: new Date(), // Disable future dates
        });

        // Set today's date as default
        const today = new Date();
        const formattedDate = today.toLocaleDateString('en-GB').split('/').join('-');
        dateInput.value = formattedDate;

        // Open calendar on icon click
        const calendarIcon = document.querySelector('.la-calendar');
        if (calendarIcon) {
            calendarIcon.addEventListener('click', () => picker.show());
        }
    }
    //end
</script>

@endsection