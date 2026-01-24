@extends('layout.main')

@section('content')
<div class="main-inner">

    <!-- Header -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex flex-col gap-2">
            <h1 class="text-lg uppercase font-semibold">Edit Passbook - {{ $passbook->passbook_no }}</h1>
           
        </div>
    </div>

    @if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
    @endif
    <form method="POST" action="{{ route('passbook.update', $passbook->id) }}" class="p-6 bg-white dark:bg-bg3 rounded-lg shadow-md">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 md:grid-cols-2 gap-4 mb-4">
            <!-- Account Type -->
            <div>
                <label for="accountType" class="block mb-4 font-medium md:text-lg">
                    Account Type <span class="text-red-500">*</span>
                </label>
                <select id="accountType" name="account_type"
                    class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3"
                    disabled>
                    <option value="Saving" {{ $passbook->account_type == 'Saving' ? 'selected' : '' }}>Saving</option>
                    <option value="Current" {{ $passbook->account_type == 'Current' ? 'selected' : '' }}>Current</option>
                    <option value="RD Accounts" {{ $passbook->account_type == 'RD Accounts' ? 'selected' : '' }}>RD Accounts</option>
                    <option value="DD Accounts" {{ $passbook->account_type == 'DD Accounts' ? 'selected' : '' }}>DD Accounts</option>
                    <option value="FD Accounts" {{ $passbook->account_type == 'FD Accounts' ? 'selected' : '' }}>FD Accounts</option>
                    <option value="MIS Accounts" {{ $passbook->account_type == 'MIS Accounts' ? 'selected' : '' }}>MIS Accounts</option>
                    <option value="DDS Accounts" {{ $passbook->account_type == 'DDS Accounts' ? 'selected' : '' }}>DDS Accounts</option>
                </select>
                <input type="hidden" name="account_type" value="{{ $passbook->account_type }}">
            </div>

            <!-- Account No -->
            <div>
                <label class="block mb-4 font-medium md:text-lg">
                    Account No <span class="text-red-500">*</span>
                </label>
                <input type="text"
                    name="account_no"
                    value="{{ $passbook->account_no }}"
                    readonly
                    class="w-full bg-secondary/5 px-3 py-2 text-sm border bg-gray-100 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
            </div>

            <!-- Passbook Issue Date -->
            <div>
                <label class="block mb-4 font-medium md:text-lg">
                    Passbook Issue Date <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="date_pass"
                    name="issue_date"
                    value="{{ \Carbon\Carbon::parse($passbook->issue_date)->format('d-m-Y') }}"
                    class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 
                           border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3 pr-10">
                @error('issue_date')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Passbook No -->
            <div>
                <label class="block mb-4 font-medium md:text-lg">
                    Passbook No <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="passbook_no"
                    value="{{ $passbook->passbook_no }}"
                    class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 
                           border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                @error('passbook_no')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        @php
        $indexUrl = route('passbook.show', $passbook->id);
        @endphp
        <!-- Action Buttons -->
        <div class="flex gap-4 mt-6">
            <button class="btn-primary" type="submit">UPDATE PASSBOOK</button>
            <button onclick="window.location.href='{{ $indexUrl }}'" class="btn-outline uppercase" type="button">
                Back
            </button>
        </div>
    </form>

    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

    <!-- Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>

    <!-- Datepicker Initialization -->
    <script>
        const dateInput = document.getElementById('date_pass');
        if (dateInput) {
            new Datepicker(dateInput, {
                autohide: true,
                format: 'dd-mm-yyyy',
                maxDate: new Date()
            });
        }
    </script>

</div>
@endsection