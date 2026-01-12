@extends('layout.main')

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
            <h1 class="text-lg font-semibold dark:text-white">RD - {{ $rdAccount->id }}</h1>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">

        <!-- LEFT FORM -->
        <div class="flex-1 w-full bg-white dark:bg-bg3 rounded-xl shadow p-6">
            <form class="space-y-6" method="POST" action="
            {{-- {{ route('rd.change-info.update', $rdAccount->id) }} --}}
             ">
                @csrf

                <h3 class="text-lg text-black dark:text-white p-1">CHANGE ACCOUNT INFO</h3>
                <hr class="border-gray-200 dark:border-gray-700" />

                <!-- Scheme -->
                <div class="mt-4">
                    <label class="block font-medium text-gray-700 dark:text-gray-300 uppercase">
                        Scheme <span class="text-red-500">*</span>
                    </label>

                    <select name="scheme"
                        class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border">

                        @if ($rdAccount->scheme)
                        <option value="{{ $rdAccount->scheme->id }}" selected>
                            RD00{{ $rdAccount->scheme->id }} - {{ $rdAccount->scheme->scheme_name }}
                        </option>
                        @endif

                        @foreach ($schemes as $scheme)
                        @if ($rdAccount->scheme_id != $scheme->id)
                        <option value="{{ $scheme->id }}">
                            RD00{{ $scheme->id }} - {{ $scheme->scheme_name }}
                        </option>
                        @endif
                        @endforeach

                    </select>
                </div>

                <!-- Account Type -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">
                        Account Type <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2 flex gap-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="account_type" value="single"
                                {{ strtolower($rdAccount->account_type) == 'single' ? 'checked' : '' }}>
                            <span class="dark:text-gray-200">Single</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="radio" name="account_type" value="joint"
                                {{ strtolower($rdAccount->account_type) == 'joint' ? 'checked' : '' }}>
                            <span class="dark:text-gray-200">Joint A/C</span>
                        </label>
                    </div>

                    <!-- <div class="mt-2 flex gap-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="account_type" value="single" 
                                {{ $rdAccount->account?->account_type == 'single' ? 'checked' : '' }}>
                            <span class="dark:text-gray-200">Single</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="radio" name="account_type" value="joint"
                                {{ $rdAccount->account?->account_type == 'joint' ? 'checked' : '' }}>
                            <span class="dark:text-gray-200">Joint A/C</span>
                        </label>
                    </div> -->
                </div>
                <!-- Joint Account Member -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">
                        Joint Account Customer
                    </label>
                    <select name="joint_member_id" class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border">
                        <option value="">Please Select Customer</option>
                        @if($rdAccount->joint_member_id && $rdAccount->jointMember)
                        <option value="{{ $rdAccount->joint_member_id }}" selected>
                            {{ $rdAccount->jointMember->member_no ?? str_pad($rdAccount->jointMember->id, 6, '0', STR_PAD_LEFT) }}
                            - {{ $rdAccount->jointMember->member_info_first_name }} {{ $rdAccount->jointMember->member_info_last_name }}
                        </option>
                        @endif


                        @foreach ($members as $member)
                        @if($member->id != $rdAccount->joint_member_id)
                        <option value="{{ $member->id }}">
                            {{ $member->member_no ?? str_pad($member->id, 6, '0', STR_PAD_LEFT) }}
                            - {{ $member->member_info_first_name }} {{ $member->member_info_last_name }}
                        </option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <!-- Minor -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">
                        Minor
                    </label>
                    <select class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border">
                        <option value="">Select Minor</option>
                    </select>
                </div>
                <!-- Open Date -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">
                        Open Date <span class="text-red-500">*</span>
                    </label>

                    <input type="text" name="open_date" id="date"
                        value="{{ \Carbon\Carbon::parse($rdAccount->open_date)->format('d-m-Y') }}"
                        class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border" />
                </div>

                <!-- Amount -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">
                        Amount <span class="text-red-500">*</span>
                    </label>

                    <input type="number" name="rd_amount" value="{{ $rdAccount->rd_amount }}"
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
                                {{ $rdAccount->member->member_info_first_name }} {{ $rdAccount->member->member_info_last_name }}
                            </td>
                        </tr>

                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2 font-semibold dark:text-gray-300 uppercase">PAN No</td>
                            <td class="py-2">
                                {{ $rdAccount->member?->kyc?->member_kyc_pan_no ?? 'N/A' }}
                            </td>
                        </tr>

                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2 font-semibold dark:text-gray-300 uppercase">Account No</td>
                            <td class="py-2">RD -{{ $rdAccount->id }}</td>
                        </tr>

                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2 font-semibold dark:text-gray-300 uppercase">Open Date</td>
                            <td class="py-2">
                                {{ $rdAccount->open_date ? \Carbon\Carbon::parse($rdAccount->open_date)->format('d-m-Y') : '' }}
                            </td>
                        </tr>

                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2 font-semibold dark:text-gray-300 uppercase">Status</td>
                            @if( $rdAccount->approve_status == 'Approved')<td class="py-2">Active</td>@endif
                        </tr>

                        <tr>
                            <td class="py-2 font-semibold dark:text-gray-300 uppercase">Available Balance</td>
                            <td class="py-2">₹ {{ $balance }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>
@endsection