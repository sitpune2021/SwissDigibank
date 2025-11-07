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
               Journal Entry - Cash debit to Saving a/c M0000003 SATISH RAMKRISHNA BURUNGALE M0000003 S113371.
            </h3>
         
        </div>
    
        <div class="col-span-12 box lg:col-span-12">
            <div class=" uppercase text-lg mb-3 mt-3 font-semibold">
                LEDGER BILL ENTRY - Cash debit to Saving a/c M0000003 SATISH RAMKRISHNA BURUNGALE M0000003 S113371.
            </div>
            <div class="pb-4 overflow-x-auto lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    DESCRIPTION
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    BRANCH
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                   VOUCHER IMG	
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                  DEBITS
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                  CREDITS
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                   IS SYSTEM	
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                   T. DATE	
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    CREATED AT	
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    UPDATED AT	
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

                        <tr class="border-b dark:border-bg3">
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    Cash debit to Saving a/c M0000003 SATISH RAMKRISHNA BURUNGALE M0000003 S113371.
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 Capitalize">
                                    SHREE RAM NAGAR SHEGAON	
                                </div>
                            </td>
                             <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 Capitalize">
                                    
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                  1,510.00
                                </div>
                            </td>
                             <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                  4,510.00
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
                                    10-10-2024
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                   12-12-2024
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    12-12-2024
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                        <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                        <ul class="horiz-option popover-content">
                                            <li>
                                                <a href="" class="single-option uppercase">edit</a>
                                            </li>
                                            <li>
                                                <a href="" class="single-option uppercase">Show Transaction</a>
                                            </li>
                                             <li>
                                                <a href="" class="single-option uppercase">Print Documents</a>
                                            </li>
                                            
                                        </ul>

                                        {{-- @include('partials._vertical-options', [
                                        /* 'id' =>base64_encode($director->id),
                                        'viewRoute' => 'director.show',
                                        'editRoute' => 'director.edit'*/
                                        ]) --}}
                                    </div>
                                </div>
                                </div>
                            </td>
                            
                        </tr>
                    </tbody>
                </table>
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