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
            <h1 class="text-xl font-semibold dark:text-white">FD - {{$fdAccountDetail->id}}</h1>


            <p class="text-gray-500 dark:text-gray-400">
                <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">Fd Accounts</a> >
                <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">{{$fdAccountDetail->id}}</a> >
                <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">change Account Info</a>
            </p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Left Side: Form -->
        <div class="flex-1 w-full bg-white dark:bg-bg3 rounded-xl shadow p-6">
            <form class="space-y-6">
                <h3 class="text-2xl text-black dark:text-white p-1">CHANGE ACCOUNT INFO</h3>
                <hr class="border-gray-200 dark:border-gray-700" />

                <p class="text-sm mt-3 text-black dark:text-gray-300">
                    Are you sure you want to change account info?
                </p>

                <!-- Member -->
                <div class="mt-4">
                    <label class="block font-medium text-gray-700 dark:text-gray-300">
                        Member <span class="text-red-500">*</span>
                    </label>
                    <select class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border">
                        {{-- First show selected member --}}
                        @if($fdAccountDetail->member )
                        <option value="{{ $fdAccountDetail->member->id }}" selected>
                            Demo-{{ $fdAccountDetail->member->id }} -
                            {{ $fdAccountDetail->member->member_info_first_name }} {{ $fdAccountDetail->member->member_info_last_name }}
                        </option>
                        @endif

                        {{-- Then show all others --}}
                        @foreach($members as $member)
                        @if($fdAccountDetail->member_id != $member->id)
                        <option value="{{ $member->id }}">
                            Demo-{{ $member->id }} - {{ $member->member_info_first_name }} {{ $member->member_info_last_name }}
                        </option>
                        @endif
                        @endforeach
                    </select>

                </div>

                <!-- Account Type -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Account Type <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2 flex gap-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="account_type" value="single"
                                class="text-green-600 focus:ring-green-500 border-gray-300 dark:border-gray-600" checked>
                            <span class="dark:text-gray-200">Single</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="account_type" value="joint"
                                class="text-green-600 focus:ring-green-500 border-gray-300 dark:border-gray-600">
                            <span class="dark:text-gray-200">Joint A/C</span>
                        </label>
                    </div>
                </div>

                <!-- Joint Account Member -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Joint Account Member
                    </label>
                    <select
                        class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border">
                        <option value="">Please Select Member</option>
                        @foreach($members as $member)
                        <option value="{{ $member->id }}">
                            Demo-{{ $member->id }} - {{ $member->member_info_first_name }} {{ $member->member_info_last_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Minor -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Minor
                    </label>
                    <select
                        class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border">
                        <option value="">Select Minor</option>
                    </select>
                </div>

                <!-- Open Date -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Open Date <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="date" placeholder="DD/MM/YYYY" value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}"
                        class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border" />
                </div>

                <!-- Buttons -->
                <div class="flex flex-col mt-6 sm:flex-row gap-3 justify-center">
                    <button type="submit"
                        class="w-full sm:w-auto btn-primary px-3 py-3 uppercase justify-center">
                        Change account info
                    </button>
                    <a href="#"
                        class="w-full sm:w-auto btn-outline px-3 py-3 uppercase justify-center">
                        back
                    </a>
                </div>
            </form>
        </div>

        <!-- Right Side: Account Info -->
        <div class="w-full lg:w-1/3 box dark:bg-bg3 rounded-xl shadow overflow-hidden">
            <div class="bg-secondary/5 text-black px-4 py-3 flex justify-between  rounded-10 items-center">
                <h3 class="font-semibold">Account Info</h3>
            </div>
            <div class="p-4">
                <table class="w-full text-sm">
                    <tbody>
                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2 font-semibold dark:text-gray-300">Member</td>
                            <td class="py-2">
                                <a href="#" class="text-green-600 hover:underline">
                                   {{ $fdAccountDetail->member->member_info_first_name }}
                                </a>
                            </td>
                        </tr>
                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2 font-semibold dark:text-gray-300">PAN No</td>
                            <td class="py-2"> {{$fdAccountDetail->member?->kyc?->member_kyc_pan_no??'N/A'}} </td>
                        </tr>
                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2 font-semibold dark:text-gray-300">Account No</td>
                            <td class="py-2">{{$fdAccountDetail->id}}</td>
                        </tr>
                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2 font-semibold dark:text-gray-300">Open Date</td>
                            <td class="py-2">{{$fdAccountDetail->open_date}}</td>
                        </tr>
                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2 font-semibold dark:text-gray-300">Status</td>
                            <td class="py-2">Active</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold dark:text-gray-300">Available Balance</td>
                            <td class="py-2">45,000.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection