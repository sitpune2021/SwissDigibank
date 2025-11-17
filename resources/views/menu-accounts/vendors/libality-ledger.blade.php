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
             Liability Ledger - NITIN AARUN SHETE - NITIN AARUN SHETE
            </h3>
            <p class="text-gray-500 uppercase text-xs">
                created on - 19-10-2023
            </p>

        </div>
        <div class=" mb-5">
        <div class="box flex gap-3 flex-col lg:flex-row md:flex-row items-center justify-center ">
                <div class="w-full">
                    <select name="" id=""
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                        <option value="">All</option>
                       
                    </select>
                </div>
                <div class="w-full">
                    <input type="text" name="" id=""
                        class="datepicker-field w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                        placeholder="DD/MM/YYYY">

                </div>
                
                <div class="w-full">
                    <input type="text" name="" id=""
                        class="datepicker-field w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                        placeholder="DD/MM/YYYY">

                </div>
                <div class="flex items-center gap-2 w-full">
                    <input type="checkbox" name="" id="">
                    <p class="font-semibold text-sm">
                        SHOW MANUAL ONLY
                    </p>
                </div>
                <div class="w-full text-center">
                    <a href="" class="uppercase btn-primary py-2 rounded-10">
                        Search
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
                                    CODE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    GROUP
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    NAME
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    SYSTEM NAME
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    IS SYSTEM
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    SHOW IN DB
                                </div>
                            </th>

                            
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    TYPE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    TOTAL T.
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    LAST T.
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    T. DEBITS
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    T. CREDITS
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    ( T. DEBITS - T. CREDITS )
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    CLOSING BALANCE
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr class="border-b dark:border-bg3">
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    102
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 Capitalize">
                                    <a href="" class="text-primary">
                                        CASH & CASH EQUIVALENT
                                    </a>
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    CASH BOOK
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    CASH BOOK
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
                                    Asset
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    4
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    12-10-2024
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    62,053.00
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    0.00
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    62,053.00
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    3,674,948.00
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end items-center gap-3">
                <div class="mt-5">
                    <a href="" class="btn-error p-2 rounded-10">
                        <i class="las la-trash-alt"></i>
                    </a>
                </div>    
                <div class="mt-5">
                    <a href="" class="btn-primary p-2 rounded-10">
                        <i class="las la-pencil-alt"></i>
                    </a>
                </div> 
                   <div class="mt-5">
                     <a href="" class="uppercase btn-warning rounded-10 py-2">
                         re-generate ledger
                    </a>
                   </div>
                
            </div>
     
             <div class="pb-4 overflow-x-auto mt-7   lg:pb-6">
                <div class="mb-5">
                   <h3 class="uppercase text-lg font-semibold">
                    Transactions
                   </h3>
                </div>
                <div class="">
                    <p class="capitalize font-semibold">there are no transaction in this account</p>
                </div>
                {{-- <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    BRANCH
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex  uppercase items-center gap-1">
                                    DATE	
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    DESCRIPTION
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                   IS SYSTEM	
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase   items-center gap-1">
                                O. BALANCE	
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                   DEBIT
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                   CREDIT
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex uppercase items-center gap-1">
                                    C .BALANCE
                                </div>
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody>

                        <tr class="border-b dark:border-bg3">
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                  SHREE RAM NAGAR SHEGAON	
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 Capitalize">
                                   10-10-2025
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                   <a href="" class="text-primary">
                                    Cash debit to Saving a/c M0000003 SATISH RAMKRISHNA BURUNGALE M0000003 S113371.
                                   </a>
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
                                   3,752,661.00
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                   1,510.00
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                   3,754,171.00

                                </div>
                            </td>
                            
                        </tr>
                    </tbody>
                </table> --}}
            </div>
            
            {{-- <div class="flex justify-end items-center gap-3">
                <div class="mt-5">
                    <a href="" class="btn-error p-2 uppercase rounded-10">
                        <i class="las la-download"></i>
                         download CSV
                    </a>
                </div>     --}}
                  
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