@extends('layout.main')

<style>
    .breadcrumb {
        list-style: none;
        display: flex;
        padding: 0;
        margin-bottom: 1rem;
        font-size: 14px;
    }

    .btn-outline:active {
        transform: scale(0.96);
        opacity: 0.7;
    }

    .breadcrumb li+li::before {
        content: "/";
        padding: 0 8px;
        color: #888;
    }

    .breadcrumb li a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb li.active {
        color: #555;
    }

    .custom-thead {
        background-color: #e6f4ea;
        color: #14532d;
    }

    .custom-thead th {
        font-weight: 600;
        border-bottom: 1px solid #ccc;
    }

    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    /* Container for the toggle background */
    .blocks {
        width: 56px;
        /* 14 * 4px */
        height: 32px;
        /* 8 * 4px */
        border-radius: 9999px;
        /* Fully rounded */
        background-color: #9CA3AF;
        /* Tailwind gray-400 default */
        transition: background-color 0.3s ease;
    }

    /* The small white dot */
    .dot {
        position: absolute;
        top: 4px;
        /* 1 * 4px */
        left: 4px;
        /* 1 * 4px */
        width: 24px;
        /* 6 * 4px */
        height: 24px;
        /* 6 * 4px */
        background-color: white;
        border-radius: 9999px;
        transition: transform 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
    }

    /* When the checkbox is checked, change bg color */
    input[type="checkbox"].slider-toggle:checked+div .blocks {
        background-color: #228cc5;
        /* Tailwind green-500 */
    }

    /* Move the dot to right when checked */
    input[type="checkbox"].slider-toggle:checked+div .dot {
        transform: translateX(24px);
        /* 6 * 4px */
    }


    @media (prefers-color-scheme: dark) {
        .custom-thead {
            background-color: #14532d;
            color: #d1fae5;
        }
    }

    input[type="checkbox"] {
        width: 24px !important;
        height: 24px !important;
        accent-color: green;
        /* For modern browsers */
    }

    /* Fallback for browsers without accent-color support */
    input[type="checkbox"]:checked {
        background-color: green;
        border: none;
    }

    input[type="radio"] {
        width: 24px !important;
        height: 24px !important;
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

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-center flex-row gap-2">
                <h3 class="text-lg uppercase font-semibold">
                    DD - DDA03629
                </h3>
                <p class="text-sm text-gray-500 uppercase">Credit Interest</p>

            </div>
        </div>


        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between  gap-5">

            <div class=" w-full box overflow-hidden ">
                <p class="text-lg border-b font-semibold">
                    CREDIT / REVERSE INTEREST
                </p>
                <form action="{{ route('ddsaccounts.storeCreditInterest', $ddaccount->id) }}" method="POST">
                    @csrf

                    <div class="col-span-2 md:col-span-1 mt-3 mb-2">
                        <label class="md:text-lg font-medium block mb-2 uppercase">
                            Transaction Date
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="transaction_date" value=""
                            class="datepicker-field w-full px-3 py-2.5 block text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3 pr-10" />
                    </div>

                    <div class="col-span-2 md:col-span-1 mt-3 mb-3">
                        <label class="md:text-lg font-medium block mb-2 uppercase">
                            Transaction Type
                            <span class="text-red-500">*</span>
                        </label>
                        <select name="transaction_type" id="employeeSelect"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="credit">Credit</option>
                            <option value="reverse">Reverse</option>
                        </select>
                    </div>

                    <div class="col-span-2 md:col-span-1 mt-3 mb-2">
                        <label class="md:text-lg font-medium block mb-2 uppercase">
                            Interest Amount
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="interest_amount" value="" placeholder="Enter Interest Amount"
                            class="w-full px-3 py-2.5 block text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3 pr-10" />
                    </div>

                    <div class="col-span-2 md:col-span-1 mb-2">
                        <label class="md:text-lg font-medium block mb-2 uppercase">
                            Remarks (if any)
                        </label>
                        <textarea name="remarks"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Remarks (if any)"></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                        <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                            CREDIT Interest
                        </button>
                        <button class="btn-outline uppercase" type="reset">
                            Reset
                        </button>

                        <a href="{{ route('ddsaccounts.show', $ddaccount->id) }}" class="btn-outline uppercase">
                            CANCEL
                        </a>
                    </div>

                </form>
            </div>

            <!-- Right: Settings -->
            <div class=" w-full overflow-hidden">
                <div id="" class="box toggle-box  ">
                    <div
                        class=" bg-secondary/5 rounded-t-lg px-4 py-3 flex items-center justify-between cursor-pointer toggle-header">
                        <h3 class="text-lg uppercase font-semibold">DD Info</h3>
                        <i class="las la-minus text-xl toggle-icon"></i>
                    </div>

                    <div class=" rounded-b-lg overflow-hidden  toggle-content">
                        <div class="p-4">
                            <table class="w-full whitespace-nowrap text-sm">
                                <tbody class="divide-y divide-gray-200">
                                    <tr class="py-2 border-b">
                                        <td class="font-semibold uppercase py-2 w-40">customer</td>
                                        <td class="py-2">
                                            {{ ($ddaccount->member?->member_no ??
                                                ($ddaccount->member?->id ? str_pad($ddaccount->member->id, 6, '0', STR_PAD_LEFT) : '')) .
                                                ' - ' .
                                                ($ddaccount->member?->member_info_first_name ?? 'N/A') .
                                                ' - ' .
                                                ($ddaccount->member?->member_info_last_name ?? '') }}
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2">DD No.</td>
                                        <td class="py-2">{{ $ddaccount->dd_no ?? 'N/A' }}</td>
                                    </tr>

                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2">Scheme</td>
                                        <td class="py-2">{{ $ddaccount->scheme->scheme_name ?? 'N/A' }}</td>
                                    </tr>

                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2">Tenure</td>
                                        <td class="py-2">{{ $ddaccount->total_installments ?? 'N/A' }}</td>
                                    </tr>

                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2">Frequency</td>
                                        <td class="py-2">{{ $ddaccount->rd_dd_frequency ?? 'N/A' }}</td>
                                    </tr>

                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2">Principal Amt.</td>
                                        <td class="py-2">{{ $ddaccount->dd_amount ?? 'N/A' }}</td>
                                    </tr>

                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2">Amount Received</td>
                                        <td class="py-2">
                                            @php
                                                $totalReceived = $ddaccount->balance ?? 0; // Current balance
                                                $totalTransactionAmounts = $ddaccount->transactions->sum(function ($t) {
                                                    return $t->transaction_type == 'reverse'
                                                        ? $t->interest_amount // reverse adds to received
                                                        : 0; // credit does not affect amount_received
                                                });
                                                $totalAmountReceived = $totalReceived + $totalTransactionAmounts;
                                            @endphp
                                            {{ number_format($totalAmountReceived, 2) }}
                                        </td>
                                    </tr>


                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2">Balance Available</td>
                                        <td class="py-2">
                                            {{ number_format(optional($ddaccount->transactions->last())->balance_available ?? $ddaccount->dd_amount, 2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>
        document.querySelectorAll('.toggle-box').forEach(box => {
            const header = box.querySelector('.toggle-header');
            const content = box.querySelector('.toggle-content');
            const icon = box.querySelector('.toggle-icon');

            header.addEventListener('click', () => {
                content.classList.toggle('hidden');

                // Change icon
                if (content.classList.contains('hidden')) {
                    icon.classList.remove('la-minus');
                    icon.classList.add('la-plus');
                } else {
                    icon.classList.remove('la-plus');
                    icon.classList.add('la-minus');
                }
            });
        });
    </script>
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
@endsection
