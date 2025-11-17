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

    .bg-greens {
        background-color: #14532d;
    }
</style>

@section('content')
    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-start gap-3 mb-6 px-4 lg:mb-8">
            <h3 class="flex text-xl block  uppercase font-semibold">
                UPDATE BULK RISK PERCENTAGE
            </h3>

        </div>
        <div class=" mb-5">
            <div class="box flex gap-3 flex-col lg:flex-row md:flex-row items-center justify-center ">
                <div class="w-full">
                    <label for="" class="uppercase font-semibold text-lg">
                        Select Ledger Type <span class="text-error">*</span>
                    </label>
                    <select name="" id=""
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3  mt-2  capitalize">
                        <option value="">Asset</option>
                        <option value="">Liability</option>
                    </select>
                </div>

                <div class=" w-full">
                    <label for="" class="uppercase font-semibold text-lg">
                        Ledger Group <span class="text-error">*</span>
                    </label>
                    <select name="" id=""
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3  mt-2  capitalize">
                        <option value="">All Groups</option>
                        <option value="">Asset- Cash & Cash Equivalent</option>
                        <option value="">Asset- Loans & Advances</option>
                        <option value="">Asset- Current Assets</option>
                        <option value="">Asset- Fixed Assets</option>
                        <option value="">Asset- Investment</option>
                        <option value="">Asset- Opening Balances</option>
                    </select>
                </div>

            </div>
        </div>
        <div class="col-span-12 box lg:col-span-12">
            <form action="">
                <div class="pb-4 overflow-x-auto lg:pb-6">
                    <table class="w-full whitespace-nowrap select-all-table" id="">
                        <thead>
                            <tr class="bg-secondary/5 dark:bg-bg3">
                                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex uppercase items-center gap-1">
                                        GROUP
                                    </div>
                                </th>
                                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex uppercase items-center gap-1">
                                        CODE
                                    </div>
                                </th>
                                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex uppercase items-center gap-1">
                                        NAME
                                    </div>
                                </th>
                                <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                    <div class="flex uppercase items-center gap-1">
                                        TYPE
                                    </div>
                                </th>

                                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex uppercase items-center gap-1">
                                        RISK (%)
                                    </div>
                                </th>
                                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex uppercase items-center gap-1">
                                        ACTIONS
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                               
                                <td class="p-2">
                                    <input type="text" name="" id="" value=""
                                        class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                        readonly>
                                </td>
                                <td class="p-2">
                                    <input type="text" name="" id="" value=""
                                        class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                        readonly>
                                </td>
                                  <td class="p-2">
                                    <input type="text" name="" id=""  value="" 
                                        class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                        readonly>
                                </td>

                                  <td class="p-2">
                                    <input type="text" name="" id=""  value="" 
                                        class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                        readonly>
                                </td>
                                  <td class="p-2">
                                    <input type="text" name="" id=""  value="" 
                                        class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                                        readonly>
                                </td>

                                   <td class="p-2">
                                    <input type="number" name="" id=""  value="" 
                                        class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
               <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                    <button type="button" id="" class="btn-primary uppercase justify-center">
                        Update All
                    </button>
                    
                </div>
            </form>
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
@endsection