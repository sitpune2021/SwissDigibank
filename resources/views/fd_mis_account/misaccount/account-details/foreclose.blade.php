@extends('layout.main')
@section('content')
<div class="main-inner">


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

    <div class="mb-4 flex flex-wrap items-center justify-between gap-4 lg:mb-4">
        <div class="flex items-start flex-col gap-2">
            <div class="flex items-center gap-2">
                <h3 class="uppercase text-lg font-semibold">MIS Account - {{$misaccount->mis_account_no}} - Fore Close</h3>
                <p class="text-gray-500 text-xs">Pay Due EMIs</p>
            </div>
            {{-- <p class="text-gray-500">
                <a href="#" class="text-gray-500 text-sm">MIS Account </a> >
                <a href="#" class="text-gray-500 text-sm">1707 </a>>
                <a href="#" class="text-gray-500 text-sm">FORE CLOSE </a>
            </p> --}}
        </div>
    </div>
    <div class="rounded-lg border-l-4 bg-error text-white p-2">

        <i class="las la-ban"> Alert</i>
        <p>You are about to fore close MIS before the minimum lock-in period. So proceed accordingly.</p>

    </div>

    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <!-- Left: Details -->
        <form action="{{ route('misaccount.raiseForecloseRequest',$misaccount->id) }}" method="POST">
            @csrf
            <div class=" w-full">
                <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                    <form action="">
                        <!-- Header -->
                        <div class="px-2 py-3 ">
                            <h3 class="text-lg  border-b mb-4 font-semibold text-black">ACCOUNT DETAILS</h3>
                        </div>
                        <!-- Body -->

                        <div class="col-span-2 md:col-span-1">
                            <div class="col-span-2 md:col-span-1 mt-4 mb-4">
                                <x-datepicker-disabled label="closure Date" name="closure_date" />
                            </div>
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                Current Balance (A)
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id="currentBalance"
                                value=" {{ number_format($currentBalance,2) }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0" readonly>

                        </div>

                        <div class="col-span-2 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                Interest Left to Paid (B)
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id="interestLeftPaid"
                                value=" {{ number_format($interestLeftToPay,2) }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0">

                        </div>

                        <div class="col-span-2 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                TDS to be Deducted (C)
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id="tdsDeducated"
                                value=" {{ number_format($tds,2) }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0">

                        </div>

                        <div class="col-span-2 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                Interest
                                <span class="text-red-500">*</span>
                            </label>
                            <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                                <tbody>
                                    <!-- Column Labels -->
                                    <tr class="">
                                        <th class="text-center px-3 py-1 ">Rate (%)</th>
                                        <th class="text-center px-3 py-1 ">Days</th>
                                        <th class="text-center px-3 py-1 ">Amount</th>

                                    </tr>

                                    <!-- Input Row -->
                                    <tr>
                                        <td class="px-2 py-2 ">
                                            <input type="text" value="{{ $rate }}" name="" id="" placeholder="0" readonly
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <td class="px-2 py-2 ">
                                            <input type="text" value="{{ $totalDays }}" name="" id="" placeholder="0" readonly
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <td class="px-2 py-2 ">
                                            <input type="text" value=" {{ number_format($interestTillDate,2) }}" name="" id="" placeholder="0" readonly
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-span-2 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                Premature Interest
                                <span class="text-red-500">*</span>
                            </label>
                            <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                                <tbody>
                                    <!-- Column Labels -->
                                    <tr class="">
                                        <th class="text-center px-3 py-1 ">Rate (%)</th>
                                        <th class="text-center px-3 py-1 ">Days</th>
                                        <th class="text-center px-3 py-1 ">Amount</th>

                                    </tr>

                                    <!-- Input Row -->
                                    <tr>
                                        <td class="px-2 py-2 ">
                                            <input type="text" value="{{ number_format($prematureRate,2) }}" name="" id="" placeholder="0"
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <td class="px-2 py-2 ">
                                            <input type="text" value="{{ $totalDays }}" name="" id="" placeholder="0" readonly
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <td class="px-2 py-2 ">
                                            <input type="text" value=" {{ number_format($prematureInterest,2) }}" name="" id="" placeholder="0" readonly
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-span-2 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                Notice Charges (D)
                                <span class="text-red-500">*</span>
                            </label>
                            <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                                <tbody>
                                    <!-- Column Labels -->
                                    <tr class="">
                                        <th class="text-center uppercase px-3 py-1 ">Amount</th>
                                        <th class="text-center uppercase px-3 py-1 ">GST Rate (%) </th>
                                        <th class="text-center uppercase px-3 py-1 ">Total Amount</th>

                                    </tr>

                                    <!-- Input Row -->
                                    <tr>
                                        <td class="px-2 py-2 ">
                                            <input type="text" name="" id="" placeholder="0" readonly
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <td class="px-2 py-2 ">
                                            <input type="text" value="{{ $gstRate }}" name="" id="" placeholder="0" readonly
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <td class="px-2 py-2 ">
                                            <input type="text" name="" id="" placeholder="0"
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-span-2 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                Reverse Interest Amount
                                (F = D - E)
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text"
                                value=" {{ number_format($reverseInterest,2) }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0" readonly>

                        </div>

                        <div class="col-span-2 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                Penal Interest Rate (%)
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" value="{{ number_format($penalRate, 2) }}" id="penalInterestRate"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0" readonly>
                        </div>


                        <div class="col-span-2 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                Penal Charges (G)
                                <span class="text-red-500">*</span>
                            </label>
                            <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                                <tbody>
                                    <!-- Column Labels -->
                                    <tr class="">
                                        <th class="text-center uppercase px-3 py-1 ">Amount</th>
                                        <th class="text-center uppercase px-3 py-1 ">GST Rate (%) </th>
                                        <th class="text-center uppercase px-3 py-1 ">T. Amount</th>

                                    </tr>

                                    <!-- Input Row -->
                                    <tr>
                                        <td class="px-2 py-2 ">
                                            <input type="text" value="{{ number_format($penalCharges,2) }}" name="" id="" placeholder="0"
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <td class="px-2 py-2 ">
                                            <input type="text" value="{{ $gstRate }}" name="" id="" placeholder="0" readonly
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <td class="px-2 py-2 ">
                                            <input type="text" value=" {{ number_format($penalChargesWithGst, 2) }}" name="" id="" placeholder="0" readonly
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class="col-span-2 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                Cancellation Charges (H)
                            </label>
                            <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                                <tbody>
                                    <!-- Column Labels -->
                                    <tr class="">
                                        <th class="text-center uppercase px-3 py-1 ">Amount</th>
                                        <th class="text-center uppercase px-3 py-1 ">GST Rate (%) </th>
                                        <th class="text-center uppercase px-3 py-1 ">T. Amount</th>

                                    </tr>

                                    <!-- Input Row -->
                                    <tr>
                                        <td class="px-2 py-2 ">
                                            <input type="text" value=" {{ number_format($cancellationCharge,2) }}" name="" id="" placeholder="0"
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <td class="px-2 py-2 ">
                                            <input type="text" value=" {{ $gstRate }} " name="" id="" placeholder="0" readonly
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                        <td class="px-2 py-2 ">
                                            <input type="text" value=" {{ number_format($cancellationTotal,2) }}" name="" id="" placeholder="0" readonly
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class="col-span-2 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                Total Account
                                (I = A + B - C - F - G - H)
                            </label>
                            <input type="text" id="totalAccount"
                                value=" {{ number_format($totalSettlement,2) }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0">
                        </div>
                        <hr>

                        <div class="col-span-2 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                Rounding Off (J)
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" value="{{ round($totalSettlement) }}" id="netAmountCollect"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0" readonly>
                        </div>

                        <div class="col-span-2 md:col-span-1 mb-4">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                Final Amount To Release
                                (I - J) (if any)
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id="netAmountCollect"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0" readonly>
                        </div>

                        <input type="hidden" name="interest_left_paid" value="{{ $interestLeftToPay }}">
                        <input type="hidden" name="tds" value="{{ $tds }}">
                        <input type="hidden" name="reverse_interest" value="{{ $reverseInterest }}">
                        <input type="hidden" name="penal_charges" value="{{ $penalCharges }}">
                        <input type="hidden" name="cancellation_charge" value="{{ $cancellationCharge }}">
                        <input type="hidden" name="total_account" value="{{ $totalSettlement }}">
                        <input type="hidden" name="rounding_off" value="{{ $roundingOff }}">
                        <input type="hidden" name="final_amount" value="{{ $finalAmount }}">


                        <!-- Buttons -->
                        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                            <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                                Raise Request
                            </button>

                            <button class="btn-outline uppercase justify-center" type="reset">
                                <a href="#"> BACK</a>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </form>
        <!-- Left: Details -->
        <div class=" w-full  overflow-hidden">

            <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg">
                <!-- Header -->
                <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                    <h3 class="text-black uppercase font-semibold text-lg">MIS Account Info</h3>

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
                                <td class="uppercase font-semibold px-3 py-2 w-1/3">Customer</td>
                                <td class="px-3 py-2">{{ $misaccount->member->member_no }} -
                                    {{ $misaccount->member->member_info_first_name }}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="uppercase font-semibold px-3 py-2">Open Date</td>
                                <td class="px-3 py-2">{{ \Carbon\Carbon::parse($misaccount->open_date)->format('d/m/Y') }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="uppercase font-semibold px-3 py-2">Maturity Date</td>
                                <td class="px-3 py-2"> {{ \Carbon\Carbon::parse($misaccount->maturity_date)->format('d/m/Y') }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="uppercase font-semibold px-3 py-2">Status</td>
                                <td class="px-3 py-2"> {{ $misaccount->status == 1 ? 'Active' : 'Closed' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- scheme info-->
            <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                <div
                    class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer">
                    <h3 class="text-lg font-semibold uppercase">Scheme Info</h3>
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
                                <td class="uppercase font-semibold px-3 py-2 w-1/3">Scheme</td>
                                <td class="px-3 py-2">{{ $misaccount->fdScheme->scheme_name }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="uppercase font-semibold px-3 py-2">Tenure</td>
                                <td class="px-3 py-2">{{ ($misaccount->tenure_year * 12) + $misaccount->tenure_month }}
                                    MONTHS</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="uppercase font-semibold px-3 py-2">MIs Lock In Period</td>
                                <td class="px-3 py-2">{{ $misaccount->fdScheme->lock_in_period }} Months</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="uppercase font-semibold px-3 py-2">Annual Interest Rate</td>
                                <td class="px-3 py-2">{{ $rate }} %</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="uppercase font-semibold px-3 py-2">Interest Lock In Period</td>
                                <td class="px-3 py-2"> {{ $misaccount->fdScheme->interest_in_period }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="uppercase font-semibold px-3 py-2">Penal Charges</td>
                                <td class="px-3 py-2">{{ $misaccount->fdScheme->penal_charge ?? 0 }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="uppercase font-semibold px-3 py-2">Fore Closure Charges</td>
                                <td class="px-3 py-2"> static</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="box bg-white dark:bg-bg3 border mt-5 shadow-md rounded-lg">
                <!-- Header -->
                <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                    <h3 class="text-black uppercase font-semibold text-lg">Interest info till date : 30/10/2025 static</h3>

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
                                <td class="uppercase font-semibold px-3 py-2 w-1/3">
                                    Interest Credited</td>
                                <td class="px-3 py-2"> (590,500.00) static</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="uppercase font-semibold px-3 py-2">Interest Released</td>
                                <td class="px-3 py-2"> 13,500.00 static</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="uppercase font-semibold px-3 py-2">TDS Deducted</td>
                                <td class="px-3 py-2"> 1,500.00 static</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="uppercase font-semibold px-3 py-2">Interest Available to Release</td>
                                <td class="px-3 py-2"> (605,500.00) static</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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