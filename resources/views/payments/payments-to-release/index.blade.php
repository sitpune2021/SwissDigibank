@extends('layout.main')
@section('content')
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

        .bg-greens {
            background-color: #14532d;
        }
    </style>
    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-xl block  uppercase font-semibold">
                FD/ RD Payments to Release
            </h3>
        </div>

        <div class="col-span-12 box lg:col-span-12">
            <div class="mb-5 flex justify-end gap-2 flex-col md:flex-row lg:flex-row">

                <a href="" class="btn-error rounded-10 px-1 py-2 text-sm uppercase">
                    <i class="las la-download"></i>
                    download xls
                </a>
                <a href="" class="btn-primary rounded-10 px-1 py-2 text-sm  uppercase">

                    pending payment History
                </a>
            </div>

            <div class="pb-4 overflow-x-auto lg:pb-6">

                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    BRANCH
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    MEMBER
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    A/C TYPE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    A/C NO.
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    A/C STATUS
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    DUE DATE
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    AMT TO RELEASE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    ACTIONS
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($data as $row)

                        <tr class="border-b">

                        <td class="px-6 py-4">
                        {{ $row->branch }}
                        </td>

                        <td class="px-6 py-4">
                        <a href="#" class="text-primary">
                        {{ $row->member }}
                        </a>
                        </td>

                        <td class="px-6 py-4">
                        {{ strtoupper($row->account_type) }}
                        </td>

                        <td class="px-6 py-4">
                        <a href="#" class="text-primary">
                        {{ $row->account_no }}
                        </a>
                        </td>

                        <td class="px-6 py-4">
                        {{ $row->account_status }}
                        </td>

                        <td class="px-6 py-4">
                        {{ date('d-m-Y',strtotime($row->due_date)) }}
                        </td>

                        <td class="px-6 py-4">
                        {{ number_format($row->amount,2) }}
                        </td>

                        <td class="px-6 py-4">

                        <a href="#" class="text-blue-600">
                        RELEASE
                        </a>

                        </td>

                        </tr>

                        @endforeach

                    </tbody>
                </table>

            </div>

        </div>
        <!-- BACKDROP -->
        <div id="loanModal"
            class="fixed inset-0 z-50 hidden bg-black/60 flex items-start justify-center overflow-y-auto pt-10">

            <!-- MODAL CONTAINER -->
            <div class="w-full max-w-3xl mt-5 rounded-lg shadow-xl bg-white">

                <div class="box">

                    <!-- HEADER -->
                    <div class="flex items-center justify-between border-b px-4 py-3">
                        <h4 class="w-full text-center text-lg font-semibold uppercase tracking-wide">
                            LOAN INFO
                        </h4>

                        <button type="button"
                            class="ml-4 inline-flex h-8 w-8 items-center justify-center rounded-full text-gray-500 hover:bg-gray-100"
                            onclick="closeLoanModal()">
                            &times;
                        </button>
                    </div>

                    <!-- BODY -->
                    <div class="p-4 sm:p-6 space-y-6">

                        <!-- Loan info table -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <tbody class="divide-y divide-gray-200">

                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Member No :</td>
                                        <td colspan="3" class="py-2 underline">
                                            <a href="" class="text-primary">
                                                DEMO-03253 - LAVANYA K
                                            </a>
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Account Type :</td>
                                        <td class="py-2 pr-4">DD</td>
                                        <td class="font-semibold uppercase py-2 pr-4">Account No :</td>
                                        <td class="py-2 underline">
                                            <a href="" class="text-primary">
                                                DDA01450
                                            </a>
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Inst Due :</td>
                                        <td class="py-2 pr-4">188</td>
                                        <td class="font-semibold uppercase py-2 pr-4">Due Date :</td>
                                        <td class="py-2">17/01/2023</td>
                                    </tr>

                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Saving Bal :</td>
                                        <td class="py-2 pr-4"></td>
                                        <td class="font-semibold uppercase py-2 pr-4">Amt to Collect :</td>
                                        <td class="py-2">282,000.00</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <!-- Last credit table -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">

                                <thead>
                                    <tr>
                                        <th colspan="5" class="bg-gray-50 py-2 text-center text-lg font-semibold uppercase">
                                            Last Credit Transaction Info
                                        </th>
                                    </tr>
                                    <tr class="border-b text-md font-medium uppercase text-gray-500">
                                        <th class="py-2 pr-4 text-start">Trans Id</th>
                                        <th class="py-2 pr-4 text-start">T Date</th>
                                        <th class="py-2 pr-4 text-start">Pay Mode</th>
                                        <th class="py-2 pr-4 text-start">Amount</th>
                                        <th class="py-2 text-start">Status</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="py-2 pr-4">DD6491</td>
                                        <td class="py-2 pr-4">13-12-2024</td>
                                        <td class="py-2 pr-4">Cash</td>
                                        <td class="py-2 pr-4">1500.0</td>
                                        <td class="py-2">
                                            <div class="flex items-center gap-1">
                                                <span
                                                    class="block w-28 rounded-[30px] border border-n30 bg-yellow-100 py-2 text-center text-xs text-yellow-600">
                                                    Pending
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>

                        <hr />

                        <!-- Comment Form -->
                        <form class="space-y-4 mt-4">
                            <label class="text-lg uppercase font-medium">Add New Comment <span
                                    class="text-red-500">*</span></label>

                            <textarea
                                class="w-full bg-secondary/5 rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500"
                                rows="3" placeholder="Write Your Comment Here..."></textarea>

                            <div class="flex items-center justify-center gap-3 pt-2">

                                <button type="submit" class="btn-primary uppercase">
                                    SAVE
                                </button>

                                <button type="button" onclick="closeLoanModal()" class="btn-outline uppercase">
                                    Back
                                </button>

                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <script>
            function openLoanModal() {
                document.getElementById('loanModal').classList.remove('hidden');
            }

            function closeLoanModal() {
                document.getElementById('loanModal').classList.add('hidden');
            }
        </script>


@endsection