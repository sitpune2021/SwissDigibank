@extends('layout.main')

<style>
    input[type="checkbox"] {
        width: 24px !important;
        height: 24px !important;
        accent-color: green;
    }

    input[type="checkbox"]:checked {
        background-color: green;
        border: none;
    }

    input[type="radio"] {
        width: 24px !important;
        height: 24px !important;
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
                <h1 class="text-lg font-semibold dark:text-white">DD - {{ $ddaccount->id }}</h1>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">

            <!-- LEFT FORM -->
            <div class="flex-1 w-full bg-white dark:bg-bg3 rounded-xl shadow p-6">
                <form class="space-y-6" method="POST" action="{{ route('dd.update.account.info', $ddaccount->id) }}">
                    @csrf

                    <h3 class="text-lg text-black dark:text-white p-1">CHANGE ACCOUNT INFO</h3>
                    <hr class="border-gray-200 dark:border-gray-700" />

                    <!-- Scheme -->
                    <div class="mt-4">
                        <label class="block font-semibold text-gray-700 dark:text-gray-300 uppercase">
                            Scheme <span class="text-red-500">*</span>
                        </label>

                        <select name="scheme_id"
                            class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border">

                            @if ($ddaccount->scheme)
                                <option value="{{ $ddaccount->scheme->id }}" selected>
                                {{ $ddaccount->scheme->id }} - {{ $ddaccount->scheme->scheme_name }}
                                </option>
                            @endif

                            @foreach ($schemes as $scheme)
                                @if ($ddaccount->scheme_id != $scheme->id)
                                    <option value="{{ $scheme->id }}">
                                {{ $scheme->id }} - {{ $scheme->scheme_name }}
                                    </option>
                                @endif
                            @endforeach

                        </select>
                    </div>

                    <!-- Account Type -->
                    <div class="mt-4">
                        <label class="block  font-semibold text-gray-700 dark:text-gray-300 uppercase">
                            Account Type <span class="text-red-500">*</span>
                        </label>

                        <div class="mt-2 flex gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="account_holder_type" value="single" checked
                                    {{ $ddaccount->account?->account_holder_type == 'single' ? 'checked' : '' }}>
                                <span class="dark:text-gray-200">Single</span>
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="radio" name="account_holder_type" value="joint"
                                    {{ $ddaccount->account?->account_holder_type == 'joint' ? 'checked' : '' }}>
                                <span class="dark:text-gray-200">Joint A/C</span>
                            </label>
                        </div>
                    </div>
                    <!-- Joint Account Member -->
                    <div class="mt-4">
                        <label class="block  font-semibold text-gray-700 dark:text-gray-300 uppercase">
                            Joint Account Customer
                        </label>
                        <select class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border">
                            <option value="">Please Select Customer</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}">
                                    {{ $member->member_no ?? ($member->id ? str_pad($member->id, 6, '0', STR_PAD_LEFT) : '') }}
                                    - {{ $member->member_info_first_name }} {{ $member->member_info_last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Minor -->
                    <div class="mt-4">
                        <label class="block  font-semibold text-gray-700 dark:text-gray-300 uppercase">
                            Minor
                        </label>
                        <select class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border">
                            <option value="">Select Minor</option>
                        </select>
                    </div>
                    <!-- Open Date -->
                    <div class="mt-4">
                        <label class="block  font-semibold text-gray-700 dark:text-gray-300 uppercase">
                            Open Date <span class="text-red-500">*</span>
                        </label>

                        <input type="text" name="open_date" id="date"
                            value="{{ \Carbon\Carbon::parse($ddaccount->open_date)->format('d-m-Y') }}"
                            class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border" />
                    </div>

                    <!-- Amount -->
                    <div class="mt-4">
                        <label class="block font-semibold text-gray-700 dark:text-gray-300 uppercase">
                            Amount <span class="text-red-500">*</span>
                        </label>

                        <input type="number" name="dd_amount" value="{{ $ddaccount->dd_amount }}"
                            placeholder="Enter Amount"
                            class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border" />
                    </div>

                    <!-- Submit -->
                    <div class="flex flex-col mt-6 sm:flex-row gap-3 justify-center">
                        <button type="submit" class="w-full sm:w-auto btn-primary px-3 py-3 uppercase justify-center">
                            Change account info
                        </button>

                        <a href="#" class="w-full sm:w-auto btn-outline px-3 py-3 uppercase justify-center">
                            back
                        </a>
                    </div>

                </form>

            </div>

            <!-- RIGHT - ACCOUNT INFO -->
            <div class="w-full lg:w-1/3 box dark:bg-bg3 rounded-xl shadow overflow-hidden">

                <div class="bg-secondary/5 text-black px-4 py-3 flex justify-between rounded-10 items-center">
                    <h3 class="font-semibold text-lg uppercase">Account Info</h3>
                </div>

                <div class="p-4">
                    <table class="w-full text-sm">
                        <tbody>

                            <tr class="border-b dark:border-gray-700">
                                <td class="py-2 font-semibold dark:text-gray-300 uppercase">Customer</td>
                                <td class="py-2">
                                    {{ $ddaccount->member->member_info_first_name }}
                                </td>
                            </tr>

                            <tr class="border-b dark:border-gray-700">
                                <td class="py-2 font-semibold dark:text-gray-300 uppercase">PAN No</td>
                                <td class="py-2">
                                    {{ $ddaccount->member?->kyc?->member_kyc_pan_no ?? 'N/A' }}
                                </td>
                            </tr>

                            <tr class="border-b dark:border-gray-700">
                                <td class="py-2 font-semibold dark:text-gray-300 uppercase">Account No</td>
                                <td class="py-2">DDA{{ $ddaccount->id }}</td>
                            </tr>

                            <tr class="border-b dark:border-gray-700">
                                <td class="py-2 font-semibold dark:text-gray-300 uppercase">Open Date</td>
                                <td class="py-2">
                                    {{ $ddaccount->open_date ? \Carbon\Carbon::parse($ddaccount->open_date)->format('d-m-Y') : '' }}
                                </td>
                            </tr>

                            <tr class="border-b dark:border-gray-700">
                                <td class="py-2 font-semibold dark:text-gray-300 uppercase">Status</td>
                                <td class="py-2">{{ $ddaccount->dd_no ?? '' }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="py-2 font-semibold dark:text-gray-300 uppercase ">Available Balance</td>
                                <td class="py-2">
                                    {{ optional($ddaccount->transactions->last())->balance_available ?? '0.00' }}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
@endsection
