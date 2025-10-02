
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
            <h1 class="text-xl font-semibold dark:text-white">FD - 03754</h1>
            <!-- <p class="text-gray-500 dark:text-gray-400">
                <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">Fd Accounts</a> >
                <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">03754</a> >
                <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">change Account Info</a>
            </p> -->
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

                <!-- Member -->
                <div class="mt-4">
                    <label class="block font-medium text-gray-700 dark:text-gray-300 uppercase">
                        Member <span class="text-red-500">*</span>
                    </label>
                    <select name="member_id"
                        class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border">
                        <option value="">-- Select Member --</option>
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
                                {{ $account->account_type == 'joint' ? 'checked' : '' }}
                                >
                            <span>Joint A/C</span>
                        </label>
                    </div>
                </div>

                   <!-- Joint Account Member -->
                <div class="mt-4" id="jointAccountInput">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">
                        Joint Account Member
                    </label>
                    <select name="joint_member_id"
                        class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border">
                        <option value="">-- Select Joint Member --</option>
                        @foreach($jointMembers as $id => $name)
                            <option value="{{ $id }}" {{ $account->joint_member_id == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
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
                        class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border" />
                </div>

                <!-- MIS Joint Date -->
                <div class="mt-4">
                    <label class="block text-sm font-medium uppercase">MIS Joint Date <span class="text-red-500">*</span></label>
                    <input type="text" name="mis_joint_date" id="date2"
                        value="{{ old('mis_joint_date', $account->mis_joint_date ? \Carbon\Carbon::parse($account->mis_joint_date)->format('d-m-Y') : '') }}"
                        placeholder="DD/MM/YYYY"
                        class="mt-2 px-3 py-3 bg-secondary/5 dark:bg-bg-3 w-full rounded-10 border" />
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
                            <td class="py-2 font-semibold dark:text-gray-300 uppercase">Member</td>
                            <td class="py-2">
                                <a href="#" class="text-green-600 hover:underline">
                                    DEMO-01231 - PRATIK
                                </a>
                            </td>
                        </tr>
                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2 font-semibold dark:text-gray-300 uppercase">PAN No</td>
                            <td class="py-2"></td>
                        </tr>
                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2 font-semibold dark:text-gray-300 uppercase">Account No</td>
                            <td class="py-2">03754</td>
                        </tr>
                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2 font-semibold dark:text-gray-300 uppercase">Open Date</td>
                            <td class="py-2">13/08/2025</td>
                        </tr>
                        <tr class="border-b dark:border-gray-700">
                            <td class="py-2 font-semibold dark:text-gray-300 uppercase">Status</td>
                            <td class="py-2">Active</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-semibold dark:text-gray-300 uppercase">Available Balance</td>
                            <td class="py-2">45,000.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const radios = document.querySelectorAll("input[name='account_type']");
        const jointInput = document.getElementById("jointAccountInput");
 
        radios.forEach(radio => {
            radio.addEventListener("change", function () {
                if (this.value === "joint") {
                    jointInput.classList.remove("hidden");
                } else {
                    jointInput.classList.add("hidden");
                }
            });
        });
    });
</script>


@endsection
