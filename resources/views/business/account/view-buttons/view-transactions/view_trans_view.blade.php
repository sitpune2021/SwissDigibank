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
    }

    input[type="checkbox"]:checked {
        background-color: green;
        border: none;
    }

    input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: green;
    }

    .tableWidth {
        width: 90%;
        margin: auto;
    }

    .bg-yellow {
        background-color: #F1BA07;
    }
</style>

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col gap-2">
                <h1 class="text-xl font-semibold uppercase dark:text-white">Transaction - GL9133
                 
                </h1>
                <p class="text-gray-500 dark:text-gray-400">
                    <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">Gold Loans</a> >
                    <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">03754</a> >
                    <a href="#" class="text-gray-500 dark:text-gray-400 text-sm ">Transactions</a> >
                    <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">GL9133</a>
                </p>
            </div>
        </div>

  <div class="w-full grid grid-cols-2 overflow-hidden">
        <div class="box overflow-x-auto border  rounded-lg dark:bg-bg shadow-md p-4 ">
            <div class="flex justify-end gap-2">
                 <div class="flex justify-end mb-4">
                    <a href="#" class="btn-primary px-2 py-2 ">
                        <i class="las la-print"></i>
                    </a>
                </div>
                 <div class="flex justify-end mb-4">
                    <a href="#" class="btn-error px-2 py-2 ">
                        <i class="las la-trash-alt"></i>
                    </a>
                </div>
            </div>

            <table class="w-full whitespace-nowrap text-sm text-left ">
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <tr>
                        <td class="font-semibold px-4 py-2 w-1/3">Member</td>
                        <td class="px-4 py-2 text-primary">
                            DEMO-04435 - atharv page
                        </td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Loan A/c No.</td>
                        <td class="px-4 py-2">00456</td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Reference Id</td>
                        <td class="px-4 py-2">GL9105</td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Transaction Date</td>
                        <td class="px-4 py-2">
                            01/06/2025
                        </td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Transaction Type</td>
                        <td class="px-4 py-2">
                            Debit
                        </td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Amount</td>
                        <td class="px-4 py-2">₹43,000.00 </td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Transaction Status</td>
                        <td class="px-4 py-2">
                            
                            <span
                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary">
                                APPROVED
                            </span>                        
                        </td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Payment Mode</td>
                        <td class="px-4 py-2">Cash</td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Remarks</td>
                        <td class="px-4 py-2"></td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Tranx Recipt</td>
                        <td class="px-4 py-2"> </td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Created at</td>
                        <td class="px-4 py-2">30/08/2025 </td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Updated at</td>
                        <td class="px-4 py-2"> 30/08/2025</td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Is Accounted</td>
                        <td class="px-4 py-2">
                           
                            <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                        Yes
                                    </span>
                        </td>
                    </tr>
                  
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Branch</td>
                        <td class="px-4 py-2">magarpatta</td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Entry Created By</td>
                        <td class="px-4 py-2">SACHIN CHAUDHARY</td>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Entry Collected By</td>
                        <td class="px-4 py-2">SACHIN CHAUDHARYtd>
                    </tr>
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Entry Approved By</td>
                        <td class="px-4 py-2">SACHIN CHAUDHARY</td>
                    </tr>   
                    <tr class="border-t">
                        <td class="font-semibold px-4 py-2">Approval Date</td>
                        <td class="px-4 py-2">30/08/2025 </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



         
        </div>

@endsection