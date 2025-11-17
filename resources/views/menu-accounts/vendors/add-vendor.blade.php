@extends('layout.main')

<style>
    .breadcrumb {
        list-style: none;
        display: flex;
        padding: 0;
        margin-bottom: 1rem;
        font-size: 14px;
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

    @media (prefers-color-scheme: dark) {
        .custom-thead {
            background-color: #14532d;
            color: #d1fae5;
        }
    }

    input[type="checkbox"] {
        width: 28px;
        height: 28px;
        accent-color: green;
        /* For modern browsers */
    }

    input[type="radio"] {
        width: 28px;
        height: 28px;
        accent-color: green;
        /* For modern browsers */
    }

    .bg-greens {
        background-color: #14532d;
    }
</style>

@section('content')
    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-start gap-3 mb-6 px-4 lg:mb-8">
            <h3 class="flex text-xl block  uppercase font-semibold">
                ADD NEW VENDOR
            </h3>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <!-- Left: Details -->
            <div class=" w-full overflow-x-auto   overflow-hidden">
                <div class="overflow-x-auto box rounded-lg dark:bg-bg3 p-2 bg-white shadow-md">
                    <div class="min-w-full p-4">
                        <form>
                            <div>
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Branch

                                </label>
                                <select id="" name=""
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option>Select Branch</option>
                                </select>
                            </div>
                            <div>
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="" name=""
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter Vendor Name">
                            </div>

                            <div>
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Description
                                    <span class="text-red-500">*</span>
                                </label>
                                <textarea name="" id=""
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                    placeholder="Enter Vendor Description "></textarea>
                            </div>

                            <div>
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    GST No

                                </label>
                                <input type="text" id="" name="" placeholder="Enter GST No"
                                    style="text-transform: uppercase;"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize" />
                            </div>

                            <div class=" ">
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Address
                                    <span class="text-red-500">*</span>
                                </label>
                                <textarea name="" id=""
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                    placeholder="Enter Vendor Address      "></textarea>
                            </div>
                            <div class="border-t mt-5">
                                <p class="text-center uppercase text-xl font-semibold mt-3">
                                    Link With Software Accounting
                                </p>
                            </div>

                            <div class="flex items-center gap-3 mt-5">
                                <input type="checkbox" id="autoLedgerCheckbox" class="w-5 h-5 cursor-pointer" checked>
                                <p class="uppercase font-medium">Auto Generate A/c Ledger</p>
                            </div>
                            <div class="mt-5">
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    A/c Ledger
                                    <span class="text-red-500">*</span>
                                </label>
                                <select id="ledgerSelect"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3">
                                    <option value="">Select Accounting Ledger</option>
                                </select>
                                <!-- Note message placeholder -->
                                <p id="ledgerNote" class="text-md text-error mt-2 hidden">
                                    Note: - Create vendor's ledger first then you can add new vendor.
                                </p>
                            </div>
                            <div class="border-t mt-5">
                                <p class="text-center uppercase text-xl font-semibold mt-3">
                                    Vendor's Bank A/C Details
                                </p>
                            </div>
                            <div>
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Bank A/C Name

                                </label>
                                <input type="text" id="" name=""
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter Beneficiary Bank A/C Name">
                            </div>
                            <div>
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Bank Name
                                </label>
                                <select id="" name=""
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option>Select Bank</option>
                                </select>
                            </div>
                            <div>
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    IFSC Code
                                </label>
                                <input type="text" id="" name="" style="text-transform: uppercase"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter IFSC Code">
                            </div>
                            <div>
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Account No.
                                </label>
                                <input type="text" id="" name=""
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter  Account No">
                            </div>
                            <div class="border-t mt-5"></div>
                            <div>
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Internal Account No
                                </label>
                                <select id="" name=""
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                    <option>
                                        Search Account No or Member No or Member Name
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Is Active
                                    <span class="text-error">*</span>
                                </label>
                                <div class="flex gap-2">
                                    <input type="radio" name="is_active" id="" checked>
                                    <p class="uppercase">Yes</p>
                                    <input type="radio" name="is_active" id="">
                                    <p  class="uppercase">no</p>
                                </div>
                            </div>
                            <!-- Buttons -->
                            <div class="flex flex-wrap gap-3 justify-center pt-4">
                                <button type="submit" class="btn-primary uppercase">
                                    Add Vendor
                                </button>
                                <a href="" class="btn-outline uppercase ">
                                    BAck
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <!-- Right: Settings -->
            <div class=" w-full overflow-x-auto "></div>
        </div>
    </div>



    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

    <!-- Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const datepickers = document.querySelectorAll('.datepicker-field');

            datepickers.forEach(function (dateInput, index) {
                // Create the datepicker with maxDate = today
                const picker = new Datepicker(dateInput, {
                    autohide: true,
                    format: 'dd-mm-yyyy',
                    maxDate: new Date(),
                });

                // Determine which default date to set
                let defaultDate;
                const today = new Date();

                if (index === 0) {
                    // First datepicker → first day of this month
                    defaultDate = new Date(today.getFullYear(), today.getMonth(), 1);
                } else {
                    // Second datepicker → today's date
                    defaultDate = today;
                }

                // Format as dd-mm-yyyy
                const formattedDate = defaultDate.toLocaleDateString('en-GB').split('/').join('-');
                dateInput.value = formattedDate;

                // If there’s a calendar icon near the field, make it open the picker
                const calendarIcon = dateInput.parentElement.querySelector('.la-calendar');
                if (calendarIcon) {
                    calendarIcon.addEventListener('click', () => picker.show());
                }
            });
        });
    </script>

    <script>
        const checkbox = document.getElementById('autoLedgerCheckbox');
        const ledgerSelect = document.getElementById('ledgerSelect');
        const note = document.getElementById('ledgerNote');

        // Handle checkbox state change
        checkbox.addEventListener('change', () => {
            if (checkbox.checked) {
                ledgerSelect.disabled = true;
                note.classList.add('hidden');
            } else {
                ledgerSelect.disabled = false;
                note.classList.remove('hidden');
            }
        });
    </script>
@endsection