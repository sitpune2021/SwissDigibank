@extends('layout.main')

@section('content')

<style>
    input[type="checkbox"] {
        width: 28px;
        height: 28px;
        accent-color: green;
        /* For modern browsers */
    }

    input[type="checkbox"]:checked {
        background-color: green;
        border: none;
    }

    input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: green;
        /* Modern browser support */
    }

    .tableWidth {
        width: 90%;
        margin: auto;

    }

    .bg-yellow {
        background-color: #e17100;
    }
</style>
<style>
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
        background-color: #e17100;
    }
</style>

@section('content')
<div class="main-inner dark:bg-gray-900 dark:text-gray-200">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-xl font-semibold dark:text-white">MIS - {{ $account->id }}</h1>
            <!-- <p class="text-gray-500 dark:text-gray-400">
                <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">Fd Accounts</a> >
                <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">03754</a> >
                <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">change Account Info</a>
            </p> -->
        </div>
        <!-- Warning Note -->
        <div id="warning-box" class="hidden mt-4 p-4 rounded bg-warning text-white text-sm border-l-6  font-semibold">
            <h4>NOTE:</h4> <br>
            <p>If there are changes to the SCHEME or the account OPEN DATE,
                please be aware that all INTEREST and TDS transactions will be automatically deleted
                from the account ledger. Therefore, make sure to proceed with these changes carefully.
            </p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Left Side: Form -->
        <div class="flex-1 w-full bg-white dark:bg-bg3 rounded-xl shadow p-6">

            <form action="{{ route('misaccount.updateAccountInfo', $account->id) }}" method="POST">
                @csrf
                <h3 class="text-2xl text-black dark:text-white p-1">CHANGE ACCOUNT INFO</h3>
                <hr class="border-gray-200 dark:border-gray-700" />

                <p class="text-sm mt-3 text-black dark:text-gray-300">
                    Are you sure you want to change account info?
                </p>

                <!-- Scheme -->
                <div class="mt-4">
                    <label class="block font-medium text-gray-700 dark:text-gray-300 uppercase">
                        Scheme <span class="text-red-500">*</span>
                    </label>
                    <select name="scheme_id" class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border">
                        <option value="">-- Select Scheme --</option>
                        @foreach($schemes as $id => $name)
                        <option value="{{ $id }}" {{ $account->fd_scheme_id == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Member -->
                <div class="mt-4">
                    <label class="block font-medium text-gray-700 dark:text-gray-300 uppercase">
                        Customer <span class="text-red-500">*</span>
                    </label>
                    <select name="member_id" disabled
                        class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border">
                        <option value="">-- Select Customer --</option>
                         @foreach($members as $id => $name)
                            <option value="{{ $id }}" {{ $account->member_id == $id ? 'selected' : '' }}>
                                    {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Account Type -->
                <div class="mt-4">
                    <label class="block text-sm font-medium uppercase">Account Type <span class="text-red-500">*</span></label>
                    <div class="mt-2 flex gap-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="account_type" value="single"
                                {{ $account->account_type == 'single' ? 'checked' : '' }}
                                checked>
                            <span>Single</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="account_type" value="joint"
                                {{ $account->account_type == 'joint' ? 'checked' : '' }}>
                            <span>Joint A/C</span>
                        </label>
                    </div>
                </div>

                <!-- Joint Account Member -->
                <div class="mt-4" id="jointAccountInput">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">
                        Joint Account Customer
                    </label>
                    <select name="joint_member_id"
                        class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border">
                        <option value="">-- Select Joint Customer --</option>
                        @if($account->account_type == 'joint')
                        @foreach($jointMembers as $id => $name)
                        <option value="{{ $id }}" {{ $account->joint_member_id == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <!-- Minor -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">
                        Minor
                    </label>
                    <select name="minor_id"
                        class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border">
                        <option value="">Select Minor</option>
                        {{-- TODO: minors list agar hai to yaha loop lagana --}}
                    </select>
                </div>

                <!-- Open Date -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">
                        Open Date <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="open_date" id="date"
                        value="{{ old('open_date', $account->open_date ? \Carbon\Carbon::parse($account->open_date)->format('d-m-Y') : '') }}"
                        placeholder="DD/MM/YYYY"
                        class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border" disabled />
                </div>


                <!-- Buttons -->
                <div class="flex mt-6 gap-3">
                    <button type="submit" class="btn-primary uppercase">Change account info</button>
                    <a href="{{ route('misaccount.show', $account->id) }}" class="btn-outline">Back</a>
                </div>
            </form>



        </div>

        <!-- Right Side: Account Info -->
        <div class="w-full lg:w-1/3 box dark:bg-bg3 rounded-xl shadow overflow-hidden">
            <div class="bg-secondary/5 text-black px-4 py-3 flex justify-between  rounded-10 items-center">
                <h3 class="font-semibold uppercase">Account Info</h3>
            </div>
            <div class="p-4">
                <table class="w-full text-sm">
                    <tbody>
                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2 font-semibold dark:text-gray-300 uppercase">Customer</td>
                            <td class="py-2">
                                <a href="#" class="text-green-600 hover:underline">
                                    {{ $account->member->member_info_first_name ?? '' }} {{ $account->member->member_info_last_name ?? '' }}
                                </a>
                            </td>
                        </tr>
                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2 font-semibold dark:text-gray-300 uppercase">PAN No</td>
                            <td class="py-2">{{ $account->member->kyc->member_kyc_pan_no ?? 'N/A' }}</td>
                        </tr>
                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2 font-semibold dark:text-gray-300 uppercase">Account No</td>
                            <td class="py-2">{{ $account->id ?? '' }}</td>
                        </tr>
                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2 font-semibold dark:text-gray-300 uppercase">Open Date</td>
                            <td class="py-2">{{  \Carbon\Carbon::parse($account->open_date)->format('d-m-Y') }}</td>
                        </tr>
                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2 font-semibold dark:text-gray-300 uppercase">Status</td>
                            <td class="py-2">@if($account->status == 1 ) Active @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold dark:text-gray-300 uppercase">Available Balance</td>
                            <td class="py-2">₹{{ number_format($balance, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const radios = document.querySelectorAll("input[name='account_type']");
        const jointInput = document.getElementById("jointAccountInput");

        radios.forEach(radio => {
            radio.addEventListener("change", function() {
                if (this.value === "joint") {
                    jointInput.classList.remove("hidden");
                } else {
                    jointInput.classList.add("hidden");
                }
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const schemeSelect = document.querySelector("select[name='scheme_id']");
        const openDateInput = document.querySelector("input[name='open_date']");
        const warningBox = document.getElementById("warning-box");

        // Store original backend values
        const originalScheme = "{{ $account->fd_scheme_id }}";
        const originalDate = "{{ \Carbon\Carbon::parse($account->open_date)->format('d-m-Y') }}";

        // Function to check if changed
        function checkForChanges() {
            const schemeChanged = schemeSelect.value !== originalScheme;
            const dateChanged = openDateInput.value !== originalDate;

            if (schemeChanged || dateChanged) {
                warningBox.classList.remove("hidden");
            } else {
                warningBox.classList.add("hidden");
            }
        }

        // Add event listeners
        schemeSelect.addEventListener("change", checkForChanges);
        openDateInput.addEventListener("input", checkForChanges);
    });
</script>

@endsection
