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

        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-center flex-row gap-2">
                <h3 class="text-xl font-semibold uppercase">
                    Commission Payout
                </h3>

            </div>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <!-- Left: Details -->
            <div class=" w-full  overflow-hidden">
                <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full whitespace-nowrap">
                            <tbody class="divide-y divide-gray-100">

                                <tr class="border-b">
                                    <td class="font-semibold text-gray-700 bg-gray-50 w-1/3 p-3 uppercase">Agent Name</td>
                                    <td class="p-3">
                                        <a href="" class="text-primary hover:underline">
                                            3212 - arun sh
                                        </a>
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold text-gray-700 bg-gray-50 p-3 uppercase">Transaction Date</td>
                                    <td class="p-3">31-10-2025</td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold text-gray-700 bg-gray-50 p-3 uppercase">Commission Type</td>
                                    <td class="p-3"></td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold text-gray-700 bg-gray-50 p-3 uppercase">Transaction Type</td>
                                    <td class="p-3 capitalize">Debit</td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold text-gray-700 bg-gray-50 p-3 uppercase">Amount</td>
                                    <td class="p-3  font-medium">₹ 500.00</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold text-gray-700 bg-gray-50 p-3 uppercase">Transaction Status</td>
                                    <td class="p-3">
                                        Approved
                                    </td>
                                </tr>

                                  <tr class="border-b">
                                    <td class="font-semibold text-gray-700 bg-gray-50 p-3 uppercase">Payment Mode</td>
                                    <td class="p-3">System</td>
                                </tr>

                                  <tr class="border-b">
                                    <td class="font-semibold text-gray-700 bg-gray-50 p-3 uppercase">Remarks</td>
                                    <td class="p-3">e3ee</td>
                                </tr>

                                  <tr class="border-b">
                                    <td class="font-semibold text-gray-700 bg-gray-50 p-3 uppercase">Created at</td>
                                    <td class="p-3">12-12-2023</td>
                                </tr>

                                  <tr class="border-b">
                                    <td class="font-semibold text-gray-700 bg-gray-50 p-3 uppercase">Updated at</td>
                                    <td class="p-3">12-12-2023</td>
                                </tr>

                                 <tr class="border-b">
                                    <td class="font-semibold text-gray-700 bg-gray-50 p-3 uppercase">Is Accounted</td>
                                    <td class="p-3">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                  <tr class="border-b">
                                    <td class="font-semibold text-gray-700 bg-gray-50 p-3 uppercase">Branch</td>
                                    <td class="p-3"></td>
                                </tr>

                                 <tr class="border-b">
                                    <td class="font-semibold text-gray-700 bg-gray-50 p-3 uppercase">Entry Created By</td>
                                    <td class="p-3">Test Test</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!--Rigth: Do Not Remove it -->
            <div class=" w-full  overflow-hidden">
                <!--  Do Not Remove it -->
            </div>

        </div>

    </div>
    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

    <!-- Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const datepickers = document.querySelectorAll('.datepicker-field');
            const today = new Date();

            datepickers.forEach(function (dateInput) {
                // Initialize the datepicker with maxDate = today
                const picker = new Datepicker(dateInput, {
                    autohide: true,
                    format: 'dd-mm-yyyy',
                    maxDate: today,
                });

                // Set today's date as default value
                const formattedDate = today.toLocaleDateString('en-GB').split('/').join('-');
                dateInput.value = formattedDate;

                // Optional: open picker when calendar icon is clicked
                const calendarIcon = dateInput.parentElement.querySelector('.la-calendar');
                if (calendarIcon) {
                    calendarIcon.addEventListener('click', () => picker.show());
                }
            });
        });
    </script>

@endsection