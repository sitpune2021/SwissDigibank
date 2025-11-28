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
            <div class="flex items-center  flex-row gap-2">
                <h3 class="uppercase text-xl font-semibold">
                    Fore Close DD - DDA03631
                </h3>
            </div>
        </div>
        <div class="bg-error p-3 text-white rounded-10">
            <h3 class="text-xl"> Alert!</h3>
            <p class="text-sm mt-3">
                You are about to fore close DD before the minimum lock-in period. So proceed accordingly.
            </p>
        </div>
        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-4 gap-5">
            <!-- Left: Details -->
            <div class=" w-full  overflow-hidden">
                <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                    <form action="">
                        <!-- Header -->
                        <div class="px-4 py-3 ">
                            <h3 class="text-lg  border-b mb-4 font-semibold text-black">ACCOUNT DETAILS</h3>
                        </div>
                        <!-- Body -->

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg uppercase font-medium block mb-2">
                                Closure Date
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id=""
                                class="datepicker-field w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="DD/MM/YYYY">
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label for="current_balance" class="md:text-md  uppercase font-medium block mb-4">
                                Current Balance (A)
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id="current_balance" value="{{ $balanceAvailable ?? 0.0 }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0" readonly>
                            <x-number-to-word for="current_balance" />
                        </div>
                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                Interest Left to Paid (B)
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0">
                            <x-number-to-word for="" />

                        </div>
                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                TDS to be Deducted (C)
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0">
                            <x-number-to-word for="" />

                        </div>
                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg uppercase font-medium block mb-2">
                                Penal Charges (D)
                                <span class="text-red-500">*</span>
                            </label>
                            <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                                <tbody>
                                    <!-- Column Labels -->
                                    <tr class="">
                                        <th class="text-center px-3 py-1 ">Amount</th>
                                        <th class="text-center px-3 py-1 ">GST Rate (%) </th>
                                        <th class="text-center px-3 py-1 ">Total Amount</th>

                                    </tr>

                                    <!-- Input Row -->
                                    <tr class="">

                                        <td class="px-2 py-2 ">
                                            <input type="number" name="" id="" placeholder="0"
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>


                                        <td class="px-2 py-2 ">
                                            <input type="number" name="" id="" placeholder="0" readonly
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>


                                        <td class="px-2 py-2 ">
                                            <input type="number" name="" id="" placeholder="0" readonly
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>


                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg uppercase font-medium block mb-2">
                                Cancellation Charges (E)

                            </label>
                            <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                                <tbody>
                                    <!-- Column Labels -->
                                    <tr class="">
                                        <th class="text-center px-3 py-1 ">Amount</th>
                                        <th class="text-center px-3 py-1 ">GST Rate (%) </th>
                                        <th class="text-center px-3 py-1 ">Total Amount</th>

                                    </tr>

                                    <!-- Input Row -->
                                    <tr class="">

                                        <td class="px-2 py-2 ">
                                            <input type="number" name="" id="" placeholder="0"
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>


                                        <td class="px-2 py-2 ">
                                            <input type="number" name="" id="" placeholder="0" readonly
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                        </td>


                                        <td class="px-2 py-2 ">
                                            <input type="number" name="" id="" placeholder="0"
                                                class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base"
                                                readonly />
                                        </td>


                                    </tr>
                                </tbody>
                            </table>

                        </div>


                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg uppercase font-medium block mb-2">
                                Total Amount
                                (F = A + B - C - D - E)
                            </label>

                            <input type="number" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0" readonly>
                            <x-number-to-word for="" />

                        </div>
                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg uppercase font-medium block mb-2">
                                Rounding Off (G)
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id="roundingOff"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0" readonly>
                            <x-number-to-word for="roundingOff" />

                        </div>
                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg uppercase font-medium block mb-2">
                                Final Amount To Release
                                (F - G) (if any)
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="number" id="" readonly
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="0.0">
                            <x-number-to-word for="" />

                        </div>


                        <!-- Buttons -->
                        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                            <button class="btn-primary uppercase justify-center" type="submit" name="">
                                RAISE REQUEST
                            </button>

                            <button class="btn-outline uppercase justify-center" type="reset">
                                <a href="#"> BACK</a>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- right: Details -->
            <div class=" w-full  overflow-hidden">

                <div class="box toggle-box bg-white dark:bg-bg3 border shadow-md rounded-lg">
                    <!-- Header -->
                    <div class=" ">
                        <button
                            class="toggle-btn flex items-center justify-between w-full bg-secondary/5 text-black px-4 py-3 rounded-10 cursor-pointer">
                            <h3 class="text-lg font-semibold uppercase">
                                DD Info
                            </h3>
                            <span class="toggle-icon text-lg font-bold">+</span>
                        </button>

                    </div>

                    <!-- Content (Initially Hidden) -->
                    <div class="overflow-x-auto p-4 toggle-content">
                        <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                            <tbody>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Member</td>
                                    <td class="px-3 py-2">
                                        <a href="" class="text-primary">
                                            {{ ($ddaccount->member?->member_no ??
                                                ($ddaccount->member?->id ? str_pad($ddaccount->member->id, 6, '0', STR_PAD_LEFT) : '-')) .
                                                ' - ' .
                                                $ddaccount->member->member_info_first_name ??
                                                'N/A' }}
                                    </td> </a>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 ">
                                    <td class="font-semibold px-3 py-2 uppercase">Open Date </td>
                                    <td class="px-3 py-2"> {{ $ddaccount->open_date?->format('d-m-Y') }}</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Balance Available</td>
                                    <td class="px-3 py-2">{{ number_format($balanceAvailable, 2) }}</td>
                                </tr>

                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Maturity Date </td>
                                    <td class="px-3 py-2"> {{ $ddaccount->maturity_date?->format('d-m-Y') }}</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Status</td>
                                    <td class="px-3 py-2">
                                        Active(static)
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="box toggle-box bg-white dark:bg-bg3 mt-5 border shadow-md rounded-lg">
                    <!-- Header -->
                    <div class=" ">
                        <button
                            class="toggle-btn flex items-center justify-between w-full bg-secondary/5 text-black px-4 py-3 rounded-10 cursor-pointer">
                            <h3 class="text-lg font-semibold uppercase">
                                Scheme Info
                            </h3>
                            <span class="toggle-icon text-lg font-bold">+</span>
                        </button>

                    </div>

                    <!-- Content (Initially Hidden) -->
                    <div class="overflow-x-auto p-4 hidden  toggle-content">
                        <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                            <tbody>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 w-1/3 uppercase">Scheme </td>
                                    <td class="px-3 py-2">
                                        {{ $ddaccount->scheme->scheme_name }} </td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Tenure</td>
                                    <td class="px-3 py-2">
                                        {{ $ddaccount->scheme->tenure_of_rd_dd_value }}
                                        {{ $ddaccount->scheme->tenure_of_rd_dd_type }}
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 ">
                                    <td class="font-semibold px-3 py-2 uppercase">DD Lock In Period </td>
                                    <td class="px-3 py-2">{{ $ddaccount->scheme->rd_dd_lock_in_period }}</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Annual Interest Rate </td>
                                    <td class="px-3 py-2">{{ $ddaccount->scheme->anuual_interest_rate }}</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Interest Lock In Period </td>
                                    <td class="px-3 py-2">{{ $ddaccount->scheme->interest_lock_in_period }}</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">Penal Charges </td>
                                    <td class="px-3 py-2">{{ $ddaccount->scheme->penal_charges ?? '-' }} %</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="font-semibold px-3 py-2 uppercase">
                                        Fore Closure Charges
                                    </td>
                                    <td class="px-3 py-2"> (static)
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>

        <!-- Datepicker CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

        <!-- Datepicker JS -->
        <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll('.datepicker-field').forEach(function(dateInput) {
                    const picker = new Datepicker(dateInput, {
                        autohide: true,
                        format: 'dd-mm-yyyy',
                        maxDate: new Date(),
                    });

                    if (!dateInput.value) {
                        const today = new Date();
                        const formattedDate = today.toLocaleDateString('en-GB').split('/').join('-');
                        dateInput.value = formattedDate;
                    }

                    const calendarIcon = dateInput.parentElement.querySelector('.la-calendar');
                    if (calendarIcon) {
                        calendarIcon.addEventListener('click', () => picker.show());
                    }
                });
            });
        </script>

        {{-- button toggle --}}
        <script>
            document.querySelectorAll(".toggle-box").forEach((box) => {
                const btn = box.querySelector(".toggle-btn");
                const content = box.querySelector(".toggle-content");
                const icon = box.querySelector(".toggle-icon");

                btn.addEventListener("click", () => {
                    content.classList.toggle("hidden");
                    icon.textContent = content.classList.contains("hidden") ? "+" : "-";
                });
            });
        </script>


        <!-- pay mode -->
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const radios = document.querySelectorAll('input[name="fee_mode"]');
                const bankDropdownWrapper = document.getElementById("bankDropdownWrapper");
                const onlineFields = document.getElementById("onlineFields");
                const rdTransaction = document.getElementById("rdTransaction");

                radios.forEach(radio => {
                    radio.addEventListener("change", () => {
                        bankDropdownWrapper.classList.add("hidden");
                        onlineFields.classList.add("hidden");
                        rdTransaction.classList.add("hidden");

                        if (radio.value === "cheque" && radio.checked) {
                            bankDropdownWrapper.classList.remove("hidden");
                        }
                        if (radio.value === "online" && radio.checked) {
                            onlineFields.classList.remove("hidden");
                        }
                        if (radio.value === "saving_acc" && radio.checked) {
                            rdTransaction.classList.remove("hidden");
                        }
                    });
                });

                // Default dates
                let today = new Date().toISOString().split('T')[0];
                document.getElementById("cheque_date").value = today;
                document.getElementById("transfer_date").value = today;
            });
        </script>
    @endsection
