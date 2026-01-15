@extends('layout.main')

@section('content')

    <style>
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

        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;
            /* Modern browser support */
        }
    </style>

    <div class="main-inner">

        <div class=" flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col  gap-2">
                <div class="flex items-center gap-3">
                    <h1 class="text-lg font-semibold uppercase">
                  DELETE LOGS
                    </h1>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-2 md:grid-cols-3 gap-6  min-h-screen md-4">
            <div class="col-span-2 md:col-span-1  dark:bg-bg3 rounded-2xl ">

                <div class="box">
                    <div class="text-end">
                       
                        {{-- <a href=""
                            class="btn-primary p-1"><i class="las la-pencil-alt"></i></a> --}}
                    </div>
                    <div class="whitespace-nowrap overflow-x-auto">
                    <table class="w-full text-lg rounded-md">

                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">DELETED BY</th>
                            <td class="px-3 py-2">
                                RM RM (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">ITEM TYPE</th>
                            <td class="px-3 py-2">
                               DepositLoanTransaction (static) 
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">ITEM ID</th>
                            <td class="px-3 py-2">
                                2147 (static)
                            </td>
                        </tr>
                         <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">ITEM INFO</th>
                            <td class="px-3 py-2">
                                (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Id</th>
                            <td class="px-3 py-2">
                                2147 (static)
                            </td>
                        </tr><tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Payment Mode</th>
                            <td class="px-3 py-2">
                                cash (static)
                            </td>
                        </tr><tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Transaction Type</th>
                            <td class="px-3 py-2">
                                credit (static)
                            </td>
                        </tr><tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Amount</th>
                            <td class="px-3 py-2">
                                2,238.00 (static)
                            </td>
                        </tr><tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Transaction Status</th>
                            <td class="px-3 py-2">
                                approved (static)
                            </td>
                        </tr><tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Payment Status</th>
                            <td class="px-3 py-2">
                                yes (static)
                            </td>
                        </tr><tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Transaction Date</th>
                            <td class="px-3 py-2">
                                12-12-2025 (static)
                            </td>
                        </tr><tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Message</th>
                            <td class="px-3 py-2">
                                Payments received via cash (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Account Name & Number</th>
                            <td class="px-3 py-2">
                                Paltu Ghose - Loan Against Deposit Loan (00062) (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Created At</th>
                            <td class="px-3 py-2">
                                12-12-2025 (static)
                            </td>
                        </tr><tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Updated At</th>
                            <td class="px-3 py-2">
                                 12-12-2025 (static)
                            </td>
                        </tr><tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Transaction Info</th>
                            <td class="px-3 py-2">
                                {} (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">
                            Slug 
                        </th>
                            <td class="px-3 py-2">
                                ef409d9e-c76a-4c76-990f-dedf93a61b50 (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">
                            Tranx
                        </th>
                            <td class="px-3 py-2">
                              DL2147   (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Reference Type</th>
                            <td class="px-3 py-2">
                                normal (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Concerned Trans</th>
                            <td class="px-3 py-2">
                                (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Trans Reference</th>
                            <td class="px-3 py-2">
                                (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Concerned Emis</th>
                            <td class="px-3 py-2">
                                [2358, 2359, 2360] (static)
                            </td>
                        </tr><tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Other Charges</th>
                            <td class="px-3 py-2">
                               0.0  (static)
                            </td>
                        </tr><tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Is Processed</th>
                            <td class="px-3 py-2">
                                false (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Company Name</th>
                            <td class="px-3 py-2">
                                DSBC (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">
                            Company Branch
                          </th>
                            <td class="px-3 py-2">
                                Shyambazar (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">
                            O Balance
                           </th>
                            <td class="px-3 py-2">
                                151100.0 (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">C Balance</th>
                            <td class="px-3 py-2">
                                148862.0 (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Created By</th>
                            <td class="px-3 py-2">
                                RM RM (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Collected By</th>
                            <td class="px-3 py-2">
                                RM RM (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Gst Rate</th>
                            <td class="px-3 py-2">
                                0.0 (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">P Paid</th>
                            <td class="px-3 py-2">
                                0.0 (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">P Due</th>
                            <td class="px-3 py-2">
                                 0.0  (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">I Paid</th>
                            <td class="px-3 py-2">
                                2200.0 (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">I Due</th>
                            <td class="px-3 py-2">
                                0.0 (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Ec Due</th>
                            <td class="px-3 py-2">
                                0.0 (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Ec Paid</th>
                            <td class="px-3 py-2">
                                0.0 (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Oi Paid</th>
                            <td class="px-3 py-2">
                                1.0 (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">
                            Oi Due
                            </th>
                            <td class="px-3 py-2">
                                0.0(static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">
                            Oc Paid
                        </th>
                            <td class="px-3 py-2">
                              24.0   (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">
                            Oc Due
                           </th>
                            <td class="px-3 py-2">
                                0.0 (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Ex Paid</th>
                            <td class="px-3 py-2">
                                1138.0 (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">N P Due</th>
                            <td class="px-3 py-2">
                              150000.0   (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">D Paid</th>
                            <td class="px-3 py-2">
                                0.0 (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">
                            Ac Status
                          </th>
                            <td class="px-3 py-2">
                                (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Receipt</th>
                            <td class="px-3 py-2">
                                (static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">DELETED ON</th>
                            <td class="px-3 py-2">
                                (static)
                            </td>
                       </tr>
                       

                    </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
    </div>






@endsection