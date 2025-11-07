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
                Ledger Group - Asset - CASH & CASH EQUIVALENT

            </h3>


        </div>
        <div class=" mb-5">
            <div class="box flex gap-3 lg:flex-row md:flex-row items-center justify-center ">
                <div class="">
                    <select name="" id=""
                        class="w-64 text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                        <option value="">All</option>

                    </select>
                </div>

                <div class=" text-center">
                    <a href="" class="uppercase btn-primary py-2 rounded-10">
                        Get
                    </a>
                </div>
            </div>
        </div>
        <div class="col-span-12 box lg:col-span-12">
            <div class="pb-4 overflow-x-auto lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    NAME
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    SYSTEM NAME
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    TYPE
                                </div>
                            </th>


                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    IS SYSTEM
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    POSITION
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    ACCOUNTS
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    BALANCE
                                </div>
                            </th>

                        </tr>
                    </thead>
                    <tbody>

                        <tr class="border-b dark:border-bg3">
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    CASH & CASH EQUIVALENT
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 Capitalize">
                                    CASH AND CASH EQUIVALENT
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Asset
                                </div>
                            </td>

                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
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
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    1
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    5
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    3,620,894.41
                                </div>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end items-center gap-3">
                <div class="mt-5">
                    <a href="" class="btn-primary p-2 rounded-10">
                        <i class="las la-pencil-alt"></i>
                    </a>
                </div>
            </div>

            <div class="pb-4 overflow-x-auto mt-7   lg:pb-6">
                <div class="mb-5">
                    <h3 class="uppercase text-lg font-semibold">
                        Ledgers under Group
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap border-gray-200 dark:border-gray-700 text-sm">
                        <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 uppercase text-xs">
                            <tr class="bg-secondary/5">
                                <th class="px-4 py-3 text-start uppercase text-lg">Code</th>
                                <th class="px-4 py-3 text-start uppercase text-lg">Name</th>
                                <th class="px-4 py-3 text-start uppercase text-lg">System Name</th>
                                <th class="px-4 py-3 text-start uppercase text-lg">Type</th>
                                <th class="px-4 py-3 text-start uppercase text-lg">System A/C</th>
                                <th class="px-4 py-3 text-start uppercase text-lg">Balance</th>
                                <th class="px-4 py-3 text-start uppercase text-lg">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <!-- Row 1 -->
                            <tr class="border-b">
                                <td class="px-4 py-3 text-start ">102</td>
                                <td class="px-4 py-3 text-start" >
                                    <a href=""
                                        class="text-primary">CASH BOOK</a>
                                </td>
                                <td class="px-4 py-3 text-start">CASH BOOK</td>
                                <td class="px-4 py-3 text-start ">Asset</td>
                                <td class="px-4 py-3 text-start">
                                 <span
                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                Yes
                              </span>
                              <span
                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                No
                            </span>
                          </td>
                                <td class="px-4 py-3 text-start">3,674,948.00</td>
                                <td class="px-4 py-3 text-start space-x-2">
                                   <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                        <ul class="horiz-option popover-content">
                                            <li>
                                                <a href="" class="single-option uppercase">
                                                    View
                                                </a>
                                            </li>
                                            <li>
                                                <a href="" class="single-option uppercase">
                                                    edit
                                                </a>
                                            </li>

                                        </ul>

                                        {{-- @include('partials._vertical-options', [
                                        /* 'id' =>base64_encode($director->id),
                                        'viewRoute' => 'director.show',
                                        'editRoute' => 'director.edit'*/
                                        ]) --}}
                                    </div>
                                </td>
                            </tr>
                      </tbody>
                    </table>
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