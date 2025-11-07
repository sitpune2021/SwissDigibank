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
                <h3 class="text-xl font-semibold uppercase dark:text-white">
                    Manoj 
                    <span class="text-gray-500 text-xs ">Salary Transactions</span>
                </h3>
               
            </div>
        </div>

        <div class="">
            <button class="btn-primary rounded-10 uppercase  dark:bg-bg3">
                Re-generate balance in ledger
            </button>
        </div>

        <div class="box dark:bg-bg3 mt-5 shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap text-sm text-start text-gray-700 dark:">
                    <thead class="bg-secondary/5 text-start text-black uppercase text-lg dark:bg-green-700">
                        <tr>
                            <th class="px-4 py-2 text-start">T. DATE</th>
                            <th class="px-4 py-2 text-start">PAY MODE</th>
                            <th class="px-4 py-2 text-start">REMARKS</th>
                            <th class="px-4 py-2 text-start">STATUS</th>
                            <th class="px-4 py-2 text-start">CREDIT</th>
                            <th class="px-4 py-2 text-start">DEBIT</th>
                            <th class="px-4 py-2 text-start">BALANCE</th>
                            <th class="px-4 py-2 text-start">ACCOUNTED</th>
                            <th class="px-4 py-2 text-start">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-800 dark:border-gray-700">
                            <td class="px-4 py-2 text-start">13-08- 2025</td>
                            <td class="px-4 py-2 text-start">Cash</td>
                            <td class="px-4 py-2 text-start">Salary ( August 2025 ) paid via Cash.</td>
                            <td class="px-4 py-2 text-start">Approved</td>
                            <td class="px-4 py-2 text-start">2,322.00</td>
                            <td class="px-4 py-2 text-start">2,322.00</td>
                            <td class="px-4 py-2 text-start">0.00	</td>
                            <td class="px-4 py-2 text-center ">
                                <span                                         class="block w-28  rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                          Yes
                                        </span>
                                        <span                                         class="block w-28  rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                       No
                                        </span>
                            </td>
                            <td class="px-4 py-2 text-start space-x-1">
                              <div class="flex justify-center">
                                        <div class="relative">
                                            <i
                                                class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                            <ul class="horiz-option popover-content">
                                                <li><a href="" class="single-option capitalize">View</a></li>
                                                
                                             
                                            </ul>

                                            {{-- @include('partials._vertical-options', [
                                            /* 'id' =>base64_encode($director->id),
                                            'viewRoute' => 'director.show',
                                            'editRoute' => 'director.edit'*/
                                            ]) --}}
                                        </div>
                                    </div>
                               
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>           
        </div>
    </div>
@endsection