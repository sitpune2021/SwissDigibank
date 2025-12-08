@extends('layout.main')
@section('content')
<div class="main-inner">

    <head>
        <style>
            input[type="radio"] {
                width: 24px;
                height: 24px;
                accent-color: green;
            }

            input[type="checkbox"] {
                width: 28px;
                height: 28px;
                accent-color: green;
                /* For modern browsers */
            }

            /* Fallback for browsers without accent-color support */
            input[type="checkbox"]:checked {
                background-color: green;
                border: none;
            }
        </style>
    </head>

    <div class="mb-4 flex flex-wrap items-center justify-between gap-4 lg:mb-4">
        <div class="flex items-start flex-col gap-2">
            <h3 class="uppercase text-lg font-semibold">
                Mortgage Loan - Link Saving Account for Auto Debit EMI
            </h3>
        </div>
    </div>


    <div class="flex flex-col  dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">

        <div class=" w-full  box overflow-hidden">

            <div class="col-span-2 md:col-span-1 mb-4">
                <p class="uppercase border-b text-lg font-bold"> Link member saving account to loan for auto debit EMI on due date</p>
            </div>

            <form action="{{ route('mortgage.account.storeSavingAccount', $goldLoan->id) }}" method="POST">
            @csrf

                <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                        Select Saving Account 
                        <span class="text-red-500">*</span>
                    </label>

                    <select name="saving_account_id" 
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                        <option value="">Select Saving Account</option>

                        @foreach($savingAccounts as $id => $account)
                            <option value="{{ $id }}">{{ $account }}</option>
                        @endforeach
                    </select>
                    @error('saving_account_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                        
                </div>
             
                <div class="col-span-2 md:col-span-1 mt-8 mb-2">
                    <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                        <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                          Link Account
                        </button>

                        <button class="btn-outline uppercase justify-center" type="reset">
                            <a href="{{ route('mortgage.account.show', $goldLoan->id) }}">BACK</a>
                        </button>
                    </div>
                </div>

            </form>

        </div>

         
        <div class=" w-full  overflow-hidden">

            <!--  Application Info -->
            <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg">

                <!-- Header -->
                <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                    <h3 class="text-black uppercase font-semibold text-lg">Mortgage Loan Account Info</h3>
                    <!-- Toggle Button -->
                    <button class="p-1 rounded transition" onclick="toggleSection(this)">
                        <span class="toggle-icon text-lg font-bold">+</span>
                    </button>
                </div>

                <!-- Content (Initially Hidden) -->
                <div class="overflow-x-auto p-4 hidden">
                   <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                            <tbody>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold uppercase px-3 py-2 w-1/3">Loan No.</td>
                                    <td class="px-3 py-2">{{ $goldLoan->id }}</td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold uppercase px-3 py-2">Customer</td>
                                    <td class="px-3 py-2">
                                        {{ $goldLoan->member->member_no }} - {{ $goldLoan->member->member_info_first_name }}
                                    </td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold uppercase px-3 py-2">Open Date</td>
                                    <td class="px-3 py-2">{{ \Carbon\Carbon::now()->format('d-m-Y') }}</td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold uppercase px-3 py-2">Scheme</td>
                                    <td class="px-3 py-2">{{ $goldLoan->scheme->scheme_name }}</td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold uppercase px-3 py-2">Loan Amount</td>
                                    <td class="px-3 py-2">₹ {{ number_format($goldLoan->loan_amount, 2) }}</td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold uppercase px-3 py-2">Current Debt</td>
                                    <td class="px-3 py-2">₹ {{ number_format($currentDebt, 2) }}</td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold uppercase px-3 py-2">Annual Interest Rate</td>
                                    <td class="px-3 py-2">{{ $goldLoan->scheme->annual_interest_rate }} %</td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold uppercase px-3 py-2">Interest Type</td>
                                    <td class="px-3 py-2">{{ ucfirst($goldLoan->scheme->gold_loan_setting) }}</td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold uppercase px-3 py-2">Tenure</td>
                                    <td class="px-3 py-2">{{ $goldLoan->scheme->tenure }} MONTHS</td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold uppercase px-3 py-2">Status</td>
                                    <td class="px-3 py-2">
                                        {{ $goldLoan->status == 1 ? 'Active' : 'Inactive' }}
                                    </td>
                                </tr>

                            </tbody>
                    </table>
                </div>

            </div>

            <!--Member Info-->
            <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">

                <div
                    class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer">
                    <h3 class="text-lg font-semibold uppercase">
                        Customer Info
                    </h3>
                    <div class="">
                        <button type="button" class="p-1 rounded transition"
                            onclick="toggleSection(this)">
                            <span class="toggle-icon text-lg font-bold">+</span>
                        </button>
                    </div>
                </div>

                <!-- Body -->
                <div class="overflow-x-auto p-4 hidden">
                   <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2 w-1/3">Customer</td>
                                <td class="px-3 py-2">{{ $goldLoan->member->member_no }} - {{ $goldLoan->member->member_info_first_name }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Branch</td>
                                <td class="px-3 py-2">{{ $goldLoan->branch->branch_name }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">DOB</td>
                                <td class="px-3 py-2">
                                       {{ \Carbon\Carbon::parse($goldLoan->member->member_info_dob)->format('d-m-Y') }}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">
                                    Gender
                                </td>
                                <td class="px-3 py-2">
                                    {{ $goldLoan->member->member_info_gender }}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">
                                    Father Name
                                </td>
                                <td class="px-3 py-2">{{ $goldLoan->member->member_info_middle_name }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">
                                  Occupation
                                </td>
                                <td class="px-3 py-2">{{ $goldLoan->member->member_info_occupation }}</td>
                            </tr>                 
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>



<script>
    function toggleSection(button) {
            const section = button.closest('.box').querySelector('.overflow-x-auto');
            const icon = button.querySelector('.toggle-icon');
            section.classList.toggle('hidden');
            icon.textContent = section.classList.contains('hidden') ? '+' : '−';
        }
</script>


@endsection