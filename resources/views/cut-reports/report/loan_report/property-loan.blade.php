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
            <h3 class=" flex text-lg block  uppercase font-semibold">
                Report - Property Loan Accounts
            </h3>
        </div>

        {{-- <div class="box mb-5 mt-5 ">

            <div class="flex justify-between" id="toggleBtn">
                <p class="font-semibold uppercase text-lg">
                    Search Box
                </p>
                <button class="text-2xl cursor-pointer">
                    <i id="toggleIcon" class="las la-plus"></i>
                </button>
            </div>

            <hr class="mt-3">
            <div id="toggleContent" class="mt-4">
                <form method="GET" action="{{ url()->current() }}">

                    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-5 w-full mt-4">

                        <div class="col-span-2 md:col-span-1">
                            <label class="md:text-lg font-medium block mb-1 uppercase">Branch</label>
                            <select name="branch_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 py-3">
                                <option value="">ALL</option>
                                @foreach($branches as $b)
                                <option value="{{ $b->id }}" {{ request('branch_id')==$b->id ? 'selected' : '' }}>
                                    {{ $b->branch_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="md:text-lg font-medium block mb-1 uppercase">Customer No</label>
                            <input type="text" name="customer_no" value="{{ request('customer_no') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 py-3"
                                placeholder="Search Customer No">
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="md:text-lg font-medium block mb-1 uppercase">Customer First Name</label>
                            <input type="text" name="first_name" value="{{ request('first_name') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 py-3"
                                placeholder="Search Customer’s First Name">
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="md:text-lg font-medium block mb-1 uppercase">Customer Last Name</label>
                            <input type="text" name="last_name" value="{{ request('last_name') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 py-3"
                                placeholder="Search Customer’s Last Name">
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="md:text-lg font-medium block mb-1 uppercase">Account No</label>
                            <input type="number" name="account_no" value="{{ request('account_no') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 py-3"
                                placeholder="Search Account No">
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="md:text-lg font-medium block mb-1 uppercase">Customer Mobile No</label>
                            <input type="text" name="mobile_no" value="{{ request('mobile_no') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 py-3"
                                placeholder="Search Mobile No">
                        </div>

                    </div>

                    <div class="mt-5 flex justify-center gap-4">
                        <button class="btn-primary px-1 py-2 text-sm uppercase">
                            <i class="las la-search"></i>
                            Search
                        </button>
                        <a href="{{ url()->current() }}" class="btn-warning px-1 py-2 text-sm uppercase">Clear</a>
                    </div>

                </form>
            </div>

        </div> --}}

        <div class="col-span-12 box lg:col-span-12">

            <div class="mb-5 flex justify-end gap-2 flex-col md:flex-row lg:flex-row">
                <a href="{{ route('mortgage.print', request()->all()) }}" target="_blank"
                    class="btn-primary rounded-10 px-2 flex justify-center py-2 text-sm uppercase">
                    <i class="las la-print"></i>
                    Print Report
                </a>
                <a href="{{ route('accounts.mortgage.export.csv') }}"
                    class="btn-error rounded-10 px-2 flex justify-center py-2 text-sm uppercase">
                    <i class="las la-download"></i>
                    Download CSV
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
                                <div class="flex items-center uppercase gap-1">
                                    Customer
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    ACCOUNT NO.
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    APPLICATION NO.
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    SCHEME
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    OPEN DATE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    STATUS
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    LOAN AMT.
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    CURRENT DEBT
                                </div>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($goldLoan as $loan)
                            <tr class="border-b dark:border-bg3">

                                <!-- BRANCH -->
                                <td class="px-6 py-5 uppercase">
                                    {{ $loan->branch->branch_name ?? 'N/A' }}
                                </td>

                                <!-- CUSTOMER -->
                                <td class="text-start !py-5 px-6">
                                    <a href="{{ url('members/member/' . $loan->member_id) }}"
                                        class="text-green-600 hover:underline">
                                        {{ $loan->member->full_name ?? 'N/A' }} -
                                        {{ $loan->member->member_no ?? '---' }}
                                    </a>
                                </td>

                                <!-- ACCOUNT NO -->
                                <td class="px-6 py-5">
                                    <a href="{{ route('mortgage.account.show', $loan->id) }}" class="text-primary">
                                        {{ str_pad($loan->id, 10, '0', STR_PAD_LEFT) }}
                                    </a>

                                </td>

                                <!-- APPLICATION NO -->
                                <td class="px-6 py-5">
                                    {{ $loan->id ?? 'N/A' }}
                                </td>

                                <!-- SCHEME -->
                                <td class="px-6 py-5">
                                    {{ $loan->scheme->scheme_name ?? 'N/A' }}
                                </td>

                                <!-- OPEN DATE -->
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        {{ \Carbon\Carbon::parse($loan->application_date)->format('d-m-Y') ?? '-' }}
                                    </div>
                                </td>

                                <!-- STATUS -->
                                <td class="px-6 py-5">
                                    {{ $loan->status == 2 ? 'Active' : 'Closed' }}
                                </td>

                                <!-- LOAN AMOUNT -->
                                <td class="px-6 py-5">
                                    {{ number_format($loan->loan_amount, 2) }}
                                </td>

                                <!-- CURRENT DEBT -->
                                <td class="px-6 py-5">
                                    {{ number_format($loan->current_debt ?? 0, 2) }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-red-500">
                                    No Records Found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>

            <div class="mt-4">
                <x-pagination :paginator="$goldLoan" />
            </div>

        </div>

        <script>
            const btn = document.getElementById("toggleBtn");
            const content = document.getElementById("toggleContent");
            const icon = document.getElementById("toggleIcon");

            btn.addEventListener("click", () => {
                content.classList.toggle("hidden");

                // Toggle icon
                if (content.classList.contains("hidden")) {
                    icon.classList.remove("la-minus");
                    icon.classList.add("la-plus");
                } else {
                    icon.classList.remove("la-plus");
                    icon.classList.add("la-minus");
                }
            });
        </script>


@endsection