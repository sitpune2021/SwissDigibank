@extends('layout.main')

@section('content')
    <div class="main-inner">


        <!-- Header -->
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col gap-2">
                <h1 class="text-lg font-semibold">ISSUE NEW PASSBOOK</h1>
                {{-- <p class="text-gray-500">
                <a href="{{ route('passbook.index') }}" class="text-gray-500">Passbooks</a> >
                <a href="#" class="text-gray-500">New</a>
            </p> --}}
            </div>
        </div>


        @if (session('success'))
            <script>
                alert("{{ session('success') }}");
            </script>
        @endif

        <form method="POST" action="{{ route('passbook.store-passbook') }}"
            class="p-6 bg-white dark:bg-bg3 rounded-lg shadow-md">
            @csrf
            <div class="grid grid-cols-2 md:grid-cols-2 gap-4 mb-4">
                <!-- Account Type -->
                <div>
                    <label for="accountType" class="block mb-2 font-medium md:text-lg">
                        Account Type <span class="text-red-500">*</span>
                    </label>
                    <select id="accountType" name="account_type"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                        <option value="">Select Account Type</option>
                        <option value="Saving">Saving</option>
                        <option value="Current">Current</option>
                        <option value="RD Accounts">RD Accounts</option>
                        <option value="FD Accounts">FD Accounts</option>
                        <option value="MIS Accounts">MIS Accounts</option>
                        <option value="DDS Accounts">DDS Accounts</option>
                        <option value="Gold Account">Gold Loan</option>
                        <option value="Property Account">Property Loan</option>
                        <option value="Deposit Account">Deposit Loan</option>
                        <option value="Business Account">Business / Other Loan</option>
                        <option value="CCOD Account">Cc/Od Loan</option>
                        <option value="Daily / Weekly Account">Daily / Weekly Loan</option>
                        <option value="Personal Account">Personal Loan</option>
                        <option value="Vehicle Account">Vehicle Loan</option>
                        <option value="Fixed Account">Fixed Loan</option>
                    </select>
                    @error('account_type')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>


                <!-- Account No -->
                <div>
                    <label class="block mb-2 font-medium md:text-lg">
                        Account No <span class="text-red-500">*</span>
                    </label>
                    <select id="accountNo" name="account_no"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">

                        <option value="">Select Account</option>

                        {{-- Saving Accounts --}}
                        @foreach ($savingAccounts as $acc)
                            <option value="{{ $acc->account_no }}" data-type="Saving">
                                {{ $acc->account_no }}
                            </option>
                        @endforeach

                        {{-- Current Accounts --}}
                        @foreach ($currentAccounts as $acc)
                            <option value="{{ $acc->account_no }}" data-type="Current">
                                {{ $acc->account_no }}
                            </option>
                        @endforeach

                        {{-- RD --}}
                        @foreach ($rdAccounts as $acc)
                            <option value="{{ $acc->id }}" data-type="RD Accounts">
                                RD-{{ $acc->id }}
                            </option>
                        @endforeach

                        {{-- FD --}}
                        @foreach ($fdAccounts as $acc)
                            <option value="{{ $acc->id }}" data-type="FD Accounts">
                                FD-{{ $acc->id }}
                            </option>
                        @endforeach

                        {{-- MIS --}}
                        @foreach ($misAccounts as $acc)
                            <option value="{{ $acc->id }}" data-type="MIS Accounts">
                                MIS-{{ $acc->id }}
                            </option>
                        @endforeach

                        {{-- DDS --}}
                        @foreach ($ddsAccounts as $acc)
                            <option value="{{ $acc->id }}" data-type="DDS Accounts">
                                DDS-{{ $acc->id }}
                            </option>
                        @endforeach
                        
                        {{-- goldLoans --}}
                        @foreach ($goldLoans as $loan)
                            <option value="{{ $loan->id }}" data-type="Gold Account">

                                GL-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}

                                ({{ $loan->member->member_no ?? '-' }} -
                                {{ $loan->member->member_info_first_name ?? '-' }}
                                {{ $loan->member->member_info_last_name ?? '-' }})
                            </option>
                        @endforeach

                        {{-- mortgageLoans --}}
                        @foreach ($mortgageLoans as $loan)
                            <option value="{{ $loan->id }}" data-type="Property Account">

                                ML-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}

                                ({{ $loan->member->member_no ?? '-' }} -
                                {{ $loan->member->member_info_first_name ?? '-' }}
                                {{ $loan->member->member_info_last_name ?? '-' }})
                            </option>
                        @endforeach

                        {{-- depositLoans --}}
                        @foreach ($depositLoans as $loan)
                            <option value="{{ $loan->id }}" data-type="Deposit Account">

                                DL-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}

                                ({{ $loan->member->member_no ?? '-' }} -
                                {{ $loan->member->member_info_first_name ?? '-' }}
                                {{ $loan->member->member_info_last_name ?? '-' }})
                            </option>
                        @endforeach

                        {{-- businessLoans --}}
                        @foreach ($businessLoans as $loan)
                            <option value="{{ $loan->id }}" data-type="Business Account">

                                BL-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}

                                ({{ $loan->member->member_no ?? '-' }} -
                                {{ $loan->member->member_info_first_name ?? '-' }}
                                {{ $loan->member->member_info_last_name ?? '-' }})
                            </option>
                        @endforeach

                        {{-- ccodLoans --}}
                        @foreach ($ccodLoans as $loan)
                            <option value="{{ $loan->id }}" data-type="CCOD Account">

                                CDL-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}

                                ({{ $loan->member->member_no ?? '-' }} -
                                {{ $loan->member->member_info_first_name ?? '-' }}
                                {{ $loan->member->member_info_last_name ?? '-' }})
                            </option>
                        @endforeach

                        {{-- dailyweeklyLoans --}}
                        @foreach ($dailyweeklyLoans as $loan)
                            <option value="{{ $loan->id }}" data-type="Daily / Weekly Account">

                                DL-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}

                                ({{ $loan->member->member_no ?? '-' }} -
                                {{ $loan->member->member_info_first_name ?? '-' }}
                                {{ $loan->member->member_info_last_name ?? '-' }})
                            </option>
                        @endforeach

                        {{-- personalLoans --}}
                        @foreach ($personalLoans as $loan)
                            <option value="{{ $loan->id }}" data-type="Personal Account">

                                PL-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}

                                ({{ $loan->member->member_no ?? '-' }} -
                                {{ $loan->member->member_info_first_name ?? '-' }}
                                {{ $loan->member->member_info_last_name ?? '-' }})
                            </option>
                        @endforeach

                        {{-- vehicaleLoans --}}
                        @foreach ($vehicleLoans as $loan)
                            <option value="{{ $loan->id }}" data-type="Vehicle Account">

                                VL-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}

                                ({{ $loan->member->member_no ?? '-' }} -
                                {{ $loan->member->member_info_first_name ?? '-' }}
                                {{ $loan->member->member_info_last_name ?? '-' }})
                            </option>
                        @endforeach

                        {{-- fixedLoans --}}
                        @foreach ($fixedLoans as $loan)
                            <option value="{{ $loan->id }}" data-type="Fixed Account">

                                FL-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}

                                ({{ $loan->member->member_no ?? '-' }} -
                                {{ $loan->member->member_info_first_name ?? '-' }}
                                {{ $loan->member->member_info_last_name ?? '-' }})
                            </option>
                        @endforeach

                    </select>

                    @error('account_no')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Passbook Issue Date -->
                <!-- datepicker component -->
                <x-datepicker-disabled label="Passbook Issue Date" name="issue_date" value="{{ old('issue_date') }}"
                    inputId="date_pass" />

                <!-- Passbook No -->
                <div>
                    <label class="block mb-2 font-medium md:text-lg">
                        Passbook No <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="passbook_no" placeholder="Enter Passbook Number"
                        value="{{ old('passbook_no') }}"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 
                       border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                    @error('passbook_no')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 mt-6 items-center">
                <button id="addPassbookBtn" class="btn-primary uppercase" type="submit">ADD PASSBOOK</button>

                @php
                    $indexUrl = route('passbook.index');
                @endphp
                <button onclick="window.location.href='{{ $indexUrl }}'" class="btn-outline uppercase" type="button">
                    Back
                </button>

            </div>
        </form>

        <!-- collapse show-->
        <script>
            document.addEventListener("DOMContentLoaded", () => {

                const accountType = document.getElementById('accountType');
                const accountNo = document.getElementById('accountNo');

                accountType.addEventListener('change', function() {
                    const selectedType = this.value;

                    [...accountNo.options].forEach(option => {
                        if (!option.value) return;

                        // Hide or show based on matching type
                        option.style.display = option.dataset.type === selectedType ?
                            'block' : 'none';
                    });

                    // Reset dropdown
                    accountNo.value = "";
                });

            });
        </script>

        <!-- <script>
            document.addEventListener("DOMContentLoaded", () => {
                const accountType = document.getElementById('accountType');
                const accountNoWrapper = document.getElementById('accountNoWrapper');
                const accountNo = document.getElementById('accountNo');
                const issueDateWrapper = document.getElementById('issueDateWrapper');
                const passbookNoWrapper = document.getElementById('passbookNoWrapper');
                const actionButtons = document.getElementById('actionButtons');

                accountType.addEventListener('change', function() {
                    const selectedType = this.value;

                    if (selectedType) {
                        // Show hidden fields
                        accountNoWrapper.style.display = 'block';
                        issueDateWrapper.style.display = 'block';
                        passbookNoWrapper.style.display = 'block';
                        actionButtons.style.display = 'flex';

                        // Filter account options
                        [...accountNo.options].forEach(option => {
                            if (!option.value) return;
                            option.style.display = option.dataset.type === selectedType ? 'block' :
                                'none';
                        });

                        // Reset account selection
                        accountNo.value = '';
                    } else {
                        // Hide all except Account Type
                        accountNoWrapper.style.display = 'none';
                        issueDateWrapper.style.display = 'none';
                        passbookNoWrapper.style.display = 'none';
                        actionButtons.style.display = 'none';
                    }
                });
            });
        </script> -->

        <!-- Datepicker CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

        <!-- Datepicker JS -->
        <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>



        <!-- Datepicker Initialization -->
        <script>
            //start
            const dateInput = document.getElementById('date_pass');

            if (dateInput) {
                // Initialize datepicker
                const picker = new Datepicker(dateInput, {
                    autohide: true,
                    format: 'dd-mm-yyyy', // Format: day-month-year
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

    </div>
@endsection
